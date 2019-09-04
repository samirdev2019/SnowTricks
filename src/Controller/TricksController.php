<?php
/**
 * The TricksController file doc comment
 *
 * PHP version 7.2.10
 *
 * @category Class
 * @package  TricksController
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/Controller/TricksController
 */
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Forms;
use App\Repository\TrickRepository;
use App\Repository\IllustrationRepository;
use App\Repository\CategoryRepository;
use App\Repository\VideoRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Entity\Illustration;
use App\Entity\Category;
use App\Entity\User;
use App\Entity\Trick;
use App\Entity\Video;
use App\Form\TrickType;
use App\Form\DescriptionType;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Services\CommentManager;
//use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Services\IllustrationManager;

/**
 * The snowtrick controller class
 *
 * @category Class
 * @package  TricksController
 * @author   Samir <allabsamir777@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/Controller/TricksController
 */
class TricksController extends AbstractController
{
    private $trickRepository;
    private $illustrationRepository;
    private $videoRepository;
    private $categoryRepository;
    private $manager;
    /**
     * The class constructor where we initialize the different
     * Repositories and the objectManager
     *
     * @param TrickRepository        $trickRepository
     * @param IllustrationRepository $illustrationRepository
     * @param VideoRepository        $videoRepository
     * @param CategoryRepository     $categoryRepository
     * @param ObjectManager          $manager
     */
    public function __construct(
        TrickRepository $trickRepository,
        IllustrationRepository $illustrationRepository,
        VideoRepository $videoRepository,
        CategoryRepository $categoryRepository,
        ObjectManager $manager
    ) {
        $this->trickRepository = $trickRepository;
        $this->illustrationRepository = $illustrationRepository;
        $this->videoRepository = $videoRepository;
        $this->categoryRepository = $categoryRepository;
        $this->manager = $manager;
    }
    /**
     * The home page
     *
     * @return Response
     *
     * @Route("/",name="home")
     */
    public function index():Response
    {
        $tricks = $this->trickRepository->findAll();
        return $this->render('tricks/home.html.twig', ['tricks' => $tricks]);
    }
    /**
     * Trick detail page
     *
     * @param Trick          $trick          instance of trick class
     * @param int            $id             the trick identifer
     * @param Request        $request        the request object
     * @param CommentManager $commentManager for factorisation raison
     *
     * @return Response
     *
     * @Route("/snowtrick/trick_detail/{id}", name="trick_detail")
     * @Route("/snowtricks/edit_trick/{id}",  name="edit_trick")
     */
    public function showTrick(
        Trick $trick,
        Request $request,
        CommentManager $commentManager
    ):Response {
        $route = $request->attributes->get('_route');
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        $formDescription = $this->createForm(DescriptionType::class, $trick);
        $formDescription->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $commentManager->addComment($comment, $this->manager, $trick);
            return $this->redirectToRoute("$route", ['id' => $trick->getId()]);
        }
        if ($formDescription->isSubmitted() && $formDescription->isValid()) {
            $trick->setUpdatedAt(new \DateTime);
            $this->manager->flush();
            return $this->redirectToRoute("$route", ['id' => $trick->getId()]);
        }
        $image = $this->illustrationRepository->findOneByTrick($trick->getId());
        $illustrations = $this->illustrationRepository->findByTrick($trick->getId());
        $videos = $this->videoRepository->findByTrick($trick->getId());
        $template = 'tricks/'.$route.'.html.twig';
        return $this->render(
            $template,
            [
                'trick' => $trick,
                'image' => $image,
                'illustrations' => $illustrations,
                'videos' => $videos,
                'commentform' => $form->createView(),
                'descriptionForm' => $formDescription->createView(),
            ]
        );
    }
    /**
     * Add a new trick
     *
     * @param Request             $request
     * @param IllustrationManager $illustrationManager uses for some instructions
     *                                                 in the code factorisation
     *                                                 raison
     *
     * @return void
     *
     * @Route("/new-trick",    name="new_trick")
     * @IsGranted("ROLE_USER")
     */
    public function addTrick(
        Request $request,
        IllustrationManager $illustrationManager
    ) {
        $trick = new Trick();
        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $files = $form['illustrations']->getData();
            $files = $request->files->get('trick')['illustrations'];
            $illustrations = $illustrationManager
            ->multipleIllustrationSave($files, $trick);
            $trick->setIllustration($illustrations);
            $trick->setCreatedAt(new \DateTime());
            $trick->setUser($this->getUser());
            $this->manager->persist($trick);
            $this->manager->flush();
            return $this->redirectToRoute('trick_detail', ['id'=>$trick->getId()]);
        }
        return $this->render(
            'tricks/new-trick.html.twig',
            ['formTrick' => $form->createView()
            ]
        );
    }
     /**
      * This method allow to edit a trick
      *
      * @param Trick   $trick   instance of trick class
      * @param Request $request the request object
      *
      * @return Response The response
      *
      * @Route("/admin/snowtrick/{id}/edit", name="trick_edit", methods="GET|POST")
      */
    public function editTrick(Trick $trick, Request $request):Response
    {
        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $trick->setUpdatedAt(new \DateTime());
            $this->manager->flush();
            $this->redirectToRoute('trick_detail', ['id'=>$trick->getId()]);
        }
        return $this->render(
            'tricks/new-trick.html.twig',
            ['formTrick' => $form->createView()
            ]
        );
    }
    /**
     * This method allow to delete a trick
     *
     * @param Trick $trick
     *
     * @return Response
     *
     * @Route("/admin/snowtrick/{id}/delete", name="delete_trick")
     */
    public function deleteTrick(Trick $trick):Response
    {
        $this->manager->remove($trick);
        $this->manager->flush();
        return $this->redirectToRoute('home');
    }
}

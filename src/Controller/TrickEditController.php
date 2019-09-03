<?php
/**
 * The TrickEditController file doc comment
 *
 * PHP version 7.2.10
 *
 * @category Class
 * @package  TrickEditController
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/Controller/TrickEditController
 */
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Forms;
use App\Repository\TrickRepository;
use App\Repository\IllustrationRepository;
use App\Repository\CategoryRepository;
use App\Repository\VideoRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Entity\Illustration;
use App\Form\IllustrationType;
use App\Entity\Category;
use App\Entity\User;
use App\Entity\Trick;
use App\Entity\Video;
use App\Form\VideoType;
use App\Form\TrickType;
use App\Entity\Comment;
use App\Form\CommentType;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * This class allows to edit a snowtrick
 *
 * @category Class
 * @package  TrickEditController
 * @author   Samir <allabsamir777@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/Controller/TrickEditController
 */
class TrickEditController extends AbstractController
{
    private $trickRepository;
    private $illustrationRepository;
    private $videoRepository;
    private $categoryRepository;
    private $manager;
    /**
     * The constructor of class with different initialisations
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
     * This method allow to edit a illustration
     *
     * @param Illustration $illustration
     * @param Request      $request
     *
     * @return Response
     *
     * @Route("/member/snowtrick/edit-illustration/{id}", name="edit_illustration")
     */
    public function editIllustration(
        Illustration $illustration,
        Request $request
    ):Response {
        if (!$illustration) {
            //exception page 404
        }
        $form = $this->createForm(IllustrationType::class, $illustration);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form['url']->getData();
            if ($file) {
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                $originalFilename = pathinfo(
                    $file->getClientOriginalName(),
                    PATHINFO_FILENAME
                );
                $file->move($this->getParameter('PATH_TO_IMAGE'), $fileName);
                $illustration->setUrl($fileName);
                $illustration->setName($originalFilename);
                $trick = $this->trickRepository
                    ->findOneBy(['id'=>$illustration->getTrick()->getId()]);
                $trick->setUpdatedAt(new \DateTime);
                //$this->manager->persist($trick);
                $this->manager->persist($illustration);
                
                $this->manager->flush();
                return $this->redirectToRoute('edit_trick', ['id'=>$trick->getId()]);
            }
        }
        return $this->render(
            'tricks/edit-illustration.html.twig',
            ['form' => $form->createView()]
        );
    }
    /**
     * This method allow to edit a illustration
     *
     * @param Trick   $trick
     * @param Request $request
     *
     * @return Response
     *
     * @Route("/member/trick/{id}/add-illustration/", name="add_illustration")
     */
    public function addIllustration(Trick $trick, Request $request):Response
    {
        
        $illustration = new Illustration();
        $form = $this->createForm(IllustrationType::class, $illustration);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form['url']->getData();
            if ($file) {
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                $originalFilename = pathinfo(
                    $file->getClientOriginalName(),
                    PATHINFO_FILENAME
                );
                $file->move($this->getParameter('PATH_TO_IMAGE'), $fileName);
                $illustration->setUrl($fileName);
                $illustration->setName($originalFilename);
                $illustration->setTrick($trick);
                $trick->setUpdatedAt(new \DateTime);
                //$this->manager->persist($trick);
                $this->manager->persist($illustration);
                
                $this->manager->flush();
                return $this->redirectToRoute('edit_trick', ['id'=>$trick->getId()]);
            }
        }
        return $this->render(
            'tricks/edit-illustration.html.twig',
            ['form' => $form->createView()]
        );
    }
    /**
     * This methode allows to edit a video
     *
     * @param Video   $video
     * @param Request $request
     *
     * @return Response
     *
     * @Route("/member/snowtrick/edit-video/{id}", name="edit_video")
     */
    public function editVideo(Video $video, Request $request):Response
    {
        $form = $this->createForm(VideoType::class, $video);
        $form->HandleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $url = $form['url']->getData();
            $trick = $this->trickRepository->findOneBy(
                ['id'=>$video->getTrick()->getId()]
            );
            $video->setUrl($url);
            $trick->setUpdatedAt(new \DateTime);
            $this->manager->flush();
            return $this->redirectToRoute('edit_trick', ['id'=>$trick->getId()]);
        }
        return $this->render(
            'tricks/edit-video.html.twig',
            ['formVideo'=>$form->createView()]
        );
    }
    /**
     * This methode allows to add a new video
     *
     * @param Trick   $trick
     * @param Request $request
     *
     * @return Response
     *
     * @Route("/member/snowtrick/{id}/add-video", name="add_video")
     */
    public function addVideo(Trick $trick, Request $request):Response
    {
        $video = new Video();
        $form = $this->createForm(VideoType::class, $video);
        $form->HandleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $url = $form['url']->getData();
            $video->setUrl($url);
            $video->setTrick($trick);
            $trick->setUpdatedAt(new \DateTime);
            $this->manager->persist($video);
            $this->manager->flush();
            return $this->redirectToRoute('edit_trick', ['id'=>$trick->getId()]);
        }
        return $this->render(
            'tricks/edit-video.html.twig',
            ['formVideo'=>$form->createView()]
        );
    }
    /**
     * This method allows to delete an illustration
     *
     * @param Illustration $illustration
     *
     * @return void
     *
     * @Route("/member/snowtrick/delete-illustration/{id}", name="delete_illustration")
     */
    public function deleteIllustration(Illustration $illustration)
    {
        $this->manager->remove($illustration);
        $this->manager->flush();
        return $this->redirectToRoute(
            'edit_trick',
            ['id'=>$illustration->getTrick()->getId()]
        );
    }
    /**
     * This method allows to delete a video
     *
     * @param Video $video
     *
     * @return void
     *
     * @Route("/member/snowtrick/delete-video/{id}", name="delete_video")
     */
    public function deleteVideo(Video $video)
    {
        $this->manager->remove($video);
        $this->manager->flush();
        return $this->redirectToRoute(
            'edit_trick',
            ['id'=>$video->getTrick()->getId()]
        );
    }
    /**
     * This method allows to delete a comment
     *
     * @param Comment $comment
     *
     * @return void
     *
     * @Route("/member/snowtrick/delete-comment/{id}", name="delete_comment")
     */
    public function deleteComment(Comment $comment)
    {
        $this->manager->remove($comment);
        $this->manager->flush();
        return $this->redirectToRoute(
            'edit_trick',
            ['id'=>$comment->getTrick()->getId()]
        );
    }
}

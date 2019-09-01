<?php
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
use App\Entity\Category;
use App\Entity\User;
use App\Entity\Trick;
use App\Entity\Video;
use App\Form\TrickType;
use App\Form\DescriptionType;
use App\Entity\Comment;
use App\Form\CommentType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
// https://symfony.com/doc/current/translation.html
// https://ngrok.com/download
class TricksController extends AbstractController 
{
    private $trickRepository;
    private $illustrationRepository;
    private $videoRepository;
    private $categoryRepository;
    private $manager;

    public function __construct(
        TrickRepository $trickRepository,
        IllustrationRepository $illustrationRepository,
        VideoRepository $videoRepository,
        CategoryRepository $categoryRepository,
        ObjectManager $manager
        )
    {
        $this->trickRepository = $trickRepository;
        $this->illustrationRepository = $illustrationRepository;
        $this->videoRepository = $videoRepository;
        $this->categoryRepository = $categoryRepository;
        $this->manager = $manager;

    }
    /**
     * @Route("/",name="home")
     */
    public function index():Response
    {
        $tricks = $this->trickRepository->findAll();
        return $this->render('tricks/home.html.twig',['tricks' => $tricks]);
    }
    /**
     * page detail trick
     *
     * @Route("/snowtrick/trick_detail/{id}", name="trick_detail")
     * @Route("/snowtricks/edit_trick/{id}", name="edit_trick")
     */
    public function showTrick(Trick $trick, $id,Request $request):Response
    {
        $route = $request->attributes->get('_route');
        $comment = new Comment();
        $form = $this->createForm(CommentType::class,$comment);
        $form->handleRequest($request);
        $formDescription = $this->createForm(DescriptionType::class,$trick);
        $formDescription->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $comment->setCommentedAt(new \DateTime);
            $comment->setTrick($trick);
            $comment->setUser($this->getUser());
            $this->manager->persist($comment);
            $this->manager->flush();
            if ($route === 'trick_detail') {
                return $this->redirectToRoute('trick_detail',['id' => $trick->getId()]);
            } else {
                return $this->redirectToRoute('edit_trick',['id' => $trick->getId()]);
            }
        }
        if($formDescription->isSubmitted() && $formDescription->isValid()) {
            $trick->setUpdatedAt(new \DateTime);
            $this->manager->flush();
            if ($route === 'trick_detail') {
            return $this->redirectToRoute('trick_detail',['id' => $trick->getId()]);
            } else {
                return $this->redirectToRoute('edit_trick',['id' => $trick->getId()]);
            }
        }
        $image = $this->illustrationRepository->findOneByTrick($id);
        $illustrations = $this->illustrationRepository->findByTrick($id);
        $videos = $this->videoRepository->findByTrick($id);
        if ($route === 'trick_detail') {
            $template = 'tricks/detail-trick.html.twig';
        } else {
            $template = 'tricks/edit-trick.html.twig';
        }
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
     *
     * @return Response
     * @Route("/new-trick", name="new_trick")
     * @IsGranted("ROLE_USER")
     */
    public function formTrick(Request $request)
    {
        $trick = new Trick();
        $form = $this->createForm(TrickType::class,$trick);
        $form->handleRequest($request);

         
        if($form->isSubmitted() && $form->isValid()) {
            $files = $form['illustrations']->getData();
            $files = $request->files->get('trick')['illustrations'];

            //dump($files);die;
            foreach($files as $file)
            {
                $url = $file['url'];
                $originalFilename = pathinfo($url->getClientOriginalName(), PATHINFO_FILENAME);
                $illustration = new Illustration();
                $fileName = md5(uniqid()).'.'.$url->guessExtension();
                 $url->move($this->getParameter('PATH_TO_IMAGE'), $fileName);
                 $illustration->setName($originalFilename);   
                 $illustration->setUrl($fileName);
                 $illustration->setTrick($trick);
                 $illustrations[] = $illustration;   
            }
            $trick->setIllustration($illustrations);
            $trick->setCreatedAt(new \DateTime());
            $trick->setUser($this->getUser());
            
            $this->manager->persist($trick);
            $this->manager->flush();
            
            return $this->redirectToRoute('trick_detail',['id'=>$trick->getId()]);
  
        }
        
        return $this->render(
            'tricks/new-trick.html.twig',['formTrick' => $form->createView()
            ]
        );
        
        
    }
    /**
     * This method allow to edit a trick
     * 
     *@Route("/admin/snowtrick/{id}/edit", name="trick_edit", methods="GET|POST")
     */
    public function editTrick(Trick $trick, Request $request):Response
    {
        $form = $this->createForm(TrickType::class,$trick);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $trick->setUpdatedAt(new \DateTime());
            $this->manager->flush();
            $this->redirectToRoute('trick_detail',['id'=>$trick->getId()]);
        }
        return $this->render(
            'tricks/new-trick.html.twig',['formTrick' => $form->createView()
            ]
        );
    }
    /**
     * This method allow to delete a trick 
     *
     * @Route("/admin/snowtrick/{id}/delete", name="delete_trick")
     */
    public function deleteTrick(Trick $trick)
    {
        $this->manager->remove($trick);
        $this->manager->flush();
        return $this->redirectToRoute('home');
    }
    
}

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
use App\Entity\Comment;
use App\Form\CommentType;
use Symfony\Component\HttpFoundation\File\UploadedFile;



class TricksController extends AbstractController 
{
    private $tRepos;
    private $iRepos;
    private $vRepos;
    private $cRepos;

    public function __construct(
        TrickRepository $tRepos,
        IllustrationRepository $iRepos,
        VideoRepository $vRepos,
        CategoryRepository $cRepos
        )
    {
        $this->tRepos = $tRepos;
        $this->iRepos = $iRepos;
        $this->vRepos = $vRepos;
        $this->cRepos = $cRepos;

    }
    /**
     * @Route("/",name="home")
     */
    public function index():Response
    {
        
        
        $firstImag = $this->iRepos->findOneBy(['id'=>'1']);
        $tricks = $this->tRepos->findAll();
        return $this->render(

            'tricks/home.html.twig',
            [
                'tricks' => $tricks,
                'firstImg'=> $firstImag,
            ]
        );

    }
    /**
     * page detail trick
     *
     * @Route("/snowtricks/snowtrick/{id}", name="trick_detail")
     */
    public function showTrick(Trick $trick, $id,Request $request,ObjectManager $em):Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class,$comment);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $comment->setCommentedAt(new \DateTime);
            $comment->setTrick($trick);
            $comment->setUser($this->getUser());
            $em->persist($comment);
            $em->flush();
            return $this->redirectToRoute('trick_detail',['id' => $trick->getId()]);
        }
        $image = $this->iRepos->findOneByTrick($id);
        $illustrations = $this->iRepos->findByTrick($id);
        $videos = $this->vRepos->findByTrick($id);
        //$category = $this->cRepos->findOneByTrick($id);
        return $this->render(
            'tricks/detail-trick.html.twig',
            [
                'trick' => $trick,
                'image' => $image,
                'illustrations' => $illustrations,
                'videos' => $videos,
                'commentform' => $form->createView(),

            ]
        );
    }
    
    /**
     *
     * @return Response
     * @Route("/new-trick", name="new_trick")
     * @IsGranted("ROLE_USER")
     */
    public function formTrick( Request $request, ObjectManager $manager)
    {
        $trick = new Trick();
        $image = new Illustration();
        $form = $this->createForm(TrickType::class,$trick);
        $form->handleRequest($request);

         
        if($form->isSubmitted() && $form->isValid()) {
            
            // $file = $image->getFile();
            // $fileName = md5(uniqid()).'.'. $file->gessExtension();
            // $file-move($this->getParameter('upload-directory'), $fileName);
            // dump($file);die();
            $trick->setCreatedAt(new \DateTime());
            $trick->setUser($this->getUser());
            $manager->persist($trick);
            
            $manager->flush();  
        }
        
        return $this->render(
            'tricks/new-trick.html.twig',['formTrick' => $form->createView()
            ]
        );
        
        
    }
    /**
     *
     *@Route("/snowtrick/{id}/edit", name="edit_trick")
     */
    public function editTrick()
    {
        //todo...
    }
    /**
     * Undocumented function
     *
     * @Route("/delete", name="delete_trick")
     */
    public function deleteTrick()
    {
        //todo...
    }
    
}

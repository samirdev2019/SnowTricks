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

use App\Entity\Illustration;
use App\Entity\Category;
use App\Entity\User;
use App\Entity\Trick;
use App\Entity\Video;
use App\Form\TrickType;


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
        //$user =$this->getUser()->getUsername();
        
        $firstImag = $this->iRepos->findOneBy(['id'=>'1']);
        $tricks = $this->tRepos->findAll();
        return $this->render(

            'tricks/home.html.twig',
            [
                'tricks' => $tricks,
                'firstImg'=> $firstImag,
                //'user' => $user,
            ]
        );

    }
    /**
     * page detail trick
     *
     * @Route("/snowtricks/snowtrick/{id}", name="trick_detail")
     */
    public function showTrick(Trick $trick, $id):Response
    {
        $image = $this->iRepos->findOneByTrick($id);
        $illustrations = $this->iRepos->findByTrick($id);
        $videos = $this->vRepos->findByTrick($id);
        //$category = $this->cRepos->findOneByTrick($id);
        return $this->render(
            'tricks/detailtrick.html.twig',
            [
                'trick' => $trick,
                'image' => $image,
                'illustrations' => $illustrations,
                'videos' => $videos,
                

            ]
        );
    }
    
    /**
     *
     * @return Response
     * @Route("/new-trick", name="new_trick")
     */
    public function formTrick( Request $request, ObjectManager $manager)
    {
        $trick = new Trick();
        $form = $this->createForm(TrickType::class,$trick);
        $form->handleRequest($request); 
        if($form->isSubmitted() && $form->isValid()) {
            
            $trick->setCreatedAt(new \DateTime());
            $trick->setUpdatedAt(new \DateTime()); 
            $manager->persist($trick);
            
            $manager->flush();  
        }
        
        return $this->render(
            'tricks/newtrick.html.twig',['formTrick' => $form->createView()
            ]
        );
        
        
    }
    
}

<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ObjectManager;
use Twig\Environment;
use App\Entity\Trick;
use App\Entity\Illustration;
use App\Entity\Category;
use App\Entity\User;
use App\Repository\TrickRepository;
use App\Repository\IllustrationRepository;

class TricksController extends AbstractController 
{
    /**
     *
     * @var [TrickRepository]
     */
    private $trickRepos;
    /**
     *
     * @var [ObjectManager]
     */
    private $em;
    /**
     *
     * @var [IllustrationRepository]
     */
    private $imgRep;
    public function __construct(TrickRepository $trickRepos, ObjectManager $em, IllustrationRepository $imgRep)
    {
        $this->trickRepos = $trickRepos;
        $this->em = $em;
        $this->imgRep = $imgRep;
    }
    /**
     * @Route("/",name="home")
     */
    public function index(TrickRepository $trickRepos):Response
    {

        $tricks = $this->trickRepos->findAll();
        dump($tricks);
        $firstImag = $this->imgRep->findOneBy(['id'=>'1']);
        return new Response($this->render(
            'tricks/home.html.twig',
            [
                'tricks' => $tricks,
                'firstImg'=> $firstImag
            ]
        ));

    }
    /**
     * Login Page
     * @Route("/login",name="login")
     */
    public function loginUser()
    {
        return $this->render(
            'user/login.html.twig',
            ['curent_menu' => 'login']
        );
    }
    /**
     * Page tricks
     * @Route("/tricks",name="tricks")
     */
    public function tricks():Response
    {
        
        return $this->render('tricks/tricks.html.twig',['curent_menu' => 'tricks']);
    }
    /**
     * page detail trick
     *
     * @Route("/tricks/trick/{id}", name="trick_detail")
     */
    public function showTrick(int $id):Response
    {
        $trick = $this->trickRepos->findOneBy(['id'=>$id]);
        $img = $this->imgRep->findOneBy(['trick_id'=>$id]);
        dump($trick,$img);    
        return $this->render(
            'tricks/detailtrick.html.twig',
            [
                'trick'=> $trick,
                'img' => $firstImag
                
            ]
        );
    }
}

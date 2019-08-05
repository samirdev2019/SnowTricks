<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
<<<<<<< HEAD
use Doctrine\Common\Persistence\ObjectManager;
use Twig\Environment;
=======
use App\Repository\TrickRepository;
use App\Repository\IllustrationRepository;
use App\Repository\VideoRepository;
>>>>>>> entities
use App\Entity\Trick;
use App\Entity\Illustration;
use App\Entity\Category;
use App\Entity\User;
use App\Repository\TrickRepository;
use App\Repository\IllustrationRepository;

class TricksController extends AbstractController 
{
<<<<<<< HEAD
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
=======

    private $tRepos;
    private $iRepos;
    private $vRepos;

    public function __construct(
        TrickRepository $tRepos,
        IllustrationRepository $iRepos,
        VideoRepository $vRepos
        )
    {
        $this->tRepos = $tRepos;
        $this->iRepos = $iRepos;
        $this->vRepos = $vRepos;
>>>>>>> entities
    }
    /**
     * @Route("/",name="home")
     */
    public function index(TrickRepository $trickRepos):Response
    {
<<<<<<< HEAD

        $tricks = $this->trickRepos->findAll();
        dump($tricks);
        $firstImag = $this->imgRep->findOneBy(['id'=>'1']);
        return new Response($this->render(
=======
        $firstImag = $this->iRepos->findOneBy(['id'=>'1']);
        $tricks = $this->tRepos->findAll();
        return $this->render(
>>>>>>> entities
            'tricks/home.html.twig',
            [
                'tricks' => $tricks,
                'firstImg'=> $firstImag
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
        return $this->render(
            'tricks/detailtrick.html.twig',
            [
                'trick' => $trick,
                'image' => $image,
                'illustrations' => $illustrations,
                'videos' => $videos

            ]
        );
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
<<<<<<< HEAD
     * Page tricks
     * @Route("/tricks",name="tricks")
     */
    public function tricks():Response
    {
        
        return $this->render('tricks/tricks.html.twig',['curent_menu' => 'tricks']);
    }
    /**
     * page detail trick
=======
>>>>>>> entities
     *
     * @Route("/snowtricks/new", name="new_trick")
     */
<<<<<<< HEAD
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
=======
    public function createSnowtick():Response
    {
        return $this->render('tricks/newTrick.html.twig');
>>>>>>> entities
    }
}

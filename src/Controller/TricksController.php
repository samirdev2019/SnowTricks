<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use App\Entity\Trick;
use App\Entity\Illustration;

class TricksController extends AbstractController 
{
    /**
     * @var Environment 
     */
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }
    /**
     * @Route("/",name="home")
     */
    public function index():Response
    {
        $repository = $this->getDoctrine()->getRepository(Trick::class);
        $rep = $this->getDoctrine()->getRepository(Illustration::class);
        $firstImag = $rep->findOneBy(['id'=>'1']);
        $tricks = $repository->findAll();
        return new Response($this->twig->render(
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
        $rep = $this->getDoctrine()->getRepository(Illustration::class);
        $firstImag = $rep->findOneBy(['id'=>'1']);
        return $this->render('tricks/tricks.html.twig',['curent_menu' => 'tricks']);
    }
    /**
     * page detail trick
     *
     * @Route("/tricks/trick/{id}", name="trick_detail")
     */
    public function showTrick(Trick $trick):Response
    {
        return $this->render('tricks/detailtrick.html.twig',['trick'=> $trick]);
    }
}
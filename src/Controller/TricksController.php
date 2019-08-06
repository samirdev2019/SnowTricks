<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TrickRepository;
use App\Repository\IllustrationRepository;
use App\Repository\VideoRepository;
use App\Entity\Trick;
use App\Entity\Illustration;
use App\Entity\Category;
use App\Entity\User;

class TricksController extends AbstractController 
{
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
     *
     * @return Response
     * @Route("/snowtriks/new-trick", name="new_trick")
     */
    public function addNewTrick():Response
    {
        return $this->render('newtrick.html.twig');
    }
    
}

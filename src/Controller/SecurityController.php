<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;
use App\Form\UserType;

class SecurityController extends AbstractController
{
    /**
     * Undocumented function
     *
     * @param Request $request
     * @param ObjectManager $em
     * @return Response
     * @Route("/inscription", name="security_registration")
     */
    public function registration(Request $request, ObjectManager $em,
    UserPasswordEncoderInterface $encoder):Response
    {
        
        $user = new User();
        $form = $this->createForm(UserType::class,$user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            //encodage du mot de passe , ok
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            // j'ai besoin de récupérer le token pour l'ajouter au user
            
            $token = $request->request->get('_token');
            //avatar : effectuer après connexion
            // declancher un evenement après inscription en envoyant 
            //un email de confirmation  
            dump($request,$token);die();
            // $em->persist($user);
            // $em->flush();
        }
            return $this->render('security/registration.html.twig',[
                'form' => $form->createView(),
            ]);

    }
    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils):Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('security/login.html.twig',[
            'error'=> $error,
            'last_username'=> $lastUsername
        ]);
    }
    /**
     * This function allow the user to logout 
     *
     * @return void
     * @Route("/logout", name="app_logout")
     */
    public function logout():void 
    {
        throw new \Exception('this shold never reached!');
    }

}
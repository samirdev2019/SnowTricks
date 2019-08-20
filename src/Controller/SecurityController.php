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
use App\Repository\UserRepository;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\NamedAddress;

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
    UserPasswordEncoderInterface $encoder, MailerInterface $mailer):Response
    {
        
        $user = new User();
        $form = $this->createForm(UserType::class,$user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $user->setIsValidated(false);
            $data = $request->request->get('user');
            $user->setToken($data['_token']);
            $user->setAvatar('lmdscmlslm');
            $user->setRoles(['ROLE_USER']);
            $em->persist($user);
            $em->flush();
            $this->sendEmail($mailer,$user);
            return $this->render('security/login.html.twig',
                [
                    'error' => null,
                    'message' => 'you have been registered ,please check your email to confirm your registration',
                    'type' => 'success',
                    'last_username' => $user->getUsername()
                ]
            );
        }
        return $this->render('security/registration.html.twig',[
            'form' => $form->createView(),
        ]);

    }
    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils, UserRepository $userRepository):Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        
        return $this->render('security/login.html.twig',[
            'error'=> $error,
            'last_username'=> $lastUsername,
            'message'=>null
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
    /**
     * This fuction allow to verify the user email after registration
     *  using the link sent to his email acount with a token as parameter
     *
     * @return void
     * @Route("/confirmation/{token}", name="security_confirmation")
     */
    public function confirmationRegister(UserRepository $userRepository, string $token, ObjectManager $em):Response
    {
        $user = new User();
        $user = $userRepository->findOneBy(['token'=> $token]);
        
        if($user) {
            $user->setIsValidated(true);
            $user->setToken("");
            $em->persist($user);
            $em->flush();
            
            return $this->render('security/login.html.twig',
            [
                'error'=> null,
                'last_username' => $user->getUsername(),
                'message' => "your email is verified! you can log in now",
                'type' => 'success'
            ]);
        } else {
            return $this->render('exceptions/404.html.twig');
        }
    }
    /**
     * Fonction allow to send a confirmation email to the user 
     *
     * @param MailerInterface $mailer
     * @param User $user
     * @return void
     */
    public function sendEmail(MailerInterface $mailer,User $user)
    {
        $email = (new TemplatedEmail())
            ->from('samirallab666@gmail.com')
            ->to(new NamedAddress($user->getEmail(), $user->getUsername()))
            ->subject('Thanks for registration!')
            ->htmlTemplate('emails/registration.html.twig')
            ->context([                
                'user' => $user,
            ])
        ;
        $mailer->send($email);
        
    }

}
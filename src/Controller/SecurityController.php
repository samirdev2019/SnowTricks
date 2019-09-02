<?php
/**
 * The SecurityController file doc comment
 * 
 * PHP version 7.2.10 
 * 
 * @category Class
 * @package  SecurityController
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/Controller/SecurityController.php
 */
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
use App\Form\ForgotPasswordType;
use App\Form\ResetPasswordType;
use App\Repository\UserRepository;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\NamedAddress;
/**
 * This class allows to controle the security access and authentication of user
 * 
 * @category Class
 * @package  SecurityController
 * @author   Samir <allabsamir777@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/Controller/SecurityController.php
 */
class SecurityController extends AbstractController
{
    private $manager;
    private $userRepository;
    private $mailer;
    private $encoderPassword;
    /**
     * The class constructor for initilize different interface,object 
     * and Repositories
     *
     * @param UserRepository               $userRepository 
     * @param ObjectManager                $manager 
     * @param MailerInterface              $mailer 
     * @param UserPasswordEncoderInterface $encoderPassword 
     */
    public function __construct(
        UserRepository $userRepository,
        ObjectManager $manager,
        MailerInterface $mailer,
        UserPasswordEncoderInterface $encoderPassword
    ) {
        $this->manager = $manager;
        $this->userRepository = $userRepository;
        $this->mailer = $mailer;
        $this->encoderPassword = $encoderPassword;
    }
    /**
     * The user registration function, the user have always
     * The ROLE_USER after registration also 
     * The password must be hached before to save it in the database
     *
     * @param Request $request 
     *  
     * @return                Response
     * @Route("/inscription", name="security_registration")
     */
    public function registration(Request $request):Response
    { 
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $this->encoderPassword
                ->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $user->setIsValidated(false);
            $data = $request->request->get('user');
            $user->setToken($data['_token']);
            $user->setAvatar('avatarDefault.png');
            $user->setRoles(['ROLE_USER']);
            $this->manager->persist($user);
            $this->manager->flush();
            $subject ='Thanks for registration!';
            $template = 'emails/registration.html.twig';
            $this->sendEmail($user, $template, $subject);
            return $this->render(
                'security/login.html.twig',
                [
                    'error' => null,
                    'message' => 'you have been registered ,please check your 
                    email to confirm your registration',
                    'type' => 'success',
                    'last_username' => $user->getUsername()
                ]
            );
        }
        return $this->render(
            'security/registration.html.twig', [
            'form' => $form->createView(),
            ]
        );

    }
    /**
     * The user can log in after registering and validating his email 
     *
     * @param AuthenticationUtils $authenticationUtils 
     *  
     * @return Response
     * 
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils):Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        
        return $this->render(
            'security/login.html.twig', [
            'error'=> $error,
            'last_username'=> $lastUsername,
            'message'=>null
            ]
        );
    }
    /**
     * This function allow the user to logout 
     *
     * @return           void
     * @Route("/logout", name="app_logout")
     */
    public function logout():void 
    {
        throw new \Exception('this shold never reached!');
    }
    /**
     * This fuction allow to verify the user email after registration
     * using the link sent to his email acount with a token 
     * as parameter by the function sendEmail()
     *
     * @param string $token sent with email it use to confirme the email of user  
     *  
     * @return                         void
     * @Route("/confirmation/{token}", name="security_confirmation")
     */
    public function confirmationRegister(string $token):Response
    {
        $user = new User();
        $user = $this->userRepository->findOneBy(['token'=> $token]);
        
        if ($user) {
            $user->setIsValidated(true);
            $user->setToken("");
            $this->manager->persist($user);
            $this->manager->flush();
            
            return $this->render(
                'security/login.html.twig',
                [
                'error'=> null,
                'last_username' => $user->getUsername(),
                'message' => "your email is verified! you can log in now",
                'type' => 'success'
                ]
            );
        } else {
            return $this->render(
                'exceptions/404.html.twig',
                ['message'=>'mybe this user is not exist
                please go to registration for inscription']
            );
        }
    }
    /**
     * This function allow to send an email to the user, it used by tow others
     * functions firstly: when the user subscribe, secondly:when he request to
     * change his password
     *
     * @param User   $user     the user will recive the email
     * @param string $template the twig HTML template 
     * @param string $subject  the subject of email
     * 
     * @return void
     */
    public function sendEmail(User $user, string $template, string $subject)
    {
        $email = (new TemplatedEmail())
            ->from('samirallab666@gmail.com')
            ->to(new NamedAddress($user->getEmail(), $user->getUsername()))
            ->subject($subject)
            ->htmlTemplate($template)
            ->context(
                [                
                'user' => $user,
                ]
            );
        $this->mailer->send($email);
        
    }
    /**
     * The user can forget his password, so this function allows a registered user
     * to receive an email with a link/token allows him to reset his password 
     * 
     * @param Request $request 
     * 
     * @return                    void
     * @Route("/forgot-password", name="forgot_password")
     */
    public function forgotPassword(Request $request):Response
    {
        $user = new User();
        $form = $this->createForm(ForgotPasswordType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $username = $form->getData();
            $user = $this->userRepository->findOneByUsername($username);
            if ($user) {
                $resetToken = $user->createResetToken();
                $user->setToken($resetToken);
                $this->manager->persist($user);
                $this->manager->flush();
                $subject ='Reset your password';
                $template = 'emails/forgot-password.html.twig';
                $this->sendEmail($user, $template, $subject);
                return $this->render(
                    'security/forgot-password.html.twig',
                    [
                    'form'=>$form->createView(),
                    'message'=>'please check your email acount
                    and clic on the link to reset your password',
                    'type' => 'success'
                    ]
                );

            } else {
                return $this->render(
                    'security/forgot-password.html.twig',
                    [
                    'form'=>$form->createView(),
                    'message'=>'this username is not exist,
                    please try with one correct',
                    'type' => 'danger'
                    ]
                );
            }
        }
        return $this->render(
            'security/forgot-password.html.twig',
            ['form'=>$form->createView()]   
        );
    }
     /**
      * This function allow the user to reset his password using a link sent
      * to him by email this link have a token as paramater , so after 
      * the send of form by the user.the new password will be hashed and 
      * the token will be reset before save , 
      * after that the user will be redirect to the login page with a secces message 
      *
      * @param User    $user 
      * @param Request $request 
      * @param [type]  $token 

      * @return                           Response
      * @Route("/reset-password/{token}", name="reset_password")
      */
    public function resetPassword(User $user, Request $request,
        $token = null
    ):Response {    
        $form = $this->createForm(ResetPasswordType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $request->attributes->get('user');
            $passwordHashed = $this->encoderPassword
                ->encodePassword($user, $user->getPassword());
            $user->setPassword($passwordHashed);
            $user->setToken("");
            $this->manager->persist($user);
            $this->manager->flush();
            return $this->render(
                'security/login.html.twig',
                [
                    'error' => null,
                    'message'=>'Your password has been successfully
                    changed !now you can use your new password',
                    'type' => 'success',
                    'last_username' => $user->getUsername()
                ]
            );
        }
        return $this->render(
            'security/reset-password.html.twig',
            [
                'form'=>$form->createView()
            ]
        );
    }
}

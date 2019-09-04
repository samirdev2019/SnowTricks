<?php
/**
 * The RegistrationController file doc comment
 *
 * PHP version 7.2.10
 *
 * @category Class
 * @package  RegistrationController
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/Controller/RegistrationController.php
 */
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\NamedAddress;
use App\Services\MailerService;

/**
 * This class allows to controle the security access and authentication of user
 *
 * @category Class
 * @package  RegistrationController
 * @author   Samir <allabsamir777@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/Controller/RegistrationController.php
 */
class RegistrationController extends AbstractController
{
    private $manager;
    private $userRepository;
    //private $mailer;
    private $mailer;
    private $encoderPassword;
    //* @param MailerInterface              $mailer
    /**
     * The class constructor for initilize different interface,object
     * and Repositories
     *
     * @param UserRepository               $userRepository
     * @param ObjectManager                $manager
     * @param UserPasswordEncoderInterface $encoderPassword
     */
    public function __construct(
        UserRepository $userRepository,
        ObjectManager $manager,
        MailerService $mailer,
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
            //$this->sendEmail($user, $template, $subject);
            $this->mailer->sendEmail($user, $template, $subject);
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
            'security/registration.html.twig',
            [
            'form' => $form->createView(),
            ]
        );
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
}

<?php
/**
 * The PasswordController file doc comment
 *
 * PHP version 7.2.10
 *
 * @category Class
 * @package  PasswordController
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/Controller/PasswordController.php
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
use App\Services\MailerService;

/**
 * This class allows to controle the security access and authentication of user
 *
 * @category Class
 * @package  PasswordController
 * @author   Samir <allabsamir777@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/Controller/PasswordController.php
 */
class PasswordController extends AbstractController
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
                $this->mailer->sendEmail($user, $template, $subject);
                return $this->render(
                    'security/forgot-password.html.twig',
                    [
                    'form'=>$form->createView(),
                    'message'=>'please check your email acount'.
                    'and clic on the link to reset your password',
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
            ['form'=>$form->createView(),
             'message'=>false
            ]
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
     *
     * @return                           Response
     * @Route("/reset-password/{token}", name="reset_password")
     */
    public function resetPassword(
        User $user,
        Request $request,
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

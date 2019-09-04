<?php
/**
 * The mailer file doc comment
 *
 * PHP version 7.2.10
 *
 * @category Class
 * @package  MailerService
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/Services/MailerService.php
 */
namespace App\Services;

//use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
//use App\Repository\UserRepository;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\NamedAddress;

/**
 * This class allows to controle the security access and authentication of user
 *
 * @category Class
 * @package  Emailer
 * @author   Samir <allabsamir777@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/Service/MailerService.php
 */
class MailerService
{
    private $mailer;
    /**
     * The class constructor for initilize different interface,object
     * and Repositories
     *
     * @param MailerInterface              $mailer
     */
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
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
}

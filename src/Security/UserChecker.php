<?php
namespace App\Security;

use App\Exception\AccountUnvalidatedException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\User as AppUser;
use Symfony\Component\Security\Core\Exception\AccountExpiredException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker extends AbstractController implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user)
    {
        if (!$user instanceof AppUser) {
            return;
        }

        // the user email is not validated, show a generic Account Not validated email message.
        if (!$user->getIsValidated()) {
            throw new AccountUnvalidatedException('this acount email is not yet confirmed');
            return $this->render('security/login.html.twig',[
                'error'=> null,
                'last_username'=> $user->getUsername(),
                'message'=>'this acount email is not yet confirmed',
                'type' => 'danger'
            ]);
        }
    }

    public function checkPostAuth(UserInterface $user)
    {
        if (!$user instanceof AppUser) {
            return;
        }

        
    }
}

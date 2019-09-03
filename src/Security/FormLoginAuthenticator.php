<?php
/**
 * The FormLoginAuthenticator file doc comment
 *
 * PHP version 7.2.10
 *
 * @category Class
 * @package  FormLoginAuthenticator
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/Security/FormLoginAuthenticator.php
 */
namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

/**
 * The FormLoginAuthenticator class defines the methode of authentication user
 *
 * @category Class
 * @package  FormLoginAuthenticator
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/Security/FormLoginAuthenticator.php
 */
class FormLoginAuthenticator extends AbstractFormLoginAuthenticator
{
    use TargetPathTrait;
    private $entityManager;
    private $router;
    private $csrfTokenManager;
    private $passwordEncoder;
    /**
     * The class constructor with initialisation
     *
     * @param EntityManagerInterface       $em  instance of EntityManagerInterface
     * @param RouterInterface              $ri  instance of RouterInterface
     * @param csrfTokenManagerInterface    $tmi instance of csrfTokenManagerInterface
     * @param UserPasswordEncoderInterface $pei instace UserPasswordEncoderInterface
     */
    public function __construct(
        EntityManagerInterface $em,
        RouterInterface $ri,
        csrfTokenManagerInterface $tmi,
        UserPasswordEncoderInterface $pei
    ) {
        $this->entityManager = $em;
        $this->router = $ri;
        $this->csrfTokenManager = $tmi;
        $this->passwordEncoder = $pei;
    }
    /**
     * The function defines in which conditions the class will be called.
     *
     * @param Request $request
     *
     * @return void
     */
    public function supports(Request $request)
    {
        return 'login' === $request->attributes->get('_route')
        && $request->isMethod('POST');
    }
    /**
     * This function returns the authentication information elements.
     *
     * @param Request $request
     *
     * @return void
     */
    public function getCredentials(Request $request)
    {
        $credentials = [
            'username' => $request->request->get('_username'),
            'password' =>$request->request->get('_password'),
            'csrf_token' =>$request->request->get('_csrf_token'),
        ];
        $request->getSession()->set(
            Security::LAST_USERNAME,
            $credentials['username']
        );
        return $credentials;
    }
    /**
     * This methode returns a user in the Symfony sense (UserInterface instance of
     * the Security component).
     *
     * @param mixed                 $credentials
     * @param UserProviderInterface $userProviderInterface
     *
     * @return void
     */
    public function getUser(
        $credentials,
        UserProviderInterface $userProviderInterface
    ) {
        $token = new CsrfToken('authenticate', $credentials['csrf_token']);
        if (!$this->csrfTokenManager->isTokenValid($token)) {
            throw new InvalidCsrfTokenException();
        }
        $user = $this->entityManager->getRepository(User::class)
            ->findOneBy(['username' => $credentials['username']]);
        if (!$user) {
            throw new CustomUserMessageAuthenticationException(
                'user could not be found !'
            );
        }
        return $user;
    }
    /**
     * This function allows to check at login that the credentials are valid.
     *
     * @param [type]        $credentials
     * @param UserInterface $user
     *
     * @return void
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        
        return $this->passwordEncoder
            ->isPasswordValid(
                $user,
                $credentials['password']
            ) && $user->getIsValidated();
    }
    /**
     * This methode allows to decide what to do in case the user is authenticated,
     * usually a redirection to a given URL.
     *
     * @param Request        $request
     * @param TokenInterface $token
     * @param [type]         $providerKey
     *
     * @return void
     */
    public function onAuthenticationSuccess(
        Request $request,
        TokenInterface $token,
        $providerKey
    ) {
        
        if ($targetPath = $this->getTargetPath($request->getSession(), $providerKey)) {
            return new RedirectResponse($targetPath);
        }
        return new RedirectResponse($this->router->generate('home'));
    }
    /**
     * The function defines the URL of the login form, in our case security_login.
     *
     * @return string
     */
    protected function getLoginUrl()
    {
        return $this->router->generate('login');
    }
}

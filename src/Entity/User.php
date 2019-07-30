<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * @ORM\Entity()
 * @ORM\Table(name="users")
 */
class User
{
    /**
     * The user identifier 
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * 
     *@ORM\Column(type="string", length=255)
     */
    private $username;
    /**
     * 
     *@ORM\Column(type="string", length=255)
     */
    private $email;
    /**
     * 
     *@ORM\Column(type="string", length=255)
     */
    private $password;
    /**
     * token that will be sent to the user for validate his acount
     * 
     *@ORM\Column(type="string", length=255)
     */
    private $token;
    /**
     * 
     *@ORM\Column(type="boolean", nullable=true)
     */
    private $isValidated;
    /**
     * Image of user
     * 
     *@ORM\Column(type="string", length=255)
     */
    private $avatar;
    /**
     * The subscribing date
     * 
     *@ORM\Column(type="date")
     */
    private $subscribedAT;
    /**
     * This var will be used just for the password confirmation
     *
     * @var [string]
     */
    private $confirmation;
    /**
     * The user can create many tricks
     *
     *@ORM\OneToMany(targetEntity="App\Entity\Trick", mappedBy="user")
     */
    private $tricks;
    /**
     * The user can send many comments on the trick
     *
     * @var [collection]|comment[]
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="user")
     */
    private $comments;
    public function __construct()
    {
        $this->subscribedAT = new \DateTime;
    }
    public function getId():integer
    {
        return $this->id;
    }
    public function getUsername(): ?string
    {
        return $this->username;
    }
    public function getEmail(): ?string
    {
        return $this->email;
    }
    public function getPassword(): ?string
    {
        return $this->password;
    }
    public function getToken(): ?string
    {
        return $this->token;
    }
    public function getAvatar(): ?string
    {
        return $this->avatar;
    }
    public function getIsValidated(): ?boolean
    {
        return $this->isValidated;
    }
    public function getConfirmation(): ?string
    {
        return $this->confirmation;
    }
    public function getSubscribedAT(): ?date
    {
        return $this->subscribedAT;
    }
    
    public function SetUsername(string $username):void
    {
        $this->username = $username;
    }
    public function SetEmail(string $email): void
    {
        $this->email = $email;
    }
    public function SetPassword(string $password): void
    {
        $this->password = $password;
    }
    public function SetToken(string $token): void
    {
        $this->token = $token;
    }
    public function SetAvatar(string $image): void
    {
        $this->avatar = $image;
    }
    public function SetIsValidated(bool $validate): void
    {
        $this->isValidated = $validate;
    }
    public function SetConfirmation(string $confirm): void
    {
        $this->confirmation = $confirm;
    }
    public function SetSubscribedAT($date): void
    {
        $this->subscribedAT = $date;
    }
}

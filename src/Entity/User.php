<?php
/**
 * The User file doc comment
 *
 * PHP version 7.2.10
 *
 * @category Class
 * @package  User
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/Entity/User.php
 */
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;

/**
 * The user class Entity
 *
 * @category Class
 * @package  User
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/Entity/User.php
 *
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="users")
 * @UniqueEntity(
 * fields={"username"},
 * message="The username you have indicated is already in use !"
 * )
 */
class User implements UserInterface
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
     * The username of user
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $username;
    /**
     * The user email
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\Email(message="The email '{{value}}' is not a valid email",
     * checkMX = true)
     */
    private $email;
    /**
     * The user password
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="5",    minMessage="your password must be 5 characters")
     */
    private $password;
    /**
     * The user role
     *
     * @ORM\Column(type="json")
     */
    private $roles = [];
    /**
     * THE token that will be sent to the user for validate his acount
     *
     * @ORM\Column(type="string", length=255)
     */
    private $token;
    /**
     * This attribute allows to check if the user has validated his email or not
     *
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isValidated;
    /**
     * Image of user
     *
     * @ORM\Column(type="string", length=255)
     */
    protected $avatar;
    /**
     * The subscribing date
     *
     * @ORM\Column(type="datetime")
     */
    private $subscribedAT;
    /**
     * This attribut will be used just for the password confirmation
     *
     * @var string
     *
     * @Assert\EqualTo(propertyPath="password",
     * message="you did't enter the same password" )
     */
    private $confirmation;
    /**
     * The user can create many snowtricks
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Trick", mappedBy="user")
     */
    private $tricks;
    /**
     * The user can send many comments on the trick, the removal
     * user leads to delete all of his comments
     *
     * @var [collection]|comment[]
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Comment",
     * mappedBy="user", orphanRemoval=true)
     */
    private $comments;
    /**
     * The constructor of class with initialisation of date and collections
     */
    public function __construct()
    {
        $this->subscribedAT = new \DateTime;
        $this->comments = new ArrayCollection;
        $this->tricks = new ArrayCollection;
    }
    /////////////////////////////////////////////////////
    //              GETTERS                            //
    /////////////////////////////////////////////////////
    /**
     * The id getter
     *
     * @return integer|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }
    /**
     * The username getter
     *
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }
    /**
     * The email getter
     *
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }
    /**
     * The password getter
     *
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }
    /**
     * Function return an table of roles
     *
     * @return array
     */
    public function getRoles(): array
    {
        
        return $this->roles;
        if (empty($roles)) {
            $roles[] = 'ROLE_USER';
        }
        return array_unique($roles);
    }
    /**
     * The token getter
     *
     * @return string|null
     */
    public function getToken(): ?string
    {
        return $this->token;
    }
    /**
     * The avatar getter
     *
     * @return string
     */
    public function getAvatar()
    {
        return $this->avatar;
    }
    /**
     * The isValidated getter
     *
     * @return boolean|null
     */
    public function getIsValidated(): ?bool
    {
        return $this->isValidated;
    }
    /**
     * The confirmation getter
     *
     * @return string|null
     */
    public function getConfirmation(): ?string
    {
        return $this->confirmation;
    }
    /**
     * The registration date getter
     *
     * @return \DateTimeInterface
     */
    public function getSubscribedAT(): \DateTimeInterface
    {
        return $this->subscribedAT;
    }
    /**
     * The username setter
     *
     * @param string $username
     *
     * @return self
     */
    public function setUsername(string $username): self
    {
        $this->username = $username;
        return $this;
    }
    /**
     * The email setter
     *
     * @param string $email
     *
     * @return self
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }
    /**
     * The password setter
     *
     * @param string $password
     *
     * @return self
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }
    /**
     * The user role setter
     *
     * @param array $roles
     *
     * @return self
     */
    public function setRoles(array $roles):self
    {
        $this->roles = $roles;
        return $this;
    }
    /**
     * Token setter
     *
     * @param string $token
     *
     * @return self
     */
    public function setToken(string $token): self
    {
        $this->token = $token;
        return $this;
    }
    /**
     * The avatar setter
     *
     * @param string $avatar
     *
     * @return self
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
        return $this;
    }
    /**
     * The validation email setter
     *
     * @param boolean $validate
     *
     * @return self
     */
    public function setIsValidated(bool $validate): self
    {
        $this->isValidated = $validate;
        return $this;
    }
    /**
     * The confirmation of password setter
     *
     * @param string $confirm
     *
     * @return self
     */
    public function setConfirmation(string $confirm): self
    {
        $this->confirmation = $confirm;
        return $this;
    }
    /**
     * The registration date setter
     *
     * @param \DateTimeInterface $date
     *
     * @return self
     */
    public function setSubscribedAT(\DateTimeInterface $date): self
    {
        $this->subscribedAT = $date;
        return $this;
    }
    /**
     * This function allow to add a snowtrick according to this user
     *
     * @param Trick $trick
     *
     * @return self
     */
    public function addTrick(Trick $trick): self
    {
        if (!$this->tricks->contains($trick)) {
            $this->tricks[] = $trick;
            $trick->setUser($this);
        }

        return $this;
    }
    /**
     * This function allow to remove a snowtrick according to this user
     * and update the trick object user attribut
     *
     * @param Trick $trick
     *
     * @return self
     */
    public function removeTrick(Trick $trick): self
    {
        if ($this->tricks->contains($trick)) {
            $this->tricks->removeElement($trick);
            if ($trick->getUser() === $this) {
                $trick->setUser(null);
            }
        }

        return $this;
    }
    /**
     * The user can add a comment in the collection comments
     * and update the object comment user
     *
     * @param Comment $comment
     *
     * @return self
     */
    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setUser($this);
        }

        return $this;
    }
    /**
     * This function remove comment of collection comments updating the attribut
     * according in the comment object
     *
     * @param Comment $comment
     *
     * @return self
     */
    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            if ($comment->getUser() === $this) {
                $comment->setUser(null);
            }
        }

        return $this;
    }
    /**
     * Object to string function
     *
     * @return string
     */
    public function __toString()
    {
        return $this->username;
    }
    /**
     * This function return null , we are note interessted by an encodage system
     * function of interface user
     *
     * @return string|null
     */
    public function getSalt(): ?string
    {
        return null;
    }
    /**
     * The methode of UserInterface
     *
     * @return void
     */
    public function eraseCredentials(): void
    {
    }
    /**
     * The methode of UserInterface
     *
     * @return void
     */
    public function serialize()
    {
    }
    /**
     * The methode of UserInterface
     *
     * @param mixed $serialized
     *
     * @return void
     */
    public function unserializa($serialized)
    {
    }
    /**
     * The methode allows to create a reset token
     * to use for user had forgoen his password
     *
     * @return void
     */
    public function createResetToken()
    {
        return md5($this->getUsername().$this->getEmail());
    }
}

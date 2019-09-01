<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;

/**
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
     * 
     *@ORM\Column(type="string", length=255)
     *@Assert\NotBlank
     */
    private $username;
    /**
     * 
     *@ORM\Column(type="string", length=255)
     *@Assert\Email(message="The email '{{value}}' is not a valid email", checkMX = true)
     */
    private $email;
    /**
     * 
     *@ORM\Column(type="string", length=255)
     *@Assert\Length(min="5", minMessage="your password must be 5 characters")
     */
    private $password;
    /**
     *
     * @ORM\Column(type="json")
     */
    private $roles = [];
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
    //@Assert\File(mimeType{"image/jpeg"})
    // @Assert\NotBlank(message="please apload an image")
    /**
     * Image of user
     * 
     * @ORM\Column(type="string", length=255)
     */
    protected $avatar;
    /**
     * The subscribing date
     * 
     *@ORM\Column(type="datetime")
     */
    private $subscribedAT;
    /**
     * This attribut will be used just for the password confirmation
     *
     * @var [string]
     * @Assert\EqualTo(propertyPath="password", message="you did't enter the same password" )
     */
    private $confirmation;
    /**
     * The user can create many snowtricks
     *
     *@ORM\OneToMany(targetEntity="App\Entity\Trick", mappedBy="user")
     */
    private $tricks;
    /**
     * The user can send many comments on the trick, the removal user leads to delete all of his comments
     *
     * @var [collection]|comment[]
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="user", orphanRemoval=true)
     */
    private $comments;
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
     *
     * @return integer|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }
    /**
     *
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }
    /**
     *
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }
    /**
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
        if(empty($roles)) {
            $roles[] = 'ROLE_USER';
        }
        return array_unique($roles);
    }
    /**
     *
     * @return string|null
     */
    public function getToken(): ?string
    {
        return $this->token;
    }
    /**
     *
     *
     */
    public function getAvatar()
    {
        return $this->avatar;
    }
    /**
     *
     * @return boolean|null
     */
    public function getIsValidated(): ?bool
    {
        return $this->isValidated;
    }
    /**
     *
     * @return string|null
     */
    public function getConfirmation(): ?string
    {
        return $this->confirmation;
    }
    /**
     *
     * @return \DateTimeInterface
     */
    public function getSubscribedAT(): \DateTimeInterface
    {
        return $this->subscribedAT;
    }
    /**
     *
     * @param string $username
     * @return self
     */
    public function setUsername(string $username): self
    {
        $this->username = $username;
        return $this;
    }
    /**
     *
     * @param string $email
     * @return self
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }
    /**
     *
     * @param string $password
     * @return self
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }
    public function setRoles(array $roles):self
    {
        $this->roles = $roles;
        return $this;
        //on peut faire return ['ROLE_ADMIN']; si on interesse pas par la gestion des roles
    }
    /**
     *
     * @param string $token
     * @return self
     */
    public function setToken(string $token): self
    {
        $this->token = $token;
        return $this;
    }
    /**
     *
     * @param string $image
     * @return self
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
        return $this;

    }
    /**
     *
     * @param boolean $validate
     * @return self
     */
    public function setIsValidated(bool $validate): self
    {
        $this->isValidated = $validate;
        return $this;

    }
    /**
     *
     * @param string $confirm
     * @return self
     */
    public function setConfirmation(string $confirm): self
    {
        $this->confirmation = $confirm;
        return $this;
    }
    /**
     *
     * @param \DateTimeInterface $date
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
    public function __toString()
    {
        return $this->username;
    }
    /**
     * This function return null , we are note interessted by an encodage system
     *function of interface user
     * @return string|null
     */
    public function getSalt(): ?string
    {
        return null; 
    }
    /**
     * methode of UserInterface
     *
     * @return void
     */
    public function eraseCredentials(): void
    {
    }
    public function serialize()
    {
        
    }
    public function unserializa($serialized)
    {

    }
    public function createResetToken()
    {
        return md5($this->getUsername().$this->getEmail());
    } 
}

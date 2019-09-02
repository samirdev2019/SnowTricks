<?php
/**
 * The Trick file doc comment
 * 
 * PHP version 7.2.10 
 * 
 * @category Class
 * @package  Trick
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/Entity/Trick.php
 */
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * The Entity class of Trick
 * 
 * @category Class
 * @package  Trick
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/Entity/Trick.php
 * 
 * @ORM\Entity(repositoryClass="App\Repository\TrickRepository")
 * @ORM\Table(name="tricks")
 * @UniqueEntity(
 * fields={"name"},
 * message="The name you have indicated is already in use !"
 * )
 */
class Trick
{
    /**
     * Identifier of the trick
     * 
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * Name of the trick
     * 
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $name;
    /**
     * The description of the trick
     * 
     * @ORM\Column(type="text")
     */ 
    private $description;
    /**
     * The trick creation date
     * 
     * @ORM\Column(type="datetime")
     */
    private $createdAt;
    /**
     * The last update date of the trick
     * 
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;
    /**
     * The trick can have more illustrations(images)
     * and its delete leads to delete all of its illustrations
     * 
     * @ORM\OneToMany(targetEntity="App\Entity\Illustration",
     * mappedBy="trick", cascade={"persist", "remove"}, orphanRemoval=true)
     * @Assert\Valid()
     */
    private $illustrations;
    /**
     * The trick can have more videos and its removal leads to delete 
     * all these last. 
     * 
     * @ORM\OneToMany(targetEntity="App\Entity\Video", mappedBy="trick",
     * cascade={"persist", "remove"}, orphanRemoval=true)
     * @Assert\Valid()
     */
    private $videos;
    /**
     * The trick can have more comments of user and its removal leads
     * to delete all of its comments
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="trick",
     * cascade={"persist", "remove"}, orphanRemoval=true)
     * @Assert\Valid()
     */
    private $comments;
    /**
     * The user that create the trick,a snowtrick must have its user creatore
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="tricks")
     * @ORM\JoinColumn(name="user_id",
     * referencedColumnName="id", nullable=false)
     */
    private $user;
    /**
     * The snowtrick belongs to a single category
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="tricks")
     * @ORM\JoinColumn(name="category_id",                referencedColumnName="id")
     */
    private $category;
    /**
     * Construct function
     */
    public function __construct()
    {
        $this->illustrations = new ArrayCollection();
        $this->videos = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->createdAt = new \DateTime;
    }
    ////////////////////////////////////////////////////////
    //                         GETTERS                    //
    ////////////////////////////////////////////////////////
    /**
     * The getter of id
     *
     * @return integer|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }
    /**
     * The getter of name
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }
    /**
     * The getter of description
     *
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }
    /**
     * The snowtrick creation date getter
     *
     * @return \DateTimeInterface|null
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }
    /**
     * The snowtrick updatation date getter
     *
     * @return \DateTimeInterface|null
     */
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }
    /**
     * The getter of category
     *
     * @return Category|null
     */
    public function getCategory(): ?Category
    {
        return $this->category;
    }
    /**
     * The getter of user
     *
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }
    /**
     * The getter of illustrations
     *
     * @return Collection
     */
    public function getIllustrations():Collection
    {
        return $this->illustrations;
    }
    /**
     * The getter of snowtrick videos
     *
     * @return Collection
     */
    public function getVideos():Collection
    {
        return $this->videos;
    }
    /**
     * The getter of snowtrick comments
     *
     * @return Collection
     */
    public function getComments():Collection
    {
        return $this->comments;
    }
    /**
     * The name setter
     *
     * @param string $name 
     * 
     * @return self
     */
    public function setName(string $name):self
    {
        $this->name = $name;
        return $this;

    }
    /**
     * The description setter
     *
     * @param text $description 
     * 
     * @return self
     */
    public function setDescription(string $description):self
    {
         $this->description = $description;
         return $this;
    }
    /**
     * The create date setter
     *
     * @param \DateTimeInterface $date 
     * 
     * @return self
     */
    public function setCreatedAt(\DateTimeInterface $date):self
    {
         $this->createdAt = $date;
         return $this;
    }
    /**
     * The update date setter
     *
     * @param \DateTime $date 
     * 
     * @return self
     */
    public function setUpdatedAt(\DateTime $date):self
    {
         $this->updatedAt = $date;
         return $this;
    }
    /**
     * The category setter
     *
     * @param Category|null $cat 
     * 
     * @return self
     */
    public function setCategory(?Category $cat):self
    {
        $this->category = $cat;
        return $this;
    }
    /**
     * The user setter
     *
     * @param User|null $user 
     * 
     * @return self
     */
    public function setUser(?User $user):self
    {
        $this->user = $user;
        return $this;
    }
    /**
     * This function allow to add an illustration to this 
     * snowtrick collection(illustrations)
     *
     * @param Illustartion $image 
     * 
     * @return self
     */
    public function addIllustration(Illustration $image): self
    {
        if (!$this->illustrations->contains($image)) {
            $this->illustrations[] = $image;
            $image->setTrick($this);
        }
        return $this;
    }
    /**
     * The illustration setter
     *
     * @param Illustration $illustrations 
     * 
     * @return self
     */
    public function setIllustration($illustrations):self
    {
        $this->illustrations = $illustrations;
        return $this;
    }
    /**
     * This function allow to add an video to this snowtrick collection(videos)
     *
     * @param Video $video 
     * 
     * @return self
     */
    public function addVideo(Video $video): self
    {
        if (!$this->videos->contains($video)) {
            $this->videos[] = $video;
            $video->setTrick($this);
        }
        return $this;
    }
    /**
     * This function allow to add an comment(message) 
     * to this snowtrick collection(comments)
     *
     * @param Comment $message 
     * 
     * @return self
     */
    public function addComment(Comment $message): self
    {
        if (!$this->comments->contains($message)) {
            $this->comments[] = $message;
            $message->setTrick($this);
        }
    }
    /**
     * This function allow to remove an illustration(image) 
     * of this snowtrick collection(illustrations)
     *
     * @param Illustration $image 
     * 
     * @return self
     */
    public function removeIllustration(Illustration $image):self
    {
        if ($this->illustrations->contains($image)) {
            $this->illustrations->removeElement($image);
            if ($image->getTrick() === $this) {
                $image->setTrick($this);
            }
        }
        return $this;
    }
    /**
     * This function allow to remove an video of this snowtrick collection(videos)
     *
     * @param Video $video 
     * 
     * @return self
     */
    public function removeVideo(Video $video): self
    {
        if ($this->videos->contains($video)) {
            $this->videos->removeElement($video);
            if ($video->getTrick() === $this) {
                $vedio->setTrick(null);
            }
        }
    }
    /**
     * This function allow to remove an comment of this snowtrick 
     * collection(comments)
     *
     * @param Video $comment 
     * 
     * @return self
     */
    public function removeComment(Video $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            if ($comment->getTrick() === $this) {
                $comment->setTrick(null);
            }
        }
    }
}

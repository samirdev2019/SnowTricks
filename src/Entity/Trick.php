<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * @ORM\Entity(repositoryClass="App\Repository\TrickRepository")
 * @ORM\Table(name="tricks")
 * 
 */
class Trick
{
    /**
     * Identifier of the trick
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * Name of the trick
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $name;
    /**
     * The description of the trick
     * @ORM\Column(type="text")
     */ 
    private $description;
    /**
     * the trick creation date
     * @ORM\Column(type="datetime")
     */
    private $createdAt;
    /**
     * the last update date of the trick
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;
    /**
     * The trick can have more illustrations(images) and its delete leads to delete all of its illustrations
     * @ORM\OneToMany(targetEntity="App\Entity\Illustration", mappedBy="trick", orphanRemoval=true)
     */
    private $illustrations;
    /**
     * The trick can have more videos and its removal leads to delete all these last. 
     *@ORM\OneToMany(targetEntity="App\Entity\Video", mappedBy="trick", orphanRemoval=true)
     * 
     */
    private $videos;
    /**
     * The trick can have more comments of user and its removal leads to delete all of its comments
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="trick", orphanRemoval=true)
     */
    private $comments;
    /**
     * The user that create the trick,a snowtrick must have its user creatore
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="tricks")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private $user;
    /**
     * The snowtrick belongs to a single category
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="tricks")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
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
     *
     * @param string $name
     * @return self
     */
    public function setName(string $name):self
    {
        $this->name = $name;
        return $this;

    }
    /**
     *
     * @param text $description
     * @return self
     */
<<<<<<< HEAD
    public function setDescription(text $description):self
=======
    public function setDescription(string $description):self
>>>>>>> entities
    {
         $this->description = $description;
         return $this;
    }
    /**
     *
     * @param \DateTimeInterface $date
     * @return self
     */
    public function setCreatedAt(\DateTimeInterface $date):self
    {
         $this->createdAt = $date;
         return $this;
    }
    /**
     *
     * @param \DateTime $date
     * @return self
     */
    public function setUpdatedAt(\DateTime $date):self
    {
         $this->updatedAt = $date;
         return $this;
    }
    /**
     *
     * @param Category|null $cat
     * @return self
     */
    public function setCategory(?Category $cat):self
    {
        $this->category = $cat;
        return $this;
    }
    /**
     *
     * @param User|null $user
     * @return self
     */
    public function setUser(?User $user):self
    {
        $this->user = $user;
        return $this;
    }
    /**
     * This function allow to add an illustration to this snowtrick collection(illustrations)
     *
     * @param Illustartion $image
     * @return self
     */
<<<<<<< HEAD
    public function addIllustration(Illustartion $image): self
=======
    public function addIllustration(Illustration $image): self
>>>>>>> entities
    {
        if(!$this->illustrations->contains($image)) {
            $this->illustrations[] = $image;
            $image->setTrick($this);
        }
        return $this;
    }
    /**
     * This function allow to add an video to this snowtrick collection(videos)
     *
     * @param Video $video
     * @return self
     */
    public function addVideo(Video $video): self
    {
        if(!$this->videos->contains($video)) {
            $this->videos[] = $video;
            $video->setTrick($this);
        }
        return $this;
    }
    /**
     * This function allow to add an comment(message) to this snowtrick collection(comments)
     *
     * @param Comment $message
     * @return self
     */
    public function addComment(Comment $message): self
    {
        if(!$this->comments->contains($message)) {
            $this->comments[] = $message;
            $message->setTrick($this);
        }
    }
    /**
     * This function allow to remove an illustration(image) of this snowtrick collection(illustrations)
     *
     * @param Illustration $image
     * @return self
     */
    public function removeIllustration(Illustration $image):self
    {
        if($this->illustrations->contains($image)) {
            $this->illustrations->removeElement($image);
            if($image->getTrick() === $this) {
                $image->setTrick($this);
            }
        }
        return $this;
    }
    /**
     * This function allow to remove an video of this snowtrick collection(videos)
     *
     * @param Video $video
     * @return self
     */
    public function removeVideo(Video $video): self
    {
        if($this->videos->contains($video)) {
            $this->videos->removeElement($video);
            if($video->getTrick() === $this) {
                $vedio->setTrick(null);
            }
        }
    }
    /**
     * This function allow to remove an comment of this snowtrick collection(comments)
     *
     * @param Video $comment
     * @return self
     */
    public function removeComment(Video $comment): self
    {
        if($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            if($comment->getTrick() === $this) {
                $comment->setTrick(null);
            }
        }
    }
}

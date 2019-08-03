<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * @ORM\Entity()
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
     * @ORM\Column(type="date")
     */
    private $createdAt;
    /**
     * the last update date of the trick
     * @ORM\Column(type="date", nullable=true)
     */
    private $updatedAt;
    /**
     * the photo of trick
     * @ORM\OneToMany(targetEntity="App\Entity\Illustration", mappedBy="trick")
     */
    private $illustrations;
    /**
     * The video of trick
     *@ORM\OneToMany(targetEntity="App\Entity\Video", mappedBy="trick")
     * 
     */
    private $videos;
    /**
     * The user comment about trick
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="trick")
     */
    private $comments;
    /**
     * The user that create the trick
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="tricks")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;
    /**
     * The figure belongs to a single category
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

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getName(): ?string
    {
        return $this->name;
    }
    public function getDescription(): ?string
    {
        return $this->description;
    }
    public function getGroupe(): ?string
    {
        return $this->groupe;
    }
    public function getCreatedAt(): ?date
    {
        return $this->createdAt;
    }
    public function getUpdatedAt(): ?date
    {
        return $this->updatedAt;
    }
    public function getCategory()
    {
        return $this->category;
    }
    public function getIllustrations():Collection
    {
        return $this->illustrations;
    }
    public function getVideos():Collection
    {
        return $this->videos;
    }
    public function getComments():Collection
    {
        return $this->comments;
    }
    public function setName($name)
    {
         $this->name = $name;
    }
    public function setDescription($description)
    {
         $this->description = $description;
    }
    public function setGroupe($groupe)
    {
         $this->groupe = $groupe;
    }
    public function setCreatedAt(\DateTime $date)
    {
         $this->createdAt = $date;
    }
    public function setUpdatedAt($date)
    {
         $this->updatedAt = $date;
    }
    public function setCategory(?Category $cat):self
    {
        $this->category = $cat;
        return $this;
    }
    public function setUser(?User $user):self
    {
        $this->user = $user;
        return $this;
    }
}

<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * @ORM\Entity()
 * @ORM\Table(name="tricks")
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
     * The group of the trick
     * @ORM\Column(type="string", length=255)
     */
    private $groupe;
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
     * Construct function
     */
    public function __construct()
    {
        $this->illustrations = new ArrayCollection();
        $this->videos = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->createdAt = new \DateTime;
    }

    public function getId(): ?integer
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
}

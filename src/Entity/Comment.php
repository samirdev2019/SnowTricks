<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentRepository")
 *@ORM\Table(name="comments")
 */
class Comment
{
    /**
     * The identfier of comment
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * 
     *@ORM\Column(type="text")
     * 
     */
    private $content;
    /**
     * 
     *@ORM\Column(type="datetime")
     * 
     */
    private $commentedAt;
    /**
     * 
     *@ORM\ManyToOne(targetEntity="App\Entity\Trick", inversedBy="comments")
     *@ORM\JoinColumn(name="trick_id", referencedColumnName="id")
     */
    private $trick;
    /**
     * 
     *@ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="comments")
     *@ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private $user;
    public function __construct()
    {
        $this->commentedAt = new \DateTime();
    }
    //////////////////////////////////////////////////////////
    //                      Getters                         //
    /////////////////////////////////////////////////////////
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?text
    {
        return $this->content;
    }

    public function getCmmentedAt(): \DateTimeInterface
    {
        return $this->commentedAT;
    }

    public function getTrick(): ?Trick
    {
        return $this->trick;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    ////////////////////////////////////////////////////////
    //                  SETTERS                           // 
    ////////////////////////////////////////////////////////

<<<<<<< HEAD
    public function setContent(text $content): self
=======
    public function setContent(string $content): self
>>>>>>> entities
    {
        $this->content = $content;
        return $this;
    }

    public function setCommentedAt(\DateTimeInterface $date): self
    {
        $this->commentedAT = $date;
        return $this;
    }

    public function setTrick(?Trick $trick): self
    {
        $this->trick = $trick;
        return $this;
    }
    
    public function setUser(?User $user): self
    {
        $this->user = $user;
        return $this;
    }
}

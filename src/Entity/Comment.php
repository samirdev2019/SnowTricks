<?php
/**
 * The Comment file doc comment
 * 
 * PHP version 7.2.10 
 * 
 * @category Class
 * @package  Comment
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/Entity/Comment.php
 */
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * The group of tricks class
 * 
 * @category Class
 * @package  Comment
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/Entity/Comment.php
 * 
 * @ORM\Entity(repositoryClass="App\Repository\CommentRepository")
 * @ORM\Table(name="comments")
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
     * The content of comment
     * 
     * @ORM\Column(type="text")
     */
    private $content;
    /**
     * The date of comment
     * 
     * @ORM\Column(type="datetime")
     */
    private $commentedAt;
    /**
     * The trick can have more comments
     * 
     * @ORM\ManyToOne(targetEntity="App\Entity\Trick", inversedBy="comments")
     * @ORM\JoinColumn(name="trick_id",                referencedColumnName="id")
     */
    private $trick;
    /**
     * The user can send more comments
     * 
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="comments")
     * @ORM\JoinColumn(name="user_id",                referencedColumnName="id",
     *  nullable=false)
     */
    private $user;
    /**
     * Initialize the creation date of comment in the constructor
     */
    public function __construct()
    {
        $this->commentedAt = new \DateTime();
    }
    //////////////////////////////////////////////////////////
    //                      Getters                         //
    /////////////////////////////////////////////////////////
    /**
     * The id getter function
     *
     * @return integer|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }
    /**
     * The getter of content
     *
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }
    /**
     * The comment date getter
     *
     * @return \DateTimeInterface
     */
    public function getCommentedAt(): \DateTimeInterface
    {
        return $this->commentedAt;
    }
    /**
     * The trick getter
     *
     * @return Trick|null
     */
    public function getTrick(): ?Trick
    {
        return $this->trick;
    }
    /**
     * The user getter
     *
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    ////////////////////////////////////////////////////////
    //                  SETTERS                           // 
    ////////////////////////////////////////////////////////
    /**
     * The content setter
     *
     * @param string $content 
     * 
     * @return self
     */
    public function setContent(string $content): self
    {
        $this->content = $content;
        return $this;
    }
    /**
     * The comment date seeter
     *
     * @param \DateTimeInterface $date 
     * 
     * @return self
     */
    public function setCommentedAt(\DateTimeInterface $date): self
    {
        $this->commentedAT = $date;
        return $this;
    }
    /**
     * The trick setter
     *
     * @param Trick|null $trick 
     * 
     * @return self
     */
    public function setTrick(?Trick $trick): self
    {
        $this->trick = $trick;
        return $this;
    }
    /**
     * The user setter
     *
     * @param User|null $user 
     * 
     * @return self
     */
    public function setUser(?User $user): self
    {
        $this->user = $user;
        return $this;
    }
}

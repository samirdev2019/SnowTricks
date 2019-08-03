<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 *@ORM\Entity()
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
     *@ORM\Column(type="date")
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
     *@ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;
    public function __construct()
    {
        $this->commentedAt = new \DateTime();
    }
    //////////////////////////////////////////////////////////
    //                      Getters                         //
    /////////////////////////////////////////////////////////
    public function getId():int
    {
        return $this->id;
    }
    public function getContent():text
    {
        return $this->content;
    }
    public function getCmmentedAt():date
    {
        return $this->commentedAT;
    }
    public function getTrick()
    {
        return $this->trick;
    }
    ////////////////////////////////////////////////////////
    //                  SETTERS                           // 
    ////////////////////////////////////////////////////////
    public function setContent($content):void
    {
        $this->content = $content;
    }
    public function setCommentedAt($date):void
    {
        $this->commentedAT = $date;
    }
    public function setTrick(?Trick $trick): self
    {
        $this->trick = $trick;
        return $this;
    }
    public function setUser(?Trick $user): self
    {
        $this->user = $user;
        return $this;
    }
}

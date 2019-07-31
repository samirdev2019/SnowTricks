<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
/**
 *@ORM\Entity()
 *@ORM\Table(name="videos")
 */
class Video
{
    /**
     * 
     *
     *@ORM\Id()
     *@ORM\GeneratedValue(strategy="AUTO")
     *@ORM\Column(type="integer")
     */
    private $id;
    /**
     * The platform or source of video like as youtub or dailymotion
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $platform;
    /**
     * 
     *
     * @ORM\Column(type="string", length=255)
     */
    private $url;
    /**
     * 
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Trick", inversedBy="videos")
     * @ORM\JoinColumn(name="trickId", referencedColumnName="id")
     */
    private $trick;
    public function __construct()
    {

    }
    public function getId():integer
    {
        return $this->id;
    }
    public function getUrl():string
    {
        return $this->url;
    }
    public function getPlatform():string
    {
        return $this->platform;
    }
    public function setUrl(string $url):void
    {
        $this->url = $url;
    }
    public function setPlatform($platform):void
    {
        $this->platform = $platform;
    }
    public function setTrick(?Trick $trick):self
    {
        $this->trick = $trick;
        return $this;
    }
}

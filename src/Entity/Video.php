<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
/**
 *@ORM\Entity(repositoryClass="App\Repository\VideoRepository")
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
     * @ORM\Column(type="string", length=255)
     */
    private $url;
    /**
     * A snowtrick can have many videos,an video belongs only to one snowtrick
     * the video must be accorded to one trick
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Trick", inversedBy="videos")
     * @ORM\JoinColumn(name="trick_id", referencedColumnName="id", nullable=false)
     */
    private $trick;
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
    public function getUrl(): ?string
    {
        return $this->url;
    }
    /**
     *
     * @return string|null
     */
    public function getPlatform(): ?string
    {
        return $this->platform;
    }
    /**
     *
     * @return Trick|null
     */
    public function getTrick(): ?Trick
    {
        return $this->trick;
    }
    /**
     *
     * @param string $url
     * @return self
     */
    public function setUrl(string $url): self
    {
        $this->url = $url;
        return $this;
    }
    /**
     *
     * @param string $platform
     * @return self
     */
    public function setPlatform(string $platform): self
    {
        $this->platform = $platform;
        return $this;
    }
    /**
     *
     * @param Trick|null $trick
     * @return self
     */
    public function setTrick(?Trick $trick):self //y a pas dans l'exo
    {
        $this->trick = $trick;
        return $this;
    }
    // public function __toString()
    // {
    //     return $this->url;
    // }
}

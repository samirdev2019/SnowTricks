<?php
/**
 * The Video file doc comment
 * 
 * PHP version 7.2.10 
 * 
 * @category Class
 * @package  Video
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/Entity/Video.php
 */
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * The video entity class
 * 
 * @category Class
 * @package  Video
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/Entity/Video.php
 * 
 * @ORM\Entity(repositoryClass="App\Repository\VideoRepository")
 * @ORM\Table(name="videos")
 */
class Video
{
    /**
     * The id of video
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * The platform or source of video like as youtub or dailymotion
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $platform;
    /**
     * The url video (integration code)
     * 
     * @ORM\Column(type="string", length=255)
     */
    private $url;
    /**
     * A snowtrick can have many videos,an video belongs only to one snowtrick
     * the video must be accorded to one trick
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Trick", inversedBy="videos")
     * @ORM\JoinColumn(name="trick_id",
     * referencedColumnName="id", nullable=false)
     */
    private $trick;
    /**
     * The id getter
     *
     * @return integer|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }
    /**
     * The url getter
     *
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }
    /**
     * The platform getter
     *
     * @return string|null
     */
    public function getPlatform(): ?string
    {
        return $this->platform;
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
     * The url setter
     *
     * @param string $url 
     * 
     * @return self
     */
    public function setUrl(string $url): self
    {
        $this->url = $url;
        return $this;
    }
    /**
     * The platform setter
     *
     * @param string $platform 
     * 
     * @return self
     */
    public function setPlatform(string $platform): self
    {
        $this->platform = $platform;
        return $this;
    }
    /**
     * The trick setter
     *
     * @param Trick|null $trick 
     * 
     * @return self
     */
    public function setTrick(?Trick $trick):self
    {
        $this->trick = $trick;
        return $this;
    }
}

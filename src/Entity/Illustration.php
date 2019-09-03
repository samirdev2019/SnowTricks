<?php
/**
 * The Illustration file doc comment
 *
 * PHP version 7.2.10
 *
 * @category Class
 * @package  Illustration
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/Entity/Illustration.php
 */
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collectons\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File;

/**
 * The group of tricks class
 *
 * @category Class
 * @package  Illustration
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/Entity/Illustration.php
 *
 * @ORM\Entity(repositoryClass="App\Repository\IllustrationRepository")
 * @ORM\Table(name="illustrations")
 */
class Illustration
{
    /**
     * The id of illustration (image)
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * The name that we we can use it as alternative if image not show
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;
    /**
     * The URL of illustration
     *
     * @ORM\Column(type="string", length=255)
     */
    private $url;
    /**
     * A snow trick can have many illustrations,an illustration belongs only
     *  to one snowtrick the illustartion must be accorded to one trick
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Trick", inversedBy="illustrations")
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
     * The name getter
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }
    /**
     * The url getter
     *
     * @return string|null
     */
    public function getUrl()
    {
        return $this->url;
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
     * The name setter
     *
     * @param string $name
     *
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }
    /**
     * The url setter
     *
     * @param string $url
     *
     * @return self
     */
    public function setUrl($url)
    {
        $this->url = $url;
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
}

<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collectons\Collection;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * @ORM\Entity(repositoryClass="App\Repository\IllustrationRepository")
 * @ORM\Table(name="illustrations")
 */
class Illustration
{
    /**
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
     * A snow trick can have many illustrations,an illustration belongs only to one snowtrick
     * the illustartion must be accorded to one trick
     * 
     * @ORM\ManyToOne(targetEntity="App\Entity\Trick", inversedBy="illustrations")
     * @ORM\JoinColumn(name="trick_id", referencedColumnName="id", nullable=false)
     * 
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
    public function getName(): ?string
    {
        return $this->name;
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
     * @return Trick|null
     */
    public function getTrick(): ?Trick
    {
        return $this->trick;
    }
    /**
     *
     * @param string $name
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
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
     * @param Trick|null $trick
     * @return self
     */
    public function setTrick(?Trick $trick): self
    {
        $this->trick = $trick;
        return $this;
    }
}

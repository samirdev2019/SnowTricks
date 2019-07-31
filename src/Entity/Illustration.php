<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collectons\Collection;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * @ORM\Entity()
 * @ORM\Table(name="illustrations")
 */
class Illustration
{
    /**
     * 
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * The name that we we can use it as alternative if image not show
     *
     * @var [string]
     * @ORM\Column(type="string", length=255)
     */
    private $name;
    /**
     * The URL of illustration
     *
     * @var [string]
     * @ORM\Column(type="string", length=255)
     */
    private $url;
    /**
     * the relation between illistration and trick 
     *
     * ORM\ManyToOne(tergetEntity="App\Entity\Trick", inversedBy="illustrations")
     */
    private $trick;
    public function construct()
    {

    }
    public function getId(): ?integer
    {
        return $this->id;
    }
    public function getName(): ?string
    {
        return $this->name;
    }
    public function getUrl(): ?string
    {
        return $this->url;
    }

   
    public function setName(string $name): void
    {
        $this->name = $name;
    }
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }
    public function setTrick(?Trick $trick):self
    {
        $this->trick = $trick;
        return $this;
    }
}

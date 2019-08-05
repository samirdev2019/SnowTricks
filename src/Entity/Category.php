<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * The group of tricks
 * 
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 * @ORM\Table(name="categories")
 */
class Category
{   
    /**
    *
    * @ORM\Id()
    * @ORM\GeneratedValue(strategy="AUTO")
    * @ORM\Column(type="integer")
    */
    private $id;
    /**
     * The name of category
     *
     * @ORM\Column(type="string", length=255)
     */
    private $name;
    /**
     * 
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;
    /**
     * A category can have zero or more tricks
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Trick", mappedBy="category")
     */
    private $tricks;
    /**
     * Initialisation of the attributte tricks like as a arrayCollection 
     */
    public function __construct()
    {
        $this->tricks = new ArrayCollection();
    }
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
     * @return text|null
     */
    public function getDescription(): ?string
    {
        return $this->getDescription;
    }
    /**
     *
     * @return collection|tricks[]
     */
    public function getTricks():collection
    {
        return $this->tricks;
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
     * @param string $description
     * @return self
     */
    public function setDescription(string $description): self
    {
        $this->name = $description;
        return $this;
    }
    /**
     * The method allow to add a new trick
     *
     * @param Trick $trick
     * @return self
     */
    public function addTrick(Trick $trick): self
    {
        if(!$this->tricks->contains($trick)) {
            $this->tricks[] = $trick;
            $trick->setCategory($this);
        }
        return $this;
    }
    /**
     * This function allow to remove an snowtrick of the category
     *
     * @param Trick $trick
     * @return self
     */
    public function removeTrick(Trick $trick): self
    {
        if($this->tricks->contains($trick)) {
            $this->tricks->removeElement($trick);
            if($trick->getCategory() === $this) {
                $trick->setCategory(null);
            }
        }
    }
}

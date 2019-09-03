<?php
/**
 * The Category file doc comment
 *
 * PHP version 7.2.10
 *
 * @category Class
 * @package  Category
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/Entity/Category.php
 */
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * The group of tricks class
 *
 * @category Class
 * @package  Category
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/Entity/Category.php
 *
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 * @ORM\Table(name="categories")
 */
class Category
{
    /**
     * The identifier of cotegory
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
     * The description of category
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
     * The getter of id
     *
     * @return integer|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }
    /**
     * The getter of name
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }
    /**
     * The getter of description
     *
     * @return text|null
     */
    public function getDescription(): ?string
    {
        return $this->getDescription;
    }
    /**
     * The getter of tricks
     *
     * @return collection|tricks[]
     */
    public function getTricks():collection
    {
        return $this->tricks;
    }
    /**
     * The name getter
     *
     * @param string $name name of category
     *
     * @return self
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }
    /**
     * The setter description
     *
     * @param string $description of category
     *
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
     * @param Trick $trick of category
     *
     * @return self
     */
    public function addTrick(Trick $trick): self
    {
        if (!$this->tricks->contains($trick)) {
            $this->tricks[] = $trick;
            $trick->setCategory($this);
        }
        return $this;
    }
    /**
     * This function allow to remove an snowtrick of the category
     *
     * @param Trick $trick of category
     *
     * @return self
     */
    public function removeTrick(Trick $trick): self
    {
        if ($this->tricks->contains($trick)) {
            $this->tricks->removeElement($trick);
            if ($trick->getCategory() === $this) {
                $trick->setCategory(null);
            }
        }
    }
}

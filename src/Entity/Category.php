<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * The group of tricks
 * 
 * @ORM\Entity()
 * @ORM\Table(name="categories")
 */
class Category
{   /**
    * Undocumented variable
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
    public function __construct()
    {
        $this->tricks = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function getDescription()
    {
        return $this->getDescription;
    }
    /**
     * Undocumented function
     *
     * @return collection|tricks[]
     */
    public function getTricks():collection
    {
        return $this->tricks;
    }
    public function setName(string $name): void
    {
        $this->name = $name;
    }
    public function setDescription(string $description): void
    {
        $this->name = $description;
    }
    //TODO add and remove trick function

}
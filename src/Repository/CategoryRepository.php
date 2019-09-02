<?php
/**
 * The CategoryRepository file doc comment
 * 
 * PHP version 7.2.10 
 * 
 * @category Class
 * @package  CategoryRepository
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/Repository/CategoryRepository.php
 */
namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * The category Repository class
 * 
 * @category Class
 * @package  CategoryRepository
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/Repository/CategoryRepository.php
 * 
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(
 * array $criteria, array $orderBy = null, $limit = null,$offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    /**
     * The class constructor
     *
     * @param RegistryInterface $registry 
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Category::class);
    }
}

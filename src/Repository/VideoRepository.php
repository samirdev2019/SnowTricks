<?php
/**
 * The VideoRepository file doc comment
 * 
 * PHP version 7.2.10 
 * 
 * @category Class
 * @package  VideoRepository
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/Repository/VideoRepository.php
 */
namespace App\Repository;

use App\Entity\Video;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * The VideoRepository class
 * 
 * @category Class
 * @package  VideoRepository
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/Repository/VideoRepository.php
 * 
 * @method Video|null find($id, $lockMode = null, $lockVersion = null)
 * @method Video|null findOneBy(array $criteria, array $orderBy = null)
 * @method Video[]    findAll()
 * @method Video[]    findBy(
 * array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VideoRepository extends ServiceEntityRepository
{
    /**
     * The constructor function
     *
     * @param RegistryInterface $registry 
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Video::class);
    }
}

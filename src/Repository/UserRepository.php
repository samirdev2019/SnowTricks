<?php
/**
 * The UserRepository file doc comment
 * 
 * PHP version 7.2.10 
 * 
 * @category Class
 * @package  UserRepository
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/Repository/UserRepository.php
 */
namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
/**
 * The UserRepository class
 * 
 * @category Class
 * @package  UserRepository
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/Repository/UserRepository.php
 *  
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(
 * array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements UserLoaderInterface
{
    /**
     * The class constructor
     *
     * @param RegistryInterface $registry 
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }
    /**
     * This methode allows load the user using his unique username 
     *
     * @param string $username 
     *  
     * @return void
     */
    public function loadUserByUsername($username)
    {
        return $this->createQueryBuilder('u')
            ->where('u.username = :query')
            ->setParameter('query', $username)
            ->getQuery()
            ->getOneOrNullResult();
    }
}

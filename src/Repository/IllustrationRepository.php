<?php
namespace App\Repository;

use App\Entity\Illustration;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Illustration|null find($id, $lockMode = null, $lockVersion = null)
 * @method Illustration|null findOneBy(array $criteria, array $orderBy = null)
 * @method Illustration[]    findAll()
 * @method Illustration[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IllustrationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Illustration::class);
    }
}

<?php

namespace App\Repository;

use App\Entity\AdOption;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method AdOption|null find($id, $lockMode = null, $lockVersion = null)
 * @method AdOption|null findOneBy(array $criteria, array $orderBy = null)
 * @method AdOption[]    findAll()
 * @method AdOption[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdOptionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AdOption::class);
    }

    // /**
    //  * @return AdOption[] Returns an array of AdOption objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AdOption
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

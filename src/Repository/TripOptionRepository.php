<?php

namespace App\Repository;

use App\Entity\TripOption;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TripOption|null find($id, $lockMode = null, $lockVersion = null)
 * @method TripOption|null findOneBy(array $criteria, array $orderBy = null)
 * @method TripOption[]    findAll()
 * @method TripOption[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TripOptionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TripOption::class);
    }

    // /**
    //  * @return TripOption[] Returns an array of TripOption objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TripOption
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

<?php

namespace App\Repository;

use App\Entity\AdBooking;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method AdBooking|null find($id, $lockMode = null, $lockVersion = null)
 * @method AdBooking|null findOneBy(array $criteria, array $orderBy = null)
 * @method AdBooking[]    findAll()
 * @method AdBooking[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdBookingRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AdBooking::class);
    }

    // /**
    //  * @return AdBooking[] Returns an array of AdBooking objects
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
    public function findOneBySomeField($value): ?AdBooking
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

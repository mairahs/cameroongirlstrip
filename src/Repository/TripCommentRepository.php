<?php

namespace App\Repository;

use App\Entity\TripComment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TripComment|null find($id, $lockMode = null, $lockVersion = null)
 * @method TripComment|null findOneBy(array $criteria, array $orderBy = null)
 * @method TripComment[]    findAll()
 * @method TripComment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TripCommentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TripComment::class);
    }

    // /**
    //  * @return TripComment[] Returns an array of TripComment objects
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
    public function findOneBySomeField($value): ?TripComment
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function getTripCommentsOnUser($traveller)
    {
        return $this->createQueryBuilder('trc')
                    ->select('trc as tripComment, t as trip')
                    ->join('trc.trip', 't')
                    ->join('t.traveller', 'tra')
                    ->where('t.traveller = :traveller')
                    ->setParameter('traveller', $traveller)
                    ->getQuery()
                    ->getResult();
    }
}

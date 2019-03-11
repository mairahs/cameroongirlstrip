<?php

namespace App\Repository;

use App\Entity\AdComment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method AdComment|null find($id, $lockMode = null, $lockVersion = null)
 * @method AdComment|null findOneBy(array $criteria, array $orderBy = null)
 * @method AdComment[]    findAll()
 * @method AdComment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdCommentRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AdComment::class);
    }

    // /**
    //  * @return AdComment[] Returns an array of AdComment objects
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
    public function findOneBySomeField($value): ?AdComment
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

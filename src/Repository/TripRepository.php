<?php

namespace App\Repository;

use App\Entity\Trip;
use App\Entity\TripSearch;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Trip|null find($id, $lockMode = null, $lockVersion = null)
 * @method Trip|null findOneBy(array $criteria, array $orderBy = null)
 * @method Trip[]    findAll()
 * @method Trip[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TripRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Trip::class);
    }

    // /**
    //  * @return Trip[] Returns an array of Trip objects
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
    public function findOneBySomeField($value): ?Trip
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * provide all trips created by the users which are not empty
     *@return Trip[] Returns an array of Trip objects
     */
    public function getAllTripsSearch(TripSearch $tripSearch)
    {
        $query = $this->findEmptyTrips();

        if($tripSearch->getDepartureDate())
        {
            $query = $query->andWhere('t.departureDate >= :departureDate')
                           ->setParameter('departureDate', $tripSearch->getDepartureDate())
                           ->orderBy('t.departureDate', 'ASC');
        }

        if($tripSearch->getArrival())
        {
            $query = $query->andWhere('t.arrival = :arrival')
                           ->setParameter('arrival', $tripSearch->getArrival());
        }

        if($tripSearch->getPrice())
        {
            $query = $query->andWhere('t.price <= :price')
                           ->setParameter('price', $tripSearch->getPrice());
        }
        return $query->getQuery()
                     ->getResult();            
    }
    
    /**
     * provide the last trips created by the users
     * @param  integer $limit
     * @return Trip[] Returns an array of Trip objects
     */
    public function getLastTrips($limit)
    {
        return $this->findEmptyTrips()
                    ->select('t as trip')
                    ->join('t.traveller', 'tra')
                    ->groupBy('t')
                    ->orderBy('t.createdAt', 'DESC')
                    ->setMaxResults($limit)
                    ->getQuery()
                    ->getResult();
    }

    private function findEmptyTrips()
    {
        return $this->createQueryBuilder('t')
                    ->where('t.numberPersons != 0');
    }

    /**
     * provide all trips created by the users which are not empty
     *@return Trip[] Returns an array of Trip objects
     */
    public function getAllTrips()
    {
        return $this->findEmptyTrips()
                    ->join('t.traveller', 'tra')
                    ->groupBy('t')
                    ->orderBy('t.createdAt', 'DESC')
                    ->getQuery()
                    ->getResult();
    }
    
}

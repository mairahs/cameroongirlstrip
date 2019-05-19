<?php

namespace App\Repository;

use App\Entity\Ad;
use App\Entity\User;
use App\Entity\AdSearch;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Ad|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ad|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ad[]    findAll()
 * @method Ad[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Ad::class);
    }

    // /**
    //  * @return Ad[] Returns an array of Ad objects
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
    public function findOneBySomeField($value): ?Ad
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * provide the best ads created by the users
     * @param  integer $limit
     *@return Trip[] Returns an array of Ad objects
     */
    public function getBestAds($limit)
    {
        return $this->createQueryBuilder('a')
                    ->select('a as ad, AVG(adc.rating) as avgRatings, pic as picture')
                    ->join('a.author', 'auth')
                    ->join('a.adComments', 'adc')
                    ->join('a.pictures', 'pic')
                    ->groupBy('a')
                    ->orderBy('avgRatings', 'DESC')
                    ->setMaxResults($limit)
                    ->getQuery()
                    ->getResult();
    }

    /**
     * provide all ads created by the users
     *@return Ad[] Returns an array of Ad objects
     */
    public function getAllAds()
    {
        return $this->createQueryBuilder('a')
                    ->join('a.author', 'auth')
                    ->groupBy('a')
                    ->getQuery()
                    ->getResult();
    }

    /**
     * provide all ads created by the users
     * @return Query
     */
    public function getAllAdsSearch(AdSearch $adSearch)
    {
        $query = $this->createQueryBuilder('a');
        if($adSearch->getLocation())
        {
            $query = $query->andWhere('a.location = :location')
                           ->setParameter('location', $adSearch->getLocation());
        }
        if($adSearch->getPrice())
        {
            $query = $query->andWhere('a.price <= :price')
                           ->setParameter('price', $adSearch->getPrice());
        }
        if($adSearch->getRooms())
        {
            $query = $query->andWhere('a.rooms >= :rooms')
                           ->setParameter('rooms', $adSearch->getRooms());
        }
        if($adSearch->getAdOptions()->count() > 0)
        {
            $k = 0;
            foreach($adSearch->getAdOptions() as $adOption)
            {
                $k++;
                $query = $query->andWhere(":adOption$k MEMBER OF a.adOptions")
                               ->setParameter("adOption$k", $adOption);
            }
        }
        return $query->getQuery();
        
    }

    /**
     * provide all ads created by a specific user
     * @param Object  $user of specific user
     * @return Ad[] Returns an array of Trip objects
     */
    public function getAllAdsByUser(User $author)
    {
        return $this->createQueryBuilder('a')
        ->andWhere('a.author = :author')
        ->setParameter('author', $author)
        ->orderBy('a.price', 'DESC')
        ->getQuery()
        ->getResult(); 
    }

}

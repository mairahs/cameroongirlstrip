<?php

namespace App\Statistics;

use Doctrine\Common\Persistence\ObjectManager;

class Statistics
{
    private $manager;

	public function __construct(ObjectManager $manager)
	{
		$this->manager = $manager;
	}

	public function getStats()
	{
		$usersNumber 	    = $this->getUsersCount();
        $adsNumber 		    = $this->getAdsCount();
        $tripsNumber        = $this->getTripsCount();
        $adBookingsNumber   = $this->getAdBookingsCount();
        $tripBookingsNumber = $this->getATripBookingsCount();
        $adCommentsNumber   = $this->getAdCommentsCount();
        $tripCommentsNumber = $this->getTripCommentsCount();

		return compact('usersNumber', 'adsNumber', 'tripsNumber', 'adBookingsNumber', 'tripBookingsNumber', 'adCommentsNumber', 'tripCommentsNumber');
	}

	public function getUsersCount()
	{
		return $this->manager->createQuery('SELECT COUNT(u) FROM App\Entity\User u')->getSingleScalarResult();
	}

	public function getAdsCount()
	{
		return $this->manager->createQuery('SELECT COUNT(a) FROM App\Entity\Ad a')->getSingleScalarResult();
    }
    
    public function getTripsCount()
    {
        return $this->manager->createQuery('SELECT COUNT(t) FROM App\Entity\Trip t')->getSingleScalarResult();
    }

	public function getAdBookingsCount()
	{
		return $this->manager->createQuery('SELECT COUNT(b) FROM App\Entity\AdBooking b')->getSingleScalarResult();
    }
    
    public function getATripBookingsCount()
	{
		return $this->manager->createQuery('SELECT COUNT(b) FROM App\Entity\TripBooking b')->getSingleScalarResult();
	}

	public function getAdCommentsCount()
	{
		return $this->manager->createQuery('SELECT COUNT(c) FROM App\Entity\AdComment c')->getSingleScalarResult();
    }
    
    public function getTripCommentsCount()
	{
		return $this->manager->createQuery('SELECT COUNT(c) FROM App\Entity\TripComment c')->getSingleScalarResult();
	}


	public function getAdsStats($direction)
	{
		return $this->manager
			->createQuery(
				'SELECT AVG(c.rating) as note, a.title, a.id, u.firstName, u.lastName, u.picture 
				FROM App\Entity\AdComment c
					JOIN c.ad a
					JOIN a.author u
					GROUP BY a
					ORDER BY note '. $direction )
		    ->setMaxResults(10)
		    ->getResult();
    }
    
    public function getTripsStats($direction)
    {
        return $this->manager
            ->createQuery(
                'SELECT AVG(c.rating) as note, t.departure, t.arrival, t.id, tra.firstName, tra.lastName, tra.picture
                 FROM App\Entity\TripComment c 
                      JOIN c.trip t
                      JOIN t.traveller tra
                      GROUP BY t
                      ORDER BY note '. $direction)
            ->setMaxResults(10)
		    ->getResult();
    }
}
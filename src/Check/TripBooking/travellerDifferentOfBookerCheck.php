<?php

namespace App\Check\TripBooking;

use App\Entity\TripBooking;


class travellerDifferentOfBookerCheck
{
     /**
      * check if the booker of a trip is different of the traveller of the same trip
      *
      * @param $tripBooking
      *
      * @return boolean
      */
     public function check(TripBooking $tripBooking ): bool
    {
        return $tripBooking->getTripBooker() !== $tripBooking->getTrip()->getTraveller();
    } 
}
<?php

namespace App\Check\TripBooking;

use App\Entity\TripBooking;

class fullTripCheck
{
   
    /**
     * check if the trip which booker wants to edit the booking is full
     * @return bool
     */
    public function check(TripBooking $tripBooking): bool
    {
        return $tripBooking->getTrip()->getNumberPersons() == 0;
     }
}
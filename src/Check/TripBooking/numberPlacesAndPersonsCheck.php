<?php

namespace App\Check\TripBooking;

use App\Entity\TripBooking;

class numberPlacesAndPersonsCheck
{
   
    /**
     * check if booker gives a places's number higher more than the number of people required
     *
     * @return bool
     */
    public function check(TripBooking $tripBooking): bool
    {
        return $tripBooking->getNumberPlaces() <= $tripBooking->getTrip()->getNumberPersons();
     }
}
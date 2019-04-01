<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use App\Entity\Trip;
use Twig\TwigFunction;
use Carbon\Carbon;

class CreatedAtTripExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('format_created_at_trip', [$this, 'formatCreatedAtTrip']),
        ];
    }

    public function formatCreatedAtTrip(Trip $trip)
    {
        $parsedDate = Carbon::parse($trip->getCreatedAt(), 'UTC');
        $formatDate = $parsedDate->locale('fr_FR')->isoFormat('LL');

        return $formatDate;
    }
}
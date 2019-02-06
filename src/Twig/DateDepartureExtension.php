<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use App\Entity\Trip;
use Twig\TwigFunction;
use Carbon\Carbon;

class DateDepartureExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('format_date_departure', [$this, 'formatDateDeparture']),
        ];
    }

    public function formatDateDeparture(Trip $trip)
    {
        $parsedDate = Carbon::parse($trip->getDepartureDate(), 'UTC');
        $formatDate = $parsedDate->locale('fr_FR')->isoFormat('LL');

        return $formatDate;
    }
}

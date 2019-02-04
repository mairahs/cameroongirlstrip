<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use App\Entity\Trip;
use Twig\TwigFunction;
use Carbon\Carbon;

class DateCreatedAtExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('format_date_created_at', [$this, 'formatDateCreatedAt']),
        ];
    }

    public function formatDateCreatedAt(Trip $trip)
    {
        $parsedDate = Carbon::parse($trip->getTripDate(), 'UTC');
        $formatDate = $parsedDate->locale('fr_FR')->isoFormat('LL');

        return $formatDate;
    }
}

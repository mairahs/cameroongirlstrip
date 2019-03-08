<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use App\Entity\TripBooking;
use Twig\TwigFunction;
use Carbon\Carbon;

class CreatedAtExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('format_created_at', [$this, 'formatCreatedAt']),
        ];
    }

    public function formatCreatedAt(TripBooking $tripBooking)
    {
        $parsedDate = Carbon::parse($tripBooking->getCreatedAt(), 'UTC');
        $formatDate = $parsedDate->locale('fr_FR')->isoFormat('LL');

        return $formatDate;
    }
}

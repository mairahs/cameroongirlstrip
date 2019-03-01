<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use App\Entity\AdBooking;
use Twig\TwigFunction;
use Carbon\Carbon;

class EndDateExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('format_end_date', [$this, 'formatEndDate']),
        ];
    }

    public function formatEndDate(AdBooking $adBooking)
    {
        $parsedDate = Carbon::parse($adBooking->getEndDate(), 'UTC');
        $formatDate = $parsedDate->locale('fr_FR')->isoFormat('LL');

        return $formatDate;
    }
}

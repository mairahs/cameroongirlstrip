<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use App\Entity\AdBooking;
use Twig\TwigFunction;
use Carbon\Carbon;

class StartDateExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('format_start_date', [$this, 'formatStartDate']),
        ];
    }

    public function formatStartDate(AdBooking $adBooking)
    {
        $parsedDate = Carbon::parse($adBooking->getStartDate(), 'UTC');
        $formatDate = $parsedDate->locale('fr_FR')->isoFormat('LL');

        return $formatDate;
    }
}

<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use App\Entity\AdBooking;
use Twig\TwigFunction;
use Carbon\Carbon;

class DateEndExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('format_date_end', [$this, 'formatDateEnd']),
        ];
    }

    public function formatDateEnd(AdBooking $adBooking)
    {
        $parsedDate = Carbon::parse($adBooking->getEndDate(), 'UTC');
        $formatDate = $parsedDate->locale('fr_FR')->isoFormat('LL');

        return $formatDate;
    }
}
<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use App\Entity\Trip;
use Twig\TwigFunction;
use Carbon\Carbon;

class DateReturnExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('format_date_return', [$this, 'formatDateReturn']),
        ];
    }

    public function formatDateReturn(Trip $trip)
    {
        $parsedDate = Carbon::parse($trip->getReturnDate(), 'UTC');
        $formatDate = $parsedDate->locale('fr_FR')->isoFormat('LL');

        return $formatDate;
    }
}

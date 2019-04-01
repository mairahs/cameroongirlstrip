<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use App\Entity\TripComment;
use Twig\TwigFunction;
use Carbon\Carbon;

class CreatedAtTripCommentExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('format_created_at_trip_comment', [$this, 'formatCreatedAtTripComment']),
        ];
    }

    public function formatCreatedAtTripComment(TripComment $tripComment)
    {
        $parsedDate = Carbon::parse($tripComment->getCreatedAt(), 'UTC');
        $formatDate = $parsedDate->locale('fr_FR')->isoFormat('LL');

        return $formatDate;
    }
}
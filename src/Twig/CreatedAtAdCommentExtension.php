<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use App\Entity\AdComment;
use Twig\TwigFunction;
use Carbon\Carbon;

class CreatedAtAdCommentExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('format_created_at_ad_comment', [$this, 'formatCreatedAtAdComment']),
        ];
    }

    public function formatCreatedAtAdComment(AdComment $adComment)
    {
        $parsedDate = Carbon::parse($adComment->getCreatedAt(), 'UTC');
        $formatDate = $parsedDate->locale('fr_FR')->isoFormat('LL');

        return $formatDate;
    }
}
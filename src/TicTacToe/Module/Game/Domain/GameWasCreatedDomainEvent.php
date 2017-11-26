<?php

declare(strict_types=1);

namespace Kev\TicTacToe\Module\Game\Domain;

use Kev\Shared\Domain\Bus\Event\DomainEvent;

final class GameWasCreatedDomainEvent extends DomainEvent
{
    public static function eventName(): string
    {
        return 'game_was_created';
    }

    protected function rules(): array
    {
        return [
            'xPlayerId' => ['string'],
            'oPlayerId' => ['string'],
        ];
    }
}

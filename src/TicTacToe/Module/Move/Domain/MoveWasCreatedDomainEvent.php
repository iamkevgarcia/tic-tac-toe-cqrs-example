<?php

declare(strict_types=1);

namespace Kev\TicTacToe\Module\Move\Domain;

use Kev\Shared\Domain\Bus\Event\DomainEvent;

final class MoveWasCreatedDomainEvent extends DomainEvent
{
    public static function eventName(): string
    {
        return 'move_was_created';
    }

    protected function rules(): array
    {
        return [
            'gameId'    => ['string'],
            'playerId'  => ['string'],
            'position'  => ['int']
        ];
    }
}

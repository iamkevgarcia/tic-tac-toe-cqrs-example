<?php

declare(strict_types=1);

namespace Kev\TicTacToe\Module\User\Domain;

use Kev\Shared\Domain\Bus\Event\DomainEvent;

final class UserWasCreatedDomainEvent extends DomainEvent
{
    public static function eventName(): string
    {
        return 'user_was_created';
    }

    protected function rules(): array
    {
        return [];
    }
}

<?php

declare(strict_types=1);

namespace Kev\TicTacToe\Module\User\Domain;

use Kev\Types\Aggregate\AggregateRoot;

final class User extends AggregateRoot
{
    private $id;

    private function __construct(UserId $id)
    {
        $this->id = $id;
    }

    public static function create(UserId $id): User
    {
        $game = new self($id);

        $game->record(
            new UserWasCreatedDomainEvent(
                $id->value(),
                []
            )
        );

        return $game;
    }

    public function id(): UserId
    {
        return $this->id;
    }
}

<?php

declare(strict_types=1);

namespace Kev\TicTacToe\Module\Game\Domain;

use Kev\Types\Aggregate\AggregateRoot;

final class Game extends AggregateRoot
{
    private $id;

    private function __construct(GameId $id)
    {
        $this->id = $id;
    }

    public static function start(GameId $id): Game
    {
        $game = new self($id);

        $game->record(
            new GameWasCreatedDomainEvent(
                $id->value(),
                []
            )
        );

        return $game;
    }

    public function id(): GameId
    {
        return $this->id;
    }
}

<?php

declare(strict_types=1);

namespace Kev\TicTacToe\Module\Move\Application\Make;

use Kev\TicTacToe\Module\Game\Domain\GameId;
use Kev\TicTacToe\Module\Game\Domain\PlayerId;
use Kev\TicTacToe\Module\Move\Domain\MoveId;
use Kev\TicTacToe\Module\Move\Domain\Position;

final class MakeAMoveCommandHandler
{
    private $initializer;

    public function __construct(MoveMaker $initializer)
    {
        $this->initializer = $initializer;
    }

    public function __invoke(MakeAMoveCommand $command): void
    {
        $id         = new MoveId($command->id());
        $gameId     = new GameId($command->gameId());
        $playerId   = new PlayerId($command->gameId());
        $position   = new Position($command->position());


    }
}

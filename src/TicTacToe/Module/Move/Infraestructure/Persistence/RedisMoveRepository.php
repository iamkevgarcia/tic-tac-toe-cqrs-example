<?php

declare(strict_types=1);

namespace Kev\TicTacToe\Module\Move\Infraestructure\Persistence;

use Kev\TicTacToe\Module\Game\Domain\GameId;
use Kev\TicTacToe\Module\Game\Domain\PlayerId;
use Kev\TicTacToe\Module\Move\Domain\Move;
use Kev\TicTacToe\Module\Move\Domain\MoveId;
use Kev\TicTacToe\Module\Move\Domain\MoveRepository;
use Kev\TicTacToe\Module\Move\Domain\Position;
use Kev\Types\ValueObject\Uuid;

final class RedisMoveRepository implements MoveRepository
{
    public function save(Move $game): void
    {

    }

    public function find(MoveId $id): ?Move
    {
        return Move::make($id, new GameId(Uuid::random()), new PlayerId(Uuid::random()), new Position(1));
    }
}

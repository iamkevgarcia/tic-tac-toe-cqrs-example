<?php

namespace Kev\TicTacToe\Module\Game\Tests\Domain;


use Kev\TicTacToe\Module\Game\Domain\GameId;
use Kev\TicTacToe\Module\Game\Domain\PlayerId;
use Kev\TicTacToe\Module\Move\Domain\Move;
use Kev\TicTacToe\Module\Move\Domain\MoveId;
use Kev\TicTacToe\Module\Move\Domain\Position;
use Kev\Types\ValueObject\Uuid;

final class MoveStub
{
    private static function make(string $playerId, string $gameId, int $position): Move
    {
        return Move::make(
            new MoveId(Uuid::random()->value()),
            new GameId($gameId),
            new PlayerId($playerId),
            new Position($position)
        );
    }

    public static function random(): Move
    {
        return self::make(Uuid::random(), Uuid::random(), 1);
    }

    public static function withPlayerId(string $playerId): Move
    {
        return self::make($playerId, Uuid::random(), 1);
    }

    public static function with(string $playerId, string $gameId, int $position): Move
    {
        return self::make($playerId, $gameId, $position);
    }
}

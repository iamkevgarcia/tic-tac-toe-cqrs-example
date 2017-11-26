<?php

declare(strict_types=1);

namespace Kev\TicTacToe\Module\Move\Domain;

use Kev\TicTacToe\Module\Game\Domain\GameId;
use Kev\TicTacToe\Module\Game\Domain\PlayerId;
use Kev\Types\Aggregate\AggregateRoot;
use function sprintf;

final class Move extends AggregateRoot
{
    const MAX_POSITION = 8;

    private $id;
    private $gameId;
    private $playerId;
    private $position;

    private function __construct(MoveId $id, GameId $gameId, PlayerId $playerId, Position $position)
    {
        $this->id = $id;
        $this->gameId = $gameId;
        $this->playerId = $playerId;
        $this->position = $position;
    }

    public static function make(MoveId $id, GameId $gameId, PlayerId $playerId, Position $position): Move
    {
        self::checkPositionIsNotGreaterThanMaximum($position);
        $game = new self($id, $gameId, $playerId, $position);

        $game->record(
            new MoveWasCreatedDomainEvent(
                $id->value(),
                [
                    'gameId'    => $gameId->value(),
                    'playerId'  => $playerId->value(),
                    'position'  => $position->value()
                ]
            )
        );

        return $game;
    }

    private static function checkPositionIsNotGreaterThanMaximum(Position $position): void
    {
        if ($position->value() > self::MAX_POSITION) {
            throw new InvalidGivenPositionException(sprintf('Position can not be greater than <%u>', self::MAX_POSITION));
        }
    }

    public function id(): MoveId
    {
        return $this->id;
    }

    public function gameId(): GameId
    {
        return $this->gameId;
    }

    public function playerId(): PlayerId
    {
        return $this->playerId;
    }

    public function position(): Position
    {
        return $this->position;
    }
}

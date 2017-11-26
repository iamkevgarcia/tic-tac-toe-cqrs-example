<?php

declare(strict_types=1);

namespace Kev\TicTacToe\Module\Game\Domain;

use Kev\TicTacToe\Module\Move\Domain\Move;
use Kev\Types\Aggregate\AggregateRoot;
use function sprintf;

final class Game extends AggregateRoot
{
    const MAX_MOVES = 8;

    private $id;
    private $xPlayerId;
    private $oPlayerId;
    private $moves;

    private function __construct(GameId $id, PlayerId $xPlayerId, PlayerId $oPlayerId)
    {
        $this->id = $id;
        $this->xPlayerId = $xPlayerId;
        $this->oPlayerId = $oPlayerId;
        $this->moves = [];
    }

    public static function start(GameId $id, PlayerId $xPlayerId, PlayerId $oPlayerId): Game
    {
        $game = new self($id, $xPlayerId, $oPlayerId);

        $game->record(
            new GameWasCreatedDomainEvent(
                $id->value(),
                [
                    'xPlayerId' => $xPlayerId->value(),
                    'oPlayerId' => $oPlayerId->value(),
                ]
            )
        );

        return $game;
    }

    public function id(): GameId
    {
        return $this->id;
    }

    public function xPlayerId(): PlayerId
    {
        return $this->xPlayerId;
    }

    public function oPlayerId(): PlayerId
    {
        return $this->oPlayerId;
    }

    public function addMove(Move $move): void
    {
        $this->checkMaxOfMovesAreNotExceeded();
        $this->checkMoveWasMadeByOneOfThisPlayers($move->playerId());
        $this->checkMoveGameIsSameAsThis($move->gameId());
        $this->moves[] = $move;
    }

    private function checkMaxOfMovesAreNotExceeded(): void
    {
        if (count($this->moves) >= self::MAX_MOVES) {
            throw new GameMovesExceededException('No more moves allowed');
        }
    }

    private function checkMoveWasMadeByOneOfThisPlayers(PlayerId $playerId): void
    {
        if (!$playerId->equals($this->xPlayerId) && !$playerId->equals($this->oPlayerId)) {
            throw new PlayerWhoDidMoveIsNotAGamePlayerException(
                sprintf('Player <%s> is not a player of <%s> game', $playerId->value(), $this->id->value())
            );
        }
    }

    private function checkMoveGameIsSameAsThis(GameId $gameId): void
    {
        if (!$this->id->equals($gameId)) {
            throw new MoveDoNotBelongsToSpecifiedGameException(
                sprintf('Given move do not belong to game with <%s> id', $this->id->value())
            );
        }
    }
}

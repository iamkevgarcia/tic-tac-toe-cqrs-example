<?php

declare(strict_types=1);

namespace Kev\TicTacToe\Module\Game\Domain;

use Kev\TicTacToe\Module\Move\Domain\Move;
use Kev\TicTacToe\Module\Move\Domain\Position;
use Kev\Types\Aggregate\AggregateRoot;
use function sprintf;

final class Game extends AggregateRoot
{
    const MAX_MOVES = 8;
    const POSSIBLE_COMBINATIONS = [
        [0, 1, 2],
        [3, 4, 5],
        [6, 7, 8],
        [0, 3, 6],
        [1, 4, 7],
        [2, 5, 8],
        [0, 4, 8],
        [2, 4, 6]
    ];

    private $id;
    private $xPlayerId;
    private $oPlayerId;
    private $moves;
    private $winner;
    private $isFinished;

    private function __construct(GameId $id, PlayerId $xPlayerId, PlayerId $oPlayerId)
    {
        $this->id = $id;
        $this->xPlayerId = $xPlayerId;
        $this->oPlayerId = $oPlayerId;
        $this->moves = [];
        $this->winner = null;
        $this->isFinished = false;
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

    public function winner(): ?PlayerId
    {
        return $this->winner;
    }

    public function isFinished(): bool
    {
        return $this->isFinished;
    }

    public function addMove(Move $move): void
    {
        $this->checkMaxOfMovesAreNotExceeded();
        $this->checkMoveWasMadeByOneOfThisPlayers($move->playerId());
        $this->checkMoveGameIsSameAsThis($move->gameId());
        $this->checkThatMovePositionIsNotAlreadyTaken($move->position());
        $this->checkMovePlayerIsNotSameAsLastOne($move->playerId());
        $this->moves[] = $move;
        $this->isFinished = count($this->moves) === self::MAX_MOVES;
        $this->ifThereIsAWinnerFinishTheGame();
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

    private function checkThatMovePositionIsNotAlreadyTaken(Position $position): void
    {
        foreach ($this->moves as $move) {
            if ($move->position()->equalsTo($position)) {
                throw new PositionAlreadyTakenException(sprintf('Position <%u> already taken', $position->value()));
            }
        }
    }

    private function checkMovePlayerIsNotSameAsLastOne(PlayerId $playerId): void
    {
        if (empty($this->moves)) return;

        $lastMove = end($this->moves);
        if ($playerId->equals($lastMove->playerId())) {
            throw new PlayerCanNotMakeConsecutiveMovesException('Player can not make two consecutive moves');
        }
    }

    private function ifThereIsAWinnerFinishTheGame(): void
    {
        if (empty($this->moves) || count($this->moves) < 5) return;

        if ($this->thereIsAWinner()) {
            $this->isFinished = true;
            $this->setLastPlayerAsAWinner();
        }
    }

    private function thereIsAWinner(): bool
    {
        if ($this->isFinished) return !empty($this->winner);

        $lastPlayer = (end($this->moves))->playerId();

        $playerMovePositions = $this->getMovePositionsByPlayer($lastPlayer);
        foreach (self::POSSIBLE_COMBINATIONS as $combination) {
            if (!array_diff($combination, $playerMovePositions)) {
                $this->winner = $lastPlayer;
                return true;
            }
        }

        return false;
    }

    private function getMovePositionsByPlayer(PlayerId $lastPlayer): array
    {
        $positions = [];

        foreach ($this->moves as $move) {
            if ($move->playerId()->equals($lastPlayer)) {
                $positions[] = $move->position()->value();
            }
        }

        return $positions;
    }

    private function setLastPlayerAsAWinner(): void
    {
        $lastMove = end($this->moves);
        $this->winner = $lastMove->playerId();
    }
}

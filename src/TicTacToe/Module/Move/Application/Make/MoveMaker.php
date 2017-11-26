<?php

declare(strict_types=1);

namespace Kev\TicTacToe\Module\Move\Application\Make;

use Kev\Shared\Domain\Bus\Event\DomainEventPublisher;
use Kev\TicTacToe\Module\Game\Domain\GameId;
use Kev\TicTacToe\Module\Game\Domain\PlayerId;
use Kev\TicTacToe\Module\Move\Domain\Move;
use Kev\TicTacToe\Module\Move\Domain\MoveId;
use Kev\TicTacToe\Module\Move\Domain\MoveRepository;
use Kev\TicTacToe\Module\Move\Domain\Position;

final class MoveMaker
{
    private $repository;
    private $publisher;

    public function __construct(MoveRepository $repository, DomainEventPublisher $publisher)
    {
        $this->repository = $repository;
        $this->publisher = $publisher;
    }

    public function start(MoveId $id, GameId $gameId, PlayerId $playerId, Position $position): void
    {
        $user = Move::make($id, $gameId, $playerId, $position);

        $this->repository->save($user);

        $this->publisher->publish(...$user->pullDomainEvents());
    }
}

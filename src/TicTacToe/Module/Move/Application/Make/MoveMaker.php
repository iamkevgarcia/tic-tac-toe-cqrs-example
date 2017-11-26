<?php

declare(strict_types=1);

namespace Kev\TicTacToe\Module\Move\Application\Make;

use Kev\Shared\Domain\Bus\Event\DomainEventPublisher;
use Kev\TicTacToe\Module\Game\Domain\GameId;
use Kev\TicTacToe\Module\Game\Domain\GameRepository;
use Kev\TicTacToe\Module\Game\Domain\PlayerId;
use Kev\TicTacToe\Module\Move\Domain\Move;
use Kev\TicTacToe\Module\Move\Domain\MoveId;
use Kev\TicTacToe\Module\Move\Domain\MoveRepository;
use Kev\TicTacToe\Module\Move\Domain\Position;

final class MoveMaker
{
    private $repository;
    private $publisher;
    private $gameRepo;

    public function __construct(MoveRepository $repository, DomainEventPublisher $publisher, GameRepository $gameRepo)
    {
        $this->repository = $repository;
        $this->publisher = $publisher;
        $this->gameRepo = $gameRepo;
    }

    public function start(MoveId $id, GameId $gameId, PlayerId $playerId, Position $position): void
    {
        // TODO: Much more better to throw queries by using the query bus, but this is just an example of how to make sure that game exists.
        $this->gameRepo->findOrFail($gameId);

        $user = Move::make($id, $gameId, $playerId, $position);

        $this->repository->save($user);

        $this->publisher->publish(...$user->pullDomainEvents());
    }
}

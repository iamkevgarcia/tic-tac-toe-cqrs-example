<?php

declare(strict_types=1);

namespace Kev\TicTacToe\Module\Game\Application\Start;

use Kev\Shared\Domain\Bus\Event\DomainEventPublisher;
use Kev\TicTacToe\Module\Game\Domain\Game;
use Kev\TicTacToe\Module\Game\Domain\GameId;
use Kev\TicTacToe\Module\Game\Domain\GameRepository;
use Kev\TicTacToe\Module\Game\Domain\PlayerId;

final class GameInitializer
{
    private $repository;
    private $publisher;

    public function __construct(GameRepository $repository, DomainEventPublisher $publisher)
    {
        $this->repository = $repository;
        $this->publisher = $publisher;
    }

    public function start(GameId $id, PlayerId $XPlayerId, PlayerId $OPlayerId): void
    {
        $user = Game::start($id, $XPlayerId, $OPlayerId);

        $this->repository->save($user);

        $this->publisher->publish(...$user->pullDomainEvents());
    }
}

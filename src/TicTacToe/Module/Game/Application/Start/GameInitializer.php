<?php

declare(strict_types=1);

namespace Kev\TicTacToe\Module\Game\Application\Start;

use Kev\Shared\Domain\Bus\Event\DomainEventPublisher;
use Kev\TicTacToe\Module\Game\Domain\Game;
use Kev\TicTacToe\Module\Game\Domain\GameId;
use Kev\TicTacToe\Module\Game\Domain\GameRepository;
use Kev\TicTacToe\Module\Game\Domain\PlayerId;
use Kev\TicTacToe\Module\User\Domain\UserId;
use Kev\TicTacToe\Module\User\Domain\UserRepository;

final class GameInitializer
{
    private $repository;
    private $publisher;
    private $userRepo;

    public function __construct(GameRepository $repository, DomainEventPublisher $publisher, UserRepository $userRepo)
    {
        $this->repository = $repository;
        $this->publisher = $publisher;
        $this->userRepo = $userRepo;
    }

    public function start(GameId $id, PlayerId $XPlayerId, PlayerId $OPlayerId): void
    {
        // TODO: Much more better to throw queries by using the query bus, but this is just an example of how to make sure that user exist.
        $this->userRepo->findOrFail(new UserId($XPlayerId->value()));
        $this->userRepo->findOrFail(new UserId($OPlayerId->value()));

        $user = Game::start($id, $XPlayerId, $OPlayerId);

        $this->repository->save($user);

        $this->publisher->publish(...$user->pullDomainEvents());
    }
}

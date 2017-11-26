<?php

declare(strict_types=1);

namespace Kev\TicTacToe\Module\User\Application\Create;

use Kev\Shared\Domain\Bus\Event\DomainEventPublisher;
use Kev\TicTacToe\Module\User\Domain\User;
use Kev\TicTacToe\Module\User\Domain\UserId;
use Kev\TicTacToe\Module\User\Domain\UserRepository;

final class UserCreator
{
    private $repository;
    private $publisher;

    public function __construct(UserRepository $repository, DomainEventPublisher $publisher)
    {
        $this->repository = $repository;
        $this->publisher  = $publisher;
    }

    public function create(UserId $id): void
    {
        $video = User::create($id);

        $this->repository->save($video);

        $this->publisher->publish(...$video->pullDomainEvents());
    }
}

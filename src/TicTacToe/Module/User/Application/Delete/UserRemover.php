<?php

declare(strict_types=1);

namespace Kev\TicTacToe\Module\User\Application\Delete;

use Kev\Shared\Domain\Bus\Event\DomainEventPublisher;
use Kev\TicTacToe\Module\User\Domain\User;
use Kev\TicTacToe\Module\User\Domain\UserId;
use Kev\TicTacToe\Module\User\Domain\UserNotFoundException;
use Kev\TicTacToe\Module\User\Domain\UserRepository;

final class UserRemover
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
        $user = $this->findUserOrFail($id);

        $this->repository->remove($user);

        $this->publisher->publish(...$user->pullDomainEvents());
    }

    private function findUserOrFail($id): User
    {
        if (!$user = $this->repository->find($id)) {
            throw new UserNotFoundException(sprintf('Unable with <%s> id does not exist', $id));
        }

        return $user;
    }
}

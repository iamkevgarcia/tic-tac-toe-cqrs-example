<?php

declare(strict_types=1);

namespace Kev\TicTacToe\Module\User\Infraestructure\Persistence;

use Kev\TicTacToe\Module\User\Domain\User;
use Kev\TicTacToe\Module\User\Domain\UserId;
use Kev\TicTacToe\Module\User\Domain\UserRepository;

final class MySqlUserRepository implements UserRepository
{
    public function find(UserId $id): ?User
    {
        return User::create($id);
    }

    public function save(User $user): void
    {
        echo "saved";
    }
}

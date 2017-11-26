<?php

declare(strict_types=1);

namespace Kev\TicTacToe\Module\User\Domain;


interface UserRepository
{
    function save(User $user): void;

    function find(UserId $id): ?User;

    function findOrFail(UserId $id): User;

    function remove(User $user): void;
}

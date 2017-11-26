<?php

declare(strict_types=1);

namespace Kev\TicTacToe\Module\User\Application\Delete;

use Kev\TicTacToe\Module\User\Domain\UserId;

final class DeleteUserCommandHandler
{
    private $creator;

    public function __construct(UserRemover $creator)
    {
        $this->creator = $creator;
    }

    public function __invoke(DeleteUserCommand $command): void
    {
        $id = new UserId($command->id());

        $this->creator->create($id);
    }
}

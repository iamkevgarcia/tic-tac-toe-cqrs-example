<?php

declare(strict_types=1);

namespace Kev\TicTacToe\Module\User\Application\Create;

use Kev\TicTacToe\Module\User\Domain\UserId;

final class CreateUserCommandHandler
{
    private $creator;

    public function __construct(UserCreator $creator)
    {
        $this->creator = $creator;
    }

    public function __invoke(CreateUserCommand $command): void
    {
        $id = new UserId($command->id());

        $this->creator->create($id);
    }
}

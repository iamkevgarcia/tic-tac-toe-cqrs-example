<?php

declare(strict_types=1);

namespace Kev\TicTacToe\Module\User\Application\Delete;

use Kev\Shared\Domain\Bus\Command\Command;
use Kev\Types\ValueObject\Uuid;

final class DeleteUserCommand extends Command
{
    private $id;

    public function __construct(Uuid $commandId, string $id)
    {
        parent::__construct($commandId);

        $this->id = $id;
    }

    public function id() : string
    {
        return $this->id;
    }
}

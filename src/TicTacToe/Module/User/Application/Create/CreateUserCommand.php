<?php

declare(strict_types=1);

namespace Kev\TicTacToe\Module\User\Application\Create;

use Kev\Shared\Domain\Bus\Command\Command;
use Kev\Types\ValueObject\Uuid;

final class CreateUserCommand extends Command
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

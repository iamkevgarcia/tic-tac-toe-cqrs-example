<?php

declare(strict_types=1);

namespace Kev\TicTacToe\Module\Move\Application\Make;

use Kev\Shared\Domain\Bus\Command\Command;
use Kev\Types\ValueObject\Uuid;

final class MakeAMoveCommand extends Command
{
    private $id;
    private $gameId;
    private $playerId;
    private $position;

    public function __construct(Uuid $commandId, string $id, string $gameId, string $playerId, int $position)
    {
        parent::__construct($commandId);

        $this->id = $id;
        $this->gameId = $gameId;
        $this->playerId = $playerId;
        $this->position = $position;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function gameId(): string
    {
        return $this->gameId;
    }

    public function playerId(): string
    {
        return $this->playerId;
    }

    public function position(): int
    {
        return $this->position;
    }
}

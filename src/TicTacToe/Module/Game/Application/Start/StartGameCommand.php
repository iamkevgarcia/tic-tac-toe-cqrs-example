<?php

declare(strict_types=1);

namespace Kev\TicTacToe\Module\Game\Application\Start;

use Kev\Shared\Domain\Bus\Command\Command;
use Kev\Types\ValueObject\Uuid;

final class StartGameCommand extends Command
{
    private $id;
    private $xPlayerId;
    private $oPlayerId;

    public function __construct(Uuid $commandId, string $id, string $xPlayerId, string $oPlayerId)
    {
        parent::__construct($commandId);

        $this->id = $id;
        $this->xPlayerId = $xPlayerId;
        $this->oPlayerId = $oPlayerId;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function xPlayerId(): string
    {
        return $this->xPlayerId;
    }

    public function oPlayerId(): string
    {
        return $this->oPlayerId;
    }
}

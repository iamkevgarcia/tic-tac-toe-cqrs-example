<?php

declare(strict_types=1);

namespace Kev\TicTacToe\Module\Game\Domain;

use Kev\Shared\Domain\Bus\Query\Response;

final class GameResponse implements Response
{
    private $id;
    private $xPlayerId;
    private $oPlayerId;
    private $isFinished;
    private $winner;

    public function __construct(string $id, string $xPlayerId, string $oPlayerId, bool $isFinished, ?string $winner)
    {
        $this->id           = $id;
        $this->xPlayerId    = $xPlayerId;
        $this->oPlayerId    = $oPlayerId;
        $this->isFinished   = $isFinished;
        $this->winner       = $winner;
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

    public function isFinished(): bool
    {
        return $this->isFinished;
    }

    public function winner(): ?string
    {
        return $this->winner;
    }
}

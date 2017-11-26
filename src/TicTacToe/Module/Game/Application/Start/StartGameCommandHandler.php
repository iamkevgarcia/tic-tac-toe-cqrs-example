<?php

declare(strict_types=1);

namespace Kev\TicTacToe\Module\Game\Application\Start;

use Kev\TicTacToe\Module\Game\Domain\GameId;
use Kev\TicTacToe\Module\Game\Domain\PlayerId;

final class StartGameCommandHandler
{
    private $initializer;

    public function __construct(GameInitializer $initializer)
    {
        $this->initializer = $initializer;
    }

    public function __invoke(StartGameCommand $command): void
    {
        $id         = new GameId($command->id());
        $xPlayerId  = new PlayerId($command->xPlayerId());
        $oPlayerId  = new PlayerId($command->oPlayerId());

        $this->initializer->start($id, $xPlayerId, $oPlayerId);
    }
}

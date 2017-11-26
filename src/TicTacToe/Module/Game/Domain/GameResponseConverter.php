<?php

declare(strict_types=1);

namespace Kev\TicTacToe\Module\Game\Domain;

final class GameResponseConverter
{
    public function __invoke(Game $game): GameResponse
    {
        return new GameResponse(
            $game->id()->value(),
            $game->xPlayerId()->value(),
            $game->oPlayerId()->value(),
            $game->isFinished(),
            $game->winner() ? $game->winner()->value(): null
        );
    }
}

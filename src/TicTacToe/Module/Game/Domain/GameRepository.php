<?php

declare(strict_types=1);

namespace Kev\TicTacToe\Module\Game\Domain;

interface GameRepository
{
    function save(Game $user): void;

    function find(GameId $id): ?Game;
}

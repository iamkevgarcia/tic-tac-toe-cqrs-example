<?php

declare(strict_types=1);

namespace Kev\TicTacToe\Module\Move\Domain;

interface MoveRepository
{
    function save(Move $user): void;

    function find(MoveId $id): ?Move;
}

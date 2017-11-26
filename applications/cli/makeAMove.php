<?php

use Kev\TicTacToe\Module\Game\Application\Start\StartGameCommand;
use Kev\TicTacToe\Module\Move\Application\Make\MakeAMoveCommand;
use Kev\Types\ValueObject\Uuid;

require __DIR__ . '/app.php';

try {
    $id         = $argv[1];
    $gameId     = $argv[2];
    $playerId   = $argv[3];
    $position   = $argv[4];
    $app->dispatch(new MakeAMoveCommand(Uuid::random(), $id, $gameId, $playerId, $position));
    echo sprintf('Move with id <%s> made' . PHP_EOL, $id);
} catch (\Exception $e) {
    error_log($e->getMessage(), $e->getCode());
    exit(1);
}

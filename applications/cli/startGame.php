<?php

use Kev\TicTacToe\Module\Game\Application\Start\StartGameCommand;
use Kev\Types\ValueObject\Uuid;

require __DIR__ . '/app.php';

try {
    $id = $argv[1];
    $xPlayerId = $argv[2];
    $oPlayerId = $argv[3];
    $app->dispatch(new StartGameCommand(Uuid::random(), $id, $xPlayerId, $oPlayerId));
    echo sprintf('Started game with id <%s>' . PHP_EOL, $id);
} catch (\Exception $e) {
    error_log($e->getMessage(), $e->getCode());
    exit(1);
}

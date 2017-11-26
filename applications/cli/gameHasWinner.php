<?php

use Kev\TicTacToe\Module\Game\Application\Find\FindGameQuery;

require __DIR__ . '/app.php';

try {
    $id = $argv[1];
    $gameResponse = $app->ask(new FindGameQuery($id));
    print_r($gameResponse->winner() ? 'Game winner is ' . $gameResponse->winner()->value() : 'Game has no winner');
    echo PHP_EOL;
} catch (\Exception $e) {
    error_log($e->getMessage(), $e->getCode());
    exit(1);
}

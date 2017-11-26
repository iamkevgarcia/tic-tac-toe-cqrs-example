<?php

use Kev\TicTacToe\Module\User\Application\Delete\DeleteUserCommand;
use Kev\Types\ValueObject\Uuid;

require __DIR__ . '/app.php';

try {
    $id = $argv[1];
    $app->dispatch(new DeleteUserCommand(Uuid::random(), $id));
    echo sprintf('Deleted user with id <%s>' . PHP_EOL, $id);
} catch (\Exception $e) {
    error_log($e->getMessage(), $e->getCode());
    exit(1);
}

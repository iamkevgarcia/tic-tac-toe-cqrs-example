<?php

require_once __DIR__ . '/../../vendor/autoload.php';

require_once __DIR__ . '/TicTacToeCliConsumer.php';

$app = new TicTacToeCliConsumer();
$app->init();

<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 26/11/17
 * Time: 11:26
 */

require_once __DIR__ . '/../../vendor/autoload.php';

require_once __DIR__ . '/TicTacToeCliConsumer.php';

$app = new TicTacToeCliConsumer();
$app->init();

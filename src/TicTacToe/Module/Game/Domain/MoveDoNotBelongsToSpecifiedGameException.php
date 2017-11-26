<?php

namespace Kev\TicTacToe\Module\Game\Domain;

use RuntimeException;

final class MoveDoNotBelongsToSpecifiedGameException extends RuntimeException
{
}

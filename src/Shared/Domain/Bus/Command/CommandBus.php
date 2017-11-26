<?php

declare (strict_types = 1);

namespace Kev\Shared\Domain\Bus\Command;

use RuntimeException;

interface CommandBus
{
    /**
     * @throws RuntimeException
     */
    public function register($commandClass, callable $handler): void;

    public function dispatch(Command $command): void;
}

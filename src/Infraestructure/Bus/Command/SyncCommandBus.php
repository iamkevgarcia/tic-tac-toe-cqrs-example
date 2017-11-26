<?php

declare (strict_types = 1);

namespace Kev\Infraestructure\Bus\Command;

use Kev\Shared\Domain\Bus\Command\Command;
use Kev\Shared\Domain\Bus\Command\CommandBus;
use Prooph\ServiceBus\CommandBus as ProophCommandBus;
use Prooph\ServiceBus\Plugin\Router\CommandRouter;
use RuntimeException;

final class SyncCommandBus implements CommandBus
{
    private $bus;
    private $router;
    private $routerIsAttached = false;

    public function __construct()
    {
        $this->bus    = new ProophCommandBus();
        $this->router = new CommandRouter();
    }

    public function register($commandClass, callable $handler): void
    {
        $this->guardRouterIsAttached();

        $this->router->route($commandClass)->to($handler);
    }

    public function dispatch(Command $command): void
    {
        $this->attachRouter();

        $this->bus->dispatch($command);
    }

    private function guardRouterIsAttached()
    {
        if ($this->routerIsAttached) {
            throw new RuntimeException('Trying to register a new handler after some dispatch has been done');
        }
    }

    private function attachRouter()
    {
        if (!$this->routerIsAttached) {
            $this->bus->utilize($this->router);

            $this->routerIsAttached = true;
        }
    }
}

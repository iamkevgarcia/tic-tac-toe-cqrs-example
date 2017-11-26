<?php

declare(strict_types=1);

use Kev\Shared\Domain\Bus\Command\Command;
use Kev\TicTacToe\Module\User\Application\Create\CreateUserCommandHandler;
use Kev\TicTacToe\Module\User\Application\Create\UserCreator;
use Kev\Infraestructure\Bus\Event\SyncDomainEventPublisher;
use Kev\Infraestructure\Bus\Command\SyncCommandBus;
use Kev\TicTacToe\Module\User\Application\Create\CreateUserCommand;
use Kev\TicTacToe\Module\User\Infraestructure\Persistence\MySqlUserRepository;

class TicTacToeCliConsumer
{
    private $bus;

    public function __construct()
    {
        $this->bus = new SyncCommandBus();
    }

    public function init(): void
    {
        $this->registerCreateUserUseCase();
    }

    private function registerCreateUserUseCase(): void
    {
        $repo       = new MySqlUserRepository();
        $creator    = new UserCreator($repo, new SyncDomainEventPublisher());
        $handler    = new CreateUserCommandHandler($creator);

        $this->bus->register(CreateUserCommand::class, $handler);
    }

    public function dispatch(Command $command): void
    {
        $this->bus->dispatch($command);
    }
}

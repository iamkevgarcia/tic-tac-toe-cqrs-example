<?php

declare(strict_types=1);

use Kev\Shared\Domain\Bus\Command\Command;
use Kev\TicTacToe\Module\Game\Application\Start\GameInitializer;
use Kev\TicTacToe\Module\Game\Application\Start\StartGameCommand;
use Kev\TicTacToe\Module\Game\Application\Start\StartGameCommandHandler;
use Kev\TicTacToe\Module\Game\Infraestructure\Persistence\DynamoDBGameRepository;
use Kev\TicTacToe\Module\Move\Application\Make\MakeAMoveCommand;
use Kev\TicTacToe\Module\Move\Application\Make\MakeAMoveCommandHandler;
use Kev\TicTacToe\Module\Move\Application\Make\MoveMaker;
use Kev\TicTacToe\Module\Move\Infraestructure\Persistence\RedisMoveRepository;
use Kev\TicTacToe\Module\User\Application\Create\CreateUserCommand;
use Kev\TicTacToe\Module\User\Application\Create\CreateUserCommandHandler;
use Kev\TicTacToe\Module\User\Application\Create\UserCreator;
use Kev\Infraestructure\Bus\Event\SyncDomainEventPublisher;
use Kev\Infraestructure\Bus\Command\SyncCommandBus;
use Kev\TicTacToe\Module\User\Application\Delete\DeleteUserCommand;
use Kev\TicTacToe\Module\User\Application\Delete\DeleteUserCommandHandler;
use Kev\TicTacToe\Module\User\Application\Delete\UserRemover;
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
        $this->registerDeleteUserUseCase();
        $this->registerStartGameUseCase();
        $this->registerMakeAMoveGameUseCase();
    }

    private function registerCreateUserUseCase(): void
    {
        $repo       = new MySqlUserRepository();
        $creator    = new UserCreator($repo, new SyncDomainEventPublisher());
        $handler    = new CreateUserCommandHandler($creator);

        $this->bus->register(CreateUserCommand::class, $handler);
    }

    private function registerDeleteUserUseCase(): void
    {
        $repo       = new MySqlUserRepository();
        $creator    = new UserRemover($repo, new SyncDomainEventPublisher());
        $handler    = new DeleteUserCommandHandler($creator);

        $this->bus->register(DeleteUserCommand::class, $handler);
    }

    public function dispatch(Command $command): void
    {
        $this->bus->dispatch($command);
    }

    private function registerStartGameUseCase()
    {
        $repo           = new DynamoDBGameRepository();
        $initializer    = new GameInitializer($repo, new SyncDomainEventPublisher());
        $handler        = new StartGameCommandHandler($initializer);

        $this->bus->register(StartGameCommand::class, $handler);
    }

    private function registerMakeAMoveGameUseCase()
    {
        $repo       = new RedisMoveRepository();
        $maker      = new MoveMaker($repo, new SyncDomainEventPublisher());
        $handler    = new MakeAMoveCommandHandler($maker);

        $this->bus->register(MakeAMoveCommand::class, $handler);
    }
}

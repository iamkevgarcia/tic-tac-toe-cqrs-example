<?php

declare(strict_types=1);

use Kev\Infraestructure\Bus\Query\QueryBusSync;
use Kev\Shared\Domain\Bus\Command\Command;
use Kev\Shared\Domain\Bus\Query\Query;
use Kev\Shared\Domain\Bus\Query\Response;
use Kev\TicTacToe\Module\Game\Application\Find\FindGameQuery;
use Kev\TicTacToe\Module\Game\Application\Find\FindGameQueryHandler;
use Kev\TicTacToe\Module\Game\Application\Find\GameFinder;
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
    private $commandBus;
    private $queryBus;

    public function __construct()
    {
        $this->commandBus = new SyncCommandBus();
        $this->queryBus = new QueryBusSync();
    }

    public function init(): void
    {
        $this->registerCreateUserUseCase();
        $this->registerDeleteUserUseCase();
        $this->registerStartGameUseCase();
        $this->registerMakeAMoveGameUseCase();
        $this->registerFindGameUseCase();
    }

    private function registerCreateUserUseCase(): void
    {
        $repo       = new MySqlUserRepository();
        $creator    = new UserCreator($repo, new SyncDomainEventPublisher());
        $handler    = new CreateUserCommandHandler($creator);

        $this->commandBus->register(CreateUserCommand::class, $handler);
    }

    private function registerDeleteUserUseCase(): void
    {
        $repo       = new MySqlUserRepository();
        $creator    = new UserRemover($repo, new SyncDomainEventPublisher());
        $handler    = new DeleteUserCommandHandler($creator);

        $this->commandBus->register(DeleteUserCommand::class, $handler);
    }

    public function dispatch(Command $command): void
    {
        $this->commandBus->dispatch($command);
    }

    private function registerStartGameUseCase(): void
    {
        $repo           = new DynamoDBGameRepository();
        $initializer    = new GameInitializer($repo, new SyncDomainEventPublisher(), new MySqlUserRepository());
        $handler        = new StartGameCommandHandler($initializer);

        $this->commandBus->register(StartGameCommand::class, $handler);
    }

    private function registerMakeAMoveGameUseCase(): void
    {
        $repo       = new RedisMoveRepository();
        $maker      = new MoveMaker($repo, new SyncDomainEventPublisher(), new DynamoDBGameRepository());
        $handler    = new MakeAMoveCommandHandler($maker);

        $this->commandBus->register(MakeAMoveCommand::class, $handler);
    }

    private function registerFindGameUseCase(): void
    {
        $repo       = new DynamoDBGameRepository();
        $finder     = new GameFinder($repo);
        $handler    = new FindGameQueryHandler($finder);

        $this->queryBus->register(FindGameQuery::class, $handler);
    }

    public function ask(Query $query): Response
    {
        return $this->queryBus->ask($query);
    }
}

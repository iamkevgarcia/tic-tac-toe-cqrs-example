<?php

declare(strict_types=1);

namespace Kev\TicTacToe\Module\Game\Tests\Domain;

use InvalidArgumentException;
use Kev\Test\PhpUnit\TestCase\UnitTestCase;
use Kev\TicTacToe\Module\Game\Domain\Game;
use Kev\TicTacToe\Module\Game\Domain\GameId;
use Kev\TicTacToe\Module\Game\Domain\PlayerId;
use Kev\Types\ValueObject\Uuid;

final class GameShould extends UnitTestCase
{
    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    public function throw_an_exception_when_passing_invalid_uuid(): void
    {
        Game::start(new GameId('invalid'), new PlayerId(''), new PlayerId(''));
    }

    /**
     * @test
     */
    public function have_game_created_domain_event_after_creating_new_game(): void
    {
        $game = Game::start(
            new GameId(Uuid::random()->value()),
            new PlayerId(Uuid::random()->value()),
            new PlayerId(Uuid::random()->value())
        );

        $this->assertCount(1, $game->pullDomainEvents());
    }

    /**
     * @test
     * @expectedException Kev\TicTacToe\Module\Game\Domain\PlayerWhoDidMoveIsNotAGamePlayerException
     */
    public function throw_an_exception_when_adding_a_player_that_is_not_one_of_the_game_players(): void
    {
        $game = Game::start(
            new GameId(Uuid::random()->value()),
            new PlayerId(Uuid::random()->value()),
            new PlayerId(Uuid::random()->value())
        );

        $game->addMove(MoveStub::random());
    }

    /**
     * @test
     * @expectedException Kev\TicTacToe\Module\Game\Domain\MoveDoNotBelongsToSpecifiedGameException
     */
    public function throw_an_exception_when_adding_a_move_that_do_not_belongs_to_game(): void
    {
        $playerIdString = Uuid::random()->value();
        $game = Game::start(
            new GameId(Uuid::random()->value()),
            new PlayerId($playerIdString),
            new PlayerId(Uuid::random()->value())
        );

        $game->addMove(MoveStub::withPlayerId($playerIdString));
    }

    /**
     * @test
     * @expectedException Kev\TicTacToe\Module\Game\Domain\GameMovesExceededException
     */
    public function throw_an_exception_when_trying_to_add_more_moves_than_allowed(): void
    {
        $playerIdString = Uuid::random()->value();
        $gameIdString   = Uuid::random()->value();
        $game = Game::start(
            new GameId($gameIdString),
            new PlayerId($playerIdString),
            new PlayerId(Uuid::random()->value())
        );

        $this->addNMoves(
           $game,
            20
        );
    }

    private function addNMoves(Game $game, int $numberOfMoves)
    {
        for ($i = 0; $i < $numberOfMoves; $i++) {
            $game->addMove(MoveStub::with($game->oPlayerId()->value(), $game->id()->value()));
        }
    }
}

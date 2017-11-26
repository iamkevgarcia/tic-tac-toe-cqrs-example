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
    public function have_game_created_domain_event_after_creating_a_new_one(): void
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
     * @expectedException Kev\TicTacToe\Module\Game\Domain\PositionAlreadyTakenException
     */
    public function throw_an_exception_when_trying_to_add_move_in_the_same_position(): void
    {
        $playerIdString = Uuid::random()->value();
        $gameIdString   = Uuid::random()->value();
        $game = Game::start(
            new GameId($gameIdString),
            new PlayerId($playerIdString),
            new PlayerId(Uuid::random()->value())
        );

        $game->addMove(MoveStub::with($game->oPlayerId()->value(), $game->id()->value(), 1));
        $game->addMove(MoveStub::with($game->xPlayerId()->value(), $game->id()->value(), 1));
    }

    /**
     * @test
     * @expectedException Kev\TicTacToe\Module\Game\Domain\PlayerCanNotMakeConsecutiveMovesException
     */
    public function throw_an_exception_when_a_player_is_making_consecutive_moves(): void
    {
        $playerIdString = Uuid::random()->value();
        $gameIdString   = Uuid::random()->value();
        $game = Game::start(
            new GameId($gameIdString),
            new PlayerId($playerIdString),
            new PlayerId(Uuid::random()->value())
        );

        $game->addMove(MoveStub::with($game->oPlayerId()->value(), $game->id()->value(), 1));
        $game->addMove(MoveStub::with($game->oPlayerId()->value(), $game->id()->value(), 2));
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
            9
        );
    }

    private function addNMoves(Game $game, int $numberOfMoves)
    {
        $oPlayer = $game->oPlayerId()->value();
        $xPlayer = $game->xPlayerId()->value();
        for ($i = 0; $i < $numberOfMoves; $i++) {
            $game->addMove(MoveStub::with(($i % 2) ? $xPlayer : $oPlayer, $game->id()->value(), $i));
        }
    }

    /**
     * @test
     */
    public function have_a_winner_after_adding_three_moves_that_makes_a_winning_combination(): void
    {
        $playerIdString = Uuid::random()->value();
        $gameIdString   = Uuid::random()->value();
        $game = Game::start(
            new GameId($gameIdString),
            new PlayerId($playerIdString),
            new PlayerId(Uuid::random()->value())
        );

        $game->addMove(MoveStub::with($game->xPlayerId()->value(), $game->id()->value(), 0));
        $game->addMove(MoveStub::with($game->oPlayerId()->value(), $game->id()->value(), 5));
        $game->addMove(MoveStub::with($game->xPlayerId()->value(), $game->id()->value(), 4));
        $game->addMove(MoveStub::with($game->oPlayerId()->value(), $game->id()->value(), 1));
        $game->addMove(MoveStub::with($game->xPlayerId()->value(), $game->id()->value(), 8));


        $this->assertNotNull($game->winner());
        $this->assertTrue($game->isFinished());
    }

    /**
     * @test
     */
    public function have_a_draw_after_a_game_without_winning_combination(): void
    {
        $playerIdString = Uuid::random()->value();
        $gameIdString   = Uuid::random()->value();
        $game = Game::start(
            new GameId($gameIdString),
            new PlayerId($playerIdString),
            new PlayerId(Uuid::random()->value())
        );

        $game = $this->makeADraw($game);

        $this->assertNull($game->winner());
        $this->assertTrue($game->isFinished());
    }

    private function makeADraw(Game $game): Game
    {
        $game->addMove(MoveStub::with($game->xPlayerId()->value(), $game->id()->value(), 0));
        $game->addMove(MoveStub::with($game->oPlayerId()->value(), $game->id()->value(), 8));
        $game->addMove(MoveStub::with($game->xPlayerId()->value(), $game->id()->value(), 2));
        $game->addMove(MoveStub::with($game->oPlayerId()->value(), $game->id()->value(), 1));
        $game->addMove(MoveStub::with($game->xPlayerId()->value(), $game->id()->value(), 6));
        $game->addMove(MoveStub::with($game->oPlayerId()->value(), $game->id()->value(), 7));
        $game->addMove(MoveStub::with($game->xPlayerId()->value(), $game->id()->value(), 5));
        $game->addMove(MoveStub::with($game->oPlayerId()->value(), $game->id()->value(), 4));

        return $game;
    }
}

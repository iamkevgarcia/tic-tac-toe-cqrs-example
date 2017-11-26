<?php

declare(strict_types=1);

namespace Kev\TicTacToe\Module\Game\Tests\Domain;

use InvalidArgumentException;
use Kev\Test\PhpUnit\TestCase\UnitTestCase;
use Kev\TicTacToe\Module\Game\Domain\Game;
use Kev\TicTacToe\Module\Game\Domain\GameId;
use Kev\Types\ValueObject\Uuid;

final class GameShould extends UnitTestCase
{
    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    public function throw_an_exception_when_passing_invalid_uuid(): void
    {
        Game::start(new GameId('invalid'));
    }

    /**
     * @test
     */
    public function have_game_created_domain_event_after_creating_new_game(): void
    {
        $game = Game::start(new GameId(Uuid::random()->value()));

        $this->assertCount(1, $game->pullDomainEvents());
    }
}

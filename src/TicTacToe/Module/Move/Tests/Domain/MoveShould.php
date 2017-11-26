<?php

declare(strict_types=1);

namespace Kev\TicTacToe\Module\Move\Tests\Domain;

use InvalidArgumentException;
use Kev\Test\PhpUnit\TestCase\UnitTestCase;
use Kev\TicTacToe\Module\Game\Domain\GameId;
use Kev\TicTacToe\Module\Game\Domain\PlayerId;
use Kev\TicTacToe\Module\Move\Domain\Move;
use Kev\TicTacToe\Module\Move\Domain\MoveId;
use Kev\TicTacToe\Module\Move\Domain\Position;
use Kev\Types\ValueObject\Uuid;

final class MoveShould extends UnitTestCase
{
    const MAX_POSITION = 8;

    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    public function throw_an_exception_when_passing_invalid_uuid(): void
    {
        Move::make(new MoveId('invalid'), new GameId(''), new PlayerId(''), new Position(1));
    }

    /**
     * @test
     */
    public function have_move_created_domain_event_after_creating_new_move(): void
    {
        $game = Move::make(
            new MoveId(Uuid::random()->value()),
            new GameId(Uuid::random()->value()),
            new PlayerId(Uuid::random()->value()),
            new Position(1)
        );

        $this->assertCount(1, $game->pullDomainEvents());
    }

    /**
     * @test
     * @expectedException Kev\TicTacToe\Module\Move\Domain\InvalidGivenPositionException
     */
    public function throw_an_exception_when_passing_invalid_position(): void
    {
        Move::make(
            new MoveId(Uuid::random()->value()),
            new GameId(Uuid::random()->value()),
            new PlayerId(Uuid::random()->value()),
            new Position(self::MAX_POSITION + 1)
        );
    }
}

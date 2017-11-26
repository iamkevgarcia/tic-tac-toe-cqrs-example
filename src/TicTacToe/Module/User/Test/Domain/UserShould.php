<?php

declare(strict_types=1);

namespace Kev\TicTacToe\Module\User\Tests\Domain;

use InvalidArgumentException;
use Kev\Test\PhpUnit\TestCase\UnitTestCase;
use Kev\TicTacToe\Module\User\Domain\User;
use Kev\TicTacToe\Module\User\Domain\UserId;
use Kev\Types\ValueObject\Uuid;

final class UserShould extends UnitTestCase
{
    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    public function throw_an_exception_when_passing_invalid_uuid(): void
    {
        User::create(new UserId('invalid'));
    }

    /**
     * @test
     */
    public function have_game_created_domain_event_after_creating_new_user(): void
    {
        $game = User::create(new UserId(Uuid::random()->value()));

        $this->assertCount(1, $game->pullDomainEvents());
    }
}

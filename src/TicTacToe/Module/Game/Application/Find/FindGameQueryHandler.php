<?php

declare(strict_types=1);

namespace Kev\TicTacToe\Module\Game\Application\Find;

use Kev\TicTacToe\Module\Game\Domain\GameId;
use Kev\TicTacToe\Module\Game\Domain\GameResponse;
use Kev\TicTacToe\Module\Game\Domain\GameResponseConverter;
use function Lambdish\Phunctional\apply;
use function Lambdish\Phunctional\pipe;

final class FindGameQueryHandler
{
    private $finder;

    public function __construct(GameFinder $finder)
    {
        $this->finder = pipe($finder, new GameResponseConverter());
    }

    public function __invoke(FindGameQuery $query): GameResponse
    {
        $id = new GameId($query->id());

        return apply($this->finder, [$id]);
    }
}

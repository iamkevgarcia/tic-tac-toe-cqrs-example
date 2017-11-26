<?php

declare(strict_types=1);

namespace Kev\TicTacToe\Module\Game\Application\Find;

use Kev\TicTacToe\Module\Game\Domain\Game;
use Kev\TicTacToe\Module\Game\Domain\GameId;
use Kev\TicTacToe\Module\Game\Domain\GameNotFoundException;
use Kev\TicTacToe\Module\Game\Domain\GameRepository;

final class GameFinder
{
    private $repository;

    public function __construct(GameRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(GameId $id): Game
    {
        $video = $this->repository->find($id);

        $this->guard($id, $video);

        return $video;
    }

    private function guard(GameId $id, Game $video = null): void
    {
        if (null === $video) {
            throw new GameNotFoundException($id);
        }
    }
}

<?php

namespace App\Containers\GameManagementSection\Game\Tasks;

use App\Containers\GameManagementSection\Game\Data\Repositories\StructureRepository;
use App\Ship\Parents\Tasks\Task;
use App\Containers\GameManagementSection\Game\Models\Game;
use Prettus\Validator\Exceptions\ValidatorException;

class GameCreateTask extends Task
{
    public function __construct(
        protected StructureRepository $repository
    )
    {
    }

    /**
     * @throws ValidatorException
     */
    public function run(
        string $name,
        string $genre,
        int $userId
    ): Game
    {
        $game = $this
            ->repository
            ->create(
                [
                    'name' => $name,
                    'genre' => $genre
                ]
            );

        $game->users()->attach($userId);

        return $game;
    }
}

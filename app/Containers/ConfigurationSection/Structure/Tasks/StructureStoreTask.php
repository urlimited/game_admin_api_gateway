<?php

namespace App\Containers\ConfigurationSection\Structure\Tasks;

use App\Containers\ConfigurationSection\Game\Models\Game;
use App\Containers\ConfigurationSection\Structure\Data\Repositories\StructureRepository;
use App\Containers\ConfigurationSection\Structure\Models\Structure;
use App\Ship\Parents\Tasks\Task;
use Prettus\Validator\Exceptions\ValidatorException;

class StructureStoreTask extends Task
{
    public function __construct(
        protected StructureRepository $repository
    )
    {
    }

    /**
     * @param string $name
     * @param string $version
     * @param string $schema
     * @param int $game
     * @return Structure
     * @throws ValidatorException
     */
    public function run(string $name, string $version, string $schema, int $game): Structure
    {
        return $this
            ->repository
            ->create(
                [
                    'name' => $name,
                    'game_id' => $game,
                    'schema' => $schema,
                    'version' => $version
                ]
            );
    }
}

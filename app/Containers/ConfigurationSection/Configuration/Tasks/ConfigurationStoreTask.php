<?php

namespace App\Containers\ConfigurationSection\Configuration\Tasks;

use App\Containers\ConfigurationSection\Configuration\Data\Repositories\ConfigurationRepository;
use App\Containers\ConfigurationSection\Configuration\Models\Configuration;
use App\Ship\Parents\Tasks\Task;
use Prettus\Validator\Exceptions\ValidatorException;

class ConfigurationStoreTask extends Task
{
    public function __construct(
        protected ConfigurationRepository $repository
    )
    {
    }

    /**
     * @param string $name
     * @param int $gameId
     * @param string $schema
     * @param int $authorId
     * @param int|null $structureId
     * @return Configuration
     * @throws ValidatorException
     */
    public function run(
        string $name,
        int $gameId,
        string $schema,
        int $authorId,
        ?int $structureId = null
    ): Configuration
    {
        return $this
            ->repository
            ->create(
                [
                    'name' => $name,
                    'structure_id' => $structureId,
                    'schema' => $schema,
                    'author_id' => $authorId,
                    'game_id' => $gameId,
                ]
            );
    }
}

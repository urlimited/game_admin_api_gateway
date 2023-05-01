<?php

namespace App\Containers\ConfigurationSection\Structure\Tasks;

use App\Containers\ConfigurationSection\Structure\Data\Repositories\StructureRepository;
use App\Containers\ConfigurationSection\Structure\Models\Structure;
use App\Ship\Parents\Tasks\Task;
use Prettus\Validator\Exceptions\ValidatorException;

class StructureUpdateTask extends Task
{
    public function __construct(
        protected StructureRepository $repository
    )
    {
    }

    /**
     * @param int $id
     * @param string $name
     * @param int $gameId
     * @param string $version
     * @param string $fields
     * @return Structure
     * @throws ValidatorException
     */
    public function run(int $id, string $name, int $gameId, string $version, string $fields): Structure
    {
        return $this
            ->repository
            ->update(
                [
                    'name' => $name,
                    'game_id' => $gameId,
                    'schema' => $fields,
                    'version' => $version
                ],
                $id
            );
    }
}

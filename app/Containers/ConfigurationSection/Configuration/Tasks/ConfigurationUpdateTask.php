<?php

namespace App\Containers\ConfigurationSection\Configuration\Tasks;

use App\Containers\ConfigurationSection\Configuration\Data\Repositories\ConfigurationRepository;
use App\Containers\ConfigurationSection\Configuration\Models\Configuration;
use App\Ship\Parents\Tasks\Task;
use Prettus\Validator\Exceptions\ValidatorException;

class ConfigurationUpdateTask extends Task
{
    public function __construct(
        protected ConfigurationRepository $repository
    )
    {
    }

    /**
     * @param int $id
     * @param string $name
     * @param int $structure_id
     * @param string $schema
     * @param int $author_id

     * @return Configuration
     * @throws ValidatorException
     */
    public function run(int $id, string $name, ?int $structure_id,string $schema, int $author_id ): Configuration
    {
        return $this
            ->repository
            ->update(
                [
                    'name' => $name,
                    'structure_id' => $structure_id,
                    'schema' => $schema,
                    'author_id' => $author_id
                ],
                $id
            );
    }
}

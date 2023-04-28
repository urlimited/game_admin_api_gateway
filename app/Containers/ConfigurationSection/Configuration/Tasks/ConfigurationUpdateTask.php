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
     * @param string $schema
     * @return Configuration
     * @throws ValidatorException
     */
    public function run(
        int    $id,
        string $name,
        string $schema,
    ): Configuration
    {
        return $this
            ->repository
            ->update(
                [
                    'name' => $name,
                    'schema' => $schema,
                ],
                $id
            );
    }
}

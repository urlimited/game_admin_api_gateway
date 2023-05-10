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
     * @param array $data
     * @return Structure
     * @throws ValidatorException
     */
    public function run(array $data): Structure
    {
        return $this->repository->create($data);
    }
}

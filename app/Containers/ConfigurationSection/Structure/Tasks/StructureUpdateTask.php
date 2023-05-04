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
     * @param array $data
     * @param int $id
     * @return Structure
     * @throws ValidatorException
     */
    public function run(array $data, int $id): Structure
    {
        return $this
            ->repository
            ->update($data, $id);
    }
}

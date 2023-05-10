<?php

namespace App\Containers\ConfigurationSection\Layout\Tasks;

use App\Containers\ConfigurationSection\Layout\Data\Repositories\LayoutRepository;
use App\Containers\ConfigurationSection\Layout\Models\Layout;
use App\Ship\Parents\Tasks\Task;
use Prettus\Validator\Exceptions\ValidatorException;

class LayoutUpdateTask extends Task
{
    public function __construct(
        protected LayoutRepository $repository
    )
    {
    }

    /**
     * @param array $data
     * @param int $id
     * @return Layout
     * @throws ValidatorException
     */
    public function run(array $data, int $id): Layout
    {
        return $this
            ->repository
            ->update($data, $id);
    }
}

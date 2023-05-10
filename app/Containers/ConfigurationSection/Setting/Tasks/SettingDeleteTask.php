<?php

namespace App\Containers\ConfigurationSection\Setting\Tasks;

use App\Containers\ConfigurationSection\Setting\Data\Repositories\SettingRepository;

use App\Ship\Parents\Tasks\Task;

class SettingDeleteTask extends Task
{
    public function __construct(
        protected SettingRepository $repository
    )
    {
    }

    /**
     * @param int $id
     * @return void
     */
    public function run(int $id): void
    {
        $this->repository->delete($id);
    }
}

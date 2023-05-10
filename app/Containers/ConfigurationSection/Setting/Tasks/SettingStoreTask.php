<?php

namespace App\Containers\ConfigurationSection\Setting\Tasks;

use App\Containers\ConfigurationSection\Setting\Data\Repositories\SettingRepository;
use App\Containers\ConfigurationSection\Setting\Models\Setting;
use App\Ship\Parents\Tasks\Task;
use Prettus\Validator\Exceptions\ValidatorException;

class SettingStoreTask extends Task
{
    public function __construct(
        protected SettingRepository $repository
    )
    {
    }

    /**
     * @param array $data
     * @return Setting
     * @throws ValidatorException
     */
    public function run(array $data): Setting
    {
        return $this->repository->create($data);
    }
}

<?php

namespace App\Containers\ConfigurationSection\Setting\Tasks;

use App\Containers\ConfigurationSection\Setting\Data\Repositories\SettingRepository;
use App\Containers\ConfigurationSection\Setting\Models\Setting;
use App\Ship\Parents\Tasks\Task;
use Prettus\Validator\Exceptions\ValidatorException;

class SettingUpdateTask extends Task
{
    public function __construct(
        protected SettingRepository $repository
    )
    {
    }

    /**
     * @param int $id
     * @param string $name
     * @param string $schema
     * @return Setting
     * @throws ValidatorException
     */
    public function run(
        int    $id,
        array $data,
    ): Setting
    {
        return $this
            ->repository
            ->update(
                $data,
                $id
            );
    }
}

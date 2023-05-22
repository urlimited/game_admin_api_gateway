<?php

namespace App\Containers\ConfigurationSection\Setting\Tasks;

use App\Containers\ConfigurationSection\Layout\Models\Layout;
use App\Ship\Parents\Tasks\Task;


class SettingMetaTask extends Task
{
    public function run(array $data): array
    {
        foreach ($data['data'] as $key => $filterCriteria) {
            if ($key === 'structure_id' && !is_null($filterCriteria) ) {
                $data['meta']['version']= $this->layoutVersion($filterCriteria);
                return $data;
            }
        }
        $data['meta']['version'] = null;
        return $data;
    }
    private function layoutVersion(int $id):string
    {
        return Layout::query()->where('id',$id)->value('version');
    }
}

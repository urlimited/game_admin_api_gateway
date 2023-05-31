<?php

namespace App\Containers\ConfigurationSection\Setting\Tasks;

use App\Containers\ConfigurationSection\Layout\Models\Layout;
use App\Ship\Parents\Tasks\Task;


class SettingMetaTask extends Task
{
    public function run(?int $structureId):array
    {
        if($structureId !== null){
           return ['version' =>$this->getLayoutVersion($structureId)];
        }
        return [];
    }
    private function getLayoutVersion(int $id):string
    {
        return Layout::query()->where('id',$id)->value('version');
    }
}

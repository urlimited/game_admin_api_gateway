<?php

namespace App\Containers\ConfigurationSection\Structure\Actions;

use App\Containers\ConfigurationSection\Structure\Models\Structure;
use App\Containers\ConfigurationSection\Structure\Tasks\StructureDeleteTask;
use App\Ship\Parents\Actions\Action;

class StructureDeleteAction extends Action
{
    public function run(Structure $structure): void
    {
        app(StructureDeleteTask::class)->run($structure->getAttribute('id'));
    }
}

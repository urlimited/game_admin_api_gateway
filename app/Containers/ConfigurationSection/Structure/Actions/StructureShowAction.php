<?php

namespace App\Containers\ConfigurationSection\Structure\Actions;

use App\Containers\ConfigurationSection\Structure\Models\Structure;
use App\Containers\ConfigurationSection\Structure\Tasks\StructureFilterTask;
use App\Ship\Parents\Actions\Action;
use Prettus\Repository\Exceptions\RepositoryException;

class StructureShowAction extends Action
{
    /**
     * @param Structure $structure
     * @return Structure
     * @throws RepositoryException
     */
    public function run(Structure $structure): Structure
    {
        return app(StructureFilterTask::class)
            ->run(
                [
                    'id' => $structure->getAttribute('id'),
                ]
            )
            ->first();
    }

}

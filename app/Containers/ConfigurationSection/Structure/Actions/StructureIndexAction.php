<?php

namespace App\Containers\ConfigurationSection\Structure\Actions;

use App\Containers\ConfigurationSection\Structure\Tasks\StructureFilterTask;
use App\Containers\ConfigurationSection\Structure\UI\WEB\Requests\StructureWebIndexRequest;
use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Collection;
use Prettus\Repository\Exceptions\RepositoryException;

class StructureIndexAction extends Action
{
    /**
     * @throws RepositoryException
     */
    public function run(StructureWebIndexRequest $request): Collection
    {
        return app(StructureFilterTask::class)->run(
            [
                'game_id' => $request->get('game_id')
            ]
        );
    }
}

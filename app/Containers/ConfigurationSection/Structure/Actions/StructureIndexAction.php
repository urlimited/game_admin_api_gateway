<?php

namespace App\Containers\ConfigurationSection\Structure\Actions;

use App\Containers\ConfigurationSection\Game\Models\Game;
use App\Containers\ConfigurationSection\Structure\Tasks\StructureIndexTask;
use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Collection;
use Prettus\Repository\Exceptions\RepositoryException;

class StructureIndexAction extends Action
{
    /**
     * @throws RepositoryException
     */
    public function run(Game $game): Collection
    {
        return app(StructureIndexTask::class)->run($game->id);
    }
}

<?php

namespace App\Containers\ConfigurationSection\Layout\Actions;

use App\Containers\ConfigurationSection\Layout\Tasks\LayoutFilterTask;
use App\Containers\ConfigurationSection\Layout\UI\WEB\Requests\LayoutWebIndexRequest;
use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Collection;
use Prettus\Repository\Exceptions\RepositoryException;

class LayoutIndexAction extends Action
{
    /**
     * @throws RepositoryException
     */
    public function run(LayoutWebIndexRequest $request): Collection
    {
        return app(LayoutFilterTask::class)->run(
            [
                'game_id' => $request->get('game_id')
            ]
        );
    }
}

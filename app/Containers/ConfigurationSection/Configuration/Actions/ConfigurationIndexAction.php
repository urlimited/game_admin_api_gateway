<?php

namespace App\Containers\ConfigurationSection\Configuration\Actions;


use App\Containers\ConfigurationSection\Configuration\Tasks\ConfigurationFilterTask;
use App\Containers\ConfigurationSection\Configuration\UI\Web\Requests\ConfigurationWebIndexRequest;
use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Collection;

class ConfigurationIndexAction extends Action
{
    public function run(ConfigurationWebIndexRequest $request): Collection
    {
        return app(ConfigurationFilterTask::class)
            ->run(
                [
                    'structure_id' => $request->get('structure_id'),
                    'game_id' => $request->get('game_id'),
                ]
            );
    }
}

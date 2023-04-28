<?php

namespace App\Containers\ConfigurationSection\Configuration\Actions;


use App\Containers\ConfigurationSection\Configuration\Tasks\FilterConfigurationsTask;
use App\Containers\ConfigurationSection\Configuration\UI\API\Requests\ConfigurationPrivateIndexRequest;
use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Collection;

class ConfigurationIndexAction extends Action
{
    public function run(ConfigurationPrivateIndexRequest $request): Collection
    {
        return app(FilterConfigurationsTask::class)
            ->run(
                [
                    'structure_id' => $request->get('structure_id'),
                    'game_id' => $request->route('game')->getAttribute('id'),
                ]
            );
    }
}

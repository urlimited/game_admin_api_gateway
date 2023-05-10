<?php

namespace App\Containers\ConfigurationSection\Setting\Actions;


use App\Containers\ConfigurationSection\Setting\Tasks\SettingFilterTask;
use App\Containers\ConfigurationSection\Setting\UI\WEB\Requests\SettingWebIndexRequest;
use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Collection;

class SettingIndexAction extends Action
{
    public function run(SettingWebIndexRequest $request): Collection
    {
        return app(SettingFilterTask::class)
            ->run(
                [
                    'structure_id' => $request->get('structure_id'),
                    'game_id' => $request->get('game_id'),
                ]
            );
    }
}

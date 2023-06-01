<?php

namespace App\Containers\ConfigurationSection\Setting\Actions;


use App\Containers\ConfigurationSection\Game\Models\Game;
use App\Containers\ConfigurationSection\Layout\Models\Layout;
use App\Containers\ConfigurationSection\Setting\Tasks\SettingFilterTask;
use App\Containers\ConfigurationSection\Setting\UI\WEB\Requests\SettingWebIndexRequest;
use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Collection;
use Ramsey\Uuid\Uuid;

class SettingIndexAction extends Action
{
    public function run(SettingWebIndexRequest $request): Collection
    {
        $layout = Layout::query()
            ->where(
                'uuid',
                Uuid::fromString($request->get('layout_uuid'))->getBytes()
            )
            ->first();

        $game = Game::query()
            ->where(
                'uuid',
                Uuid::fromString($request->get('game_uuid'))->getBytes()
            )
            ->first();

        return app(SettingFilterTask::class)
            ->run(
                [
                    'layout_id' => !is_null($layout) ? $layout->getAttribute('id') : null,
                    'game_id' => $game->getAttribute('id'),
                ]
            );
    }
}

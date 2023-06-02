<?php

namespace App\Containers\ConfigurationSection\Layout\Actions;

use App\Containers\ConfigurationSection\Game\Models\Game;
use App\Containers\ConfigurationSection\Layout\Tasks\LayoutFilterTask;
use App\Containers\ConfigurationSection\Layout\UI\WEB\Requests\LayoutWebIndexRequest;
use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Collection;
use Prettus\Repository\Exceptions\RepositoryException;
use Ramsey\Uuid\Uuid;

class LayoutIndexAction extends Action
{
    /**
     * @throws RepositoryException
     */
    public function run(LayoutWebIndexRequest $request): Collection
    {
        $gameId=Game::query()->where('uuid',Uuid::fromString($request->get('game_uuid'))->getBytes())->value('id');

        return app(LayoutFilterTask::class)->run(
            [
                'game_id' =>$gameId
            ]
        );
    }
}

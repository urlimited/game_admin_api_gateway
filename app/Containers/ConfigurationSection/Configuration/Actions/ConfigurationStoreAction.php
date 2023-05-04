<?php

namespace App\Containers\ConfigurationSection\Configuration\Actions;


use App\Containers\ConfigurationSection\Configuration\Models\Configuration;
use App\Containers\ConfigurationSection\Configuration\Tasks\ConfigurationStoreTask;
use App\Containers\ConfigurationSection\Configuration\UI\Web\Requests\ConfigurationWebStoreRequest;
use App\Ship\Parents\Actions\Action;
use Prettus\Validator\Exceptions\ValidatorException;

class ConfigurationStoreAction extends Action
{
    /**
     * @throws ValidatorException
     */
    public function run(ConfigurationWebStoreRequest $request): Configuration
    {
        return app(ConfigurationStoreTask::class)
            ->run(
                name: $request->get('name'),
                gameId: $request->get('game_id'),
                schema: $request->get('schema'),
                authorId: $request->user()->getAttribute('id'),
                structureId: $request->get('structure_id'),
            );
    }
}

<?php

namespace App\Containers\ConfigurationSection\Configuration\Actions;


use App\Containers\ConfigurationSection\Configuration\Models\Configuration;
use App\Containers\ConfigurationSection\Configuration\Tasks\ConfigurationStoreTask;
use App\Containers\ConfigurationSection\Configuration\UI\API\Requests\ConfigurationPrivateStoreRequest;
use App\Ship\Parents\Actions\Action;
use Prettus\Validator\Exceptions\ValidatorException;

class ConfigurationStoreAction extends Action
{
    /**
     * @throws ValidatorException
     */
    public function run(ConfigurationPrivateStoreRequest $request): Configuration
    {
        return app(ConfigurationStoreTask::class)
            ->run(
                name: $request->get('name'),
                gameId: $request->route('game')->getAttribute('id'),
                schema: $request->get('schema'),
                authorId: $request->user()->getAttribute('id'),
                structureId: $request->get('structure_id'),
            );
    }
}

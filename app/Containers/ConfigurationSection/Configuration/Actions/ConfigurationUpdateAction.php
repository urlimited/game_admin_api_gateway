<?php

namespace App\Containers\ConfigurationSection\Configuration\Actions;


use App\Containers\ConfigurationSection\Configuration\Models\Configuration;
use App\Containers\ConfigurationSection\Configuration\Tasks\ConfigurationUpdateTask;
use App\Containers\ConfigurationSection\Configuration\UI\API\Requests\ConfigurationPrivateUpdateRequest;
use App\Ship\Parents\Actions\Action;
use Prettus\Validator\Exceptions\ValidatorException;

class ConfigurationUpdateAction extends Action
{
    /**
     * @throws ValidatorException
     */
    public function run(ConfigurationPrivateUpdateRequest $request, Configuration $configuration): Configuration
    {
        return app(ConfigurationUpdateTask::class)
            ->run(
                id: $configuration->getAttribute('id'),
                name: $request->get('name'),
                schema: $request->get('schema')
            );
    }
}

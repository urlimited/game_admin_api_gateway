<?php

namespace App\Containers\ConfigurationSection\Configuration\Actions;


use App\Containers\ConfigurationSection\Configuration\Models\Configuration;
use App\Containers\ConfigurationSection\Configuration\Tasks\ConfigurationStoreTask;
use App\Containers\ConfigurationSection\Configuration\UI\API\Requests\ConfigurationStoreRequest;
use App\Containers\ConfigurationSection\Structure\Support\StructureValidator\Exceptions\InvalidDataProvidedForRuleException;
use App\Ship\Parents\Actions\Action;
use Prettus\Validator\Exceptions\ValidatorException;

class ConfigurationStoreAction extends Action
{
    /**
     * @throws InvalidDataProvidedForRuleException
     * @throws ValidatorException
     */
    public function run(ConfigurationStoreRequest $request): Configuration
    {
        $schemas = $request->get('schema');
//        $formattedSchemas = app(ConfigurationProcessFields::class)->run($schemas);
        return app(ConfigurationStoreTask::class)
            ->run(
                $request->get('name'),
                $request->get('structure_id'),
                $schemas,
                $request->get('author_id'),
            );
    }
}

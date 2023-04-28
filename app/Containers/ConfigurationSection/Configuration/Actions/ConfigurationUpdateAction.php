<?php

namespace App\Containers\ConfigurationSection\Configuration\Actions;


use App\Containers\ConfigurationSection\Configuration\Models\Configuration;
use App\Containers\ConfigurationSection\Configuration\Tasks\ConfigurationUpdateTask;
use App\Containers\ConfigurationSection\Configuration\UI\API\Requests\ConfigurationUpdateRequest;
use App\Containers\ConfigurationSection\Structure\Support\StructureValidator\Exceptions\InvalidDataProvidedForRuleException;
use App\Ship\Parents\Actions\Action;
use Prettus\Validator\Exceptions\ValidatorException;

class ConfigurationUpdateAction extends Action
{
    /**
     * @throws ValidatorException
     */
    public function run(ConfigurationUpdateRequest $request, Configuration $configuration): Configuration
    {
        $schema = $request->get('schema');

//        $formattedFields = app(StructureProcessFields::class)->run($fields);
        return app(ConfigurationUpdateTask::class)
            ->run(
                $configuration->id,
                $request->get('name'),
                $request->get('structure_id'),
                $schema,
                $request->get('author_id'),
            );
    }
}

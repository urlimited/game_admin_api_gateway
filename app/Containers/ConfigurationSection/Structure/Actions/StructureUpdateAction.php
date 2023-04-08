<?php

namespace App\Containers\ConfigurationSection\Structure\Actions;

use App\Containers\ConfigurationSection\Structure\Models\Structure;
use App\Containers\ConfigurationSection\Structure\Support\StructureValidator\Exceptions\InvalidDataProvidedForRuleException;
use App\Containers\ConfigurationSection\Structure\Tasks\StructureProcessFields;
use App\Containers\ConfigurationSection\Structure\Tasks\StructureUpdateTask;
use App\Containers\ConfigurationSection\Structure\UI\API\Requests\StructureUpdateRequest;
use App\Ship\Parents\Actions\Action;
use Prettus\Validator\Exceptions\ValidatorException;

class StructureUpdateAction extends Action
{
    /**
     * @throws InvalidDataProvidedForRuleException
     * @throws ValidatorException
     */
    public function run(StructureUpdateRequest $request, Structure $structure): Structure
    {
        $fields = $request->get('fields');

        $formattedFields = app(StructureProcessFields::class)->run($fields);

        return app(StructureUpdateTask::class)
            ->run(
                $structure->id,
                $request->get('name'),
                $request->get('game_id'),
                $request->get('version'),
                $formattedFields,
            );
    }
}

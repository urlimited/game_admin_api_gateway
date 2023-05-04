<?php

namespace App\Containers\ConfigurationSection\Structure\Actions;

use App\Containers\ConfigurationSection\Game\Models\Game;
use App\Containers\ConfigurationSection\Structure\Models\Structure;
use App\Containers\ConfigurationSection\Structure\Support\StructureValidator\Exceptions\InvalidDataProvidedForRuleException;
use App\Containers\ConfigurationSection\Structure\Tasks\StructureProcessFields;
use App\Containers\ConfigurationSection\Structure\Tasks\StructureStoreTask;
use App\Containers\ConfigurationSection\Structure\UI\API\Requests\StructureStoreRequest;
use App\Ship\Parents\Actions\Action;
use Prettus\Validator\Exceptions\ValidatorException;

class StructureStoreAction extends Action
{
    /**
     * @throws InvalidDataProvidedForRuleException
     * @throws ValidatorException
     */
    public function run(StructureStoreRequest $request): Structure
    {
        //$formattedFields = app(StructureProcessFields::class)->run($fields);

        return app(StructureStoreTask::class)
            ->run(
                $request->get('name'),
                $request->get('version'),
                json_encode($request->get('schema')),
                $request->get('game_id'),
            );
    }
}

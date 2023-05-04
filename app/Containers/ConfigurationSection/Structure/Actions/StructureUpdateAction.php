<?php

namespace App\Containers\ConfigurationSection\Structure\Actions;

use App\Containers\ConfigurationSection\Structure\Models\Structure;
use App\Containers\ConfigurationSection\Structure\Tasks\StructureUpdateTask;
use App\Containers\ConfigurationSection\Structure\UI\Web\Requests\StructureWebUpdateRequest;
use App\Ship\Parents\Actions\Action;
use Prettus\Validator\Exceptions\ValidatorException;

class StructureUpdateAction extends Action
{
    /**
     * @throws ValidatorException
     */
    public function run(StructureWebUpdateRequest $request, Structure $structure): Structure
    {
        $schema = $request->get('schema');

        //$formattedFields = app(StructureProcessFields::class)->run($fields);

        return app(StructureUpdateTask::class)
            ->run(
                [
                    'name' => $request->get('name'),
                    'version' => $request->get('version'),
                    'schema' => json_encode($schema),
                ],
                $structure->id
            );
    }
}

<?php

namespace App\Containers\ConfigurationSection\Structure\Actions;

use App\Containers\ConfigurationSection\Structure\Models\Structure;
use App\Containers\ConfigurationSection\Structure\Tasks\StructureUpdateTask;
use App\Containers\ConfigurationSection\Structure\UI\WEB\Requests\StructureWebUpdateRequest;
use App\Ship\Parents\Actions\Action;
use App\Ship\Support\GameControlSettings\Exceptions\InvalidDataProvidedException;
use App\Ship\Support\GameControlSettings\GameControlSettingsContext;
use App\Ship\Support\GameControlSettings\GameControlSettingsFacade;
use Prettus\Validator\Exceptions\ValidatorException;

class StructureUpdateAction extends Action
{
    /**
     * @throws ValidatorException
     * @throws InvalidDataProvidedException
     */
    public function run(StructureWebUpdateRequest $request, Structure $structure): Structure
    {
        $context = new GameControlSettingsContext();

        $context->setLayoutSchema($request->get('schema'));

        GameControlSettingsFacade::checkLayout($context);

        return app(StructureUpdateTask::class)
            ->run(
                [
                    'name' => $request->get('name'),
                    'version' => $request->get('version'),
                    'schema' => json_encode($request->get('schema')),
                ],
                $structure->id
            );
    }
}

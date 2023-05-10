<?php

namespace App\Containers\ConfigurationSection\Structure\Actions;

use App\Containers\ConfigurationSection\Structure\Models\Structure;
use App\Containers\ConfigurationSection\Structure\Tasks\StructureStoreTask;
use App\Containers\ConfigurationSection\Structure\UI\WEB\Requests\StructureWebStoreRequest;
use App\Ship\Parents\Actions\Action;
use App\Ship\Support\GameControlSettings\Exceptions\InvalidDataProvidedException;
use App\Ship\Support\GameControlSettings\GameControlSettingsContext;
use App\Ship\Support\GameControlSettings\GameControlSettingsFacade;
use Prettus\Validator\Exceptions\ValidatorException;

class StructureStoreAction extends Action
{
    /**
     * @throws ValidatorException
     * @throws \App\Ship\Support\GameControlSettings\Exceptions\InvalidDataProvidedException
     */
    public function run(StructureWebStoreRequest $request): Structure
    {
        $context = new GameControlSettingsContext();

        $context->setLayoutSchema($request->get('schema'));

        GameControlSettingsFacade::checkLayout($context);

        return app(StructureStoreTask::class)
            ->run(
                [
                    'name' => $request->get('name'),
                    'version' => $request->get('version'),
                    'schema' => json_encode($request->get('schema')),
                    'game_id' => $request->get('game_id'),
                ]
            );
    }
}

<?php

namespace App\Containers\ConfigurationSection\Layout\Actions;

use App\Containers\ConfigurationSection\Layout\Models\Layout;
use App\Containers\ConfigurationSection\Layout\Tasks\LayoutStoreTask;
use App\Containers\ConfigurationSection\Layout\UI\WEB\Requests\LayoutWebStoreRequest;
use App\Ship\Parents\Actions\Action;
use App\Ship\Support\GameControlSettings\GameControlSettingsContext;
use App\Ship\Support\GameControlSettings\GameControlSettingsFacade;
use Prettus\Validator\Exceptions\ValidatorException;

class LayoutStoreAction extends Action
{
    /**
     * @throws ValidatorException
     * @throws \App\Ship\Support\GameControlSettings\Exceptions\InvalidDataProvidedException
     */
    public function run(LayoutWebStoreRequest $request): Layout
    {
        $context = new GameControlSettingsContext();

        $context->setLayoutSchema($request->get('schema'));

        GameControlSettingsFacade::checkLayout($context);

        return app(LayoutStoreTask::class)
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

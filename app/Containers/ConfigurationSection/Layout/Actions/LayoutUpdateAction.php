<?php

namespace App\Containers\ConfigurationSection\Layout\Actions;

use App\Containers\ConfigurationSection\Layout\Models\Layout;
use App\Containers\ConfigurationSection\Layout\Tasks\LayoutUpdateTask;
use App\Containers\ConfigurationSection\Layout\UI\WEB\Requests\LayoutWebUpdateRequest;
use App\Ship\Parents\Actions\Action;
use App\Ship\Support\GameControlSettings\Exceptions\InvalidDataProvidedException;
use App\Ship\Support\GameControlSettings\GameControlSettingsContext;
use App\Ship\Support\GameControlSettings\GameControlSettingsFacade;
use Prettus\Validator\Exceptions\ValidatorException;

class LayoutUpdateAction extends Action
{
    /**
     * @throws ValidatorException
     * @throws InvalidDataProvidedException
     */
    public function run(LayoutWebUpdateRequest $request, Layout $layout): Layout
    {
        $context = new GameControlSettingsContext();

        $context->setLayoutSchema($request->get('schema'));

        GameControlSettingsFacade::checkLayout($context);

        return app(LayoutUpdateTask::class)
            ->run(
                [
                    'name' => $request->get('name'),
                    'version' => $request->get('version'),
                    'schema' => json_encode($request->get('schema')),
                ],
                $layout->getAttribute('id')
            );
    }
}

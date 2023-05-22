<?php

namespace App\Containers\ConfigurationSection\Adjustment\Actions;

use App\Containers\ConfigurationSection\Adjustment\UI\WEB\Requests\AdjustmentWebStoreRequest;
use App\Containers\ConfigurationSection\Layout\Models\Layout;
use App\Containers\ConfigurationSection\Layout\Tasks\AdjustmentStoreTask;
use App\Containers\ConfigurationSection\Setting\Models\Setting;
use App\Ship\Parents\Actions\Action;
use App\Ship\Support\GameControlSettings\Exceptions\InvalidDataProvidedException;
use App\Ship\Support\GameControlSettings\GameControlSettingsContext;
use App\Ship\Support\GameControlSettings\GameControlSettingsFacade;
use Prettus\Validator\Exceptions\ValidatorException;

class AdjustmentStoreAction extends Action
{
    /**
     * @throws ValidatorException
     * @throws InvalidDataProvidedException
     */
    public function run(AdjustmentWebStoreRequest $request): Layout
    {
        $settingId = Setting::query()
            ->whereUuid($request->get('setting_uuid'))
            ->firstOrFail();

        $context = new GameControlSettingsContext();

        $context->setLayoutSchema($request->get('schema'));

        GameControlSettingsFacade::checkLayout($context);

        return app(AdjustmentStoreTask::class)
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

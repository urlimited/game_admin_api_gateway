<?php

namespace App\Containers\ConfigurationSection\Setting\Actions;


use App\Containers\ConfigurationSection\Setting\Models\Setting;
use App\Containers\ConfigurationSection\Setting\Tasks\SettingUpdateTask;
use App\Containers\ConfigurationSection\Setting\UI\WEB\Requests\SettingWebUpdateRequest;
use App\Containers\ConfigurationSection\Layout\Models\Layout;
use App\Ship\Parents\Actions\Action;
use App\Ship\Support\GameControlSettings\Exceptions\InvalidDataProvidedException;
use App\Ship\Support\GameControlSettings\GameControlSettingsContext;
use App\Ship\Support\GameControlSettings\GameControlSettingsFacade;
use App\Ship\Support\GameControlSettings\Settings\Exceptions\SettingNotInitializedException;
use Prettus\Validator\Exceptions\ValidatorException;

class SettingUpdateAction extends Action
{
    /**
     * @throws ValidatorException
     * @throws InvalidDataProvidedException
     * @throws SettingNotInitializedException
     */
    public function run(SettingWebUpdateRequest $request, Setting $setting): Setting
    {
        $context = new GameControlSettingsContext();

        $context->setSettingSchema($request->get('schema'));

        $layoutSchema = Layout::query()->where('id',1)->value('schema');

        if (!is_null($layoutSchema)) {
            $arrayLayoutSchema = json_decode($layoutSchema, true);

            $context->setLayoutSchema($arrayLayoutSchema);

            GameControlSettingsFacade::checkSetting($context);
        }

        return app(SettingUpdateTask::class)
            ->run(
                 id: $setting->getAttribute('id'),
                 data: [
                'name'=> $request->get('name'),
                'schema'=> json_encode($request->get('schema')),
            ]);
    }
}

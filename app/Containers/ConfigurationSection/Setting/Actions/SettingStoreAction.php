<?php

namespace App\Containers\ConfigurationSection\Setting\Actions;


use App\Containers\ConfigurationSection\Setting\Models\Setting;
use App\Containers\ConfigurationSection\Setting\Tasks\SettingStoreTask;
use App\Containers\ConfigurationSection\Setting\UI\WEB\Requests\SettingWebStoreRequest;
use App\Containers\ConfigurationSection\Layout\Models\Layout;
use App\Ship\Parents\Actions\Action;
use App\Ship\Support\GameControlSettings\Exceptions\InvalidDataProvidedException;
use App\Ship\Support\GameControlSettings\GameControlSettingsContext;
use App\Ship\Support\GameControlSettings\GameControlSettingsFacade;
use App\Ship\Support\GameControlSettings\Settings\Exceptions\SettingNotInitializedException;
use Prettus\Validator\Exceptions\ValidatorException;

class SettingStoreAction extends Action
{
    /**
     * @throws ValidatorException
     * @throws InvalidDataProvidedException
     * @throws SettingNotInitializedException
     */
    public function run(SettingWebStoreRequest $request): Setting
    {
        $context = new GameControlSettingsContext();

        $context->setSettingSchema($request->get('schema'));

        $layoutSchema = Layout::query()->where('id',1)->value('schema');

        if (!is_null($layoutSchema)) {
            $arrayLayoutSchema = json_decode($layoutSchema, true);

            $context->setLayoutSchema($arrayLayoutSchema);

            GameControlSettingsFacade::checkSetting($context);
        }

        return app(SettingStoreTask::class)
            ->run([
                'name'=> $request->get('name'),
                'structure_id'=> $request->get('structure_id'),
                'game_id'=> $request->get('game_id'),
                'schema'=> json_encode($request->get('schema')),
                'author_id'=> $request->user()->getAttribute('id'),
        ]);
    }
}

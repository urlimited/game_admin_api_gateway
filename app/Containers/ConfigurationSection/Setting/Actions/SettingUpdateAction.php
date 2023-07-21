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
use CodeBaseTeam\DataStructures\Tree\Exceptions\InvalidDataException;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Prettus\Validator\Exceptions\ValidatorException;

class SettingUpdateAction extends Action
{
    /**
     * @param SettingWebUpdateRequest $request
     * @param Setting $setting
     * @return Setting
     * @throws InvalidDataProvidedException
     * @throws SettingNotInitializedException
     * @throws ValidatorException
     * @throws InvalidDataException
     * @throws ValidationException
     */
    public function run(SettingWebUpdateRequest $request, Setting $setting): Setting
    {
        $context = new GameControlSettingsContext();

        try {
            $context->setSettingSchema($request->get('schema'));
        } catch (InvalidDataException) {
            throw ValidationException::withMessages(["The configuration does not applicable for the correct format"]);
        }

        $layoutSchema = null;

        if (!is_null($setting->getAttribute('layout_id'))) {
            $layoutSchema = Layout::query()
                ->find($setting->getAttribute('layout_id'))
                ->getAttribute('schema');
        }

        if (!is_null($layoutSchema)) {
            $arrayLayoutSchema = json_decode($layoutSchema, true);

            $context->setLayoutSchema($arrayLayoutSchema);

            try {
                GameControlSettingsFacade::checkSetting($context);
            } catch (InvalidDataProvidedException $e) {
                throw ValidationException::withMessages(
                    [
                        'setting_id' => $e->getSettingId(),
                        'message' => $e->getMessage(),
                    ]
                );
            }
        }

        return app(SettingUpdateTask::class)
            ->run(
                id: $setting->getAttribute('id'),
                data: [
                    'name' => $request->get('name'),
                    'schema' => json_encode($request->get('schema')),
                ]
            );
    }
}

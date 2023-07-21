<?php

namespace App\Containers\ConfigurationSection\Setting\Actions;


use App\Containers\ConfigurationSection\Game\Models\Game;
use App\Containers\ConfigurationSection\Setting\Models\Setting;
use App\Containers\ConfigurationSection\Setting\Tasks\SettingStoreTask;
use App\Containers\ConfigurationSection\Setting\UI\WEB\Requests\SettingWebStoreRequest;
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
use Ramsey\Uuid\Uuid;

class SettingStoreAction extends Action
{
    /**
     * @param SettingWebStoreRequest $request
     * @return Setting
     * @throws InvalidDataProvidedException
     * @throws SettingNotInitializedException
     * @throws ValidatorException
     * @throws InvalidDataException
     * @throws ValidationException
     */
    public function run(SettingWebStoreRequest $request): Setting
    {
        $context = new GameControlSettingsContext();

        try {
            $context->setSettingSchema($request->get('schema'));
        } catch (InvalidDataException) {
            throw ValidationException::withMessages(["The configuration does not applicable for the correct format"]);
        }

        $layoutSchema = null;
        $layout = null;

        if (!is_null($request->get('layout_uuid'))) {
            $layout = Layout::query()
                ->where(
                    'uuid',
                    Uuid::fromString($request->get('layout_uuid'))->getBytes()
                )
                ->first();

            $layoutSchema = $layout->getAttribute('schema');
        }

        $game = Game::query()
            ->where(
                'uuid',
                Uuid::fromString($request->get('game_uuid'))->getBytes()
            )
            ->first();

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

        return app(SettingStoreTask::class)
            ->run([
                'name' => $request->get('name'),
                'layout_id' => $layout?->getAttribute('id'),
                'game_id' => $game->getAttribute('id'),
                'schema' => json_encode($request->get('schema')),
                'author_id' => $request->user()->getAttribute('id'),
        ]);
    }
}

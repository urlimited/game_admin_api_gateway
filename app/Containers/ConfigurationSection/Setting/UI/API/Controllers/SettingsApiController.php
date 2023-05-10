<?php

namespace App\Containers\ConfigurationSection\Setting\UI\API\Controllers;

use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\ConfigurationSection\Setting\Actions\SettingShowAction;
use App\Containers\ConfigurationSection\Setting\Models\Setting;
use App\Containers\ConfigurationSection\Setting\UI\API\Requests\SettingApiShowRequest;
use App\Containers\ConfigurationSection\Setting\UI\API\Transformers\SettingPublicTransformer;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

class SettingsApiController extends ApiController
{
    /**
     * @throws InvalidTransformerException
     */
    public function show(SettingApiShowRequest $request, Setting $setting): JsonResponse
    {
        $setting = app(SettingShowAction::class)->run($setting);

        $preparedLayoutData = $this->transform($setting, SettingPublicTransformer::class);

        return response()->json($preparedLayoutData);
    }
}

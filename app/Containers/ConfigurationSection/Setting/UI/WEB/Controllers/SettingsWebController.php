<?php

namespace App\Containers\ConfigurationSection\Setting\UI\WEB\Controllers;

use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\ConfigurationSection\Setting\Actions\SettingDeleteAction;
use App\Containers\ConfigurationSection\Setting\Actions\SettingIndexAction;
use App\Containers\ConfigurationSection\Setting\Actions\SettingMetaAction;
use App\Containers\ConfigurationSection\Setting\Actions\SettingShowAction;
use App\Containers\ConfigurationSection\Setting\Actions\SettingStoreAction;
use App\Containers\ConfigurationSection\Setting\Actions\SettingUpdateAction;
use App\Containers\ConfigurationSection\Setting\Models\Setting;
use App\Containers\ConfigurationSection\Setting\UI\WEB\Requests\SettingWebDeleteRequest;
use App\Containers\ConfigurationSection\Setting\UI\WEB\Requests\SettingWebIndexRequest;
use App\Containers\ConfigurationSection\Setting\UI\WEB\Requests\SettingWebShowRequest;
use App\Containers\ConfigurationSection\Setting\UI\WEB\Requests\SettingWebStoreRequest;
use App\Containers\ConfigurationSection\Setting\UI\WEB\Requests\SettingWebUpdateRequest;
use App\Containers\ConfigurationSection\Setting\UI\WEB\Transformers\SettingPrivateTransformer;
use App\Containers\ConfigurationSection\Game\Models\Game;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Prettus\Validator\Exceptions\ValidatorException;

class SettingsWebController extends ApiController
{
    /**
     * @throws InvalidTransformerException
     * @throws ValidatorException
     */
    public function store(SettingWebStoreRequest $request, Game $game): JsonResponse
    {
        $setting = app(SettingStoreAction::class)->run($request);

        $preparedLayoutData = $this->transform($setting, SettingPrivateTransformer::class);

        return response()->json($preparedLayoutData);
    }


    /**
     * @throws InvalidTransformerException
     * @throws ValidatorException
     */
    public function update(SettingWebUpdateRequest $request, Game $game, Setting $setting): JsonResponse
    {
        $setting = app(SettingUpdateAction::class)->run($request, $setting);

        $preparedLayoutData = $this->transform($setting, SettingPrivateTransformer::class);

        return response()->json($preparedLayoutData);
    }


    public function delete(SettingWebDeleteRequest $request, Game $game, Setting $setting): Response
    {

        app(SettingDeleteAction::class)->run($setting);

        return response()->noContent();
    }


    /**
     * @throws InvalidTransformerException
     */
    public function index(SettingWebIndexRequest $request, Game $game): JsonResponse
    {
        $setting = app(SettingIndexAction::class)->run($request);

        $preparedLayoutData = $this->transform($setting, SettingPrivateTransformer::class);

        return response()->json($preparedLayoutData);
    }


    /**
     * @throws InvalidTransformerException
     */
    public function show(SettingWebShowRequest $request, Game $game, Setting $setting): JsonResponse
    {
        $setting = app(SettingShowAction::class)->run($setting);

        $preparedLayoutData = $this->transform($setting, SettingPrivateTransformer::class);

        return response()->json($preparedLayoutData);
    }
}

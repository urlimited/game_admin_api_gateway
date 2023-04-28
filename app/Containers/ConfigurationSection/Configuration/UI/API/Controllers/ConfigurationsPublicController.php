<?php

namespace App\Containers\ConfigurationSection\Configuration\UI\API\Controllers;

use Apiato\Core\Exceptions\InvalidTransformerException;
use App\Containers\ConfigurationSection\Configuration\Actions\ConfigurationShowAction;
use App\Containers\ConfigurationSection\Configuration\Models\Configuration;
use App\Containers\ConfigurationSection\Configuration\UI\API\Requests\ConfigurationPublicShowRequest;
use App\Containers\ConfigurationSection\Configuration\UI\API\Transformers\ConfigurationPublicTransformer;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

class ConfigurationsPublicController extends ApiController
{
    /**
     * @throws InvalidTransformerException
     */
    public function show(ConfigurationPublicShowRequest $request, Configuration $configuration): JsonResponse
    {
        $configuration = app(ConfigurationShowAction::class)->run($configuration);

        $preparedStructureData = $this->transform($configuration, ConfigurationPublicTransformer::class);

        return response()->json($preparedStructureData);
    }
}

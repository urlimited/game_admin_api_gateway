<?php

namespace App\Containers\ConfigurationSection\Configuration\UI\API\Controllers;

use App\Ship\Parents\Controllers\ApiController;

class ConfigurationsPublicController extends ApiController
{
    public function show()
    {
        return response()->json([
            'hello' => 'world'
        ]);
    }
}

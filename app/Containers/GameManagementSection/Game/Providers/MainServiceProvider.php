<?php

namespace App\Containers\GameManagementSection\Game\Providers;

use App\Ship\Parents\Providers\MainProvider;

class MainServiceProvider extends MainProvider
{
    public array $serviceProviders = [
        MiddlewareServiceProvider::class
    ];

    public array $aliases = [

    ];
}

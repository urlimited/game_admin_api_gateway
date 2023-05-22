<?php

namespace App\Ship\Parents\Providers;

use Apiato\Core\Abstracts\Providers\RoutesProvider as AbstractRoutesProvider;
use Apiato\Core\Loaders\RoutesLoaderTrait;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;

class RoutesProvider extends AbstractRoutesProvider
{
    use RoutesLoaderTrait {
        loadWebContainerRoutes as loadWebContainerRoutesTrait;
        loadWebRoute as loadWebRouteTrait;
    }

    /**
     * Define your route model bindings, pattern filters, etc.
     */
    public function boot(): void
    {
        parent::boot();
    }

    private function loadWebRoute($file, $controllerNamespace): void
    {
        Route::group([
            'namespace' => $controllerNamespace,
            'middleware' => $this->getMiddlewares(),
            'domain' => $this->getWebUrl(),
            'prefix' => is_string($file) ? $file : $this->getWebApiVersionPrefix($file),
        ], function ($router) use ($file) {
            require $file->getPathname();
        });
    }

    private function getWebApiVersionPrefix($file): string
    {
        return Config::get('apiato.web.prefix') . (Config::get('apiato.web.enable_version_prefix') ? $this->getRouteFileVersionFromFileName($file) : '');
    }

    private function getWebUrl()
    {
        return Config::get('apiato.web.url');
    }
}

<?php

namespace App\Ship\Parents\Providers;

use Apiato\Core\Abstracts\Providers\RoutesProvider as AbstractRoutesProvider;
use Apiato\Core\Loaders\RoutesLoaderTrait;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;

class RoutesProvider extends AbstractRoutesProvider
{
    use RoutesLoaderTrait {
        loadWebContainerRoutes as loadWebContainerRoutesTrait;
    }

    /**
     * Define your route model bindings, pattern filters, etc.
     */
    public function boot(): void
    {
        parent::boot();
    }

    private function loadWebContainerRoutes($containerPath): void
    {
        // build the container web routes path
        $webRoutesPath = $containerPath . '/UI/WEB/Routes';
        // build the namespace from the path
        $controllerNamespace = $containerPath . '\\UI\WEB\Controllers';

        if (File::isDirectory($webRoutesPath)) {
            $files = File::allFiles($webRoutesPath);
            $files = Arr::sort($files, function ($file) {
                return $file->getFilename();
            });
            foreach ($files as $file) {
                $this->loadApiRoute($file, $controllerNamespace);
            }
        }
    }
}

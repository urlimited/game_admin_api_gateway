<?php

namespace App\Containers\ConfigurationSection\Configuration\Actions;


use App\Containers\ConfigurationSection\Configuration\Tasks\ConfigurationIndexTask;
use App\Containers\ConfigurationSection\Configuration\Tasks\FilterConfigurationsTask;
use App\Containers\ConfigurationSection\Configuration\UI\API\Requests\ConfigurationIndexRequest;
use App\Containers\ConfigurationSection\Structure\Models\Structure;
use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Collection;
use Prettus\Repository\Exceptions\RepositoryException;

class ConfigurationIndexAction extends Action
{
    /**
     * @throws RepositoryException
     */
    public function run(ConfigurationIndexRequest $request): Collection
    {
        return app(FilterConfigurationsTask::class)
            ->run(
                [
                    'structure_id'=>$request->get('structure_id')
                ]
            );
    }
}

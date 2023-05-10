<?php

namespace App\Containers\ConfigurationSection\Layout\Actions;

use App\Containers\ConfigurationSection\Layout\Models\Layout;
use App\Containers\ConfigurationSection\Layout\Tasks\LayoutFilterTask;
use App\Ship\Parents\Actions\Action;
use Prettus\Repository\Exceptions\RepositoryException;

class LayoutShowAction extends Action
{
    /**
     * @param Layout $layout
     * @return Layout
     * @throws RepositoryException
     */
    public function run(Layout $layout): Layout
    {
        return app(LayoutFilterTask::class)
            ->run(
                [
                    'id' => $layout->getAttribute('id'),
                ]
            )
            ->first();
    }

}

<?php

namespace App\Containers\ConfigurationSection\Adjustment\Actions;

use App\Containers\ConfigurationSection\Adjustment\Models\Adjustment;
use App\Containers\ConfigurationSection\Adjustment\UI\WEB\Requests\AdjustmentWebDeleteRequest;
use App\Containers\ConfigurationSection\Adjustment\Tasks\AdjustmentDeleteTask;
use App\Ship\Parents\Actions\Action;
use Prettus\Validator\Exceptions\ValidatorException;

class AdjustmentDeleteAction extends Action
{
    /**
     * @throws ValidatorException
     */
    public function run(AdjustmentWebDeleteRequest $request, Adjustment $adjustment): void
    {
        // Adjustment check if deletable

        // Adjustment delete

        app(AdjustmentDeleteTask::class)->run($adjustment->getAttribute('id'));
    }
}

<?php

namespace App\Ship\Parents\Repositories;

use Apiato\Core\Abstracts\Repositories\Repository as AbstractRepository;
use App\Ship\Parents\Models\Model;

/**
 * @mixin Model
 */
abstract class Repository extends AbstractRepository
{
    /**
     * Boot up the repository, pushing criteria.
     */
    public function boot()
    {
        parent::boot();
    }
}

<?php

namespace App\Ship\Parents\Models;

use Apiato\Core\Traits\FactoryLocatorTrait;
use Apiato\Core\Traits\HashIdTrait;
use Apiato\Core\Traits\HasResourceKeyTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property string $login
 */
abstract class PermissionModel extends Model
{
    use HashIdTrait;
    use HasResourceKeyTrait;
    use HasFactory, FactoryLocatorTrait {
        FactoryLocatorTrait::newFactory insteadof HasFactory;
    }

    protected $fillable = [
        'name',
        'display_name',
        'description',
    ];
}

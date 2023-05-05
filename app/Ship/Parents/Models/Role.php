<?php

namespace App\Ship\Parents\Models;

use Apiato\Core\Traits\FactoryLocatorTrait;
use Apiato\Core\Traits\HashIdTrait;
use Apiato\Core\Traits\HasResourceKeyTrait;
use App\Ship\Parents\Factories\RoleFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $login
 */
class Role extends Model
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

    protected $table = 'roles';

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(
            Permission::class,
            'permissions_to_roles',
            'role_id',
            'permission_id'
        );
    }

    protected static function newFactory(): RoleFactory
    {
        return RoleFactory::new();
    }
}

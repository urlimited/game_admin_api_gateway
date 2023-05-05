<?php

namespace App\Ship\Parents\Models;

use Apiato\Core\Traits\FactoryLocatorTrait;
use Apiato\Core\Traits\HashIdTrait;
use Apiato\Core\Traits\HasResourceKeyTrait;
use App\Ship\Parents\Factories\PermissionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $login
 */
class Permission extends Model
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

    protected $table = 'permissions';

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(
            Role::class,
            'permissions_to_roles',
            'permission_id',
            'role_id'
        );
    }

    protected static function newFactory(): PermissionFactory
    {
        return PermissionFactory::new();
    }
}

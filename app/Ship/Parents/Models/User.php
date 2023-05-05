<?php

namespace App\Ship\Parents\Models;

use Apiato\Core\Traits\HashIdTrait;
use Apiato\Core\Traits\HasResourceKeyTrait;
use App\Ship\Parents\Factories\UserFactory;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as LaravelUser;
use Illuminate\Notifications\Notifiable;
use \Illuminate\Contracts\Auth\Authenticatable as AuthenticatableInterface;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property int $id
 * @property string $login
 * @method static UserFactory factory()
 */
class User extends LaravelUser implements AuthenticatableInterface
{
    use Notifiable;
    use HasApiTokens;
    use HasFactory;
    use HashIdTrait;
    use HasResourceKeyTrait;
    use AuthenticatableTrait;

    protected $table = 'users';

    protected $fillable = [
        'login',
        'password',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [

    ];

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(
            Role::class,
            'user_has_roles',
            'user_id',
            'role_id'
        );
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(
            Permission::class,
            'user_has_permissions',
            'user_id',
            'permission_id'
        );
    }

    public function hasRole(array|string $rolesToBeChecked): bool
    {
        if (is_string($rolesToBeChecked)) {
            $rolesToBeChecked = [$rolesToBeChecked];
        }

        foreach ($rolesToBeChecked as $roleNameToBeChecked) {
            if (!$this->getAttribute('roles')->contains('name', $roleNameToBeChecked)) {
                return false;
            }
        }

        return true;
    }

    public function hasPermission(array|string $permissionsToBeChecked): bool
    {
        if (is_string($permissionsToBeChecked)) {
            $permissionsToBeChecked = [$permissionsToBeChecked];
        }

        $permissionsFromRoles = $this
            ->roles()
            ->with('permissions')
            ->get()
            ->map(
                fn(Role $role) => $role
                    ->getAttribute('permissions')
                    ->map(fn(Permission $permission) => $permission->getAttribute('name'))
            )->flatten();

        $permissionsFromUser = $this
            ->getAttribute('permissions')
            ->map(fn(Permission $permission) => $permission->getAttribute('name'))
            ->flatten();

        $totalPermissions = $permissionsFromRoles->merge($permissionsFromUser);

        if (is_string($permissionsToBeChecked)) {
            return $totalPermissions->contains($permissionsToBeChecked);
        }

        foreach ($permissionsToBeChecked as $permissionToBeChecked) {
            if (!$totalPermissions->contains($permissionToBeChecked)) {
                return false;
            }
        }

        return true;
    }

    protected static function newFactory(): UserFactory
    {
        return UserFactory::new();
    }
}

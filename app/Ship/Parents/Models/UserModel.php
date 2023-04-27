<?php

namespace App\Ship\Parents\Models;

use Apiato\Core\Traits\HashIdTrait;
use Apiato\Core\Traits\HasResourceKeyTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as LaravelUser;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property int $id
 * @property string $login
 */
abstract class UserModel extends LaravelUser
{
    use Notifiable;
    use HasApiTokens;
    use HasFactory;
    use HashIdTrait;
    use HasResourceKeyTrait;

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
}

<?php

namespace App\Containers\GameManagementSection\User\Models;

use App\Containers\GameManagementSection\Game\Models\Game;
use App\Containers\GameManagementSection\User\Data\Factories\UserFactory;
use App\Ship\Parents\Models\UserModel;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @method static UserFactory factory()
 */
class User extends UserModel
{
    use Authenticatable;

    public function games(): BelongsToMany
    {
        return $this->belongsToMany(Game::class, 'game_user', 'user_id');
    }

    protected static function newFactory(): UserFactory
    {
        return UserFactory::new();
    }
}

<?php

namespace App\Containers\ConfigurationSection\User\Models;

use App\Containers\ConfigurationSection\Game\Models\Game;
use App\Containers\ConfigurationSection\User\Data\Factories\UserFactory;
use App\Ship\Parents\Models\User as ParentUser;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

final class User extends ParentUser
{
    public function games(): BelongsToMany
    {
        return $this->belongsToMany(Game::class, 'game_user');
    }

    protected static function newFactory(): UserFactory
    {
        return UserFactory::new();
    }
}

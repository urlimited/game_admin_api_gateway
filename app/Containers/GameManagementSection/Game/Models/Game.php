<?php

namespace App\Containers\GameManagementSection\Game\Models;

use App\Containers\GameManagementSection\Player\Models\Player;
use App\Containers\GameManagementSection\User\Models\User;
use App\Containers\GameManagementSection\Game\Data\Factories\GameFactory;
use App\Containers\GameManagementSection\Game\Enums\GameGenre;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Apiato\Core\Traits\HasResourceKeyTrait;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\PersonalAccessToken;

/**
 * @property int $id
 * @property string $name
 * @property string $genre
 * @property Collection<PersonalAccessToken> $tokens
 * @method static GameFactory factory()
 */
class Game extends Model
{
    use HasResourceKeyTrait;
    use HasApiTokens;
    use HasFactory;
    use SoftDeletes;

    protected $table = 'games';

    protected $fillable = [
        'name',
        'genre',
    ];

    protected $hidden = [

    ];

    protected $casts = [
        'genre' => GameGenre::class,
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'game_user', 'game_id');
    }

    public function players(): HasMany
    {
        return $this->hasMany(Player::class);
    }

    protected static function newFactory(): GameFactory
    {
        return GameFactory::new();
    }
}

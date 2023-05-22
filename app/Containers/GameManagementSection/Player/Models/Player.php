<?php

namespace App\Containers\GameManagementSection\Player\Models;

use App\Containers\GameManagementSection\Game\Models\Game;
use App\Containers\GameManagementSection\Player\Data\Factories\PlayerFactory;
use App\Ship\Libs\OptimisedUuid\HasBinaryUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Apiato\Core\Traits\HasResourceKeyTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\PersonalAccessToken;

/**
 * @property int $id
 * @property string $login
 * @property int $game_id
 * @property Collection<PersonalAccessToken> $tokens
 * @method static PlayerFactory factory()
 */
class Player extends Model
{
    use HasResourceKeyTrait;
    use HasApiTokens;
    use HasFactory;
    use SoftDeletes;
    use HasBinaryUuid;

    protected $table = 'players';

    protected $guarded = [

    ];

    protected $hidden = [
        'password'
    ];

    protected $casts = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    protected static function newFactory(): PlayerFactory
    {
        return PlayerFactory::new();
    }
}

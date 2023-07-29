<?php

namespace App\Containers\AnalyticsSection\Player\Models;

use App\Containers\AnalyticsSection\Game\Models\Game;
use App\Containers\AnalyticsSection\Player\Data\Factories\PlayerFactory;
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
 * @property int $uuid
 * @property string $name
 * @property string $genre
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

    protected $hidden = [

    ];

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class, 'game_id');
    }

    protected static function newFactory(): PlayerFactory
    {
        return PlayerFactory::new();
    }
}

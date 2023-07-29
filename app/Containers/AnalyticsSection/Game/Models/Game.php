<?php

namespace App\Containers\AnalyticsSection\Game\Models;

use App\Containers\AnalyticsSection\Game\Data\Factories\GameFactory;
use App\Ship\Libs\OptimisedUuid\HasBinaryUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Apiato\Core\Traits\HasResourceKeyTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\PersonalAccessToken;

/**
 * @property int $uuid
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
    use HasBinaryUuid;

    protected $table = 'games';

    protected $hidden = [

    ];

    protected static function newFactory(): GameFactory
    {
        return GameFactory::new();
    }
}

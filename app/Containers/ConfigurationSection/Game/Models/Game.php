<?php

namespace App\Containers\ConfigurationSection\Game\Models;

use App\Containers\ConfigurationSection\Setting\Models\Setting;
use App\Containers\ConfigurationSection\Game\Data\Factories\GameFactory;
use App\Containers\ConfigurationSection\Layout\Models\Layout;
use App\Ship\Libs\OptimisedUuid\HasBinaryUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Apiato\Core\Traits\HasResourceKeyTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    public function layouts(): HasMany
    {
        return $this->hasMany(Layout::class);
    }

    public function settings(): HasMany
    {
        return $this->hasMany(Setting::class);
    }

    protected static function newFactory(): GameFactory
    {
        return GameFactory::new();
    }
}

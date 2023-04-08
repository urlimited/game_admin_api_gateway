<?php

namespace App\Containers\ConfigurationSection\Game\Models;

use App\Containers\ConfigurationSection\Game\Data\Factories\GameFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Apiato\Core\Traits\HasResourceKeyTrait;
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

    protected $hidden = [

    ];

    protected static function newFactory(): GameFactory
    {
        return GameFactory::new();
    }
}

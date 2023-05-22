<?php

namespace App\Containers\ConfigurationSection\Layout\Models;

use Apiato\Core\Traits\HasResourceKeyTrait;
use App\Containers\ConfigurationSection\Setting\Models\Setting;
use App\Containers\ConfigurationSection\Game\Models\Game;
use App\Containers\ConfigurationSection\Layout\Data\Factories\LayoutFactory;
use App\Ship\Libs\OptimisedUuid\HasBinaryUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
/**
 * @property int $uuid
 * @property string $name
 * @property int $game_id
 * @property string $version
 * @property string $schema
 * @method static LayoutFactory factory()
 */
class Layout extends Model
{
    use HasResourceKeyTrait;
    use HasFactory;
    use SoftDeletes;
    use HasBinaryUuid;

    protected $table = 'layouts';

    protected $fillable = [
        'uuid',
        'name',
        'game_id',
        'schema',
        'version'
    ];

    protected $hidden = [

    ];

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function settings(): HasMany
    {
        return $this->hasMany(Setting::class);
    }

    protected static function newFactory(): LayoutFactory
    {
        return LayoutFactory::new();
    }
}

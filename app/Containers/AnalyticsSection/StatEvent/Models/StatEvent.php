<?php

namespace App\Containers\AnalyticsSection\StatEvent\Models;

use Apiato\Core\Traits\HasResourceKeyTrait;
use App\Containers\AnalyticsSection\Game\Models\Game;
use App\Containers\AnalyticsSection\StatEvent\Data\Factories\StatEventFactory;
use App\Ship\Libs\OptimisedUuid\HasBinaryUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $uuid
 * @property string $name
 * @property int $game_id
 * @property int|null $structure_id
 * @property int $author_id
 * @property string $schema
 * @method static StatEventFactory factory()
 */
class StatEvent extends Model
{
    use HasResourceKeyTrait;
    use HasFactory;
    use SoftDeletes;
    use HasBinaryUuid;

    protected $table = 'stat_events';

    protected $fillable = [
        'uuid',
        'name',
        'game_id',
        'type',
    ];

    protected $hidden = [

    ];

    public function statEventData(): HasMany
    {
        return $this->hasMany(StatEventData::class, 'stat_event_id');
    }

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class, 'game_id');
    }

    protected static function newFactory(): StatEventFactory
    {
        return StatEventFactory::new();
    }
}

<?php

namespace App\Containers\AnalyticsSection\StatEvent\Models;

use Apiato\Core\Traits\HasResourceKeyTrait;
use App\Containers\AnalyticsSection\Player\Models\Player;
use App\Containers\AnalyticsSection\StatEvent\Data\Factories\StatEventDataFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $uuid
 * @property string $name
 * @property int $game_id
 * @property int|null $structure_id
 * @property int $author_id
 * @property string $schema
 * @method static StatEventDataFactory factory()
 */
class StatEventData extends Model
{
    use HasResourceKeyTrait;
    use HasFactory;
    use SoftDeletes;

    protected $table = 'stat_event_data';

    protected $fillable = [
        'player_id',
        'stat_event_id',
        'value',
    ];

    protected $hidden = [

    ];

    public function statEvent(): BelongsTo
    {
        return $this->belongsTo(StatEvent::class, 'stat_event_id');
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class, 'player_id');
    }

    protected static function newFactory(): StatEventDataFactory
    {
        return StatEventDataFactory::new();
    }
}

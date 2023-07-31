<?php

namespace App\Containers\AnalyticsSection\TargetGroup\Models;

use Apiato\Core\Traits\HasResourceKeyTrait;
use App\Containers\AnalyticsSection\TargetGroup\Data\Factories\TargetGroupFactory;
use App\Containers\AnalyticsSection\Game\Models\Game;
use App\Ship\Libs\OptimisedUuid\HasBinaryUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $uuid
 * @property string $name
 * @property int $game_id
 * @property string $conditions
 * @method static TargetGroupFactory factory()
 */
class TargetGroup extends Model
{
    use HasResourceKeyTrait;
    use HasFactory;
    use SoftDeletes;
    use HasBinaryUuid;

    protected $table = 'target_groups';

    protected $fillable = [
        'uuid',
        'name',
        'conditions',
        'game_id',
    ];

    protected $hidden = [

    ];

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class, 'game_id');
    }

    protected static function newFactory(): TargetGroupFactory
    {
        return TargetGroupFactory::new();
    }
}

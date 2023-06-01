<?php

namespace App\Containers\ConfigurationSection\Adjustment\Models;

use Apiato\Core\Traits\HasResourceKeyTrait;
use App\Containers\ConfigurationSection\Adjustment\Data\Factories\AdjustmentFactory;
use App\Containers\ConfigurationSection\Setting\Models\Setting;
use App\Containers\ConfigurationSection\User\Models\User;
use App\Ship\Libs\OptimisedUuid\HasBinaryUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static AdjustmentFactory factory()
 */
class Adjustment extends Model
{
    use HasResourceKeyTrait;
    use HasFactory;
    use SoftDeletes;
    use HasBinaryUuid;

    protected $table = 'adjustments';

    protected $fillable = [
        'name',
        'priority',
        'uuid',
        'author_id',
        'setting_id',
        'schema',
    ];

    protected $hidden = [

    ];

    public function setting(): BelongsTo
    {
        return $this->belongsTo(Setting::class, 'setting_id');
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    protected static function newFactory(): AdjustmentFactory
    {
        return AdjustmentFactory::new();
    }
}

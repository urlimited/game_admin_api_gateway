<?php

namespace App\Containers\ConfigurationSection\Setting\Models;

use Apiato\Core\Traits\HasResourceKeyTrait;
use App\Containers\ConfigurationSection\Setting\Data\Factories\SettingFactory;
use App\Containers\ConfigurationSection\Game\Models\Game;
use App\Containers\ConfigurationSection\Layout\Data\Factories\LayoutFactory;
use App\Containers\ConfigurationSection\Layout\Models\Layout;
use App\Ship\Libs\OptimisedUuid\HasBinaryUuid;
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
 * @method static LayoutFactory factory()
 */
class Setting extends Model
{
    use HasResourceKeyTrait;
    use HasFactory;
    use SoftDeletes;
    use HasBinaryUuid;

    protected $table = 'settings';

    protected $fillable = [
        'uuid',
        'name',
        'structure_id',
        'game_id',
        'schema',
        'author_id',
    ];

    protected $hidden = [

    ];

    public function layout(): BelongsTo
    {
        return $this->belongsTo(Layout::class,'structure_id');
    }

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    protected static function newFactory(): SettingFactory
    {
        return SettingFactory::new();
    }
}

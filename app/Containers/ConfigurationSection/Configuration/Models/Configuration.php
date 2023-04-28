<?php

namespace App\Containers\ConfigurationSection\Configuration\Models;

use Apiato\Core\Traits\HasResourceKeyTrait;
use App\Containers\ConfigurationSection\Configuration\Data\Factories\ConfigurationFactory;
use App\Containers\ConfigurationSection\Structure\Data\Factories\StructureFactory;
use App\Containers\ConfigurationSection\Structure\Models\Structure;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $name
 * @property int $game_id
 * @property string $version
 * @property string $fields
 * @method static StructureFactory factory()
 */
class Configuration extends Model
{
    use HasResourceKeyTrait;
    use HasFactory;
    use SoftDeletes;

    protected $table = 'configurations';

    protected $fillable = [
        'name',
        'structure_id',
        'schema',
        'author_id',
    ];

    protected $hidden = [

    ];

    public function structure(): BelongsTo
    {
        return $this->belongsTo(Structure::class);
    }

    protected static function newFactory(): ConfigurationFactory
    {
        return ConfigurationFactory::new();
    }
}

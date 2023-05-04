<?php

namespace App\Containers\ConfigurationSection\Structure\Models;

use Apiato\Core\Traits\HasResourceKeyTrait;
use App\Containers\ConfigurationSection\Configuration\Models\Configuration;
use App\Containers\ConfigurationSection\Game\Models\Game;
use App\Containers\ConfigurationSection\Structure\Data\Factories\StructureFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $name
 * @property int $game_id
 * @property string $version
 * @property string $schema
 * @method static StructureFactory factory()
 */
class Structure extends Model
{
    use HasResourceKeyTrait;
    use HasFactory;
    use SoftDeletes;

    protected $table = 'structures';

    protected $fillable = [
        'name',
        'game_id',
        'schema',
        'version'
    ];

    protected $hidden = [

    ];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function configurations()
    {
        return $this->hasMany(Configuration::class);
    }

    protected static function newFactory(): StructureFactory
    {
        return StructureFactory::new();
    }
}

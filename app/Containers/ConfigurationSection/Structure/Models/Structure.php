<?php

namespace App\Containers\ConfigurationSection\Structure\Models;

use App\Containers\ConfigurationSection\Structure\Data\Factories\StructureFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $name
 * @property int $game_id
 * @property string $version
 * @property string $fields
 * @method static StructureFactory factory()
 */
class Structure extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'structures';

    protected $fillable = [
        'name',
        'game_id',
        'fields',
        'version'
    ];

    protected $hidden = [

    ];

    protected static function newFactory(): StructureFactory
    {
        return StructureFactory::new();
    }
}

<?php

namespace App\Containers\GameManagementSection\Game\UI\WEB\Transformers;

use App\Containers\GameManagementSection\Game\Models\Game;
use App\Ship\Parents\Transformers\Transformer;
use JetBrains\PhpStorm\ArrayShape;

class GamePrivateTransformer extends Transformer
{
    protected array $availableIncludes = [

    ];

    protected array $defaultIncludes = [

    ];

        #[ArrayShape
        ([
            'id' => "int",
            'name' => "string",
            'genre' => "genre"
        ])]
    public function transform(Game $game): array
    {
        return [
            'id' => $game->id,
            'name' => $game->name,
            'genre' => $game->genre,
        ];
    }
}

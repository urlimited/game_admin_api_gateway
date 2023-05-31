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
            'uuid' => "string",
            'name' => "string",
            'genre' => "genre"
        ])]
    public function transform(Game $game): array
    {
        return [
            'uuid' => $game->getAttribute('uuidText'),
            'name' => $game->getAttribute('name'),
            'genre' => $game->getAttribute('genre'),
        ];
    }
}

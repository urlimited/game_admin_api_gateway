<?php

namespace App\Containers\GameManagementSection\Game\UI\Web\Transformers;

use App\Containers\GameManagementSection\Game\Models\Game;
use App\Ship\Parents\Transformers\Transformer;
use JetBrains\PhpStorm\ArrayShape;

class GameCreatedTransformer extends Transformer
{
    protected array $availableIncludes = [

    ];

    protected array $defaultIncludes = [

    ];

        #[ArrayShape
        ([
            'id' => "int",
            'name' => "string",
            'genre' => "genre",
            'api_token' => 'string'
        ])]
    public function transform(Game $game): array
    {
        return [
            'id' => $game->id,
            'name' => $game->name,
            'genre' => $game->genre,
            'api_token' => $game->apiToken
        ];
    }
}

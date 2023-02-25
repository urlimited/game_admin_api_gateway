<?php

namespace App\Containers\GameManagementSection\Player\UI\API\Transformers;

use App\Containers\GameManagementSection\Player\Models\Player;
use App\Ship\Parents\Transformers\Transformer;
use JetBrains\PhpStorm\ArrayShape;

class PlayerAuthedTransformer extends Transformer
{
    protected $availableIncludes = [

    ];

    protected $defaultIncludes = [

    ];

    public function transform(Player $player): array
    {
        return [
            'id' => $player->getAttribute('id'),
            'login' => $player->getAttribute('login'),
            'game_id' => $player->getAttribute('game_id'),
            'player_token' => $player->apiToken,
        ];
    }
}

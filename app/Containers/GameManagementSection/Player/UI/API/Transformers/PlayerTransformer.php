<?php

namespace App\Containers\GameManagementSection\Player\UI\API\Transformers;

use App\Containers\GameManagementSection\Player\Models\Player;
use App\Ship\Parents\Transformers\Transformer;
use JetBrains\PhpStorm\ArrayShape;

class PlayerTransformer extends Transformer
{
    protected $availableIncludes = [

    ];

    protected $defaultIncludes = [

    ];

    public function transform(Player $player): array
    {
        return [
            'id' => $player->id,
            'login' => $player->login,
            'game_id' => $player->game_id
        ];
    }
}

<?php

namespace App\Containers\GameManagementSection\Player\UI\Web\Transformers;

use App\Containers\GameManagementSection\Player\Models\Player;
use App\Ship\Parents\Transformers\Transformer;

class PlayerGeneralTransformer extends Transformer
{
    protected array $availableIncludes = [

    ];

    protected array $defaultIncludes = [

    ];

    public function transform(Player $player): array
    {
        return [
            'id' => $player->getAttribute('id'),
            'login' => $player->getAttribute('login'),
            'game_id' => $player->getAttribute('game_id'),
            'player_token' => $player->getAttribute('apiToken'),
        ];
    }
}

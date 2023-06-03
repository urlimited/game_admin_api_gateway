<?php

namespace App\Containers\GameManagementSection\Player\UI\WEB\Transformers;

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
            'uuid' => $player->getAttribute('uuidText'),
            'login' => $player->getAttribute('login'),
            'game_uuid' => $player->getAttribute('game')->getAttribute('uuidText'),
            'player_token' => $player->getAttribute('apiToken'),
        ];
    }
}

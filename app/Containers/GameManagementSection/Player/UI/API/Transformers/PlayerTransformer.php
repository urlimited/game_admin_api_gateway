<?php

namespace App\Containers\GameManagementSection\Player\UI\API\Transformers;

use App\Containers\GameManagementSection\Player\Models\Player;
use App\Ship\Parents\Transformers\Transformer;
use JetBrains\PhpStorm\ArrayShape;

class PlayerTransformer extends Transformer
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
            // 'game_id' => $player->getAttribute('game_id')
        ];
    }
}

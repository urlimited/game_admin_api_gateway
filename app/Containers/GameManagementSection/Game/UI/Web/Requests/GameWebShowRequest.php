<?php

namespace App\Containers\GameManagementSection\Game\UI\Web\Requests;

use App\Containers\GameManagementSection\Game\Models\Game;
use App\Ship\Parents\Models\User;
use App\Ship\Parents\Requests\Request;

/**
 * @description Can be obtained in the following scenarios: \
 *      1. When a user has permission game-full-own-read and the game belongs to the user \
 *      2. When a user has permission game-full-other-read
 */
class GameWebShowRequest extends Request
{
    /**
     * Id's that needs decoding before applying the validation rules.
     */
    protected array $decode = [

    ];

    /**
     * Defining the URL parameters (`/stores/999/items`) allows applying
     * validation rules on them and allows accessing them like request data.
     */
    protected array $urlParameters = [

    ];

    public function rules(): array
    {
        return [

        ];
    }

    public function authorize(): bool
    {
        return (
            $this->user()->hasPermission('game-full-other-read')
            || (
                $this->user()->hasPermission('game-full-own-read')
                && $this->user()
                    ->games
                    ->map(fn(Game $game) => $game->getAttribute('id'))
                    ->contains(fn($gameId) => $gameId == $this->route('game_id'))
            )
        );
    }
}

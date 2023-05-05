<?php

namespace App\Containers\GameManagementSection\Player\UI\Web\Requests;

use App\Containers\GameManagementSection\Game\Models\Game;
use App\Containers\GameManagementSection\Player\UI\Contracts\Requests\PlayerUpdateRequestContract;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @description Can be obtained in the following scenarios: \
 *      1. When a user has permission player-full-own-update and game belongs to the user \
 *      2. When a user has permission player-full-other-update
 */
final class PlayerWebUpdateRequest extends FormRequest implements PlayerUpdateRequestContract
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
        return $this->user()->hasPermission('player-full-other-update')
            || (
                $this->user()->hasPermission('player-full-own-update')
                && $this
                    ->user()
                    ->games
                    ->map(fn(Game $game) => $game->getAttribute('id'))
                    ->contains(fn($gameId) => $gameId == $this->get('game_id'))
            );
    }

    public function getGameId()
    {
        return $this->get('game_id');
    }

    public function getPlayerId()
    {
        return $this->route('player')->getAttribute('id');
    }
}

<?php

namespace App\Containers\GameManagementSection\Player\UI\WEB\Requests;

use App\Containers\GameManagementSection\Game\Models\Game;
use App\Containers\GameManagementSection\Player\UI\Contracts\Requests\PlayerStoreRequestContract;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @description Can be obtained in the following scenarios: \
 *      1. When a user has permission player-full-own-create and game belongs to the user \
 *      2. When a user has permission player-full-other-create
 */
final class PlayerWebStoreRequest extends FormRequest implements PlayerStoreRequestContract
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
            'login' => [
                'required',
                'string',
                Rule::unique('players')
                    ->where(
                        function ($q) {
                            return $q->where('game_id', $this->getGameId());
                        }
                    )
            ],
            'password' => [
                'required',
                'string'
            ],
            'game_id' => [
                'required',
                'exists:games,id'
            ]
        ];
    }

    public function authorize(): bool
    {
        return $this->user()->hasPermission('player-full-other-create')
            || (
                $this->user()->hasPermission('player-full-own-create')
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
}

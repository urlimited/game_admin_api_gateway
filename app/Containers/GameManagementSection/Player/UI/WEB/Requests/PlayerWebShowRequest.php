<?php

namespace App\Containers\GameManagementSection\Player\UI\WEB\Requests;

use App\Containers\GameManagementSection\Game\Models\Game;
use App\Containers\GameManagementSection\Player\UI\Contracts\Requests\PlayerShowRequestContract;
use Illuminate\Foundation\Http\FormRequest;
use Ramsey\Uuid\Uuid;

/**
 * @description Can be obtained in the following scenarios: \
 *      1. When a user has permission player-full-own-read and game belongs to the user \
 *      2. When a user has permission player-full-other-read
 */
final class PlayerWebShowRequest extends FormRequest implements PlayerShowRequestContract
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
        return $this->user()->hasPermission('player-full-other-read')
            || (
                $this->user()->hasPermission('player-full-own-read')
                && $this
                    ->user()
                    ->games
                    ->map(fn(Game $game) => $game->getAttribute('id'))
                    ->contains(fn($gameId) => $gameId == $this->getGameId())
            );
    }

    public function getGameId()
    {
        return $this->route('player')->getAttribute('game_id');
    }

    public function getPlayerId()
    {
        return $this->route('player')->getAttribute('id');
    }
}

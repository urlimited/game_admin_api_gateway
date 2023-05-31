<?php

namespace App\Containers\GameManagementSection\Player\UI\WEB\Requests;

use App\Containers\GameManagementSection\Game\Models\Game;
use Illuminate\Foundation\Http\FormRequest;
use Ramsey\Uuid\Uuid;

/**
 * @description Can be obtained in the following scenarios: \
 *      1. When a user has permission player-full-own-read and game belongs to the user \
 *      2. When a user has permission player-full-other-read
 */
final class PlayerWebIndexRequest extends FormRequest
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
            'game_uuid' => [
                'required',
            ]
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
                    ->map(fn(Game $game) => $game->getAttribute('uuid'))
                    ->contains(fn($gameId) => $gameId == Uuid::fromString($this->get('game_uuid'))->getBytes() )
            );
    }

    public function getGameId()
    {
        return $this->get('game_uuid');

    }
}

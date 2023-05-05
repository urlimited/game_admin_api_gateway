<?php

namespace App\Containers\GameManagementSection\Player\UI\API\Requests;

use App\Containers\GameManagementSection\Player\Models\Player;
use App\Containers\GameManagementSection\Player\UI\Contracts\Requests\PlayerShowRequestContract;
use App\Ship\Exceptions\AuthenticationException;
use App\Ship\Parents\Requests\PlayerReceivableRequest;
use Illuminate\Auth\Access\AuthorizationException;

/**
 * @description Can be obtained in the following scenarios: \
 *      1. When the request has correct game token and player token \
 *              and player token, and player must belong to the current game
 */
final class PlayerApiShowRequest extends PlayerReceivableRequest implements PlayerShowRequestContract
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

    /**
     * @throws AuthorizationException
     * @throws AuthenticationException
     */
    public function authorize(): bool
    {
        return (
            $this->getGameId()
            && Player::query()->find($this->getPlayerId())->getAttribute('game_id') == $this->getGameId()
        );
    }
}

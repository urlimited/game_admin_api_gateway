<?php

namespace App\Containers\GameManagementSection\Game\UI\Web\Requests;

use App\Ship\Parents\Models\User;
use App\Ship\Parents\Requests\GameReceivableRequest;

/**
 * @description Can be obtained in the following scenarios: \
 *      1. When a user has permission game-full-own-delete and the game belongs to the user and a token is correct
 *      2. When a user has permission game-full-other-delete
 */
class GameWebDeleteRequest extends GameReceivableRequest
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
            $this->user()->hasPermission('game-full-other-delete')
            || (
                $this->user()->hasPermission('game-full-own-delete')
                && $this
                    ->route('game')
                    ->users
                    ->map(fn(User $user) => $user->getAttribute('id'))
                    ->contains($this->user()->getAttribute('id'))
                && $this->getGameId() == $this->route('game')->getAttribute('id')
            )
        );
    }
}

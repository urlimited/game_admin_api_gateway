<?php

namespace App\Containers\GameManagementSection\Game\UI\Web\Requests;

use App\Ship\Parents\Models\User;
use App\Ship\Parents\Requests\Request;

/**
 * @description Can be obtained in the following scenarios: \
 *      1. When a user has permission game-full-own-update and the game belongs to the user
 *      2. When a user has permission game-full-other-update
 */
class GameWebUpdateRequest extends Request
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
            'name' => ['required', 'string']
        ];
    }

    public function authorize(): bool
    {
        return (
            $this->user()->hasPermission('game-full-other-update')
            || (
                $this->user()->hasPermission('game-full-own-update')
                && $this
                    ->route('game')
                    ->users
                    ->map(fn(User $user) => $user->getAttribute('id'))
                    ->contains($this->user()->getAttribute('id'))
            )
        );
    }
}

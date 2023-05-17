<?php

namespace App\Containers\GameManagementSection\Player\UI\API\Requests;

use App\Containers\GameManagementSection\Player\UI\Contracts\Requests\PlayerStoreRequestContract;
use App\Ship\Exceptions\AuthenticationException;
use App\Ship\Parents\Requests\GameReceivableRequest;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Validation\Rule;

/**
 * @description Can be obtained in the following scenarios: \
 *      1. When the request has correct game token
 */
final class PlayerApiStoreRequest extends GameReceivableRequest implements PlayerStoreRequestContract
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
                'email',
                'string',
                Rule::unique('players')
                    ->where(
                        function ($q) {
                            return $q->where('game_id', $this->getGameId());
                        }
                    ),
                'max:191'
            ],
            'password' => [
                'required',
                'string',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,100}$/'
            ]
        ];
    }

    /**
     * @throws AuthorizationException
     * @throws AuthenticationException
     */
    public function authorize(): bool
    {
        return (bool)$this->getGameId();
    }
}

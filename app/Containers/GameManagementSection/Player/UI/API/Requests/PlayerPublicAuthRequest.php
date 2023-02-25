<?php

namespace App\Containers\GameManagementSection\Player\UI\API\Requests;

use App\Ship\Parents\Requests\GameReceivableRequest;
use Illuminate\Validation\Rule;

final class PlayerPublicAuthRequest extends GameReceivableRequest
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
                Rule::exists('players')
                    ->where(
                        function ($q) {
                            return $q->where('game_id', $this->getGameId());
                        }
                    )
            ],
            'password' => [
                'required',
                'string'
            ]
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
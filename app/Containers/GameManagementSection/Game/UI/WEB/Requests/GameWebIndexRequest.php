<?php

namespace App\Containers\GameManagementSection\Game\UI\WEB\Requests;

use App\Ship\Parents\Models\User;
use App\Ship\Parents\Requests\Request;

/**
 * @description Can be obtained in the following scenarios: \
 *      1. When a user has permission game-full-own-read \
 *      2. When a user has permission game-full-other-read
 */
class GameWebIndexRequest extends Request
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
            || $this->user()->hasPermission('game-full-own-read')
        );
    }
}

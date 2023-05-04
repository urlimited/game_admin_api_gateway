<?php

namespace App\Containers\GameManagementSection\Game\UI\Web\Requests;

use App\Ship\Parents\Requests\Request;

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
        return true;
    }
}

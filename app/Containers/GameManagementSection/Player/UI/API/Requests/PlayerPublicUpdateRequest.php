<?php

namespace App\Containers\GameManagementSection\Player\UI\API\Requests;

use App\Containers\GameManagementSection\Player\UI\API\Requests\Contracts\PlayerUpdateRequestContract;
use App\Ship\Parents\Requests\PlayerReceivableRequest;

final class PlayerPublicUpdateRequest extends PlayerReceivableRequest implements PlayerUpdateRequestContract
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
        return true;
    }
}

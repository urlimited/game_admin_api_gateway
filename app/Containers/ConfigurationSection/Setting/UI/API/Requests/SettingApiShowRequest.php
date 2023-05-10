<?php

namespace App\Containers\ConfigurationSection\Setting\UI\API\Requests;

use App\Containers\ConfigurationSection\Setting\UI\Contracts\Requests\SettingShowRequestContract;
use App\Ship\Parents\Requests\GameReceivableRequest;

class SettingApiShowRequest extends GameReceivableRequest implements SettingShowRequestContract
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

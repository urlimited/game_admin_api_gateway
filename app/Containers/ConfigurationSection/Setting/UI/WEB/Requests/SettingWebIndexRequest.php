<?php

namespace App\Containers\ConfigurationSection\Setting\UI\WEB\Requests;

use App\Ship\Parents\Requests\Request;

/**
 * @description Can be obtained in the following scenarios: \
 *      1. When a user has permission setting-full-other-read \
 *      2. When a user has permission setting-full-own-read
 */
class SettingWebIndexRequest extends Request
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
            'game_id' => ['required', 'exists:games,id']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}

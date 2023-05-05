<?php

namespace App\Containers\AppSection\User\UI\WEB\Requests;

use App\Ship\Parents\Requests\Request;

/**
 * @description Only users with permission user-full-other-read can receive the list of all users
 */
class UserWebIndexRequest extends Request
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
        return $this->user()->hasPermission(
            'user-full-other-read'
        );
    }
}

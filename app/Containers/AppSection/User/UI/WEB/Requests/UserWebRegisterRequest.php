<?php

namespace App\Containers\AppSection\User\UI\WEB\Requests;

use App\Ship\Parents\Requests\Request;

/**
 * @description Everyone can perform this request
 */
class UserWebRegisterRequest extends Request
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
                'max:191',
                'unique:users,login',
            ],
            'password' => [
                'string',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,60}$/'
            ],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}

<?php

namespace App\Containers\AppSection\User\UI\Web\Requests;

use App\Containers\AppSection\User\Enums\UserStatus;
use App\Ship\Parents\Requests\Request;
use Illuminate\Validation\Rule;

/**
 * @description Can be obtained in the following scenarios: \
 *      1. When user is admin
 */
class UserWebStoreRequest extends Request
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
            'login' => 'required|max:40|unique:users,login',
            'password' => 'min:6|max:30',
            'status' => [
                'required',
                Rule::in(collect(UserStatus::cases())->map(fn($status) => $status->value)->toArray()),
            ],
            'roles' => [
                'required',
                'array',
            ],
            'roles.*' => [
                'integer',
                'exists:roles,id',
            ],
            'permissions' => [
                'required',
                'array',
            ],
            'permissions.*' => [
                'integer',
                'exists:permissions,id',
            ],


        ];
    }

    public function authorize(): bool
    {
        return $this->user()->hasRole('admin');
    }
}

<?php

namespace App\Containers\AppSection\User\UI\API\Requests;

use App\Containers\AppSection\User\Enums\UserStatus;
use App\Ship\Parents\Requests\Request;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends Request
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
        if (
            $this->user()->hasPermission('user-full-other-update')
            || (
                $this->user()->hasPermission('user-full-own-update')
                && $this->user()->id == $this->route('user')->id
            )
        ) {
            return true;
        }

        return false;
    }
}

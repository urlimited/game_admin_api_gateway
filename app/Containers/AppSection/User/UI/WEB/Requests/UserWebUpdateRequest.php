<?php

namespace App\Containers\AppSection\User\UI\WEB\Requests;

use App\Containers\AppSection\User\Enums\UserStatus;
use App\Ship\Parents\Requests\Request;
use Illuminate\Validation\Rule;

/**
 * @description Can be obtained in the following scenarios: \
 *      1. When user has user-full-other-update \
 *      2. When user has user-full-own-update and he updates only personal data, \
 *              and doesn't update status, login, permissions or roles
 */
class UserWebUpdateRequest extends Request
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
            'password' => [
                'string',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,100}$/'

            ],
            'status' => [
                Rule::in(collect(UserStatus::cases())->map(fn($status) => $status->value)->toArray()),
                'max:191',
            ],
            'roles' => [
                'array',
            ],
            'roles.*' => [
                'integer',
                'exists:roles,id',
            ],
            'permissions' => [
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
        return $this->user()->hasPermission('user-full-other-update')
            || (
                $this->user()->hasPermission('user-full-own-update')
                && $this->user()->getAttribute('id') == $this->route('user')->getAttribute('id')
                && (
                    empty($this->get('permissions'))
                    && empty($this->get('roles'))
                    && is_null($this->get('status'))
                )
            );
    }
}

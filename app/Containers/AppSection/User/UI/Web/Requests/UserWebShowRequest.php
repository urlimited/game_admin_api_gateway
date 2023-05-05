<?php

namespace App\Containers\AppSection\User\UI\Web\Requests;

use App\Ship\Parents\Requests\Request;

/**
 * @description Can be obtained in the following scenarios: \
 *      1. When user has user-full-other-read
 *      2. When user has user-full-own-read and user id is his own
 */
class UserWebShowRequest extends Request
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
            $this->user()->hasPermission('user-full-other-read')
            || (
                $this->user()->getAttribute('id') == $this->route('user_id')
                && $this->user()->hasPermission('user-full-own-read')
            )
        );
    }
}

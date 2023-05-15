<?php

namespace App\Containers\ConfigurationSection\Layout\UI\WEB\Requests;

use App\Containers\ConfigurationSection\User\Models\User;
use App\Ship\Parents\Requests\Request;

/**
 * @description Can be obtained in the following scenarios: \
 *      1. When a user has permission layout-full-other-create \
 *      2. When a user has permission layout-full-own-create and game belongs to the user
 */
class LayoutWebStoreRequest extends Request
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
            'name' => ['required', 'string','min:3','max:255','regex:/^[^{}*"\',()\[\] \/+%#^&?<>~.№;=!\\\\]+$/'],
            'version' => ['required', 'string', 'regex:/^(\d{1,58}\.\d{1,58}\.\d{1,58})$/', 'max:60'],
            'schema' => ['required', 'array'],
        ];
    }

    public function authorize(): bool
    {
        /** @var User $user */
        $user = $this->user();

        return (
            $user->hasPermission('layout-full-other-create')
            || (
                $user->hasPermission('layout-full-own-create')
                && $user
                    ->games
                    ->map(fn($game) => $game->id)
                    ->contains($this->get('game_id'))
            )
        );
    }
}

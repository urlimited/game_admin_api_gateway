<?php

namespace App\Containers\ConfigurationSection\Setting\UI\WEB\Requests;

use App\Containers\ConfigurationSection\User\Models\User;
use App\Ship\Parents\Requests\Request;

/**
 * @description Can be obtained in the following scenarios: \
 *      1. When a user has permission setting-full-other-update \
 *      2. When a user has permission setting-full-own-update and game belongs to the user
 */
class SettingWebUpdateRequest extends Request
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
            'schema' => ['required', 'array'],
            'name' => ['required','string','min:3','max:255','regex:/^[^{}*"\',\(\)\[\]\s\/+%#\^&\?<>~\.№;=!\\\\]+$/'],
        ];
    }

    public function authorize(): bool
    {
        /** @var User $user */
        $user = $this->user();

        return (
            $user->hasPermission('setting-full-other-update')
            || (
                $user->hasPermission('setting-full-own-update')
                && $user
                    ->games
                    ->map(fn($game) => $game->id)
                    ->contains($this->route('setting')->getAttribute('game_id'))
            )
        );
    }
}

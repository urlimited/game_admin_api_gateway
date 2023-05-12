<?php

namespace App\Containers\ConfigurationSection\Setting\UI\WEB\Requests;

use App\Containers\ConfigurationSection\Setting\UI\Contracts\Requests\SettingShowRequestContract;
use App\Containers\ConfigurationSection\User\Models\User;
use App\Ship\Parents\Requests\GameReceivableRequest;

/**
 * @description Can be obtained in the following scenarios: \
 *      1. When a user has permission setting-full-other-read \
 *      2. When a user has permission setting-full-own-read and game belongs to the user
 */
class SettingWebShowRequest extends GameReceivableRequest implements SettingShowRequestContract
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
        /** @var User $user */
        $user = $this->user();

        return (
            $user->hasPermission('setting-full-other-read')
            || (
                $user->hasPermission('setting-full-own-read')
                && $user
                    ->games
                    ->map(fn($game) => $game->id)
                    ->contains($this->route('setting')->getAttribute('game_id'))
            )
        );
    }
}

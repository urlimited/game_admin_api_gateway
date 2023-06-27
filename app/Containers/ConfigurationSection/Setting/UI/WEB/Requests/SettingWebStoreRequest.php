<?php

namespace App\Containers\ConfigurationSection\Setting\UI\WEB\Requests;

use App\Containers\ConfigurationSection\Game\Models\Game;
use App\Containers\ConfigurationSection\User\Models\User;
use App\Ship\Parents\Requests\Request;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

/**
 * @description Can be obtained in the following scenarios: \
 *      1. When a user has permission setting-full-other-create \
 *      2. When a user has permission setting-full-own-create and game belongs to the user
 */
class SettingWebStoreRequest extends Request
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
            'name' => ['required','string','min:3','max:255','regex:/^[^{}*"\',\(\)\[\]\s\/+%#\^&\?<>~\.№;=!\\\\]+$/'],
            'game_uuid' => ['required', 'string'],
            'layout_uuid' => ['nullable', 'string'],
            'schema' => ['required', 'array'],
        ];
    }

    public function authorize(): bool
    {
        /** @var User $user */
        $user = $this->user();

        return (
            $user->hasPermission('setting-full-other-create')
            || (
                $user->hasPermission('setting-full-own-create')
                && $user
                    ->getAttribute('games')
                    ->map(fn($game) => $game->id)
                    ->contains(
                        Game::query()
                            ->where(
                                'uuid',
                                Uuid::fromString($this->get('game_uuid'))->getBytes()
                            )
                            ->value('id')
                    )
            )
        );
    }
}

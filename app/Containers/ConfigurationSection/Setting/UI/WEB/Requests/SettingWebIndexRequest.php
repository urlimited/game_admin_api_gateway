<?php

namespace App\Containers\ConfigurationSection\Setting\UI\WEB\Requests;

use App\Containers\ConfigurationSection\Game\Models\Game;
use App\Containers\ConfigurationSection\User\Models\User;
use App\Ship\Parents\Requests\Request;
use Ramsey\Uuid\Uuid;

/**
 * @description Can be obtained in the following scenarios: \
 *      1. When a user has permission setting-full-other-read \
 *      2. When a user has permission setting-full-own-read
 */
class SettingWebIndexRequest extends Request
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
            'layout_uuid' => ['string'],
            'game_uuid' => ['required', 'string'],
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
                    ->contains($this->getGameId())
            )
        );
    }

    public function getGameId(){
        return Game::query()
            ->where(
                'uuid',
                Uuid::fromString($this->get('game_uuid'))->getBytes()
            )->value('id');
    }
}

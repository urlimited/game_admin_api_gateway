<?php

namespace App\Containers\AnalyticsSection\StatEvent\UI\WEB\Requests;

use App\Containers\AnalyticsSection\User\Models\User;
use App\Ship\Parents\Requests\Request;

/**
 * @description Can be obtained in the following scenarios: \
 *      1. When a user has permission stat-event-full-own-delete
 *      2. When a user has permission stat-event-full-other-delete and game belongs to the user
 */
class StatEventWebDeleteRequest extends Request
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
            $user->hasPermission('stat-event-full-other-delete')
            || (
                $user->hasPermission('stat-event-full-own-delete')
                && $user
                    ->games
                    ->map(fn($game) => $game->id)
                    ->contains($this->route('statEvent')->getAttribute('game_id'))
            )
        );
    }
}

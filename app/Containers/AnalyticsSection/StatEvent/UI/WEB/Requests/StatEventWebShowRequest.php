<?php

namespace App\Containers\AnalyticsSection\StatEvent\UI\WEB\Requests;

use App\Containers\AnalyticsSection\Game\Models\Game;
use App\Containers\AnalyticsSection\User\Models\User;
use App\Ship\Parents\Requests\Request;
use Ramsey\Uuid\Uuid;

/**
 * @description Can be obtained in the following scenarios: \
 *      1. When a user has permission stat-event-full-other-read \
 *      2. When a user has permission stat-event-full-own-read
 */
class StatEventWebShowRequest extends Request
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
            $user->hasPermission('stat-event-full-other-read')
            || (
                $user->hasPermission('stat-event-full-own-read')
                && $user
                    ->games
                    ->map(fn($game) => $game->id)
                    ->contains($this->route('statEvent')->getAttribute('game_id'))
            )
        );
    }
}

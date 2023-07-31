<?php

namespace App\Containers\AnalyticsSection\TargetGroup\UI\WEB\Requests;

use App\Containers\AnalyticsSection\User\Models\User;
use App\Ship\Parents\Requests\Request;

/**
 * @description Can be obtained in the following scenarios: \
 *      1. When a user has permission target-group-full-other-read \
 *      2. When a user has permission target-group-full-own-read
 */
class TargetGroupWebShowRequest extends Request
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
            $user->hasPermission('target-group-full-other-read')
            || (
                $user->hasPermission('target-group-full-own-read')
                && $user
                    ->getAttribute('games')
                    ->map(fn($game) => $game->id)
                    ->contains($this->route('targetGroup')->getAttribute('game_id'))
            )
        );
    }
}

<?php

namespace App\Containers\AnalyticsSection\StatEvent\UI\API\Requests;

use App\Containers\AnalyticsSection\StatEvent\Models\StatEvent;
use App\Containers\AnalyticsSection\StatEvent\UI\Contracts\Requests\StatEventDataStoreRequestContract;
use App\Ship\Exceptions\AuthenticationException;
use App\Ship\Parents\Requests\PlayerReceivableRequest;
use Illuminate\Auth\Access\AuthorizationException;
use Ramsey\Uuid\Uuid;

class StatEventDataAPIStoreRequest extends PlayerReceivableRequest implements StatEventDataStoreRequestContract
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
            'stat_event_data' => ['required', 'array'],
            'stat_event_data.*.value' => ['required', 'string', 'max:255'],
            'stat_event_data.*.stat_event_uuid' => ['required', 'string'],
        ];
    }

    /**
     * @throws AuthorizationException
     * @throws AuthenticationException
     */
    public function authorize(): bool
    {
        $statEventUuidList = collect($this->get('stat_event_data'))
            ->map(function ($statItem) {
                return Uuid::fromString($statItem['stat_event_uuid'])->getBytes();
            });

        $gameIdByStats = StatEvent::query()
            ->whereIn('uuid', $statEventUuidList)
            ->get('game_id')
            ->pluck('game_id')
            ->unique();

        // If there is stat data from different games
        if ($gameIdByStats->count() > 1) {
            return false;
        }

        // If player's game id doesn't match with stat data game id
        return $this->getGameId() === $gameIdByStats->first();
    }
}

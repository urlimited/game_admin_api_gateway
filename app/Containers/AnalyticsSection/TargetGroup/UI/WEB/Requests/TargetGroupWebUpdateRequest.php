<?php

namespace App\Containers\AnalyticsSection\TargetGroup\UI\WEB\Requests;

use App\Containers\AnalyticsSection\TargetGroup\Enums\ConditionOperator;
use App\Containers\AnalyticsSection\TargetGroup\Enums\ConditionPlayerDataField;
use App\Containers\AnalyticsSection\TargetGroup\Enums\ConditionType;
use App\Containers\AnalyticsSection\User\Models\User;
use App\Ship\Parents\Requests\Request;
use Closure;

/**
 * @description Can be obtained in the following scenarios: \
 *      1. When a user has permission target-group-full-own-update
 *      2. When a user has permission target-group-full-other-update and game belongs to the user
 */
class TargetGroupWebUpdateRequest extends Request
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
            'name' => ['required', 'string', 'min:3', 'max:255', 'regex:/^[^{}*"\',\(\)\[\]\/+%#\^&\?<>~\.№;=!\\\\]+$/m'],
            'conditions' => [
                'required',
                'json',
                function (string $attribute, mixed $value, Closure $fail) {
                    $conditions = json_decode($value, true);

                    foreach ($conditions as $condition) {
                        if (
                            !in_array(
                                $condition['type'],
                                collect(ConditionType::cases())->map(function ($case) {
                                    return $case->value;
                                })->toArray()
                            )
                            || !in_array(
                                $condition['operator'],
                                collect(ConditionOperator::cases())->map(function ($case) {
                                    return $case->value;
                                })->toArray()
                            )
                        ) {
                            $fail("The $attribute is invalid.");
                        }

                        if (
                            $condition['type'] === ConditionType::PlayerData
                            && !in_array(
                                $condition['field'],
                                collect(ConditionPlayerDataField::cases())->map(function ($case) {
                                    return $case->value;
                                })->toArray()
                            )
                        ) {
                            $fail("The $attribute is invalid.");
                        }
                    }
                },
            ],
        ];
    }

    public function authorize(): bool
    {
        /** @var User $user */
        $user = $this->user();

        return (
            $user->hasPermission('target-group-full-other-update')
            || (
                $user->hasPermission('target-group-full-own-update')
                && $user
                    ->getAttribute('games')
                    ->map(fn($game) => $game->id)
                    ->contains($this->getGameId())
            )
        );
    }

    public function getGameId(){
        return $this->route('targetGroup')->getAttribute('game_id');
    }
}

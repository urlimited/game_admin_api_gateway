<?php

namespace App\Containers\ConfigurationSection\Adjustment\UI\WEB\Requests;

use App\Containers\ConfigurationSection\Adjustment\Enums\AdjustmentStatus;
use App\Containers\ConfigurationSection\User\Models\User;
use App\Ship\Parents\Requests\Request;
use Illuminate\Validation\Rule;

/**
 * @description Can be obtained in the following scenarios: \
 *      1. When a user has permission adjustment-full-other-create \
 *      2. When a user has permission adjustment-full-own-create and game belongs to the user
 */
class AdjustmentWebStoreRequest extends Request
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
            'name' => ['required', 'string','min:3','max:255','regex:/^[^{}*"\',\(\)\[\]\s\/+%#\^&\?<>~\.№;=!\\\\]+$/'],
            'priority' => ['required', 'integer', 'min:1', 'max:999'],
            'status' => [
                'required',
                Rule::in(collect(AdjustmentStatus::cases())->map(fn($status) => $status->value)->toArray()),
                'max:191',
            ],
            'setting_uuid' => [
                'required',
                'string',
                Rule::exists()
            ],
            'author_uuid' => ['required', 'string'],
            'schema' => ['required', 'array'],
        ];
    }

    public function authorize(): bool
    {
        /** @var User $user */
        $user = $this->user();

        return (
            $user->hasPermission('adjustment-full-other-create')
            || (
                $user->hasPermission('adjustment-full-own-create')
                && $user
                    ->games
                    ->map(fn($game) => $game->id)
                    ->contains($this->get('game_id'))
            )
        );
    }
}

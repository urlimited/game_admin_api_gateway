<?php

namespace App\Containers\ConfigurationSection\Layout\UI\WEB\Requests;

use App\Containers\ConfigurationSection\User\Models\User;
use App\Ship\Parents\Requests\Request;

/**
 * @description Can be obtained in the following scenarios: \
 *      1. When a user has permission layout-full-other-update \
 *      2. When a user has permission layout-full-own-update and game belongs to the user
 */
class LayoutWebUpdateRequest extends Request
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
            'name' => ['required', 'string','min:3','max:255','regex:/^[^{}*"\',()\[\] \/+%#^&?<>~.№;=!\\\\]+$/'],
            'version' => ['required', 'string', 'regex:/^(\d{1,58}\.\d{1,58}\.\d{1,58})$/', 'max:60'],
            'schema' => ['required', 'array'],
            'schema.*.name' => ['required', 'string'],
            'schema.*.data_type' => ['required', 'string', 'in:string,list,int,float,object,bool'],
            'schema.*.min' => ['numeric', 'nullable'],
            'schema.*.max' => ['numeric', 'nullable'],
            'schema.*.regex' => ['string', 'nullable', 'regex:/^((?:(?:[^?+*{}()[\]\\|]+|\\.|\[(?:\^?\\.|\^[^\\]|[^\\^])(?:[^\]\\]+|\\.)*\]|\((?:\?[:=!]|\?<[=!]|\?>)?(?1)??\)|\(\?(?:R|[+-]?\d+)\))(?:(?:[?+*]|\{\d+(?:,\d*)?\})[?+]?)?|\|)*)$/'],
            'schema.*.list_values' => ['array', 'nullable'],
            'schema.*.list_values.*' => ['string']
        ];
    }

    public function authorize(): bool
    {
        /** @var User $user */
        $user = $this->user();

        return (
            $user->hasPermission('layout-full-other-update')
            || (
                $user->hasPermission('layout-full-own-update')
                && $user
                    ->games
                    ->map(fn($game) => $game->id)
                    ->contains($this->route('layout')->getAttribute('game_id'))
            )
        );
    }
}

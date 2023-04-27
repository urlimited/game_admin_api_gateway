<?php

namespace App\Containers\ConfigurationSection\Structure\UI\API\Requests;

use App\Ship\Parents\Requests\Request;

class StructureStoreRequest extends Request
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
            'name' => ['required', 'string', 'max:255'],
            'version' => ['required', 'string', 'regex:/^(\d{1,58}\.\d{1,58}\.\d{1,58})$/', 'max:60'],
            'fields' => ['required', 'array'],
            'fields.*.path' => ['required', 'string'],
            'fields.*.data_type' => ['required', 'string', 'in:string,int,float,list_values,bool'],
            'fields.*.min' => ['numeric', 'nullable'],
            'fields.*.max' => ['numeric', 'nullable'],
            'fields.*.regex' => ['string', 'nullable', 'regex:/^((?:(?:[^?+*{}()[\]\\|]+|\\.|\[(?:\^?\\.|\^[^\\]|[^\\^])(?:[^\]\\]+|\\.)*\]|\((?:\?[:=!]|\?<[=!]|\?>)?(?1)??\)|\(\?(?:R|[+-]?\d+)\))(?:(?:[?+*]|\{\d+(?:,\d*)?\})[?+]?)?|\|)*)$/'],
            'fields.*.list_values' => ['array', 'nullable'],
            'fields.*.list_values.*' => ['string']
        ];
    }

    public function authorize(): bool
    {
        $game = $this->route('game');

//        return $this->user()->hasRole('admin')
//            || $game->user->id === $this->user()->id;

        return true;
    }
}

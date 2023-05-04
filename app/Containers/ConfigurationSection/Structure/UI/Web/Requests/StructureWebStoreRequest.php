<?php

namespace App\Containers\ConfigurationSection\Structure\UI\Web\Requests;

use App\Ship\Parents\Requests\Request;

class StructureWebStoreRequest extends Request
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
        $game = $this->route('game');

//        return $this->user()->hasRole('admin')
//            || $game->user->id === $this->user()->id;

        return true;
    }
}

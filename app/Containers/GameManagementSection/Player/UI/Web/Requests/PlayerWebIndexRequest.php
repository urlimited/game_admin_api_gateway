<?php

namespace App\Containers\GameManagementSection\Player\UI\Web\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class PlayerWebIndexRequest extends FormRequest
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
        return true;
    }

    public function getGameId()
    {
        return $this->route('game')->getAttribute('id');
    }
}

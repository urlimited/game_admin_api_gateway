<?php

namespace App\Containers\GameManagementSection\Player\UI\Web\Requests;

use App\Containers\GameManagementSection\Player\UI\Contracts\Requests\PlayerUpdateRequestContract;
use Illuminate\Foundation\Http\FormRequest;

final class PlayerWebUpdateRequest extends FormRequest implements PlayerUpdateRequestContract
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

    public function getPlayerId()
    {
        return $this->route('player')->getAttribute('id');
    }
}

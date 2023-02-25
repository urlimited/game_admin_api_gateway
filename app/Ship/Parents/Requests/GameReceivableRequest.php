<?php

namespace App\Ship\Parents\Requests;

use App\Ship\Exceptions\AuthenticationException;
use App\Ship\Parents\Exceptions\Exception;
use App\Ship\Parents\Requests\Contracts\GameReceivableRequestContract;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Laravel\Sanctum\PersonalAccessToken;

abstract class GameReceivableRequest extends FormRequest implements GameReceivableRequestContract
{
    protected ?int $gameId = null;
    protected ?PersonalAccessToken $gameToken = null;

    /**
     * @throws AuthenticationException
     */
    public function getGameId(): int
    {
        try {
            if (is_null($this->gameId)) {
                $this->gameId = $this->getGameToken()->getAttribute('tokenable')->getAttribute('id');
            }

            return $this->gameId;
        } catch (Exception) {
            throw new AuthenticationException('Game token is not correct');
        }
    }

    protected function getGameToken(): PersonalAccessToken
    {
        if (is_null($this->gameToken)) {
            $this->gameToken = PersonalAccessToken
                ::findToken(
                    Str::replace('Bearer ', '', $this->headers->get('X-GameToken'))
                );
        }

        return $this->gameToken;
    }
}

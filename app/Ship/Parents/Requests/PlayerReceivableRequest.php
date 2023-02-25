<?php

namespace App\Ship\Parents\Requests;

use App\Ship\Exceptions\AuthenticationException;
use App\Ship\Parents\Exceptions\Exception;
use App\Ship\Parents\Requests\Contracts\PlayerReceivableRequestContract;
use Illuminate\Support\Str;
use Laravel\Sanctum\PersonalAccessToken;

abstract class PlayerReceivableRequest extends GameReceivableRequest implements PlayerReceivableRequestContract
{
    protected ?int $playerId = null;
    protected ?PersonalAccessToken $playerToken = null;

    /**
     * @throws AuthenticationException
     */
    public function getPlayerId(): int
    {
        try {
            if (is_null($this->playerId)) {
                $this->playerId = $this->getPlayerToken()->getAttribute('tokenable')->getAttribute('id');
            }

            return $this->playerId;
        } catch (Exception) {
            throw new AuthenticationException('Player token is not correct');
        }
    }

    protected function getPlayerToken(): PersonalAccessToken
    {
        if (is_null($this->playerToken)) {
            $this->playerToken = PersonalAccessToken
                ::findToken(
                    Str::replace('Bearer ', '', $this->headers->get('X-PlayerToken'))
                );
        }

        return $this->playerToken;
    }
}

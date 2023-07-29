<?php

namespace App\Ship\Parents\Requests;

use App\Ship\Exceptions\AuthenticationException;
use App\Ship\Parents\Exceptions\Exception;
use App\Ship\Parents\Requests\Contracts\PlayerReceivableRequestContract;
use Illuminate\Auth\Access\AuthorizationException;
use Laravel\Sanctum\PersonalAccessToken;

abstract class PlayerReceivableRequest extends GameReceivableRequest implements PlayerReceivableRequestContract
{
    protected ?int $playerId = null;
    protected ?PersonalAccessToken $playerToken = null;

    /**
     * @throws AuthenticationException
     * @throws AuthorizationException
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

    /**
     * @throws AuthorizationException
     */
    protected function getPlayerToken(): PersonalAccessToken
    {
        if (is_null($this->playerToken)) {
            $this->playerToken = PersonalAccessToken
                ::findToken(
                   $this->headers->get('X-PlayerToken')
                );
        }

        if (is_null($this->playerToken)) {
            throw new AuthorizationException();
        }

        return $this->playerToken;
    }
}

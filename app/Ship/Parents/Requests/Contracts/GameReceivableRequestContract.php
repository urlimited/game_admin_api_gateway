<?php

namespace App\Ship\Parents\Requests\Contracts;

interface GameReceivableRequestContract extends FormRequestContract {
    public function getGameId();
}

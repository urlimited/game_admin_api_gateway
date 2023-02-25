<?php

namespace App\Ship\Parents\Requests\Contracts;

interface PlayerReceivableRequestContract extends GameReceivableRequestContract {
    public function getPlayerId();
}

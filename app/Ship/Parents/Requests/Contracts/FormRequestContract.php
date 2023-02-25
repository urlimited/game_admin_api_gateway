<?php

namespace App\Ship\Parents\Requests\Contracts;

interface FormRequestContract {
    public function get(string $key, $default = null);

    public function has(string $inputKey);
}

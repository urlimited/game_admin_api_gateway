<?php

namespace App\Ship\Support\GameControlSettings\Exceptions;

use Exception;
use Throwable;

abstract class GameControlSettingsException extends Exception
{
    protected int $settingId;

    public function __construct(string $message = "", int $settingId = 0, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->settingId = $settingId;
    }

    public function getSettingId(): int
    {
        return $this->settingId;
    }
}

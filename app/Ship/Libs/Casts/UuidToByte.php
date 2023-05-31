<?php

namespace App\Ship\Libs\Casts;

use App\Ship\Libs\OptimisedUuid\HasBinaryUuid;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Exception\InvalidUuidStringException;
use Ramsey\Uuid\Uuid;

class UuidToByte implements CastsAttributes
{
//    use HasBinaryUuid;
    /**
     * Cast the given value.
     *
     * @param  Model  $model
     * @param string $key
     * @param  mixed  $value
     * @param array $attributes
     * @return string
     */
    public function get($model, string $key, $value, array $attributes)
    {
        return $value;
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  Model  $model
     * @param string $key
     * @param  array  $value
     * @param array $attributes
     * @return array
     */
    public function set($model, string $key, $value, array $attributes): ?string
    {
        try {
            $val = Uuid::fromString((string)$value);

            return $val->getBytes();
        } catch (InvalidUuidStringException) {
            return $value;
        }
    }
}

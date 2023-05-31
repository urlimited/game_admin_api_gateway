<?php

namespace App\Ship\Libs\OptimisedUuid;

use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * @mixin Builder
 */
trait HasBinaryUuid
{
    protected static function bootHasBinaryUuid()
    {
        static::creating(function (Model $model) {
            if ($model->{$model->getUuidKeyName()}) {
                return;
            }

            $model->{$model->getUuidKeyName()} = static::encodeUuid(Uuid::uuid1());
        });
    }

    public static function scopeWithUuid(Builder $builder, $uuid, $field = null): Builder
    {
        if ($field) {
            return static::scopeWithUuidRelation($builder, $uuid, $field);
        }

        if ($uuid instanceof Uuid) {
            $uuid = (string) $uuid;
        }

        $uuid = (array) $uuid;

        return $builder->whereKey(array_map(function (string $modelUuid) {
            return static::encodeUuid($modelUuid);
        }, $uuid));
    }

    public static function scopeWithUuidRelation(Builder $builder, $uuid, string $field): Builder
    {
        if ($uuid instanceof Uuid) {
            $uuid = (string) $uuid;
        }

        $uuid = (array) $uuid;

        return $builder->whereIn($field, array_map(function (string $modelUuid) {
            return static::encodeUuid($modelUuid);
        }, $uuid));
    }

    public static function encodeUuid($uuid): string
    {
        if (! Uuid::isValid($uuid)) {
            return $uuid;
        }

        if (! $uuid instanceof Uuid) {
            $uuid = Uuid::fromString($uuid);
        }

        return $uuid->getBytes();
    }

    public static function decodeUuid(string $binaryUuid): string
    {
        if (Uuid::isValid($binaryUuid)) {
            return $binaryUuid;
        }

        return Uuid::fromBytes($binaryUuid)->toString();
    }

    public function toArray()
    {
        $uuidAttributes = $this->getUuidAttributes();

        $array = parent::toArray();

        if (! $this->exists || ! is_array($uuidAttributes)) {
            return $array;
        }

        foreach ($uuidAttributes as $attributeKey) {
            if (! array_key_exists($attributeKey, $array)) {
                continue;
            }
            $uuidKey = $this->getRelatedBinaryKeyName($attributeKey);
            $array[$attributeKey] = $this->{$uuidKey};
        }

        return $array;
    }

    public function getRelatedBinaryKeyName($attribute)
    {
        $suffix = $this->getUuidSuffix();

        return preg_match('/(?:uu)?id/i', $attribute) ? "{$attribute}{$suffix}" : $attribute;
    }

    public function getAttribute($key)
    {
        $uuidKey = $this->uuidTextAttribute($key);

        if ($uuidKey && $this->{$uuidKey} !== null) {
            return static::decodeUuid($this->{$uuidKey});
        }

        return parent::getAttribute($key);
    }

    public function setAttribute($key, $value)
    {
        if ($this->uuidTextAttribute($key)) {
            $value = static::encodeUuid($value);
        }

        return parent::setAttribute($key, $value);
    }

    protected function getUuidSuffix()
    {
        return (property_exists($this, 'uuidSuffix')) ? $this->uuidSuffix : '_text';
    }

    protected function uuidTextAttribute($key)
    {
        $uuidAttributes = $this->getUuidAttributes();
        $suffix = $this->getUuidSuffix();
        $offset = -(strlen($suffix));

        if (substr($key, $offset) == $suffix && in_array(($uuidKey = substr($key, 0, $offset)), $uuidAttributes)) {
            return $uuidKey;
        }

        return false;
    }

    public function getUuidAttributes()
    {
        $uuidAttributes = [];

        if (property_exists($this, 'uuids') && is_array($this->uuids)) {
            $uuidAttributes = array_merge($uuidAttributes, $this->uuids);
        }

        // non-composite primary keys will return a string so casting required
        $key = (array) $this->getUuidKeyName();

        $uuidAttributes = array_unique(array_merge($uuidAttributes, $key));

        return $uuidAttributes;
    }

    public function getUuidTextAttribute(): ?string
    {
        $key = $this->getUuidKeyName();

        if (! $this->exists || is_array($key)) {
            return null;
        }

        return static::decodeUuid($this->{$key});
    }

    public function setUuidTextAttribute(string $uuid)
    {
        $key = $this->getUuidKeyName();

        if (is_array($key)) {
            return;
        }

        $this->{$key} = static::encodeUuid($uuid);
    }

    public function getQueueableId()
    {
        return base64_encode($this->{$this->getUuidKeyName()});
    }

    public function newQueryForRestoration($id)
    {
        return $this->newQueryWithoutScopes()->whereKey(base64_decode($id));
    }

    public function getRouteKeyName()
    {
        $suffix = $this->getUuidSuffix();

        return "uuid{$suffix}";
    }

    public function getUuidKeyName()
    {
        return 'uuid';
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->withUuid($value, 'uuid')->first();
    }
}

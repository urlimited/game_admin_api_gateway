<?php

namespace App\Ship\Support\GameControlSettings\Settings;

use App\Ship\Parents\Exceptions\Exception;
use App\Ship\Support\GameControlSettings\Exceptions\InvalidDataProvidedException;
use CodeBaseTeam\DataStructures\Tree\Exceptions\InvalidDataException;
use CodeBaseTeam\DataStructures\Tree\TreeBuilder;

/**
 * @description The class responses for technical validation issues
 */
final class SettingSchemaValidator
{
    public const TECH_FIELDS = "meta";
    public const VISIBLE_FIELDS = "content";


    /**
     * @throws InvalidDataException
     * @throws InvalidDataProvidedException
     */
    public static function process(array $arraySettingSchema): array
    {
        TreeBuilder::setChildrenFieldKey(null);
        TreeBuilder::setMetaFieldKeys(['meta']);
        TreeBuilder::setValueContentFieldKey('content');

        try {
            TreeBuilder::fromArray(['content' => $arraySettingSchema]);
        } catch (Exception) {
            throw new InvalidDataProvidedException();
        }

        return $arraySettingSchema;
    }
}

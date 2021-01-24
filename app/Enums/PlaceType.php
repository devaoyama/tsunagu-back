<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Restaurant()
 * @method static static Online()
 * @method static static Hall()
 */
final class PlaceType extends Enum
{
    const Restaurant = 0;
    const Online = 1;
    const Hall = 2;

    public static function getDescription($value): string
    {
        switch ($value) {
            case self::Restaurant:
                return 'お店';
            case self::Online:
                return 'オンライン';
            case self::Hall:
                return 'ホール';
            default:
                return '';
        }
    }
}

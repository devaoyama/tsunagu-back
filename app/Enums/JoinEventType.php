<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Waiting()
 * @method static static Accepted()
 * @method static static Rejected()
 */
final class JoinEventType extends Enum
{
    const Waiting =   0;
    const Accepted =   1;
    const Rejected = 2;

    public static function getDescription($value): string
    {
        switch ($value) {
            case self::Waiting:
                return '確認中';
            case self::Accepted:
                return '参加する';
            case self::Rejected:
                return '参加できない';
            default:
                return '';
        }
    }
}

<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class JoinStatusType extends Enum
{
    /** @var int 承認待ち */
    const Waiting = 0;

    /** @var int 承認 */
    const Accepted = 1;

    /** @var int 拒否 */
    const Rejected = 2;

    public static function getDescription($value): string
    {
        switch ($value) {
            case self::Waiting:
                return '承認待ち';
            case self::Accepted:
                return '承認';
            case self::Rejected:
                return '拒否';
            default:
                return '';
        }
    }
}

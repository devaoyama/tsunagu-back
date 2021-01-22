<?php

namespace App\Services\Group;

use Illuminate\Support\Str;

class InvitationCodeGenerator implements InvitationCodeGeneratorInterface
{
    /**
     * 6文字のランダム文字列生成.
     * @return string
     */
    public function generate(): string
    {
        return Str::random(6);
    }
}

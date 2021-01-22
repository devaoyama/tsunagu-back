<?php

namespace App\Services\Group;

interface InvitationCodeGeneratorInterface
{
    public function generate(): string;
}

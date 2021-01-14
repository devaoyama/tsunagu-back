<?php

namespace App\Services\Auth;

use App\User;

interface VerificationServiceInterface
{
    public function verify(string $token): ?User;
}

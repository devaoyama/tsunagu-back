<?php

namespace App\Services\Auth;

use App\User;
use Kreait\Laravel\Firebase\Facades\Firebase;

class FirebaseVerificationService implements VerificationServiceInterface
{
    public function verify(string $token): ?User
    {
        try {
            $verifiedToken = Firebase::auth()->verifyIdToken($token);
            $uid = $verifiedToken->claims()->get('sub');
            return User::firstWhere('uid', $uid);
        } catch (\Exception $exception) {
            return null;
        }
    }
}

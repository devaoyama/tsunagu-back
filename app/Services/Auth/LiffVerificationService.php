<?php

namespace App\Services\Auth;

use App\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class LiffVerificationService implements VerificationServiceInterface
{
    public function verify(string $token): ?User
    {
        $client = new Client();
        try {
            $response = $client->request('POST', 'https://api.line.me/oauth2/v2.1/verify', [
                'form_params' => [
                    'id_token' => $token,
                    'client_id' => config('app.liff_channel_id'),
                ]
            ]);
            $lineInfo = json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $exception) {
            abort(response()->json(['error' => 'unauthorized'], 401));
        }

        return User::updateOrCreate(
            [
                'uid' => $lineInfo['sub'],
            ],
            [
                'name' => $lineInfo['name'],
                'picture_url' => $lineInfo['picture']
            ]
        );
    }
}

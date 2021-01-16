<?php

namespace App\Http\Controllers;

use App\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Kreait\Laravel\Firebase\Facades\Firebase;

class AuthController extends Controller
{
    public function auth(Request $request)
    {
        $idToken = $request->id_token;
        $client = new Client();
        try {
            $response = $client->request('POST', 'https://api.line.me/oauth2/v2.1/verify', [
                'form_params' => [
                    'id_token' => $idToken,
                    'client_id' => '1655537420'
                ]
            ]);
            $lineInfo = json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $exception) {
            abort(response()->json(['error' => 'Unauthorized'], 401));
        }

        User::updateOrCreate(
            [
                'uid' => $lineInfo['sub'],
            ],
            [
                'name' => $lineInfo['name'],
                'picture_url' => $lineInfo['picture']
            ]
        );

        return Firebase::auth()->createCustomToken($lineInfo['sub'])->toString();
    }
}

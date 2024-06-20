<?php

namespace App\Controllers;

use Google\Client;
use CodeIgniter\Controller;

class OAuthController extends Controller
{
    public function authorize()
    {
        $client = new Client();
        $client->setAuthConfig(WRITEPATH . 'token.json');
        $client->addScope('https://www.googleapis.com/auth/drive');
        $client->setRedirectUri(base_url('callback'));

        // Generate a URL to request access from Google's OAuth 2.0 server:
        $authUrl = $client->createAuthUrl();

        // Redirect the user to the Google authorization URL:
        return redirect()->to($authUrl);
    }

    public function oauth2callback()
    {
        // Pastikan Anda memuat helper URL
        helper('url');

        $client = new Client();
        $client->setAuthConfig(WRITEPATH . 'token.json');
        $client->setRedirectUri(base_url('oauth2callback'));

        // Mengambil parameter 'code' dari query string
        $request = \Config\Services::request();
        $code = $request->getGet('code');

        if ($code) {
            $token = $client->fetchAccessTokenWithAuthCode($code);
            $client->setAccessToken($token);

            // Save the token to a file or database for future use
            file_put_contents(WRITEPATH . 'token.json', json_encode($token));

            return 'Token has been saved.';
        } else {
            return 'Authorization code not found.';
        }
    }
}

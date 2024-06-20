<?php

require 'vendor/autoload.php';

use League\OAuth2\Client\Provider\Google;

$provider = new Google([
    'clientId'     => '51113200853-iqs1le6npscek6ip04sshjo20d7v88cu.apps.googleusercontent.com',
    'clientSecret' => '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',
    'redirectUri'  => 'http://localhost/tppk/callback',
]);

if (!isset($_GET['code'])) {
    // Jika belum ada kode, minta otorisasi dari pengguna
    $authUrl = $provider->getAuthorizationUrl();
    $_SESSION['oauth2state'] = $provider->getState();
    header('Location: ' . $authUrl);
    exit;
} elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {
    // Jika state tidak cocok, berhenti
    unset($_SESSION['oauth2state']);
    exit('Invalid state');
} else {
    // Dapatkan token akses
    $token = $provider->getAccessToken('authorization_code', [
        'code' => $_GET['code']
    ]);

    // Simpan refresh token
    echo 'Refresh Token: ' . $token->getRefreshToken();
}

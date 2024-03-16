<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use Firebase\JWT\JWT;

class Auth extends BaseController
{
    public function login()
    {
        $csrfName = $this->csrf->getTokenName();
        $csrfValue = $this->csrf->getTokenHash();

        $request = \Config\Services::request();
        $username = $request->getPost('username');
        $password = $request->getPost('password');

        if ($username === 'user@TPPK_4p1' && $password === 'p4ss_key@4p1tppk') {
            $key = 'api_key_khusus_untuk_TPPK'; // Ganti dengan kunci rahasia yang kuat
            $payload = ['username' => $username];
            $alg = 'HS256';
            $token = JWT::encode($payload, $key, $alg);
            return $this->response
                ->setStatusCode(200)
                ->setJSON(['token_csrf' => ['name' => $csrfName, 'hash' => $csrfValue], 'message' => 'Login berhasil']);
        } else {
            echo "AS63t5472";
            die();
            return $this->response
                ->setStatusCode(401)
                ->setJSON(['message' => 'Invalid credentials']);
        }
    }
}

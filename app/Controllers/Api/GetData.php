<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use Firebase\JWT\JWT;

class GetData extends BaseController
{
    public function getPropinsi()
    {
        $request = \Config\Services::request();
        $token = $request->getServer('HTTP_AUTHORIZATION');

        if (empty($token)) {
            return $this->response
                ->setStatusCode(401)
                ->setJSON(['message' => 'Invalid credentials']);
        }

        $key = 'api_key_khusus_untuk_TPPK';
        try {
            $decoded = JWT::decode($token, $key);
        } catch (\Exception $e) {
            return $this->response
                ->setStatusCode(401)
                ->setJSON(['message' => 'Unauthorized']);
        }

        $propinsiData = [
            ['id' => 1, 'name' => 'Propinsi A'],
            ['id' => 2, 'name' => 'Propinsi B'],
        ];

        return $this->response->setStatusCode(200)->setJSON($propinsiData);
    }
}

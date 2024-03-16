<?php

namespace App\Filters;

use CodeIgniter\HTTP\Response;
use CodeIgniter\Filters\FilterInterface;
use Firebase\JWT\JWT;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

class AuthFilter implements FilterInterface
{

    public function before(\CodeIgniter\HTTP\RequestInterface $request, $arguments = null)
    {
        $request = \Config\Services::request();
        $response = Services::response();
        $token = $request->getServer('HTTP_AUTHORIZATION');

        if (empty($token)) {
            return Services::response()->setStatusCode(401)->setJSON(['message' => 'Unauthorized']);
        }

        if (empty($token)) {
            $response->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
            $response->setJSON(['message' => 'Unauthorized']);
        }

        $key = 'api_key_khusus_untuk_TPPK';
        try {
            $decoded = JWT::decode($token, $key);
        } catch (\Exception $e) {
            $response->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
            $response->setJSON(['message' => 'Unauthorized']);
        }

        return $request;
    }

    public function after(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, $arguments = null)
    {
        // Do nothing here
    }
}

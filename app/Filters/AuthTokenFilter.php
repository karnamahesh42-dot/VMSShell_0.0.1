<?php
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthTokenFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $authHeader = null;

        // 1. Standard header
        $authHeader = $request->getHeaderLine('Authorization');

        // 2. Check server variable (works in Apache/XAMPP)
        if (!$authHeader && isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $authHeader = $_SERVER['HTTP_AUTHORIZATION'];
        }

        // 3. Check apache_request_headers fallback
        if (!$authHeader && function_exists('apache_request_headers')) {
            $headers = apache_request_headers();
            if (isset($headers['Authorization'])) {
                $authHeader = $headers['Authorization'];
            }
        }

        if (!$authHeader) {
            return service('response')->setJSON([
                'status' => false,
                'message' => 'Token missing'
            ])->setStatusCode(401);
        }

        // Extract token (ignore case and spaces)
        $token = trim(str_ireplace('Bearer', '', $authHeader));

        $validToken = env('api.token');

        if ($token !== $validToken) {
            return service('response')->setJSON([
                'status' => false,
                'message' => 'Invalid token'
            ])->setStatusCode(401);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // nothing
    }
}

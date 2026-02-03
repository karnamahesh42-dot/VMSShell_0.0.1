<?php
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class IpWhitelist implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $allowedIPs = ['192.168.1.10', '192.168.1.20'];

        if (!in_array($request->getIPAddress(), $allowedIPs)) {
            return service('response')
                ->setJSON([
                    'status' => false,
                    'message' => 'Access denied',
                    'ip' => $request->getIPAddress()
                ])
                ->setStatusCode(403);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // nothing
    }
}

















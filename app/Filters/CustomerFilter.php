<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

class CustomerFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = NULL)
    {
        $session = Services::session();
        //     echo "test";
        //    die;
        if ($session->has('logged_in')) {
            if ($request->uri->getPath() == '/login') {
                return redirect()->to(base_url('customer'));
            }
        } else {
            if ($request->uri->getPath() != '/login') {
                return redirect()->to(base_url('login'));
            }
        }
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = NULL)
    {
        // Do something here
    }
}

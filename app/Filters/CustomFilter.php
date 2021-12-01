<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

require_once(FCPATH . "SCRIPT/apl_core_configuration.php");
require_once(FCPATH . "SCRIPT/apl_core_functions.php");
class CustomFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = NULL)
    {
        if(!file_exists(FCPATH."public/setup.txt")) {
            $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]/install";
            return redirect()->to($url);
        }

        // $checklicense = aplVerifyLicense();
        // if ($checklicense['notification_case']!="notification_license_ok")
        // {
        //     echo "License verification failed because of this reason: ".$checklicense['notification_text'];
        // exit();
        // }
        
            
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = NULL)
    {
        // Do something here
    }
}

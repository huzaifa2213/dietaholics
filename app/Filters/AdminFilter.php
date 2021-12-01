<?php namespace App\Filters;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = NULL)
   {
      $session = Services::session();
       if ($session->has('logged_in') && $session->get('admin_id')!="")
       { 
           if ($request->uri->getPath() == 'admin/login')
           {
               return redirect()->to(base_url('admin/dashboard'));
           }
           
       } 
       else
       {
           if ($request->uri->getPath() != 'admin/login' && $request->uri->getPath() != 'admin/forgot-password')
           {
               return redirect()->to(base_url('admin/login'));
           }
       }
   }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = NULL)
    {
        // Do something here
    }
}
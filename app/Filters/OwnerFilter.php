<?php namespace App\Filters;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
class OwnerFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = NULL)
   {
      $session = Services::session();
       if ($session->has('logged_in') && $session->get('owner_id')!="")
       { 
           if ($request->uri->getPath() == 'owner/login')
           {
               return redirect()->to(base_url('owner/dashboard'));
           }
           
       } 
       else
       {
           if ($request->uri->getPath() != 'owner/login' && $request->uri->getPath() != 'owner/forgot-password')
           {
               return redirect()->to(base_url('owner/login'));
           }
       }
   }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = NULL)
    {
        // Do something here
    }
}
<?php
namespace App\Controllers\Owner;
use App\Controllers\OwnerBaseController;
class Login extends OwnerBaseController {

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		parent::initController($request, $response, $logger);
	}
	public function index() {
		$data['error']= "";
		if($_POST && !empty($_POST)) {
			
				$username = $this->request->getVar("useremail");
				$password = $this->request->getVar("password");
				$admin_find= $this->ownerModel->where(array('email'=>urlencode($username), 'password'=>md5($password)))->first();
				if(!empty($admin_find)) {
					$newdata = [
						'owner_id'  => $admin_find['id'],
						'logged_in' => TRUE
					];
	
					$this->session->set($newdata);
					$this->session->setFlashdata('success', lang('Owner.logged_in_successfully'));
					return redirect()->to(base_url('owner/dashboard'));
				}
				else {
					$data['error']= lang('Owner.invalid_id_password');
					
				}
			}

		
			$data['settings'] = $this->settings;
			echo view('owner/login/login', $data);
	}
	public function forgot_password() {
		$data['success']='';
		$data['error']='';
		if(!empty($_POST)) {
			
				$username = $this->request->getVar("email");
				$admin_find= $this->ownerModel->where(array('email'=>urlencode($this->request->getVar('email'))))->first();
				if(!empty($admin_find)) {
					$password= substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz!@#$%^&*'), 0, 8);
					$data_array= array('password'=>md5($password));
				
					$this->ownerModel->update($admin_find['id'] ,$data_array);
					if($this->sendMailToAdmin($admin_find['id'], $password, $username)) {
						$data['success']= lang('Owner.password_sent_to_email');
					}else {
						$data['error']= lang('Owner.error_try_again');
					}
					
				}
				else {
					$data['error']= lang('Owner.invalid_email_id');
					
				}
			}
			
		$data['settings'] = $this->settings;
		echo view('owner/login/forgot_pass', $data);
		
	}

}
?>
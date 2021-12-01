<?php

namespace App\Controllers\Driver;

use App\Controllers\AdminBaseController;
// use App\Models\DriverCompanyModel;

class Login extends AdminBaseController
{

	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		parent::initController($request, $response, $logger);
		// $this->DriverCompanyModel = new DriverCompanyModel();
		
	}




	public function index()
	{
		// print_r($_POST);exit;
		if (isset($_POST) && !empty($_POST)) {
			$username = $this->request->getVar("useremail");
			$password = $this->request->getVar("password");

			// print_r($password);exit;

			$admin_find = $this->DriverCompanyModel->where(array('company_email_id' => urlencode($username), 'password' => md5($password)))->first();

			
			print_r($admin_find);exit;

			if (!empty($admin_find)) {
				$newdata = [
					'admin_id'  => $admin_find['id'],
					'logged_in' => TRUE
				];

				$this->session->set($newdata);
				$this->session->setFlashdata('success', lang('Admin.logged_in_successfully'));
				return redirect()->to(base_url('driver/dashboard'));
			} else {
				$data['error'] = lang('Admin.invalid_id_password');
			}
		}
		$data['settings'] = $this->settings;
		echo view('driver/login/login', $data);
	}

	public function forgot_password()
	{
		if (isset($_POST) && !empty($_POST)) {

			$username = $this->request->getVar("email");
			$admin_find = $this->adminModel->where(array('email' => urlencode($username)))->first();
			if (!empty($admin_find)) {
				$password = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz!@#$%^&*'), 0, 8);
				$data_array = array('password' => md5($password));

				$this->adminModel->update($admin_find['id'], $data_array);
				if ($this->sendMailToAdmin($admin_find['id'], $password, $username)) {
					$data['success'] = lang('Admin.password_sent_to_email');
				} else {
					$data['error'] = lang('Admin.error_try_again');
				}
			} else {
				$data['error'] = lang('Admin.invalid_email_id');
			}
		}
		$data['settings'] = $this->settings;
		echo view('admin/login/forgot_pass', $data);
	}
}

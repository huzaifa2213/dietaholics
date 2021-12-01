<?php

namespace App\Controllers\Admin;

use App\Controllers\AdminBaseController;

class Login extends AdminBaseController
{

	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		parent::initController($request, $response, $logger);
	}
	public function index()
	{
		if (isset($_POST) && !empty($_POST)) {
			$username = $this->request->getVar("useremail");
			$password = $this->request->getVar("password");
			$admin_find = $this->adminModel->where(array('email' => urlencode($username), 'password' => md5($password)))->first();
			if (!empty($admin_find)) {
				$newdata = [
					'admin_id'  => $admin_find['id'],
					'logged_in' => TRUE
				];

				$this->session->set($newdata);
				$this->session->setFlashdata('success', lang('Admin.logged_in_successfully'));
				return redirect()->to(base_url('admin/dashboard'));
			} else {
				$data['error'] = lang('Admin.invalid_id_password');
			}
		}
		$data['settings'] = $this->settings;
		echo view('admin/login/login', $data);
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

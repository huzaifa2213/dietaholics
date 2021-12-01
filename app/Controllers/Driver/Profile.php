<?php

namespace App\Controllers\Admin;

use App\Controllers\AdminBaseController;

class Profile extends AdminBaseController
{

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }
    public function index()
    {
        $data['results'] = $this->adminModel->where('id', $this->session->admin_id)->first();

        if ($_POST && !empty($_POST)) {
            if(ENVIRONMENT=='demo') {
                $this->session->setFlashdata('error', lang('Admin.this_operation_not_permited_in_demo_mode'));
                return redirect()->to(base_url('admin/profile'));
            }
            $data_array['first_name'] = urlencode($this->request->getVar('first_name'));
            $data_array['last_name'] = urlencode($this->request->getVar('last_name'));
            $data_array['email'] = urlencode($this->request->getVar('email'));
            $data_array['phone'] = $this->request->getVar('phone');

            if (!empty($_FILES['image']['name'])) {

                $img = $this->request->getFile('image');
                $newName = $img->getRandomName();
                $img->move(FCPATH . 'public/uploads/profile', $newName);

                $data_array['image'] = $img->getName();
                $this->unlinkFile($data['results']['image'], 'profile');
            }

            if ($this->adminModel->update($this->session->admin_id, $data_array)) {
                $this->session->setFlashdata('success', lang('Admin.profile_updated_successfully'));
                return redirect()->to(base_url('admin/profile'));
            } else {
                $this->session->setFlashdata('error', lang('Admin.error_try_again'));
            }
        }
        return $this->view_page('profile/change_profile', $data);
    }



    public function change_password()
    {
        $data['results'] =  $this->adminModel->where('id', $this->session->admin_id)->first();
        if (empty($data['results'])) {
            $this->session->setFlashdata('error', lang('Admin.data_not_found'));
            return redirect()->to(base_url('admin/dashboard'));
        }

        if ($_POST && !empty($_POST)) {

            if(ENVIRONMENT=='demo') {
                $this->session->setFlashdata('error', lang('Admin.this_operation_not_permited_in_demo_mode'));
                return redirect()->to(base_url('admin/profile'));
            }
            $old_password = $this->request->getVar('old_password');
            $new_password = $this->request->getVar('new_password');
            $confirm_password = $this->request->getVar('confirm_password');

            $check_password = $this->adminModel->where(array('password' => md5($old_password)));
            if (!empty($check_password)) {
                if ($new_password == $confirm_password) {
                    $data_array['password'] = md5($this->request->getVar('new_password'));
                    if ($this->adminModel->update($this->session->admin_id, $data_array)) {
                        $this->session->setFlashdata('success', lang('Admin.password_updated_successfully'));
                        return redirect()->to(base_url('admin/change-password'));
                    } else {
                        $this->session->setFlashdata('error', lang('Admin.error_try_again'));
                    }
                } else {
                    $this->session->setFlashdata('error', lang('Admin.confirm_password_same_as_new_password'));
                }
            } else {
                $this->session->setFlashdata('error', lang('Admin.old_password_invalid'));
            }
        }

        return $this->view_page('profile/change_password', $data);
    }


    public function change_language ($lang, $lang_short) {

        $data= array('lang'=>$lang_short,'lang_short'=>$lang_short);
        $this->session->set($data);
        return redirect()->back();
        

    }
    public function logout()
    {
        $this->session->destroy();
        return redirect()->to(base_url('admin/login'));
    }
}

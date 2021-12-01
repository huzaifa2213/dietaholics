<?php

namespace App\Controllers\Owner;

use App\Controllers\OwnerBaseController;

class Profile extends OwnerBaseController
{

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }
    public function index()
    {
        $data['results'] = $this->ownerModel->where('id', $this->session->owner_id)->first();
        if ($_POST && !empty($_POST)) {

            if (ENVIRONMENT == 'demo') {
                $this->session->setFlashdata('error', lang('Owner.this_operation_not_permited_in_demo_mode'));
                return redirect()->to(base_url('owner/profile'));
            }
            $data_array['first_name'] = urlencode($this->request->getVar('first_name'));
            $data_array['last_name'] = urlencode($this->request->getVar('last_name'));
            $data_array['email'] = urlencode($this->request->getVar('email'));
            $data_array['phone'] = $this->request->getVar('phone');
            if (!empty($_FILES['image']['name'])) {

                $img = $this->request->getFile('image');
                $newName = $img->getRandomName();
                $img->move(FCPATH . 'public/uploads/owners', $newName);

                $data_array['image'] = $img->getName();
                $this->unlinkFile($data['results']['image'], 'owners');
            }

            if ($this->ownerModel->update($this->session->owner_id, $data_array)) {
                $this->session->setFlashdata('success', lang('Owner.profile_updated_successfully'));
                return redirect()->to(base_url('owner/profile'));
            } else {
                $this->session->setFlashdata('error', lang('Owner.error_try_again'));
            }
        }
        return $this->view_page('profile/change_profile', $data);
    }



    public function change_password()
    {
        $data['results'] =  $this->ownerModel->where('id', $this->session->owner_id)->first();
        if (empty($data['results'])) {
            $this->session->setFlashdata('error', lang('Owner.data_not_found'));
            return redirect()->to(base_url('owner/dashboard'));
        }
        if ($_POST && !empty($_POST)) {
            if (ENVIRONMENT == 'demo') {
                $this->session->setFlashdata('error', lang('Owner.this_operation_not_permited_in_demo_mode'));
                return redirect()->to(base_url('owner/profile'));
            }
            $old_password = $this->request->getVar('old_password');
            $new_password = $this->request->getVar('new_password');
            $confirm_password = $this->request->getVar('confirm_password');

            $check_password = $this->ownerModel->select('id')->where(array('password' => md5($old_password)))->first();
            if (!empty($check_password)) {
                if ($new_password == $confirm_password) {
                    $data_array['password'] = md5($this->request->getVar('new_password'));
                    if ($this->ownerModel->update($this->session->owner_id, $data_array)) {
                        $this->session->setFlashdata('success', lang('Owner.password_updated_successfully'));
                        return redirect()->to(base_url('owner/profile') . '/change_password');
                    } else {
                        $this->session->setFlashdata('error', lang('Owner.error_try_again'));
                    }
                } else {
                    $this->session->setFlashdata('error', lang('Owner.confirm_password_same_as_new_password'));
                }
            } else {
                $this->session->setFlashdata('error', lang('Owner.old_password_invalid'));
            }
        }




        return $this->view_page('profile/change_password', $data);
    }

    public function change_language($lang, $lang_short)
    {

        $data = array('lang' => $lang_short, 'lang_short' => $lang_short);
        $this->session->set($data);
        return redirect()->back();
    }
    public function logout()
    {
        $this->session->destroy();
        return redirect()->to(base_url('owner/login'));
    }
}

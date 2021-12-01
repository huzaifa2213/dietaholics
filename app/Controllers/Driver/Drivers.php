<?php

namespace App\Controllers\Admin;

use App\Controllers\AdminBaseController;

class Drivers extends AdminBaseController
{

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }
    public function index()
    {
        
        $data['results'] = $this->userModel->select('o.*, s.name as state_name, ct.name as city_name, c.name as country_name')->from(TBL_USERS . ' as o')->join(TBL_STATE . ' as s', "s.id=o.state_id")->join(TBL_CITY . ' as ct', "ct.id=o.city_id")->join(TBL_COUNTRY . " as c", "c.id=o.country_id")->where(array('o.status!=' => 9, 'o.user_type' => 2))->groupBy('o.id')->orderBy('o.id', 'desc')->find();

        $this->view_page('drivers/index', $data);
    }

    public function delete()
    {

        if(ENVIRONMENT!='demo') {
            $id= $this->request->getVar('id');
            $this->userModel->update($id, ['status' => 9]);
            if($this->userModel->delete(array('id' => $id))){
                $data['success'] =1;
                $data['message'] = lang('Admin.data_deleted_successfully');
            }else {
                $data['message'] = lang('Admin.error_try_again');
            }
        } else {
            $data['message'] = lang('Admin.this_operation_not_permited_in_demo_mode');
        }
        echo json_encode($data); 
    }

    public function multiple_delete()
    {
        if(ENVIRONMENT!='demo') {
            $ids= $this->request->getVar('id');
            foreach($ids as $id){
                $this->userModel->update($id, ['status' => 9]);
                $this->userModel->delete(array('id' => $id));
            }
            $data['success'] =1;
            $data['message'] = lang('Admin.data_deleted_successfully');
            
        }else {
            $data['message'] = lang('Admin.this_operation_not_permited_in_demo_mode');
        }
        echo json_encode($data);
    }

    public function add()
    {
        $postData = $this->request->getVar();
        if ($postData && !empty($postData)) {

            $data_array['fullname'] = urlencode($this->request->getVar('fullname'));
            $data_array['phone'] = $this->request->getVar('phone_number');
            $data_array['email'] = urlencode($this->request->getVar('email_id'));
            $data_array['city_id'] = $this->request->getVar('city_id');
            $data_array['state_id'] = $this->request->getVar('state_id');
            $data_array['country_id'] = $this->request->getVar('country_id');
            $data_array['pincode'] = $this->request->getVar('pincode');
            $data_array['password'] = md5($this->request->getVar('password'));
            $data_array['address'] = urlencode($this->request->getVar('address'));

            $data_array['identity_number'] = $this->request->getVar('identity_number');
            $data_array['license_number'] = $this->request->getVar('license_number');
            $data_array['gender'] = $this->request->getVar('gender');
            $data_array['date_of_birth'] = date('Y-m-d', strtotime($this->request->getVar('date_of_birth')));

            if (!empty($_FILES['identity_image']['name'])) {

                $img = $this->request->getFile('identity_image');
                $newName = $img->getRandomName();
                $img->move(FCPATH . 'public/uploads/user', $newName);

                $data_array['identity_image'] = $img->getName();
            }


            if (!empty($_FILES['license_image']['name'])) {

                $img = $this->request->getFile('license_image');
                $newName = $img->getRandomName();
                $img->move(FCPATH . 'public/uploads/user', $newName);

                $data_array['license_image'] = $img->getName();
            }



            $data_array['user_type'] = 2;
            $insert = $this->userModel->insert($data_array);
            if ($insert) {
                $this->session->setFlashdata('success', lang('Admin.driver_added_successfully'));
                return redirect()->to(base_url('admin/drivers'));
            } else {
                $this->session->setFlashdata('error', lang('Admin.error_try_again'));
            }
        }

        $data['country'] = $this->countryModel->select('id, name')->where(array('status' => 1))->find();
        $this->view_page('drivers/add', $data);
    }

    public function edit($id)
    {
        $data['results'] = $this->userModel->where(array('id' => $id))->first();
        if (!$id || empty($data['results'])) {
            $this->session->setFlashdata('error', lang('Admin.data_not_found'));
            return redirect()->to(base_url('admin/drivers'));
        }
        if ($_POST && !empty($_POST)) {

            $data_array['fullname'] = urlencode($this->request->getVar('fullname'));
            $data_array['phone'] = $this->request->getVar('phone_number');
            $data_array['email'] = urlencode($this->request->getVar('email_id'));
            $data_array['city_id'] = $this->request->getVar('city_id');
            $data_array['state_id'] = $this->request->getVar('state_id');
            $data_array['country_id'] = $this->request->getVar('country_id');
            $data_array['pincode'] = $this->request->getVar('pincode');
            if ($this->request->getVar('password') != '') {
                $data_array['password'] = md5($this->request->getVar('password'));
            }
            $data_array['address'] = urlencode($this->request->getVar('address'));

            $data_array['identity_number'] = $this->request->getVar('identity_number');
            $data_array['license_number'] = $this->request->getVar('license_number');
            $data_array['gender'] = $this->request->getVar('gender');
            $data_array['date_of_birth'] = date('Y-m-d', strtotime($this->request->getVar('date_of_birth')));

            if (!empty($_FILES['identity_image']['name'])) {

                $img = $this->request->getFile('identity_image');
                $newName = $img->getRandomName();
                $img->move(FCPATH . 'public/uploads/user', $newName);

                $data_array['identity_image'] = $img->getName();
                $this->unlinkFile($data['results']['identity_image'], 'user');
            }


            if (!empty($_FILES['license_image']['name'])) {

                $img = $this->request->getFile('license_image');
                $newName = $img->getRandomName();
                $img->move(FCPATH . 'public/uploads/user', $newName);

                $data_array['license_image'] = $img->getName();
                $this->unlinkFile($data['results']['license_image'], 'user');
            }
            if ($this->userModel->update($id, $data_array)) {
                $this->session->setFlashdata('success', lang('Admin.driver_updated_successfully'));
                return redirect()->to(base_url('admin/drivers'));
            } else {
                $this->session->setFlashdata('error', lang('Admin.error_try_again'));
            }
        }
        $data['country'] = $this->countryModel->select('id, name')->where(array('status' => 1))->find();
        $data['state'] = $this->stateModel->select('id, name')->where(array('status' => 1, 'country_id' => $data['results']['country_id']))->find();
        $data['city'] = $this->cityModel->select('id, name')->where(array('status' => 1, 'state_id' => $data['results']['state_id']))->find();
        $this->view_page('drivers/edit', $data);
    }
}

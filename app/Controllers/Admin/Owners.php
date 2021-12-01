<?php

namespace App\Controllers\Admin;

use App\Controllers\AdminBaseController;
use App\Models\OwnerModel;

class Owners extends AdminBaseController
{

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->ownerModel = new OwnerModel();
    }
    public function index()
    {
        $data['results'] =  $this->ownerModel->select('o.*, s.name as state_name, ct.name as city_name, c.name as country_name')->from(TBL_OWNERS . ' as o')->join(TBL_STATE . ' as s', "s.id=o.state_id")->join(TBL_CITY . ' as ct', "ct.id=o.city_id")->join(TBL_COUNTRY . " as c", "c.id=o.country_id")->groupBy('o.id')->orderBy('o.id', 'desc')->find();

        $this->view_page('owners/index', $data);
    }

    public function delete()
    {

        if(ENVIRONMENT!='demo') {
            $id= $this->request->getVar('id');
            $this->ownerModel->update($id, ['status' => 9]);
            if($this->ownerModel->delete(array('id' => $id))){
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
                $this->ownerModel->update($id, ['status' => 9]);
                $this->ownerModel->delete(array('id' => $id));
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
        if ($_POST && !empty($_POST)) {

            $data_array['first_name'] = urlencode($this->request->getVar('first_name'));
            $data_array['last_name'] = urlencode($this->request->getVar('last_name'));
            $data_array['phone'] = $this->request->getVar('phone_number');
            $data_array['email'] = urlencode($this->request->getVar('email_id'));
            $data_array['city_id'] = $this->request->getVar('city_id');
            $data_array['state_id'] = $this->request->getVar('state_id');
            $data_array['country_id'] = $this->request->getVar('country_id');
            $data_array['pincode'] = $this->request->getVar('pincode');
            $data_array['password'] = md5($this->request->getVar('password'));
            $data_array['address'] = urlencode($this->request->getVar('address'));
            if ($this->ownerModel->insert($data_array)) {
                $this->session->setFlashdata('success', lang('Admin.owner_added_successfully'));
                return redirect()->to(base_url('admin/owners'));
            } else {
                $this->session->setFlashdata('error', lang('Admin.error_try_again'));
            }
        }
        $data['country'] = $this->countryModel->select('id, name')->where(array('status' => 1))->find();
        $this->view_page('owners/add', $data);
    }

    public function edit($id)
    {
        $data['results'] = $this->ownerModel->where(array('id' => $id))->first();
        if (!$id || empty($data['results'])) {
            $this->session->setFlashdata('error', lang('Admin.data_not_found'));
            return redirect()->to(base_url('admin/owners'));
        }
        if ($_POST && !empty($_POST)) {

            $data_array['first_name'] = urlencode($this->request->getVar('first_name'));
            $data_array['last_name'] = urlencode($this->request->getVar('last_name'));
            $data_array['phone'] = $this->request->getVar('phone_number');
            $data_array['email'] = urlencode($this->request->getVar('email_id'));
            $data_array['city_id'] = $this->request->getVar('city_id');
            $data_array['state_id'] = $this->request->getVar('state_id');
            $data_array['country_id'] = $this->request->getVar('country_id');
            $data_array['pincode'] = $this->request->getVar('pincode');
            $data_array['address'] = urlencode($this->request->getVar('address'));
            if (trim($this->request->getVar('password'))) {
                $data_array['password'] = md5($this->request->getVar('password'));
            }
            if ($this->ownerModel->update($id, $data_array)) {
                $this->session->setFlashdata('success', lang('Admin.owner_updated_successfully'));
                return redirect()->to(base_url('admin/owners'));
            } else {
                $this->session->setFlashdata('error', lang('Admin.error_try_again'));
            }
        }
        $data['country'] = $this->countryModel->select('id, name')->where(array('status' => 1))->find();
        $data['state'] = $this->stateModel->select('id, name')->where(array('status' => 1, 'country_id' => $data['results']['country_id']))->find();
        $data['city'] = $this->cityModel->select('id, name')->where(array('status' => 1, 'state_id' => $data['results']['state_id']))->find();
        $this->view_page('owners/edit', $data);
    }
}

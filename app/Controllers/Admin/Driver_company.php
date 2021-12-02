<?php

namespace App\Controllers\Admin;

use App\Controllers\AdminBaseController;

use App\Models\RestaurantModel;
use App\Models\DriverCompanyModel;
use App\Models\OwnerModel;

class Driver_company extends AdminBaseController
{

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        
        $this->RestaurantModel = new RestaurantModel();
        $this->DriverCompanyModel = new DriverCompanyModel();
        $this->OwnerModel = new OwnerModel();
    }
    public function index()
    {

        // echo "hello";exit;
        
        // $data['results'] = $this->DriverCompanyModel->select('*')->find();
        $data['results'] = $this->DriverCompanyModel->select('o.*, c.first_name,c.last_name')->from(tbl_drivers_company . ' as o')->join(TBL_OWNERS . " as c", "c.id=o.owner_id")->orderBy('o.id', 'desc')->find();

        //  $data['resaurants'] = $this->DriverCompanyModel->select('*')->find();
        // echo $this->DriverCompanyModel->getLastQuery()->getQuery();
        // die;
        //print_r($data['results']);exit;

        $this->view_page('driver_company/index', $data);
    }

    public function delete()
    {

        if(ENVIRONMENT!='demo') {
            $id= $this->request->getVar('id');
            $this->userModel->update($id, ['status' => 9]);
            if($this->DriverCompanyModel->delete(array('id' => $id))){
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
                $this->DriverCompanyModel->delete(array('id' => $id));
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
        
        // print_r($postData);exit;
        if ($postData && !empty($postData)) {

            $data_array['company_name'] = urlencode($this->request->getVar('company_name'));
            $data_array['owner_name'] = $this->request->getVar('owner_name');
            $data_array['owner_id_number'] = urlencode($this->request->getVar('owner_id_number'));
            $data_array['owner_mobile_number'] = $this->request->getVar('owner_mobile_number');
            $data_array['restaurant_id'] = $this->request->getVar('restaurant');
            $data_array['owner_id'] = $this->request->getVar('owner');
            $data_array['address'] = $this->request->getVar('address');
            $data_array['identity_number'] = $this->request->getVar('identity_number');
            $data_array['company_email_id'] = $this->request->getVar('company_email_id');
            $data_array['license_number'] = urlencode($this->request->getVar('license_number'));
            $data_array['password'] = md5($this->request->getVar('password'));

            $data_array['company_contact_number'] = $this->request->getVar('company_contact_number');

          
            $insert = $this->DriverCompanyModel->insert($data_array);
            if ($insert) {
                $this->session->setFlashdata('success', lang('Admin.driver_added_successfully'));
                return redirect()->to(base_url('admin/driver_company'));
            } else {
                $this->session->setFlashdata('error', lang('Admin.error_try_again'));
            }
        }


        
        $data['resaurants'] = $this->RestaurantModel->select('id, name')->where(array('status' => 1))->find();
        $data['owners'] = $this->OwnerModel->find();
        
        // print_r($data['owners']);exit;
        $this->view_page('driver_company/add', $data);
    }

    public function edit($id)
    {
        

        $data['results'] = $this->DriverCompanyModel->where(array('id' => $id))->first();

     
        if (!$id || empty($data['results'])) {
            $this->session->setFlashdata('error', lang('Admin.data_not_found'));
            return redirect()->to(base_url('admin/driver_company'));
        }

         

        if ($_POST && !empty($_POST)) {

           
            $data_array['company_name'] = urlencode($this->request->getVar('company_name'));
            $data_array['owner_name'] = $this->request->getVar('owner_name');
            $data_array['owner_id_number'] = urlencode($this->request->getVar('owner_id_number'));
            $data_array['owner_mobile_number'] = $this->request->getVar('owner_mobile_number');
            $data_array['restaurant_id'] = $this->request->getVar('restaurant');
            $data_array['address'] = $this->request->getVar('address');
            $data_array['identity_number'] = $this->request->getVar('identity_number');
            $data_array['company_email_id'] = md5($this->request->getVar('company_email_id'));
            $data_array['license_number'] = urlencode($this->request->getVar('license_number'));

            $data_array['company_contact_number'] = $this->request->getVar('company_contact_number');

          
            if ($this->DriverCompanyModel->update($id, $data_array)) {
                $this->session->setFlashdata('success', lang('Admin.driver_updated_successfully'));
                return redirect()->to(base_url('admin/driver_company'));
            } else {
                $this->session->setFlashdata('error', lang('Admin.error_try_again'));
            }

        }

        $data['resaurants'] = $this->RestaurantModel->select('id, name')->where(array('status' => 1))->find();
        $this->view_page('driver_company/edit', $data);
    }
}

<?php

namespace App\Controllers\Admin;

use App\Controllers\AdminBaseController;

class Country extends AdminBaseController
{

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }
    public function index()
    {
        $data['results'] =  $this->countryModel->orderBy('id', 'desc')->find();
        return $this->view_page('country/index', $data);
    }
    public function add()
    {
        if ($_POST && !empty($_POST)) {

            $data_array = array('name' => urlencode($this->request->getVar('name')));
            if ($this->countryModel->insert($data_array)) {
                $this->session->setFlashdata('success', lang('Admin.country_added_successfully'));
                return redirect()->to(base_url('admin/country'));
            } else {
                $this->session->setFlashdata('error', lang('Admin.error_try_again'));
            }
        }
        $this->view_page('country/add');
    }
    public function delete()
    {
        if(ENVIRONMENT!='demo') {
            $id= $this->request->getVar('id');
            $this->countryModel->update($id, ['status' => 9]);
            if($this->countryModel->delete(array('id' => $id))){
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
                $this->countryModel->update($id, ['status' => 9]);
                $this->countryModel->delete(array('id' => $id));
            }
            $data['success'] =1;
            $data['message'] = lang('Admin.data_deleted_successfully');
            
        }else {
            $data['message'] = lang('Admin.this_operation_not_permited_in_demo_mode');
        }
        echo json_encode($data);
    }
    public function edit($id)
    {
        $data['results'] = $this->countryModel->where(array('id' => $id))->first();
        if (!$id || empty($data['results'])) {
            $this->session->setFlashdata('error', lang('Admin.data_not_found'));
            return redirect()->to(base_url('admin/country'));
        }

        if ($_POST && !empty($_POST)) {

            $data_array = array('name' => urlencode($this->request->getVar('name')));
            if ($this->countryModel->update($id, $data_array)) {
                $this->session->setFlashdata('success', lang('Admin.country_updated_successfully'));
                return redirect()->to(base_url('admin/country'));
            } else {
                $this->session->setFlashdata('error', lang('Admin.error_try_again'));
            }
        }

        $this->view_page('country/edit', $data);
    }
}

<?php

namespace App\Controllers\Admin;

use App\Controllers\AdminBaseController;

class State extends AdminBaseController
{

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }
    public function index()
    {
        $data['results'] =  $this->stateModel->select("s.*, c.name as country_name")->from(TBL_STATE . ' as s')->join(TBL_COUNTRY . ' as c', "c.id=s.country_id")->where('s.deleted', NULL)->groupBy('s.id')->orderBy('s.id', 'desc')->find();
        return $this->view_page('state/index', $data);
    }
    public function add()
    {

        if ($_POST && !empty($_POST)) {


            $data_array['name'] = urlencode($this->request->getVar('name'));
            $data_array['country_id'] = $this->request->getVar('country_id');
            
            if ($this->stateModel->insert($data_array)) {
                $this->session->setFlashdata('success', lang('Admin.state_added_successfully'));
                return redirect()->to(base_url('admin/state'));
            } else {
                $this->session->setFlashdata('error', lang('Admin.error_try_again'));
            }
        }
        $data['country'] = $this->countryModel->select('id, name')->where(array('status' => 1))->find();
        return $this->view_page('state/add', $data);
    }
    public function delete()
    {
        if(ENVIRONMENT!='demo') {
            $id= $this->request->getVar('id');
            $this->stateModel->update($id, ['status' => 9]);
            if($this->stateModel->delete(array('id' => $id))){
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
                $this->stateModel->update($id, ['status' => 9]);
                $this->stateModel->delete(array('id' => $id));
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
        $data['results'] = $this->stateModel->where(array('id' => $id))->first();
        if (!$id || empty($data['results'])) {
            $this->session->setFlashdata('error', lang('Admin.data_not_found'));
            return redirect()->to(base_url('admin/state'));
        }

        if ($_POST && !empty($_POST)) {

            $data_array['name'] = urlencode($this->request->getVar('name'));
            $data_array['country_id'] = $this->request->getVar('country_id');
            if ($this->stateModel->update($id, $data_array)) {
                $this->session->setFlashdata('success', lang('Admin.state_updated_successfully'));
                return redirect()->to(base_url('admin/state'));
            } else {
                $this->session->setFlashdata('error', lang('Admin.error_try_again'));
            }
        }


        $data['country'] = $this->countryModel->select('id, name')->where(array('status' => 1))->find();
        return $this->view_page('state/edit', $data);
    }
}

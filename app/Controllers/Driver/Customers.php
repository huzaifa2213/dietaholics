<?php
namespace App\Controllers\Admin;
use App\Controllers\AdminBaseController;
class Customers extends AdminBaseController
{

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		parent::initController($request, $response, $logger);
	}
    public function index()
    {
        $data['results'] =  $this->userModel->where(array('status!=' => 9, 'user_type' => 1))->find();
        $this->view_page('customers/index', $data);
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
}

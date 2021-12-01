<?php
namespace App\Controllers\Admin;
use App\Controllers\AdminBaseController;
class City extends AdminBaseController {

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		parent::initController($request, $response, $logger);
	}
	public function index() {
        $data['results'] =  $this->cityModel->select("s.*, c.name as state_name")->from(TBL_CITY . ' as s')->join(TBL_STATE . ' as c', "c.id=s.state_id")->where('s.deleted', NULL)->groupBy('s.id')->orderBy('s.id', 'desc')->find();
		return $this->view_page('city/index', $data);
	}
	public function add(){
        
        if($_POST && !empty($_POST)) {
            
                $data_array['name']= urlencode($this->request->getVar('name'));
                $data_array['state_id']= $this->request->getVar('state_id');
                
                
                if($this->cityModel->insert($data_array)){
                    $this->session->setFlashdata('success', lang('Admin.city_added_successfully'));
                    return redirect()->to(base_url('admin/city'));
                }else {
                    $this->session->setFlashdata('error', lang('Admin.error_try_again'));
                }
            }
            
        
        $data['state'] = $this->stateModel->select('id, name')->where(array('status' => 1))->find();
        return $this->view_page('city/add',$data);       
    }
	public function delete() {
        if(ENVIRONMENT!='demo') {
            $id= $this->request->getVar('id');
            $this->cityModel->update($id, ['status' => 9]);
            if($this->cityModel->delete(array('id' => $id))){
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
    public function multiple_delete() {
        if(ENVIRONMENT!='demo') {
            $ids= $this->request->getVar('id');
            foreach($ids as $id){
                $this->cityModel->update($id, ['status' => 9]);
                $this->cityModel->delete(array('id' => $id));
            }
            $data['success'] =1;
            $data['message'] = lang('Admin.data_deleted_successfully');
            
        }else {
            $data['message'] = lang('Admin.this_operation_not_permited_in_demo_mode');
        }
        echo json_encode($data);
    }
    public function edit($id) {
        $data['results']= $this->cityModel->where(array('id'=>$id))->first();
        if(!$id || empty($data['results'])) {
            $this->session->setFlashdata('error', lang('Admin.data_not_found'));
            return redirect()->to(base_url('admin/city'));
        }
        if($_POST && !empty($_POST)) {
           
                $data_array['name']= urlencode($this->request->getVar('name'));
                $data_array['state_id']= $this->request->getVar('state_id');
                if($this->cityModel->update($id, $data_array)){
                    $this->session->setFlashdata('success', lang('Admin.city_updated_successfully'));
                    return redirect()->to(base_url('admin/city'));
                }else {
                    $this->session->setFlashdata('error', lang('Admin.error_try_again'));
                }
            } 
        $data['state'] = $this->stateModel->select('id, name')->where(array('status' => 1))->find();
        return $this->view_page('city/edit',$data);  
    }
}
?>
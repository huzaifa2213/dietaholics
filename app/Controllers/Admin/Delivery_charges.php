<?php
namespace App\Controllers\Admin;
use App\Controllers\AdminBaseController;
use App\Models\DeliveryChargesModel;

class Delivery_charges extends AdminBaseController {

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		parent::initController($request, $response, $logger);
        $this->deliveryChargesModel =  new DeliveryChargesModel();
	}
	public function index() {
        
        $data['results'] =  $this->deliveryChargesModel->orderBy('id', 'desc')->find();
		return $this->view_page('delivery_charges/index', $data);
	}
	public function add(){
        
        if($_POST && !empty($_POST)) {
            
               
                
                if($this->deliveryChargesModel->insert($_POST)){
                    $this->session->setFlashdata('success', lang('Admin.charges_added_successfully'));
                    return redirect()->to(base_url('admin/delivery_charges'));
                }else {
                    $this->session->setFlashdata('error', lang('Admin.error_try_again'));
                }
            }
            
        
       
        return $this->view_page('delivery_charges/add');       
    }
	public function delete() {
		if(ENVIRONMENT!='demo') {
            $id= $this->request->getVar('id');
            $this->deliveryChargesModel->update($id, ['status' => 9]);
            if($this->deliveryChargesModel->delete(array('id' => $id))){
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
                $this->deliveryChargesModel->update($id, ['status' => 9]);
                $this->deliveryChargesModel->delete(array('id' => $id));
            }
            $data['success'] =1;
            $data['message'] = lang('Admin.data_deleted_successfully');
            
        }else {
            $data['message'] = lang('Admin.this_operation_not_permited_in_demo_mode');
        }
        echo json_encode($data);

    }

    public function edit($id) {
        $data['row']= $this->deliveryChargesModel->where(array('id'=>$id))->first();
        if(!$id || empty($data['row'])) {
            $this->session->setFlashdata('error', lang('Admin.data_not_found'));
            return redirect()->to(base_url('admin/delivery_charges'));
        }
        
        if($_POST && !empty($_POST)) {
           
               
                if($this->deliveryChargesModel->update($id, $_POST)){
                    $this->session->setFlashdata('success', lang('Admin.charges_updated_successfully'));
                    return redirect()->to(base_url('admin/delivery_charges'));
                }else {
                    $this->session->setFlashdata('error', lang('Admin.error_try_again'));
                }
            } 
        
        return $this->view_page('delivery_charges/edit',$data);  
    }
}
?>
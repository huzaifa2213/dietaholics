<?php
namespace App\Controllers\Admin;
use App\Controllers\AdminBaseController;
class Settings extends AdminBaseController {

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		parent::initController($request, $response, $logger);
	}
	public function index() {
        $data['results']=  $this->settingModel->where(['status'=>1])->find();
        
		$this->view_page('settings/index', $data);
	}
	
	

    public function edit($id){
        $data['results']= $this->settingModel->where(array('id'=>$id))->first();
        if (!$id || empty($data['results'])) {
            $this->session->setFlashdata('error', lang('Admin.data_not_found'));
            return redirect()->to(base_url('admin/settings'));
        }
        
        if ($_POST && !empty($_POST)) {
            if(ENVIRONMENT=='demo') {
                $this->session->setFlashdata('error', lang('Admin.this_operation_not_permited_in_demo_mode'));
                return redirect()->to(base_url('admin/settings'));
            }
            $data_array = $_POST;
            $data_array['website_name']=urlencode($this->request->getVar('website_name'));
            $data_array['email']=urlencode($this->request->getVar('email'));
            $data_array['smtp_username']=urlencode($this->request->getVar('smtp_username'));
            $data_array['smtp_from_email']=urlencode($this->request->getVar('smtp_from_email'));
            $data_array['smtp_from_name']=urlencode($this->request->getVar('smtp_from_name'));
           
            if (!empty($_FILES['website_logo']['name'])) {

                $img = $this->request->getFile('website_logo');
                $newName = $img->getRandomName();
                $img->move(FCPATH . 'public/uploads', $newName);

                $data_array['website_logo'] = $img->getName();
            }
            if ($this->settingModel->update($id, $data_array)) {
                $this->session->setFlashdata('success', lang('Admin.settings_updated_successfully'));
                return redirect()->to(base_url('admin/settings'));
            } else {
                $this->session->setFlashdata('error', lang('Admin.error_try_again'));
            }
            
        }
         
        $this->view_page('settings/edit',$data);       
    }

   
}
?>
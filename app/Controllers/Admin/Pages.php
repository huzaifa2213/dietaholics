<?php
namespace App\Controllers\Admin;
use App\Controllers\AdminBaseController;
use App\Models\PagesModel;

class Pages extends AdminBaseController {

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->pageModel = new PagesModel();
    }
	public function index() {
       
        $data['results']=  $this->pageModel->where(['status'=>1])->find();
        
		return $this->view_page('pages/index', $data);
	}
	
	

    public function edit($id){
        $data['results']= $this->pageModel->where(array('id'=>$id))->first();
        if(!$id || empty($data['results'])) {
            $this->session->setFlashdata('error', lang('Admin.data_not_found'));
            return redirect()->to(base_url('admin/pages'));
        }
        
        if($_POST && !empty($_POST)) {

            $data_array['title']=urlencode($this->request->getVar('title'));
            $data_array['description']=urlencode($this->request->getVar('description'));
           if($this->pageModel->update($id, $data_array)){
                $this->session->setFlashdata('success', lang('Admin.page_updated_successfully'));
                return redirect()->to(base_url('admin/pages'));
            }else {
                $this->session->setFlashdata('error', lang('Admin.error_try_again'));
            }
            
        }
         
        return $this->view_page('pages/edit',$data);       
    }

   
}
?>
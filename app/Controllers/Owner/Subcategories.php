<?php
namespace App\Controllers\Owner;
use App\Controllers\OwnerBaseController;
use App\Models\SubcategoryModel;
class Subcategories extends OwnerBaseController {

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		parent::initController($request, $response, $logger);
        $this->subcategoryModel = new SubcategoryModel();
	}
	public function index() {
        $data['results'] = $this->subcategoryModel->select("s.*, c.title as cat_title, r.name as restaurant_name")->from(TBL_SUBCATEGORIES . ' as s')->join(TBL_CATEGORIES . ' as c', "c.id=s.category_id")->join(TBL_RESTAURANTS . ' as r', "r.id=s.restaurant_id")->where(array('s.status!=' => 9, 'r.owner_id'=>$this->session->owner_id))->orderBy('s.id', 'desc')->groupBy('s.id')->find();
		$this->view_page('subcategories/index', $data);
    }
    public function change_visibility() {
        $id= $this->request->getVar('id');
        $data_array= array('status'=>trim($this->request->getVar('visibility')));
        if($this->subcategoryModel->update($id, $data_array)) {
            $data['success'] =1;
            $data['message'] = lang('Owner.status_changed_successfully');
        }else {
            $data['message'] = lang('Owner.error_try_again');
        }
        echo json_encode($data); 
        
    }
    
}
?>
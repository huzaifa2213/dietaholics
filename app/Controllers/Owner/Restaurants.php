<?php
namespace App\Controllers\Owner;
use App\Controllers\OwnerBaseController;
use App\Models\CategoryModel;
use App\Models\SubcategoryModel;
use App\Models\EarningModel;
class Restaurants extends OwnerBaseController {

  public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		parent::initController($request, $response, $logger);
      $this->categoryModel = new CategoryModel();
      $this->subcategoryModel = new SubcategoryModel();
      $this->earningModel = new EarningModel();
	}
	public function index() {
       $data['results'] = $this->restaurantModel->select("r.*, o.first_name, o.last_name, s.name as state_name, ct.name as city_name, c.name as country_name")->from(TBL_RESTAURANTS . ' as r')->join(TBL_STATE . ' as s', "s.id=r.state_id")->join(TBL_CITY . ' as ct', "ct.id=r.city_id")->join(TBL_COUNTRY . " as c", "c.id=r.country_id")->join(TBL_OWNERS . " as o", "o.id=r.owner_id")->where(['r.deleted'=> NULL, 'r.owner_id'=>$this->session->owner_id])->orderBy('r.id', 'DESC')->groupBy('r.id')->find();
        
		$this->view_page('restaurants/index', $data);
    }
    

    public function view($id) {

     

      $data['restaurant_info'] =  $this->restaurantModel->select('r.*, ct.name as city_name, s.name as state_name, c.name as country_name')->from(TBL_RESTAURANTS . " as r")->join(TBL_CITY . " as ct", " ct.id=r.city_id", "INNER")->join(TBL_STATE . " as s ", " s.id=r.state_id", 'INNER')->join(TBL_COUNTRY . " as c ", " c.id=r.country_id", 'INNER')->where(['r.id' => $id, 'r.owner_id'=>$this->session->owner_id])->first();
               
        $data['controller'] = $this;

        if (empty($data['restaurant_info'])) {
            $this->session->setFlashdata('error', lang('Owner.restaurant_not_found'));
            return redirect()->to(base_url('owner/restaurants'));
        }

        $data['categories'] = $this->categoryModel->select("c.*")->from(TBL_CATEGORIES . ' as c')->join(TBL_SUBCATEGORIES . ' as s', "s.category_id=c.id")->where(array('s.restaurant_id=' => $id, 's.status' => 1))->groupBy('c.id')->find();

        $this->view_page("restaurants/view", $data);

    }

    public function change_availablity() {
      $data_array= array('is_available'=>trim($this->request->getVar('visibility')));
			
			if($this->restaurantModel->update($this->request->getVar('id'),$data_array)) {
        $data['success'] =1;
        $data['message'] = lang('Owner.status_changed_successfully');
      }else {
        $data['message'] = lang('Owner.error_try_again');
      }
      echo json_encode($data); 
    }
  
    function invoice($id) {

     
      $data['restaurant_id'] = $id;
      $data['invoice_info'] = $this->orderModel->select("o.*, e.admin_charge_amount, e.owners_amount, e.total_amount, e.payment_status, e.payment_date")->from(TBL_ORDERS . ' as o')->join(TBL_EARNINGS . ' as e' , "e.order_id=o.id", "INNER")->join(TBL_RESTAURANTS . ' as r' , "r.id=o.restaurent_id")->where(array('o.restaurent_id='=>$id, 'o.status'=>1, 'r.owner_id'=>$this->session->owner_id, 'e.status'=>1))->groupBy('o.id')->orderBy('o.id', 'DESC')->find();
      $this->view_page("restaurants/invoice", $data);


  }
  public function getProducts($res_id, $cat_id){
    $data = $this->subcategoryModel->where(array('deleted'=>NULL, "category_id"=>$cat_id, "restaurant_id"=>$res_id))->find();

    return $data;
  }
    
    
}
?>
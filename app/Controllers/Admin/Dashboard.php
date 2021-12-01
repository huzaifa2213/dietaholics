<?php
namespace App\Controllers\Admin;
use App\Controllers\AdminBaseController;
use App\Models\EarningModel;
use App\Models\OwnerModel;

class Dashboard extends AdminBaseController {

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		parent::initController($request, $response, $logger);
	}
	public function index() {
		
        $earningModel = new EarningModel();
        $ownerModel = new OwnerModel();
         $data["customerslist"] =$this->userModel->select("id")->where(array('status!='=>9, 'user_type'=>1))->find();
         $data["orderdeliveredlist"] =$this->orderModel->select("id")->where(array('order_status'=>5))->find();
         $data["totalorderreceived"] =$this->orderModel->select("id")->where(array('created'=>date('Y-m-d'), 'order_status'=>1))->find();
         $data["totalearnings"] = $earningModel->select("SUM(admin_charge_amount) AS earnings")->where(array('status'=>1))->find();
         $data["totalowners"] =$ownerModel->select("id")->where(array('status!='=>9))->find();
         $data["totalResaturants"] =$this->restaurantModel->select("id")->where(array('status!='=>9))->find();
         $data['available_drivers']= $this->userModel->where(array('status'=>1, 'user_type'=>2, 'latitude!='=>"", 'longitude!='=>""))->find();

        
         $data['latest_order_list'] = $this->orderModel->select('o.*, u.fullname, r.name')->from(TBL_ORDERS.' as o')->join(TBL_USERS.' as u' , "u.id=o.user_id")->join(TBL_RESTAURANTS.' as r',"o.restaurent_id=r.id")->where(array('o.status'=>1))->orderBy('o.id','desc')->limit(5,0)->find();

         for($m=1; $m<=12; $m++){
             $m= $m<=9?('0'.$m):$m;
             $date=  $m."-".date('Y');
             $montly_profit= $earningModel->select("SUM(total_amount) AS earnings")->where(array('status'=>1,  "DATE_FORMAT(created, '%m-%Y')="=>"$date"))->find();
             $profit=!empty($montly_profit) ? $montly_profit[0]['earnings'] : 0;
             $profit_record[]= $profit;
        
             $montlyAdmin_profit= $earningModel->select("SUM(admin_charge_amount) AS earnings")->where(array('status'=>1,  "DATE_FORMAT(created, '%m-%Y')="=>"$date"))->find();
             $profitAdmin=!empty($montlyAdmin_profit) ? $montlyAdmin_profit[0]['earnings'] : 0;
             $profitAdmin_record[]= $profitAdmin;
        
        
             $montlyOwner_profit= $earningModel->select("SUM(owners_amount) AS earnings")->where(array('status'=>1,  "DATE_FORMAT(created, '%m-%Y')="=>"$date"))->find();
             $profitOwner=!empty($montlyOwner_profit) ? $montlyOwner_profit[0]['earnings'] : 0;
            $profitOwner_record[]= $profitOwner;
            
         }
        $data['profitOwner_record'] = $profitOwner_record;
        $data['profitAdmin_record'] = $profitAdmin_record;
        $data['profit_record'] = $profit_record;
		        
        $this->view_page('dashboard/index', $data);
	}

}
?>
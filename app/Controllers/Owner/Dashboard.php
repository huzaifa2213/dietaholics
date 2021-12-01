<?php
namespace App\Controllers\Owner;
use App\Controllers\OwnerBaseController;
use App\Models\EarningModel;
class Dashboard extends OwnerBaseController {

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		parent::initController($request, $response, $logger);
        $this->earningModel = new EarningModel();
	}
	public function index() {
		$data["orderdeliveredlist"] =$this->orderModel->select('o.id')->from(TBL_ORDERS . ' as o')->join(TBL_RESTAURANTS . ' as r', "o.restaurent_id=r.id", 'INNER')->where(array('o.deleted' => null, 'o.order_status' => 5, 'r.owner_id' => $this->session->owner_id))->groupBy('o.id')->find();

        $data["totalorderreceived"] =$this->orderModel->select('o.id')->from(TBL_ORDERS . ' as o')->join(TBL_RESTAURANTS . ' as r', "o.restaurent_id=r.id", 'INNER')->where(array('o.deleted' => null, 'o.order_status' => 1, 'r.owner_id' => $this->session->owner_id))->groupBy('o.id')->find();

        $data["totaltodayorderview"]  =$this->orderModel->select('o.id')->from(TBL_ORDERS . ' as o')->join(TBL_RESTAURANTS . ' as r', "o.restaurent_id=r.id", 'INNER')->where(array('o.deleted' => null, "DATE_FORMAT(o.created, '%Y-%m-%d')=" => date('Y-m-d'), 'r.owner_id' => $this->session->owner_id))->groupBy('o.id')->find();
       
        $data["totalEarnings"] = $this->earningModel->select('SUM(e.owners_amount) AS earnings')->from(TBL_EARNINGS . ' as e')->join(TBL_RESTAURANTS . ' as r', "e.restaurent_id=r.id", 'INNER')->where(array('e.status' => 1, "r.owner_id" => $this->session->owner_id, 'e.deleted'=>null))->groupBy('e.id')->find();
        
        $data['latest_order_list'] = $this->orderModel->select('o.*, u.fullname, r.name')->from(TBL_ORDERS . ' as o')->join(TBL_RESTAURANTS . ' as r', "o.restaurent_id=r.id", 'INNER')->join(TBL_USERS . ' as u', "u.id=o.user_id")->where(array('o.deleted' => null, 'r.owner_id' => $this->session->owner_id))->groupBy('o.id')->orderBy('o.id', 'desc')->limit(5, 0)->find();

        $data['controller']=$this;

        for ($m = 1; $m <= 12; $m++) {
            $m = $m <= 9 ? ('0' . $m) : $m;
            $date =  $m . "-" . date('Y');
            $montly_profit = $this->earningModel->select('SUM(e.owners_amount) AS earnings')->from(TBL_EARNINGS . ' as e')->join(TBL_RESTAURANTS . ' as r', "e.restaurent_id=r.id", 'INNER')->where(array('e.status' => 1, "r.owner_id" => $this->session->owner_id, "DATE_FORMAT(e.created, '%m-%Y')=" => "$date", 'e.deleted'=>null))->groupBy('e.id')->find();
            $profit = !empty($montly_profit) ? $montly_profit[0]['earnings'] : 0;

            $profit_record[] = $profit;
        }
        $data['profit_record'] = $profit_record;
        return $this->view_page('dashboard/index', $data);
	}

}
?>
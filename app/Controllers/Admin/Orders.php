<?php

namespace App\Controllers\Admin;

use App\Controllers\AdminBaseController;
use App\Models\OrderModel;
use App\Models\OrderDetailsModel;
use App\Models\DriverOrdersModel;
class Orders extends AdminBaseController
{

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->orderModel = new OrderModel();
        $this->orderDetailModel = new OrderDetailsModel();
        $this->driverOrderModel = new DriverOrdersModel();
    }
    public function index()
    {


        $data['results'] = $this->orderModel->select("o.*, u.fullname as user_name, a.latitude, a.longitude")->from(TBL_ORDERS . ' as o')->join(TBL_USERS . ' as u', "u.id=o.user_id")->join(TBL_ADDRESS . ' as a', "a.id=o.address_id")->groupBy('o.id')->orderBy('o.id', 'desc')->find();
        $data['controller'] = $this;
        $this->view_page('orders/index', $data);
    }

    public function delete()
    {

        if(ENVIRONMENT!='demo') {
            $id= $this->request->getVar('id');
            $this->orderModel->update($id, ['status' => 9]);
            if($this->orderModel->delete(array('id' => $id))){
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

    public function assign_driver()
    {
        $data_array['order_id'] = $this->request->getVar('order_id');
        $data_array['driver_id'] = $this->request->getVar('driver_id');

        $this->driverOrderModel->insert($data_array);

        $data_array1['title'] = urlencode("Order Assigned");
        $data_array1['description'] = urlencode("Order #" . $data_array['order_id'] . " has been assigned to you.");
        $data_array1['type'] = 2;
        $data_array1['user_id'] = $this->request->getVar('driver_id');
        $data_array1['type_id'] = $data_array['order_id'];

        $notification_id = $this->notificationModel->insert($data_array1);
        if ($notification_id) {
            $this->sendPushNotification($data_array['driver_id'], $notification_id, 'driver');
        }
        return true;
    }

    public function view($id)
    {

        $data['order_info'] = $this->orderModel->select("o.*, r.name, r.profile_image, r.address, r.phone as r_phone, r.email as r_email, r.id as restaurant_id, r.opening_time, r.closing_time, r.average_price, a.address_line_1, a.address_line_2, a.phone, a.name as user_name, a.city, u.phone as customer_phone, u.email as customer_email, u.fullname as customer_name")->from(TBL_ORDERS . " as o")->join(TBL_RESTAURANTS . " as r", "r.id=o.restaurent_id")->join(TBL_ADDRESS . " as a", "a.id=o.address_id")->join(TBL_USERS . " as u", "u.id=o.user_id")->where(["o.id" =>  $id, "o.status" => 1])->first();
        if(empty($data['order_info'])) {
            return redirect()->to(base_url('admin/orders'));
            $this->session->setFlashdata('error', lang('Admin.data_not_found'));
        }
        $data['get_order_details'] = $this->orderDetailModel->select("od.*, p.type, p.title, p.image")->from(TBL_ORDERDETAIL . ' as od')->join(TBL_SUBCATEGORIES . ' as p', "od.product_id=p.id")->groupBy('od.id')->where(array('od.order_id=' => $id, 'od.status' => 1))->find();
        $this->view_page("orders/view", $data);
    }


    public function change_order_status()
    {

        if ($this->orderModel->update($this->request->getVar('orderid'), array("order_status" => $this->request->getVar('order_status')))) {
            $this->session->setFlashdata('success', lang('Admin.order_status_updated_successfully'));
            return redirect()->to(base_url('admin/orders/view/' . $this->request->getVar('orderid')));
        } else {
            $this->session->setFlashdata('error', lang('Admin.error_try_again'));
        }
    }

    public function getAssignedDriver($id, $type)
    {
        $data = array();
        if ($type == 5) {

            $data = $this->driverOrderModel->select('d.id, d.fullname, od.driver_status')->from(TBL_ORDER_DRIVERS . " as od")->join(TBL_USERS . " as d", "d.id=od.driver_id")->where(['od.status' => 1, 'od.order_id' => $id, 'od.driver_status' => 1])->first();
        }else{

            $data = $this->driverOrderModel->select('d.id, d.fullname, od.driver_status')->from(TBL_ORDER_DRIVERS . " as od")->join(TBL_USERS . " as d", "d.id=od.driver_id")->where(['od.status' => 1, 'od.order_id' => $id])->orderBy('d.id', 'desc')->first();
        }
        return $data;
    }

    public function getNearByDriver($lat, $long)
    {


        $data = $this->db->query("SELECT d.id, d.fullname, d.status,d.is_available, d.user_type, ( 3959 * acos( cos( radians(" . $lat . ") ) * cos( radians( latitude ) )  * cos( radians( longitude ) - radians(" . $long . ") ) + sin( radians(" . $lat . ") ) * sin(radians(latitude)) ) ) AS distance FROM " . TBL_USERS . " as d  GROUP BY d.id HAVING d.status=1 and d.is_available=1 and d.user_type=2 ORDER BY distance ASC")->getResult();


        return $data;
    }
}

<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\CouponModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\UserModel;
use App\Models\DeviceTokenModel;
use App\Models\NotificationModel;
use App\Models\OrderModel;
use App\Models\SettingsModel;
use App\Models\SubcategoryModel;
use App\Models\OwnerModel;
use App\Models\OrderDetailsModel;
use App\Models\DriverOrdersModel;
use App\Models\RestaurantModel;
use App\Models\CityModel;
use App\Models\RestaurantReviewModel;
/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */

class BaseController extends Controller
{
	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = ['filesystem', 'url', 'Common', 'form', 'cookie'];
	protected $settings;
	
	/**
	 * Constructor.
	 *
	 * @param RequestInterface  $request
	 * @param ResponseInterface $response
	 * @param LoggerInterface   $logger
	 */
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);
		$this->userModel = new UserModel();
		$this->deviceTokenModel = new DeviceTokenModel();
		$this->settingsModel = new SettingsModel();
		$this->subcategoryModel = new SubcategoryModel();
		$this->categoryModel = new CategoryModel();
		$this->couponModel = new CouponModel();
		$this->notificationModel = new NotificationModel();
		$this->orderModel = new OrderModel();
		$this->ownerModel = new OwnerModel();
		$this->orderDetailsModel = new OrderDetailsModel();
		$this->driverOrderModel = new DriverOrdersModel();
		$this->restaurantModel = new RestaurantModel();
		$this->cityModel = new CityModel();
		$this->restaurantReviewModel = new RestaurantReviewModel();
		$this->settings = $this->settingsModel->where('status', 1)->first();
		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		$this->session = \Config\Services::session();
	}

	protected function view_page($page = 'home', $data = array(), $isLoggedIn = false)
	{
		if (!is_file(APPPATH . '/Views/web/' . $page . '.php')) {
			// Whoops, we don't have a page for that!
			throw new \CodeIgniter\Exceptions\PageNotFoundException($page);
		}
		// Capitalize the first letter
		$data['settings'] = $this->settings;
		$data['session'] = $this->session;
		$router = service('router');
		$controllerName  = $router->controllerName();
		$data['methodName'] = $router->methodName();
		$data['controllerName'] = end(explode("\\", $controllerName));
		if ($data['methodName'] == 'index') {
			$data['title'] = str_replace('_', ' ', ucfirst($data['controllerName']));
		} else {
			$data['title'] = str_replace('_', ' ', ucfirst($data['methodName']));
		}
		$data['userInfo'] = array();
		if ($this->session->user_id) {
			$data['userInfo'] = $this->userModel->where('id', $this->session->user_id)->first();
		}
		$data['categories'] = $this->getCategories(6);
		$data['cities'] = $this->cityModel->where(['status' => 1])->find();
		echo view('web/includes/header', $data);
		if ($isLoggedIn)
			echo view('web/customers/profile_header', $data);
		echo view('web/' . $page, $data);
		if ($isLoggedIn)
			echo view('web/customers/profile_footer', $data);
		echo view('web/includes/footer', $data);
	}
	protected function parseJson()
	{
		$json = file_get_contents("php://input");
		$data = json_decode($json, 1);
		return $data;
	}
	protected function sendMailToUser($user_id,  $emailId, $type, $password = false)
	{
		if ($type == 1) {
			$subject = "Reset Password";
			$query = $this->userModel->where('id', $user_id)->first();
			$fullname = ucwords(urldecode($query['fullname']));
		} else if ($type == 2) {
			$subject = "Reset Password";
			$query = $this->ownerModel->where('id', $user_id)->first();
			$fullname = ucwords(urldecode($query['first_name'] . ' ' . $query['last_name']));
		} else if ($type == 3) {
			$subject = 'New Enquiry On ' . urldecode($this->settings['website_name']);
			$query = $this->contactModel->where('id', $user_id)->first();

			$fullname = ucwords(urldecode($query['fullname']));
		}
		$config = array(
			"SMTPHost"=>urldecode($this->settings['smtp_host']),
			'SMTPPort'=>$this->settings['smtp_port'],
			'SMTPUser'=>urldecode($this->settings['smtp_username']),
			'SMTPPass'=>$this->settings['smtp_password'],
			'fromName'=>urldecode($this->settings['smtp_from_name']),
			'fromEmail'=>urldecode($this->settings['smtp_from_email']),
			'mailType' => 'html',
            'charset' => 'utf-8'
		);
		$email = \Config\Services::email($config);
		
		$email->setTo($emailId);
		$msg = "";
		if ($type == 1 || $type == 2) {

			$msg = '<html>
						<body>
							<table style="border-spacing:0"  border="1" cellpadding="10" align="center" width="100%" style="border-collapse: collapse;">
								<tr>
									<td>
										<table border="0" cellpadding="0" align="center" style="padding-bottom:20px;">
											<tr>
												<td><h3><font color="#283092">Reset Password</font></h3></td>
											</tr>
										</table>
										<table border="0" cellpadding="0" width="100%" style="padding-bottom:20px;">
											<tr>
												<td>Dear ' . $fullname . ',</td>
											</tr>
											<tr>
												<td><h3>We have received your request to change your password.</h3></td>
											</tr>
											
										</table>
										<table border="0" cellpadding="5px" width="100%" style="padding-bottom:20px;">
											
											<tr>
												<td>Please Find your new password detail below..​</td>
											</tr>
											<tr>
												<td><b>Email:</b> ' . urldecode($emailId) . '</td>
												
											</tr>
											<tr>
												
												<td><b>Password:</b> ' . $password . '</td>
											</tr>
										</table>
										
										
										<table border="0" cellpadding="0" width="100%" >
											
											<tr>
												<td>Thanks and Regards</td>
											</tr>
											<tr>
												<td><strong>' . urldecode($this->settings['website_name']) . '</strong></td>
											</tr>
											
										</table>
									</td>
								</tr>
							</table>
						</body>
				</html>';
		} else {

			$msg = '<html>
						<body>
							<table style="border-spacing:0"  border="1" cellpadding="10" align="center" width="100%" style="border-collapse: collapse;">
								<tr>
									<td>
										<table border="0" cellpadding="0" align="center" style="padding-bottom:20px;">
											<tr>
												<td><h3><font color="#283092">New Enquiry On ' . urldecode($this->settings['website_name']) . '</font></h3></td>
											</tr>
										</table>
										<table border="0" cellpadding="0" width="100%" style="padding-bottom:20px;">
											
											<tr>
												<td><h3>We have received new enquiry. Please check the details below</h3></td>
											</tr>
											
										</table>
										<table border="0" cellpadding="5px" width="100%" style="padding-bottom:20px;">
											
											
											<tr>
												<td><b>Email:</b> ' . urldecode($query['email']) . '</td>
												
											</tr>
											<tr>
												
												<td><b>Fullname:</b> ' . urldecode($query['fullname']) . '</td>
											</tr>
											<tr>
												
												<td><b>Subject:</b> ' . urldecode($query['subject']) . '</td>
											</tr>
											<tr>
												
												<td><b>Message:</b> ' . urldecode($query['message']) . '</td>
											</tr>
										</table>
										
										
										<table border="0" cellpadding="0" width="100%" >
											
											<tr>
												<td>Thanks and Regards</td>
											</tr>
											<tr>
												<td><strong>' . urldecode($this->settings['website_name']) . '</strong></td>
											</tr>
											
										</table>
									</td>
								</tr>
							</table>
						</body>
				</html>';
		}
		$email->setSubject($subject);
		$email->setMessage($msg);

		if ($email->send()) {
			return true;
		} else {
			return false;
			// $data = $email->printDebugger();
			// print_r($data);
		}
		//die;
	}
	public function getMealDeals($lat, $long, $filter=array()) {
		$mealDealResponse = array();
		$getD= $this->subcategoryModel->select("r.id, r.latitude, r.longitude, f.title, f.image, r.address, f.discount_type, f.discount, f.price, r.name as restaurant_name,r.status as r_status, r.is_available, s.status as s_status, ct.status as ct_status,  c.status as c_status, f.status as f_status, f.category_id, ( 3959 * acos( cos( radians(" . $lat . ") ) * cos( radians( r.latitude ) )  * cos( radians( r.longitude ) - radians(" . $long . ") ) + sin( radians(" . $lat . ") ) * sin(radians(r.latitude)) ) ) AS distance")->from(TBL_SUBCATEGORIES . " as f")->join(TBL_RESTAURANTS.' as r', 'r.id=f.restaurant_id', 'INNER')->join(TBL_STATE.' as s', 's.id=r.state_id', 'INNER')->join( TBL_CITY.' as ct', 'ct.id=r.city_id', 'INNER')->join(TBL_COUNTRY.' as c', 'c.id=r.country_id', 'INNER')->groupBy('f.id')->having(["distance<=" => $this->settings['delivery_radius'] , "r_status"=>1, "s_status"=>1, "ct_status"=>1, "c_status"=>1]);

		if(!empty($filter)) {			
			if(isset($filter['status'])) {
				$getD->having('f_status', $filter['status']);
			}else {
				$getD->having('f_status!=', 9);
			}
			if(isset($filter['category_id'])) {
				$getD->having('f.category_id', $filter['category_id']);
			}
			if(isset($filter['start']) && isset($filter['limit'])) {
				$getD->limit($filter['limit'],$filter['start']);
			}else if(isset($filter['limit'])) {
				$getD->limit($filter['limit'],0);
			}
		}else {
			$getD->having('f_status!=', 9);
		}
		$get_mealdela = $getD->orderBy("distance", "ASC")->find();
		if (!empty($get_mealdela)) {
			foreach ($get_mealdela as $row) {
				$mealRes['id'] = $row['id'];
				$mealRes['name'] = urldecode($row['title']);
				$mealrRes['is_available'] = $row['is_available'];
				$mealRes['status'] = $row['f_status'];
				$mealRes['restaurant_name'] = urldecode($row['restaurant_name']);
				$mealRes['image'] = getImagePath(explode(',', $row['image'])[0], 'subcategory');;
				$mealRes['price'] = $row['price'];
				$mealRes['discount'] = $row['discount'];
				$mealRes['latitude'] = $row['latitude'];
				$mealRes['longitude'] = $row['longitude'];
				$mealRes['discount_type'] = $row['discount_type'];
				$mealDealResponse[] = $mealRes;
			}
		}
		return $mealDealResponse;
	}
	public function getProfileData($user_id) {
		$get_user =  $this->userModel->where(array('id' => $user_id, 'status' => 1))->first();
		$user= array();
		if (!empty($get_user)) {
			$user['user_id'] = $get_user['id'];
			$user['name'] = urldecode($get_user['fullname']);
			$user['wallet_amount'] = $get_user['wallet_amount'];
			$user['email'] = urldecode($get_user['email']);
			$user['profile_image'] = getImagePath($get_user['image'], 'user');
			$user['phone'] = $get_user['phone'];
		}
		return $user;
	}
	public function getMyOrdersList($user_id, $status=null, $limit=null, $isCount = null) {
		$where['o.user_id'] = $user_id;
		$where['o.status'] = 1;
		if($status && $status!=null) {
			$where['o.order_status'] = $status;
		}
		$getData = $this->orderModel->select('o.*, r.name, r.profile_image, r.address, rr.review')->from(TBL_ORDERS . ' as o')->join(TBL_RESTAURANTS . ' as r', "r.id=o.restaurent_id")->join(TBL_RESTAURANT_REVIEW . ' as rr' , "rr.order_id=o.id", 'left')->where($where)->groupBy('o.id')->orderBy('o.id', 'DESC');
		if($limit) {
			$getData->limit($limit, 0);
		}
		$get_data = $getData->find();
		if($isCount) {
			return count($get_data);
		}
		$ordResponse = array();
		if (!empty($get_data)) {
			foreach ($get_data as $ord) {
				$ordRes['name'] = urldecode($ord['name']);
				$ordRes['banner_image'] = getImagePath(explode(',', $ord['profile_image'])[0], 'restaurants/profile');
				$ordRes['address'] = urldecode($ord['address']);
				$ordRes['order_id'] = $ord['id'];
				$ordRes['order_status'] = $ord['order_status'];
				$ordRes['total_price'] = $ord['total_price'];
				$ordRes['created'] = $ord['created'];
				$ordRes['order_status'] = $ord['order_status'];
				$ordRes['review'] = urldecode($ord['review']);
				$ordResponse[] = $ordRes;
			}
		}
		return $ordResponse;
	}
	public function sendPushNotification( $user_id,  $notification_id, $type=null) {
		if($type=="driver") {
			$getToken= $this->userModel->where(array('status'=>1, 'id'=>$user_id))->find();
		}else if($type=="owners") {
			$getToken=$this->ownerModel->where(array('status'=>1, 'id'=>$user_id))->find();
		}else {
			$getToken= $this->deviceTokenModel->where(array('status'=>1, 'user_id'=>$user_id))->find();
		}
		$token= array();
		foreach($getToken as $getTokens) {
			$token[]= $getTokens['device_token'];
		}
		$getNotification= $this->notificationModel->where(array('status'=>1, 'id'=>$notification_id))->first();
		$title= urldecode($getNotification['title']);
		$message=urldecode($getNotification['description']);
		$path_to_firebase_cm = 'https://fcm.googleapis.com/fcm/send';
        $fields = array(
            'registration_ids' => $token,
            'priority' => 10,
            'notification' => array('title' => $title, 'body' =>  $message ,'sound'=>'default', 'badge'=>"1",'type_id'=>$getNotification['type_id']),
        );
        $headers = array(
            'Authorization:key=' . $this->settings['fcm_key'],
            'Content-Type:application/json'
        );    
        // Open connection  
        $ch = curl_init(); 
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $path_to_firebase_cm); 
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        // Execute post   
        $result = curl_exec($ch); 
        // Close connection      
        curl_close($ch);
		return $result;
	}
	public function getOrderDetails($order_id){
		$get_order =  $this->orderModel->select("o.*, r.name, r.profile_image, r.address as r_address, a.address_line_1, a.address_line_2, a.phone, r.id as restaurant_id, a.latitude, a.longitude, r.email as r_email, r.phone as r_phone")->from(TBL_ORDERS . " as o")->join(TBL_RESTAURANTS . " as r", "r.id=o.restaurent_id")->join(TBL_ADDRESS . " as a", "a.id=o.address_id", 'left')->where('o.status=1')->groupStart()->where('o.id', $order_id)->orWhere('md5(o.id)', $order_id)->groupEnd()->first();
		$restData= array();
		if (!empty($get_order)) {
			$get_driver =  $this->driverOrderModel->select('driver_id')->where(array('order_id' => $order_id, 'status' => 1, 'driver_status' => 1))->first();
			$restData['order_id'] = $get_order['id'];
			$restData['restaurant_id'] = $get_order['restaurant_id'];
			$restData['latitude'] = $get_order['latitude'];
			$restData['longitude'] = $get_order['longitude'];
			$restData['driver_id'] = !empty($get_driver) ? $get_driver['driver_id'] : "";
			$restData['isReviewed'] = $get_order['isReviewed'];
			$restData['name'] = urldecode($get_order['name']);
			$restData['r_phone'] = $get_order['r_phone'];
			$restData['r_email'] = urldecode($get_order['r_email']);
			$restData['banner_image'] = getImagePath(explode(',', $get_order['profile_image'])[0], 'restaurants/profile');
			$restData['address'] = urldecode($get_order['r_address']);
			$restData['date'] = $get_order['created'];
			$restData['total_price'] = $get_order['total_price'];
			$restData['tip_price'] = $get_order['tip_price'];
			$restData['grand_total'] = $get_order['grand_total'];
			$restData['discount_price'] = $get_order['discount_price'];
			$restData['payment_type'] = $get_order['payment_type'];
			$restData['order_status'] = $get_order['order_status'];
			$restData['admin_charge'] = $get_order['admin_charge'];
			if($get_order['address_id']==0) {
				$restData['delivery_address'] = urldecode($get_order['address']);
			}else {
				$restData['delivery_address'] = urldecode($get_order['address_line_1'] . ' ' . $get_order['address_line_2']);
			}
			
			$restData['delivery_charges'] = $get_order['delivery_charges'];
			$restData['phone'] = $get_order['phone'];
			$get_order_details = $this->orderDetailsModel->select("od.*, p.type, p.title, p.discount, p.price, p.image, p.description")->from(TBL_ORDERDETAIL . ' as od')->join(TBL_SUBCATEGORIES . ' as p', "od.product_id=p.id")->where(array('od.order_id=' => $order_id, 'od.status' => 1))->groupBy('od.id')->find();
			$odResponse = array();
			if (!empty($get_order_details)) {
				foreach ($get_order_details as $oDetails) {
					$odRes['product_name'] = urldecode($oDetails['title']);
					$odRes['product_price'] = $oDetails['product_price'];
					$odRes['extra_note'] = urldecode($oDetails['extra_note']);
					$odRes['product_quantity'] = $oDetails['product_quantity'];
					$odRes['product_id'] = $oDetails['product_id'];
					$odRes['type'] = $oDetails['type'];
					$odRes['discount'] = $oDetails['discount'];
					$odRes['price'] = $oDetails['price'];
					$odRes['description'] = urldecode($oDetails['description']);
					$odRes['image'] = getImagePath($oDetails['image'], 'subcategory');
					$odResponse[] = $odRes;
				}
			}
			$restData['products'] = $odResponse;
		}
		return $restData;
		
	}
	protected function create_invoice_pdf($getOrderInfo)
	{
		$data['orderInfo'] = $getOrderInfo;
		$data['settings'] = $this->settings;
		$mpdf = new \Mpdf\Mpdf();
		$html = view('web/pdf/invoice', $data);
		$mpdf->WriteHTML($html);
		$mpdf->Output(FCPATH . 'public/uploads/invoice/' . md5($getOrderInfo['order_id']) . '.pdf', 'F');
	}


	public function getRestaurantList($latitude, $longitude, $filter=array()) {

		$finalResponse = array();
		
		
		$getData = $this->restaurantModel->select("r.id, r.name, r.profile_image, r.address, r.pincode, r.status as r_status, r.is_available, s.status as s_status, ct.status as ct_status,  c.status as c_status, s.name as state_name, ct.name as city_name, c.name as country_name, r.discount_type, r.discount, r.latitude, r.longitude, ( 3959 * acos( cos( radians(" . $latitude . ") ) * cos( radians( r.latitude ) )  * cos( radians( r.longitude ) - radians(" . $longitude . ") ) + sin( radians(" . $latitude . ") ) * sin(radians(r.latitude)) ) ) AS distance,  ROUND( AVG(rr.review),1 ) as review, COUNT(rr.restaurant_id) as total_review, r.opening_time, r.closing_time, r.average_price, r.slug_url")->from(TBL_RESTAURANTS . ' as r')->join(TBL_STATE . ' as s', 's.id=r.state_id', 'INNER')->join(TBL_CITY . ' as ct', 'ct.id=r.city_id', 'INNER')->join(TBL_COUNTRY . ' as c', 'c.id=r.country_id', 'INNER')->join(TBL_RESTAURANT_REVIEW . ' as rr', 'rr.restaurant_id=r.id', 'LEFT')->groupBy('r.id')->having(["distance<=" => $this->settings['delivery_radius'], "r_status" => 1, "s_status" => 1, "ct_status" => 1, "c_status" => 1]);

		if(!empty($filter)) {
			if(isset($filter['is_available'])) {
				$getData->having('r.is_available', 1);
			}
			if(isset($filter['start']) && isset($filter['limit'])) {
				$getData->limit($filter['limit'], $filter['start']);
			}else if(isset($filter['limit'])) {
				$getData->limit($filter['limit'], 0);
			}
		}
		$get_restaurants = $getData->orderBy("distance", "ASC")->find();
		
		if(!empty($filter) && isset($filter['returnType']) && $filter['returnType']== "count") {
			return count($get_restaurants);
		}
		if (!empty($get_restaurants)) {
			foreach ($get_restaurants as $row) {
				$res['id'] = $row['id'];
				$res['distance'] = numbeFormat($row['distance'], 1);
				$res['review'] = $row['review'];
				$res['total_review'] = $row['total_review'] ?  $row['total_review'] :"0";
				$res['is_available'] = $row['is_available'];
				$res['name'] = urldecode($row['name']);
				$res['image'] = getImagePath(explode(',', $row['profile_image'])[0], 'restaurants/profile');
				$res['address'] = urldecode($row['address']) . ',' . urldecode($row['city_name']);
				$res['discount'] = $row['discount'];
				$res['latitude'] = $row['latitude'];
				$res['longitude'] = $row['longitude'];
				$res['discount_type'] = $row['discount_type'];
				$res['opening_time'] = timeFormat($row['opening_time']);
				$res['closing_time'] = timeFormat($row['closing_time']);
				$res['average_price'] = numbeFormat($row['average_price']);
				$res['slug_url'] = $row['slug_url'] ? $res['slug_url'] : md5($row['id']);

				$finalResponse[] = $res;
			}
		}
		
		return $finalResponse;

	}

	public function getCategories($limit=null) {
		$catResponse =array();
		$query = $this->categoryModel->select("c.*, COUNT(s.category_id) as total")->from(TBL_CATEGORIES . ' as c')->join(TBL_SUBCATEGORIES . ' as s' , 's.category_id=c.id')->where(['c.status' => 1])->groupBy('c.id')->orderBy('title', 'ASC');
		if($limit) {
			$query->limit($limit, 0);
		}	
		$getData= $query->find();
		if (!empty($getData)) {
			foreach ($getData as $cats) {
				$catRes['category_name'] = urldecode($cats['title']);
				$catRes['image'] = getImagePath($cats['image'], 'category');;
				$catRes['category_id'] = $cats['id'];
				$catRes['total_count'] = $cats['total'];
				$catRes['slug_url'] = $cats['slug_url'];
				$catResponse[] = $catRes;
			}
			$catResponse;
		}
		return $catResponse;
	}

	public function getRestaurantDetails($id) {
		$get_restaurant =  $this->restaurantModel->where(array('status' => 1))->groupStart()->orWhere(['id'=>$id, 'slug_url'=>$id, 'md5(id)'=>$id])->groupEnd()->first();
		$restaurant_id = $get_restaurant['id'];
		$restData = array();
		if (!empty($get_restaurant)) {
			$get_avg_review = $this->restaurantReviewModel->select('ROUND( AVG(review),1 ) as review, COUNT(id) as total_review')->where(['restaurant_id' => $restaurant_id, 'status' => 1])->groupBy('restaurant_id')->find();
			$restData['restaurant_id'] = $restaurant_id;
			$restData['avg_review'] = null;
			$restData['total_review'] =0;
			if (!empty($get_avg_review)) {
				$restData['avg_review'] = $get_avg_review[0]['review'];
				$restData['total_review'] = $get_avg_review[0]['total_review'];
			}
			$restData['name'] = urldecode($get_restaurant['name']);
			$restData['email'] = urldecode($get_restaurant['email']);
			$restData['banner_image'] = getImagePath(explode(',', $get_restaurant['profile_image'])[0], 'restaurants/profile');
			$restData['phone'] = $get_restaurant['phone'];
			$restData['address'] = urldecode($get_restaurant['address']);
			$restData['opening_time'] = $get_restaurant['opening_time'];
			$restData['closing_time'] = $get_restaurant['closing_time'];
			$restData['latitude'] = $get_restaurant['latitude'];
			$restData['longitude'] = $get_restaurant['longitude'];
			$restData['average_price'] = $get_restaurant['average_price'];
			$restData['discount'] = $get_restaurant['discount'];
			$restData['discount_type'] = $get_restaurant['discount_type'];
			$restData['average_price'] = $get_restaurant['average_price'];
			$restData['is_available'] = $get_restaurant['is_available'];
			$get_categories = $this->categoryModel->select('c.*, s.id as subcategory_id, s.restaurant_id')->from(TBL_CATEGORIES . ' as c')->join(TBL_SUBCATEGORIES . ' as s', "s.category_id=c.id")->join(TBL_RESTAURANTS . ' as r', "r.id=s.restaurant_id")->where(['r.id=' => $restaurant_id, 's.status!=' => 9, 'c.status' => 1])->groupBy('c.id')->orderBy('c.title', 'ASC')->find();
			$catResponse = array();
			if (!empty($get_categories)) {
				foreach ($get_categories as $cats) {
					$catRes['category_name'] = urldecode($cats['title']);
					$catRes['category_id'] = $cats['id'];
					$get_subcat = $this->subcategoryModel->where(['category_id=' => $cats['id'], 'status!=' => 9, 'restaurant_id' => $restaurant_id])->find();
					$subcatResponse = array();
					if (!empty($get_subcat)) {
						foreach ($get_subcat as $subcat) {
							$subcatRes['id'] = $subcat['id'];
							$subcatRes['is_available'] = $subcat['status'];
							$subcatRes['name'] = urldecode($subcat['title']);
							$subcatRes['image'] = getImagePath($subcat['image'], 'subcategory');
							$subcatRes['price'] = $subcat['price'];
							$subcatRes['discount'] = $subcat['discount'];
							$subcatRes['discount_type'] = $subcat['discount_type'];
							$subcatRes['type'] = $subcat['type'];
							$subcatRes['description'] = urldecode($subcat['description']);

							$subcatResponse[] = $subcatRes;
						}
					}

					$catRes['subcategories'] = $subcatResponse;
					$catResponse[] = $catRes;
				}
			}

			$reviewResponse =  $this->getReviews($restaurant_id, 2);
			$restData['reviews'] = $reviewResponse;
			$restData['categories'] = $catResponse;

		}
		return $restData;
	}

	public function getReviews($restaurant_id, $limit=null) {
		$query =$this->restaurantReviewModel->select("rr.*, u.fullname, u.image, a.city as city_name")->from(TBL_RESTAURANT_REVIEW . ' as rr')->join(TBL_USERS . ' as u', 'u.id=rr.customer_id')->join(TBL_ORDERS . ' as o', 'o.id=rr.order_id')->join(TBL_ADDRESS . ' as a', 'a.id=o.address_id')->where(['rr.restaurant_id' => $restaurant_id, 'rr.status' => 1])->groupBy('rr.id')->orderBy('rr.id', "DESC");
		if($limit) {
			$query->limit($limit, 0);
		}
		$get_last_review = $query->find();
		$reviewResponse = array();
		if (!empty($get_last_review)) {
			foreach ($get_last_review as $rev) {
				$revRes['review'] = $rev['review'];
				$revRes['message'] = urldecode($rev['message']);
				$revRes['user_name'] = urldecode($rev['fullname']);
				$revRes['user_image'] = getImagePath($rev['image'], 'user');
				$revRes['city'] = urldecode($rev['city_name']);
				$revRes['date'] = date('d M, Y', strtotime($rev['created']));
				$reviewResponse[] = $revRes;
			}
		}
		return $reviewResponse;
	}

	protected function unlinkFile($image, $folder)
	{
		if ($image) {
			if (file_exists(FCPATH . 'public/uploads/' . $folder . '/' . $image)) {
				unlink(FCPATH . 'public/uploads/' . $folder . '/' . $image);
			}
		}
	}

}

<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DriversReviewModel;
use App\Models\UserAddressModel;
use App\Models\EarningModel;
use App\Models\DeliveryChargesModel;
use App\Models\OrderModel;

class webservices extends BaseController
{
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		parent::initController($request, $response, $logger);
		$this->addressModel = new UserAddressModel();
		$this->earningModel = new EarningModel();
		$this->OrderModel = new OrderModel();
	}
	public function index()
	{
		$this->load->view('index');
	}
	public function login()
	{
		header('Content-type: application/x-www-form-urlencoded');
		$requestData = $this->parseJson();
		$latitude = $requestData['latitude'];
		$longitude = $requestData['longitude'];
		$email = urlencode($requestData['email']);
		$password = $requestData['password'];
		$device_token = $requestData['device_token'];
		$printarray = array();
		try {
			$get_user =  $this->userModel->select('*')->where(array('email' => $email, 'password' => md5($password)))->first();
			if (!empty($get_user)) {
				$user_status = $get_user['status'];
				if ($user_status == 1) {
					$getDeviceTokens = $this->deviceTokenModel->where(['user_id' => $get_user['id']])->find();
					if (!empty($getDeviceTokens)) {
						foreach ($getDeviceTokens as $t) {
							$this->deviceTokenModel->update($t['id'], ['is_last_login' => 0]);
						}
					}
					$find_device_tokens = $this->deviceTokenModel->where(array('device_token' => $device_token))->first();
					if (!empty($find_device_tokens)) {
						$this->deviceTokenModel->update($find_device_tokens['id'], array('is_last_login' => 1, 'user_id' => $get_user['id']));
					} else {
						$insertTokenArr = array('user_id' => $get_user['id'], 'device_token' => $device_token);
						$this->deviceTokenModel->insert($insertTokenArr);
					}
					$this->userModel->update($get_user['id'], array('latitude' => $latitude, 'longitude' => $longitude));

					$getUserAddress = file_get_contents('https://maps.google.com/maps/api/geocode/json?latlng=' . trim($latitude) . ',' . trim($longitude) . '&key=' . $this->settings['map_api_key']);

					$addressData = json_decode($getUserAddress);
					$printarrayStatus = $addressData->status;


					$user['user_id'] = $get_user['id'];
					$user['name'] = urldecode($get_user['fullname']);
					$user['email'] = urldecode($get_user['email']);
					$user['profile_image'] = getImagePath($get_user['image'], 'user');
					$user['phone'] = $get_user['phone'];
					$user['address'] = "";
					if ($printarrayStatus == "OK") {
						$user['address'] = $addressData->results[0]->formatted_address;
					}
					$printarray['code'] = SUCCESS;
					$printarray['message'] = 'Success.';
					$printarray['result'] = $user;
				} else {
					$printarray['code'] = INACTIVE_ACCOUNT;
					$printarray['message'] = 'Your account is inactive.';
					$printarray['result'] = [];
				}
			} else {
				$printarray['code'] = NO_DATA;
				$printarray['message'] = "Invaid email or password.";
			}
		} catch (\Exception $e) {
			$printarray['code'] = 500;
			$printarray['message'] = $e->getMessage();
		}
		header('Content-type: application/json');
		echo json_encode($printarray);
	}
	public function registration()
	{
		header('Content-type: application/x-www-form-urlencoded');
		$requestData = $this->parseJson();
		$addArr['email'] = urlencode($requestData['email']);
		$addArr['password'] = md5($requestData['password']);
		$addArr['fullname'] = urlencode($requestData['name']);
		$addArr['phone'] = $requestData['phone'];
		$addArr['latitude'] = $requestData['latitude'];
		$addArr['longitude'] = $requestData['longitude'];
		$addArr['image'] = "";
		$addArr['token'] = substr(str_shuffle('abcdefghijklmnopqrstuvwxyz1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 6);
		$printarray = array();
		try {
			$get_user =  $this->userModel->select('id')->where(array('email' => $addArr['email'],  'is_social_login' => 0))->first();
			if (!empty($get_user)) {
				$printarray['code'] = EMAIL_EXIST;
				$printarray['message'] = 'Email id already exist.';
				$printarray['result'] = [];
			} else {
				$insert_id = $this->userModel->insert($addArr);
				if ($insert_id) {
					$device_token = $requestData['device_token'];
					$find_device_tokens = $this->deviceTokenModel->select('id')->where(array('device_token' => $device_token))->first();
					if (!empty($find_device_tokens)) {
						$this->deviceTokenModel->update($find_device_tokens['id'], array('is_last_login' => 1, 'user_id' => $insert_id));
					} else {
						$insertTokenArr = array('user_id' => $insert_id, 'device_token' => $device_token);
						$this->deviceTokenModel->insert($insertTokenArr);
					}
					$get_user =  $this->userModel->where(array('id' => $insert_id))->first();
					$getUserAddress = file_get_contents('https://maps.google.com/maps/api/geocode/json?latlng=' . trim($get_user['latitude']) . ',' . trim($get_user['longitude']) . '&key=' . $this->settings['map_api_key']);

					$addressData = json_decode($getUserAddress);
					$printarrayStatus = $addressData->status;

					$user['user_id'] = $get_user['id'];
					$user['name'] = urldecode($get_user['fullname']);
					$user['email'] = urldecode($get_user['email']);
					$user['profile_image'] = getImagePath($get_user['image'], 'user');
					$user['phone'] = $get_user['phone'];
					$user['address'] = "";
					if ($printarrayStatus == "OK") {
						$user['address'] = urldecode($addressData->results[0]->formatted_address);
					}
					$printarray['code'] = SUCCESS;
					$printarray['message'] = 'Success.';
					$printarray['result'] = $user;
				} else {
					$printarray['code'] = FAILURE;
					$printarray['message'] = 'Failure.';
					$printarray['result'] = [];
				}
			}
		} catch (\Exception $e) {
			$printarray['code'] = 500;
			$printarray['message'] = $e->getMessage();
		}
		header('Content-type: application/json');
		echo json_encode($printarray);
	}
	public function social_signin()
	{

		header('Content-type: application/x-www-form-urlencoded');
		$requestData = $this->parseJson();

		$device_token = $requestData['device_token'];
		$addArr['latitude'] = $requestData['latitude'];
		$addArr['longitude'] = $requestData['longitude'];
		$addArr['token'] = substr(str_shuffle('abcdefghijklmnopqrstuvwxyz1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 6);
		$addArr['social_id'] = $requestData['social_id'];
		$printarray = array();
		try {
			$get_user = $this->userModel->select('id')->where(['social_id' => $addArr['social_id']])->first();
			if (!empty($get_user)) {
				$update = $this->userModel->update($get_user['id'], $addArr);
			} else {
				$addArr['email'] = urlencode($requestData['email']);
				$addArr['fullname'] = urlencode($requestData['name']);
				$addArr['image'] = $requestData['profile_image'];
				$addArr['password'] = "";
				$addArr['phone'] = $requestData['phone'];
				$addArr['is_social_login'] = $requestData['is_social_login']; //1=>facebook, 2==>googge
				$update = $this->userModel->insert($addArr);
			}
			if ($update) {
				$insert_id = empty($get_user) ? $update : $get_user['id'];

				$get_user =  $this->userModel->where(array('id' => $insert_id))->first();

				$this->deviceTokenModel->where(['user_id' => $get_user['id']])->set(['is_last_login' => 0])->update();

				$find_device_tokens = $this->deviceTokenModel->where(array('device_token' => $device_token))->first();
				if (!empty($find_device_tokens)) {
					$this->deviceTokenModel->update($find_device_tokens['id'], array('is_last_login' => 1, 'user_id' => $get_user['id']));
				} else {
					$insertTokenArr = array('user_id' => $get_user['id'], 'device_token' => $device_token);
					$this->deviceTokenModel->insert($insertTokenArr);
				}

				$getUserAddress = file_get_contents('https://maps.google.com/maps/api/geocode/json?latlng=' . trim($get_user['latitude']) . ',' . trim($get_user['longitude']) . '&key=' . $this->settings['map_api_key']);

				$addressData = json_decode($getUserAddress);
				$printarrayStatus = $addressData->status;

				$user['user_id'] = $get_user['id'];
				$user['name'] = urldecode($get_user['fullname']);
				$user['email'] = urldecode($get_user['email']);
				$user['profile_image'] = getImagePath($get_user['image'], 'user');
				$user['phone'] = $get_user['phone'];
				$user['address'] = "";
				if ($printarrayStatus == "OK") {
					$user['address'] = $addressData->results[0]->formatted_address;
				}
				$printarray['code'] = SUCCESS;
				$printarray['message'] = 'Success.';
				$printarray['result'] = $user;
			} else {
				$printarray['code'] = FAILURE;
				$printarray['message'] = 'Failure.';
				$printarray['result'] = [];
			}
		} catch (\Exception $e) {
			$printarray['code'] = 500;
			$printarray['message'] = $e->getMessage();
		}
		header('Content-type: application/json');
		echo json_encode($printarray);
	}
	public function logout()
	{
		header('Content-type: application/x-www-form-urlencoded');
		$requestData = $this->parseJson();
		$user_id = $requestData['user_id'];
		$device_token = $requestData['device_token'];
		$printarray = array();
		try {
			$this->deviceTokenModel->where(['user_id' => $user_id, 'device_token' => $device_token])->set(['is_last_login' => 0])->update();
			$printarray['code'] = SUCCESS;
			$printarray['message'] = 'Logout successfully.';
		} catch (\Exception $e) {
			$printarray['code'] = 500;
			$printarray['message'] = $e->getMessage();
		}
		header('Content-type: application/json');
		echo json_encode($printarray);
	}
	public function forgot_password()
	{

		header('Content-type: application/x-www-form-urlencoded');
		$requestData = $this->parseJson();
		$email = $requestData['email'];
		$printarray = array();
		try {
			$get_user =  $this->userModel->select('status, id')->where(array('email' => urlencode($email), 'status=' => 1, 'is_social_login' => 0))->first();
			if (!empty($get_user)) {
				$password = substr(str_shuffle("ABCDEFGH1234567890IGHIJKLMNOPQ@!$%^&*RSTUVWXYZ"), 0, 8);
				$addArr['password'] = md5($password);
				$sendEmail = $this->sendMailToUser($get_user['id'],  $email, 1, $password);
				if ($sendEmail) {
					$update = $this->userModel->update($get_user['id'], $addArr);
					$printarray['code'] = SUCCESS;
					$printarray['message'] = 'Password successfully sent to your email id.';
				} else {
					$printarray['code'] = FAILURE;
					$printarray['message'] = 'Failure.';
				}
			} else {
				$printarray['code'] = EMAIL_EXIST;
				$printarray['message'] = 'Email does not exist.';
			}
		} catch (\Exception $e) {
			$printarray['code'] = 500;
			$printarray['message'] = $e->getMessage();
		}
		header('Content-type: application/json');
		echo json_encode($printarray);
	}
	public function home()
	{
		header('Content-type: application/x-www-form-urlencoded');
		$requestData = $this->parseJson();
		$lat = $requestData['latitude'];
		$long = $requestData['longitude'];
		try {
			$bannerResponse = $topResponse = $mealDealResponse = $popularResponse = $catResponse = $codeResponse = array();
			$get_banner_restaurants = $this->restaurantModel->select("r.id, r.name, r.profile_image, r.address, r.pincode, r.status as r_status, r.is_available, s.status as s_status, ct.status as ct_status,  c.status as c_status, s.name as state_name, ct.name as city_name, c.name as country_name, r.discount_type, r.discount, r.latitude, r.longitude, ( 3959 * acos( cos( radians(" . $lat . ") ) * cos( radians( r.latitude ) )  * cos( radians( r.longitude ) - radians(" . $long . ") ) + sin( radians(" . $lat . ") ) * sin(radians(r.latitude)) ) ) AS distance,  ROUND( AVG(rr.review),1 ) as review")->from(TBL_RESTAURANTS . ' as r')->join(TBL_STATE . ' as s', 's.id=r.state_id', 'INNER')->join(TBL_CITY . ' as ct', 'ct.id=r.city_id', 'INNER')->join(TBL_COUNTRY . ' as c', 'c.id=r.country_id', 'INNER')->join(TBL_RESTAURANT_REVIEW . ' as rr', 'rr.restaurant_id=r.id', 'LEFT')->groupBy('r.id')->having(["distance<=" => $this->settings['delivery_radius'], "r_status" => 1, "s_status" => 1, "ct_status" => 1, "c_status" => 1])->orderBy("distance", "ASC")->limit(5, 0)->find();
			if (!empty($get_banner_restaurants)) {
				foreach ($get_banner_restaurants as $row) {
					$bannerRes['id'] = $row['id'];
					$bannerRes['review'] = $row['review'];
					$bannerRes['is_available'] = $row['is_available'];
					$bannerRes['name'] = urldecode($row['name']);
					$bannerRes['image'] = getImagePath(explode(',', $row['profile_image'])[0], 'restaurants/profile');
					$bannerRes['address'] = urldecode($row['address']) . ',' . urldecode($row['city_name']);
					$bannerRes['discount'] = $row['discount'];
					$bannerRes['latitude'] = $row['latitude'];
					$bannerRes['longitude'] = $row['longitude'];
					$bannerRes['discount_type'] = $row['discount_type'];
					$bannerResponse[] = $bannerRes;
				}
			}

			$get_popular_restaurants = $this->restaurantModel->select("r.id, r.name, r.profile_image, r.address, r.pincode, r.status as r_status, r.is_available, s.status as s_status, ct.status as ct_status,  c.status as c_status, s.name as state_name, ct.name as city_name, c.name as country_name, r.discount_type, r.discount, r.latitude, r.longitude, ( 3959 * acos( cos( radians(" . $lat . ") ) * cos( radians( r.latitude ) )  * cos( radians( r.longitude ) - radians(" . $long . ") ) + sin( radians(" . $lat . ") ) * sin(radians(r.latitude)) ) ) AS distance, ROUND( AVG(rr.review),1 ) as review, COUNT(o.id) as total_orders")->from(TBL_RESTAURANTS . ' as r')->join(TBL_STATE . ' as s', 's.id=r.state_id', 'INNER')->join(TBL_CITY . ' as ct', 'ct.id=r.city_id', 'INNER')->join(TBL_COUNTRY . ' as c', 'c.id=r.country_id', 'INNER')->join(TBL_RESTAURANT_REVIEW . ' as rr', 'rr.restaurant_id=r.id', 'LEFT')->join(TBL_ORDERS . ' as o', 'o.restaurent_id=r.id', 'LEFT')->groupBy('r.id')->having(["distance<=" => $this->settings['delivery_radius'], "r_status" => 1, "s_status" => 1, "ct_status" => 1, "c_status" => 1])->orderBy("total_orders", "DESC")->limit(10, 0)->find();

			if (!empty($get_popular_restaurants)) {
				foreach ($get_popular_restaurants as $row) {
					$popRes['id'] = $row['id'];
					$popRes['review'] = $row['review'];
					$popRes['is_available'] = $row['is_available'];
					$popRes['name'] = urldecode($row['name']);
					$popRes['image'] = getImagePath(explode(',', $row['profile_image'])[0], 'restaurants/profile');
					$popRes['address'] = urldecode($row['address']) . ',' . urldecode($row['city_name']);
					$popRes['discount'] = $row['discount'];
					$popRes['latitude'] = $row['latitude'];
					$popRes['longitude'] = $row['longitude'];
					$popRes['discount_type'] = $row['discount_type'];
					$popularResponse[] = $popRes;
				}
			}


			$get_top_restaurants = $this->restaurantModel->select("r.id, r.name, r.profile_image, r.address, r.pincode, r.status as r_status, r.is_available, s.status as s_status, ct.status as ct_status,  c.status as c_status, s.name as state_name, ct.name as city_name, c.name as country_name, r.discount_type, r.discount, r.latitude, r.longitude, ( 3959 * acos( cos( radians(" . $lat . ") ) * cos( radians( r.latitude ) )  * cos( radians( r.longitude ) - radians(" . $long . ") ) + sin( radians(" . $lat . ") ) * sin(radians(r.latitude)) ) ) AS distance,  ROUND( AVG(rr.review),1 ) as review")->from(TBL_RESTAURANTS . ' as r')->join(TBL_STATE . ' as s', 's.id=r.state_id', 'INNER')->join(TBL_CITY . ' as ct', 'ct.id=r.city_id', 'INNER')->join(TBL_COUNTRY . ' as c', 'c.id=r.country_id', 'INNER')->join(TBL_RESTAURANT_REVIEW . ' as rr', 'rr.restaurant_id=r.id', 'LEFT')->groupBy('r.id')->having(["distance<=" => $this->settings['delivery_radius'], "r_status" => 1, "s_status" => 1, "ct_status" => 1, "c_status" => 1])->orderBy("distance", "ASC")->limit(15, 5)->find();
			if (!empty($get_top_restaurants)) {
				foreach ($get_top_restaurants as $row) {
					$topRes['id'] = $row['id'];
					$topRes['review'] = $row['review'];
					$topRes['name'] = urldecode($row['name']);
					$topRes['address'] = urldecode($row['address']) . ',' . urldecode($row['city_name']);
					$topRes['is_available'] = $row['is_available'];
					$topRes['image'] = getImagePath(explode(',', $row['profile_image'])[0], 'restaurants/profile');;
					$topRes['latitude'] = $row['latitude'];
					$topRes['longitude'] = $row['longitude'];
					$topResponse[] = $topRes;
				}
			}

			$mealDealResponse = $this->getMealDeals($lat, $long, array('start' => 0, 'limit' => 10));

			$catResponse  = $this->getCategories(10); 
			
			$current_date = date('Y-m-d');
			$get_codes =   $this->couponModel->select('c.*, ROUND(c.discount, 0) as discount')->from(TBL_COUPONS . ' as c')->where(array('c.status' => 1, 'c.end_date >= ' => $current_date))->groupBy('c.id')->orderBy('c.end_date', 'ASC')->limit(10, 0)->find();
			if (!empty($get_codes)) {

				foreach ($get_codes as $codes) {
					$codeRes['coupon_code'] = $codes['coupon_code'];
					$codeRes['image'] = getImagePath($codes['image'], 'coupons');;
					$codeRes['id'] = $codes['id'];
					$codeRes['description'] = urldecode($codes['description']);
					$codeRes['start_date'] = date('dS M, Y', strtotime($codes['start_date']));
					$codeRes['end_date'] = date('dS M, Y', strtotime($codes['end_date']));
					$codeRes['discount'] = $codes['discount'];
					$codeRes['discount_type'] = $codes['discount_type'];
					$codeResponse1[] = $codeRes;
				}
				$codeResponse = $codeResponse1;
			}

			$finalResponse['coupon_codes'] = $codeResponse;
			$finalResponse['categories'] = $catResponse;
			$finalResponse['bannerRestaurents'] = $bannerResponse;
			$finalResponse['topRestaurents'] = $topResponse;
			$finalResponse['popularRestaurents'] = $popularResponse;
			$finalResponse['mealDeal'] = $mealDealResponse;
			$printarray['code'] = SUCCESS;
			$printarray['message'] = 'Success.';
			$printarray['result'] = $finalResponse;
		} catch (\Exception $e) {
			$printarray['code'] = 500;
			$printarray['message'] = $e->getMessage();
		}
		header('Content-type: application/json');
		echo json_encode($printarray);
	}
	public function details()
	{
		header('Content-type: application/x-www-form-urlencoded');
		$requestData = $this->parseJson();
		$restaurant_id = $requestData['restaurant_id'];
		
		$restData = $this->getRestaurantDetails($restaurant_id);
		if(!empty($restData)){
			$printarray['code'] = SUCCESS;
			$printarray['message'] = 'Success.';
			$printarray['result'] = $restData;
		} else {
			$printarray['code'] = NO_DATA;
			$printarray['message'] = 'No Data Found.';
			$printarray['result'] = [];
		}
		header('Content-type: application/json');
		echo json_encode($printarray);
	}
	public function all_top_restaurants()
	{
		header('Content-type: application/x-www-form-urlencoded');
		$requestData = $this->parseJson();
		$lat = $requestData['latitude'];
		$long = $requestData['longitude'];
		$finalResponse = array();

		$get_top_restaurants = $this->restaurantModel->select("r.id, r.name, r.profile_image, r.address, r.pincode, r.status as r_status, r.is_available, s.status as s_status, ct.status as ct_status,  c.status as c_status, s.name as state_name, ct.name as city_name, c.name as country_name, r.discount_type, r.discount, r.latitude, r.longitude, ( 3959 * acos( cos( radians(" . $lat . ") ) * cos( radians( r.latitude ) )  * cos( radians( r.longitude ) - radians(" . $long . ") ) + sin( radians(" . $lat . ") ) * sin(radians(r.latitude)) ) ) AS distance,  ROUND( AVG(rr.review),1 ) as review")->from(TBL_RESTAURANTS . ' as r')->join(TBL_STATE . ' as s', 's.id=r.state_id', 'INNER')->join(TBL_CITY . ' as ct', 'ct.id=r.city_id', 'INNER')->join(TBL_COUNTRY . ' as c', 'c.id=r.country_id', 'INNER')->join(TBL_RESTAURANT_REVIEW . ' as rr', 'rr.restaurant_id=r.id', 'LEFT')->groupBy('r.id')->having(["distance<=" => $this->settings['delivery_radius'], "r_status" => 1, "s_status" => 1, "ct_status" => 1, "c_status" => 1])->orderBy("distance", "ASC")->find();
		if (!empty($get_top_restaurants)) {
			foreach ($get_top_restaurants as $row) {
				$res['id'] = $row['id'];
				$res['review'] = $row['review'];
				$res['is_available'] = $row['is_available'];
				$res['name'] = urldecode($row['name']);
				$res['image'] = getImagePath(explode(',', $row['profile_image'])[0], 'restaurants/profile');
				$res['address'] = urldecode($row['address']) . ',' . urldecode($row['city_name']);
				$res['discount'] = $row['discount'];
				$res['latitude'] = $row['latitude'];
				$res['longitude'] = $row['longitude'];
				$res['discount_type'] = $row['discount_type'];

				$finalResponse[] = $res;
			}
		}
		$printarray['code'] = SUCCESS;
		$printarray['message'] = 'Success.';
		$printarray['result'] = $finalResponse;

		header('Content-type: application/json');
		echo json_encode($printarray);
	}
	public function mealDeal($cat_id = null)
	{
		header('Content-type: application/x-www-form-urlencoded');
		$requestData = $this->parseJson();
		$lat = $requestData['latitude'];
		$long = $requestData['longitude'];
		$filter = array();
		if ($cat_id) {
			$filter['category_id'] =  $cat_id;
		}
		$finalResponse = $this->getMealDeals($lat, $long, $filter);
		$printarray['code'] = SUCCESS;
		$printarray['message'] = 'Success.';
		$printarray['result'] = $finalResponse;
		header('Content-type: application/json');
		echo json_encode($printarray);
	}
	public function notifications()
	{
		header('Content-type: application/x-www-form-urlencoded');
		$requestData = $this->parseJson();
		$user_id = $requestData['user_id'];
		try {
			$list =  $this->notificationModel->where('status', 1)->groupStart()->where('user_id', 0)->orWhere('user_id', $user_id)->groupEnd()->orderBy('id', 'DESC')->find();
			$Notifications = array();
			if (count($list) > 0 && !empty($list)) {

				foreach ($list as $lists) {

					$notification['title'] = urldecode($lists['title']);
					$notification['description'] = urldecode($lists['description']);
					$notification['type'] = $lists['type'];
					$notification['type_id'] = $lists['type_id'];
					$notification['date'] = date('d-m-Y h:i a', strtotime($lists['created']));
					$Notifications[] = $notification;
				}
				$printarray['code'] = SUCCESS;
				$printarray['message'] = 'Success.';
				$printarray['result'] = $Notifications;
			} else {
				$printarray['code'] = NO_DATA;
				$printarray['message'] = 'No Record Found.';
			}
		} catch (\Exception $e) {
			$printarray['code'] = 500;
			$printarray['message'] = $e->getMessage();
		}
		header('Content-type: application/json');
		echo json_encode($printarray);
	}
	public function profile()
	{

		header('Content-type: application/x-www-form-urlencoded');
		$requestData = $this->parseJson();
		$user_id = $requestData['user_id'];
		$get_user =  $this->getProfileData($user_id);

		if (!empty($get_user)) {

			$ordResponse = $this->getMyOrdersList($user_id, null, 5);
			$get_user['orders'] = $ordResponse;
			$get_user['total_orders'] = strval($this->getMyOrdersList($user_id, null, null, true));
			$printarray['code'] = SUCCESS;
			$printarray['message'] = 'Success.';
			$printarray['result'] = $get_user;
		} else {
			$printarray['code'] = NO_DATA;
			$printarray['message'] = 'No Data Found.';
			$printarray['result'] = [];
		}
		header('Content-type: application/json');
		echo json_encode($printarray);
	}
	public function add_user_address()
	{
		header('Content-type: application/x-www-form-urlencoded');
		$requestData = $this->parseJson();
		$addArr['user_id'] = $requestData['user_id'];
		$addArr['name'] = urlencode($requestData['name']);
		$addArr['phone'] = $requestData['phone'];
		$addArr['address_line_1'] = urlencode($requestData['address_line_1']);
		$addArr['address_line_2'] = urlencode($requestData['address_line_2']);
		$addArr['pincode'] = $requestData['pincode'];
		$addArr['latitude'] = $requestData['latitude'];
		$addArr['longitude'] = $requestData['longitude'];
		$addArr['city'] = urlencode($requestData['city']);
		$addArr['state'] = urlencode($requestData['state']);
		$addArr['country'] = urlencode($requestData['country']);
		$addArr['isDefault'] = $requestData['isDefault'];
		$addArr['address_type'] = $requestData['address_type'];
		$get_address =  $this->addressModel->select('id')->where(array('latitude' => $addArr['latitude'], 'status!=' => 2, 'longitude' => $addArr['longitude'], 'user_id' => $addArr['user_id']))->first();
		if (!empty($get_address)) {
			$printarray['code'] = EMAIL_EXIST;
			$printarray['message'] = 'Address already exist.';
			$printarray['result'] = [];
		} else {
			$insert = $this->addressModel->insert($addArr);
			if ($insert) {
				$printarray['code'] = SUCCESS;
				$printarray['message'] = 'Success.';
				$printarray['result'] = [];
			} else {
				$printarray['code'] = FAILURE;
				$printarray['message'] = 'Failure.';
				$printarray['result'] = [];
			}
		}
		header('Content-type: application/json');
		echo json_encode($printarray);
	}
	public function get_user_address()
	{
		header('Content-type: application/x-www-form-urlencoded');
		$requestData = $this->parseJson();
		$user_id = $requestData['user_id'];
		$finalResponse = array();
		$get_address =  $this->addressModel->where(['status=' => 1, 'user_id' => $user_id])->orderBy('id', 'desc')->find();
		if (!empty($get_address)) {
			foreach ($get_address as $row) {
				$res['id'] = $row['id'];
				$res['name'] = urldecode($row['name']);
				$res['phone'] = $row['phone'];
				$res['address_line_1'] = urldecode($row['address_line_1']);
				$res['address_line_2'] = urldecode($row['address_line_2']);
				$res['pincode'] = $row['pincode'];
				$res['latitude'] = $row['latitude'];
				$res['longitude'] = $row['longitude'];
				$res['city'] = urldecode($row['city']);
				$res['state'] = urldecode($row['state']);
				$res['country'] = urldecode($row['country']);
				$res['isDefault'] = $row['isDefault'];
				$res['address_type'] = $row['address_type'];
				$finalResponse[] = $res;
			}
		}
		$printarray['code'] = SUCCESS;
		$printarray['message'] = 'Success.';
		$printarray['result'] = $finalResponse;
		header('Content-type: application/json');
		echo json_encode($printarray);
	}
	function delete_address()
	{
		header('Content-type: application/x-www-form-urlencoded');
		$requestData = $this->parseJson();
		$address_id = $requestData['address_id'];
		$get_address =  $this->addressModel->select('id')->where(array('status!=' => 2,  'id' => $address_id))->first();
		if (empty($get_address)) {
			$printarray['code'] = EMAIL_EXIST;
			$printarray['message'] = 'Address not found.';
			$printarray['result'] = [];
		} else {
			$update = $this->addressModel->update($address_id, array('status' => 2));
			if ($update) {
				$printarray['code'] = SUCCESS;
				$printarray['message'] = 'Success.';
				$printarray['result'] = [];
			} else {
				$printarray['code'] = FAILURE;
				$printarray['message'] = 'Failure.';
				$printarray['result'] = [];
			}
		}
		header('Content-type: application/json');
		echo json_encode($printarray);
	}
	function orders_list()
	{
		header('Content-type: application/x-www-form-urlencoded');
		$requestData = $this->parseJson();
		$user_id = $requestData['user_id'];
		$get_data =  $this->getMyOrdersList($user_id);
		if (!empty($get_data)) {
			$printarray['code'] = SUCCESS;
			$printarray['message'] = 'Success.';
			$printarray['result'] = $get_data;
		} else {

			$printarray['code'] = NO_DATA;
			$printarray['message'] = 'No Data Found.';
			$printarray['result'] = [];
		}
		header('Content-type: application/json');
		echo json_encode($printarray);
	}
	function order_details()
	{
		header('Content-type: application/x-www-form-urlencoded');
		$requestData = $this->parseJson();
		$order_id = $requestData['order_id'];
		$get_order =  $this->getOrderDetails($order_id);
		if (!empty($get_order)) {
			$printarray['code'] = SUCCESS;
			$printarray['message'] = 'Success.';
			$printarray['result'] = $get_order;
		} else {
			$printarray['code'] = NO_DATA;
			$printarray['message'] = 'No Data Found.';
			$printarray['result'] = [];
		}
		header('Content-type: application/json');
		echo json_encode($printarray);
	}
	function add_order($isWeb = null)
	{
		header('Content-type: application/x-www-form-urlencoded');
		$requestData = $this->parseJson();
		$printarray = array();
		try {
			$getUserData = $this->userModel->where(array('id' => $requestData['user_id']))->first();
// 		
			if (isset($requestData['address_id']) && $requestData['address_id']!='') {
				$getAddressData = $this->addressModel->where(array('id' => $requestData['address_id']))->first();
				$addArr['address_id'] = $requestData['address_id'];
				$addArr['address'] = $getAddressData['address_line_1'] . '+' . $getAddressData['address_line_2'];
				$addArr['city'] = $getAddressData['city'];
				$addArr['state'] = $getAddressData['state'];
				$addArr['pincode'] = $getAddressData['pincode'];
				$addArr['latitude'] = $getAddressData['latitude'];
				$addArr['longitude'] = $getAddressData['longitude'];
				$addArr['name'] = $getAddressData['name'];
				$addArr['phone'] = $getAddressData['phone'];
			} else {
				$addArr['address_id'] = 0;
				$addArr['address'] = urlencode($requestData['address']);
				$addArr['city'] = urlencode($requestData['city']);
				$addArr['state'] = urlencode($requestData['state']);
				$addArr['pincode'] = $requestData['pincode'];
				$addArr['latitude'] = $requestData['latitude'];
				$addArr['longitude'] = $requestData['longitude'];
				$addArr['name'] = urlencode($requestData['name']);
				$addArr['phone'] = $requestData['phone'];
			}
			
				
			if ($requestData['token_id'] != "" && $requestData['payment_type'] == 2 && $requestData['total_price'] > 0) {
				require_once APPPATH . "ThirdParty/stripe/init.php";
				$stripe = array(
					"secret_key"      => $this->settings['stripe_private_key'],
					"publishable_key" => $this->settings['stripe_publish_key']
				);
				$stripe = new \Stripe\StripeClient($stripe['secret_key']);

				$customer = $stripe->customers->create(
					array(
						'name' => urldecode($getUserData['fullname']),
						'source' => $requestData['token_id']
					)
				);
				$charge = $stripe->charges->create(
					[
						"amount" => $requestData['total_price'] * 100,
						"currency" => "USD",
						"receipt_email" => urldecode($getUserData['email']),
						"description" => "Order from " . urldecode($this->settings['website_name']),
						'customer' => $customer->id,
					]
				);
			} elseif ($requestData['token_id'] != "" && $requestData['payment_type'] == 3 && $requestData['total_price'] > 0) {
				$gateway = new \Braintree\Gateway([
					'environment' => $this->settings['braintree_environment'],
					'merchantId' => $this->settings['braintree_merchant_id'],
					'publicKey' => $this->settings['braintree_public_key'],
					'privateKey' => $this->settings['braintree_private_key']
				]);
				$paypalResult = $gateway->transaction()->sale([
					'amount' => $requestData['total_price'],
					'paymentMethodNonce' => $requestData['token_id'],
					"deviceData" => uniqid(),
					'options' => ['submitForSettlement' => true]
				]);
			} elseif ( $requestData['payment_type'] == 6 && $requestData['total_price'] > 0) {
			    
        				
        				$cbk =  $this->request($requestData['total_price'], uniqid(), "abc");
        				// print_r($cbk);exit;
        				
			} 
			
			
			if ((isset($charge) && !empty($charge)) || (isset($paypalResult) && !empty($paypalResult->success))  || $requestData['payment_type'] == 1 || $requestData['total_price'] == '0.00' || $requestData['payment_type'] == 4 || $requestData['payment_type'] == 5 || $requestData['payment_type'] == 6) {
				$grand_total = (float)$requestData['total_price'] + (float)$requestData['discount_price'] + (float)$requestData['wallet_price'];
				$addArr['user_id'] = $requestData['user_id'];
				$addArr['restaurent_id'] = $requestData['restaurent_id'];
				$addArr['total_price'] = $requestData['total_price'];
				$addArr['tip_price'] = $requestData['tip_price'];
				$addArr['admin_charge'] = $requestData['admin_charge'];
				$addArr['discount_price'] = $requestData['discount_price'];
				$addArr['wallet_price'] = $requestData['wallet_price'];
				$addArr['promo_code'] = $requestData['promo_code'];
				$addArr['grand_total'] = $grand_total;
				$addArr['payment_type'] = $requestData['payment_type'];
				$addArr['payment_status'] = 1;
					if($requestData['payment_type'] == 6)
					{
					    $addArr['payment_status'] = 0;
					}
				
				$insert_id = $this->orderModel->insert($addArr);
				if ($insert_id) {
					if ($requestData['wallet_price'] > 0) {
						$updated_amount = (float)$getUserData['wallet_amount'] - (float)$requestData['wallet_price'];
						$this->userModel->update($requestData['user_id'], array('wallet_amount' => $updated_amount));
					}
					$addNotification = array();
					$addNotification['title'] = urlencode("Order Placed");
					$addNotification['Description'] = urlencode("Your order has been placed successfully.");
					$addNotification['type'] = "1";
					$addNotification['type_id'] = $insert_id;
					$addNotification['user_id'] = $requestData['user_id'];
					$notification_id = $this->notificationModel->insert($addNotification);
					$this->sendPushNotification($requestData['user_id'], $notification_id);
					$getOwner =  $this->restaurantModel->select('owner_id')->where(array('id' => $requestData['restaurent_id'], 'status' => 1))->first();
					$ownerNotification = array();
					$ownerNotification['title'] = urlencode("Order Received");
					$ownerNotification['Description'] = urlencode("Congratulations!!, You received new order.");
					$ownerNotification['type'] = "3";
					$ownerNotification['type_id'] = $insert_id;
					$ownerNotification['user_id'] = $getOwner['owner_id'];
					$notification_id = $this->notificationModel->insert($ownerNotification);
					$this->sendPushNotification($getOwner['owner_id'], $notification_id, 'owners');
					if ($isWeb) {
						$order_details = cart()->contents();
						foreach ($order_details as $oData) {
							$addArrO = array();
							$addArrO['product_id'] = $oData['id'];
							$addArrO['product_price'] = $oData['discount_price'];
							$addArrO['extra_note'] = $oData['extra_note'];
							$addArrO['product_quantity'] = $oData['qty'];
							$addArrO['order_id'] = $insert_id;
							$this->orderDetailsModel->insert($addArrO);
						}
						cart()->destroy();
					} else {
						$order_details = $requestData['ProductDetails'];
						foreach ($order_details as $oData) {
							$addArrO = array();
							$addArrO['product_id'] = $oData['product_id'];
							$addArrO['product_price'] = $oData['product_price'];
							$addArrO['extra_note'] = $oData['extra_note'];
							$addArrO['product_quantity'] = $oData['product_quantity'];
							$addArrO['order_id'] = $insert_id;
							$this->orderDetailsModel->insert($addArrO);
						}
					}
					$addEarn = array();
					$total_payable = $grand_total - 20 - $requestData['tip_price'];
					$addEarn['total_amount'] = $grand_total;
					$addEarn['owners_amount'] = $total_payable - (($this->settings['charge_from_owner'] / 100) * $total_payable);
					$addEarn['admin_charge_amount'] = ($this->settings['charge_from_owner'] / 100) * $total_payable;
					$addEarn['order_id'] = $insert_id;
					$addEarn['restaurent_id'] = $requestData['restaurent_id'];
					$this->earningModel->insert($addEarn);
					$getOrderInfo = $this->getOrderDetails($insert_id);
					$this->create_invoice_pdf($getOrderInfo);
					
					$printarray['code'] = SUCCESS;
					$printarray['message'] = 'Success.';
					$printarray['result'] = ['order_id' => $insert_id];
					if($requestData['payment_type'] == 6)
					{
					    
					    $printarray['result'] = ['order_id' => $insert_id,'data'=>$cbk];
					}
					
					
					
				} else {
					$printarray['code'] = FAILURE;
					$printarray['message'] = 'Failure.';
					$printarray['result'] = [];
				}
			} else {
				$printarray['code'] = FAILURE;
				$printarray['message'] = 'Failure.';
				$printarray['result'] = [];
			}
		} catch (\Exception $e) {
			$printarray['code'] = 500;
			$printarray['message'] = $e->getMessage();
		}

		header('Content-type: application/json');
		echo json_encode($printarray);
	}
	public function updateProfile()
	{
		header('Content-type: application/x-www-form-urlencoded');
		$requestData = $this->parseJson();
		try {
			$addArr['fullname'] = urlencode($requestData['fullname']);
			$addArr['phone'] = $requestData['phone'];
			if ($requestData['image']) {
				$image_base64 = base64_decode($requestData['image']);
				$file_name = uniqid() . '.png';
				$file = FCPATH . 'public/uploads/user/' . $file_name;
				file_put_contents($file, $image_base64);
				$addArr['image'] = $file_name;
			}
			$get_user =  $this->userModel->select('id')->where(array('id' => $requestData['user_id'], 'status!=' => 2))->first();
			if (!empty($get_user)) {
				$update = $this->userModel->update($requestData['user_id'], $addArr);
				if ($update) {
					$get_user =  $this->userModel->where(array('id' => $requestData['user_id']))->first();
					$user['user_id'] = $get_user['id'];
					$user['name'] = urldecode($get_user['fullname']);
					$user['email'] = urldecode($get_user['email']);
					$user['profile_image'] = getImagePath($get_user['image'], 'user');
					$user['phone'] = $get_user['phone'];
					$printarray['code'] = SUCCESS;
					$printarray['message'] = 'Success.';
					$printarray['result'] = $user;
				} else {
					$printarray['code'] = FAILURE;
					$printarray['message'] = 'Failure.';
					$printarray['result'] = [];
				}
			} else {
				$printarray['code'] = FAILURE;
				$printarray['message'] = 'Invalid id.';
				$printarray['result'] = [];
			}
		} catch (\Exception $e) {
			$printarray['code'] = 500;
			$printarray['message'] = $e->getMessage();
		}

		header('Content-type: application/json');
		echo json_encode($printarray);
	}
	public function most_polupar_restaurants()
	{
		header('Content-type: application/x-www-form-urlencoded');
		$requestData = $this->parseJson();
		$lat = $requestData['latitude'];
		$long = $requestData['longitude'];
		try {
			$finalResponse = array();
			$get_top_restaurants = $this->restaurantModel->select("r.id, r.name, r.profile_image, r.address, r.pincode, r.status as r_status, r.is_available, s.status as s_status, ct.status as ct_status,  c.status as c_status, s.name as state_name, ct.name as city_name, c.name as country_name, r.discount_type, r.discount, r.latitude, r.longitude, ( 3959 * acos( cos( radians(" . $lat . ") ) * cos( radians( r.latitude ) )  * cos( radians( r.longitude ) - radians(" . $long . ") ) + sin( radians(" . $lat . ") ) * sin(radians(r.latitude)) ) ) AS distance, ROUND( AVG(rr.review),1 ) as review, COUNT(o.id) as total_orders")->from(TBL_RESTAURANTS . ' as r')->join(TBL_STATE . ' as s', 's.id=r.state_id', 'INNER')->join(TBL_CITY . ' as ct', 'ct.id=r.city_id', 'INNER')->join(TBL_COUNTRY . ' as c', 'c.id=r.country_id', 'INNER')->join(TBL_RESTAURANT_REVIEW . ' as rr', 'rr.restaurant_id=r.id', 'LEFT')->join(TBL_ORDERS . ' as o', 'o.restaurent_id=r.id', 'LEFT')->groupBy('r.id')->having(["distance<=" => $this->settings['delivery_radius'], "r_status" => 1, "s_status" => 1, "ct_status" => 1, "c_status" => 1])->orderBy("total_orders", "DESC")->find();
			if (!empty($get_top_restaurants)) {
				foreach ($get_top_restaurants as $row) {
					$res['id'] = $row['id'];
					$res['review'] = $row['review'];
					$res['is_available'] = $row['is_available'];
					$res['name'] = urldecode($row['name']);
					$res['image'] = getImagePath(explode(',', $row['profile_image'])[0], 'restaurants/profile');
					$res['address'] = urldecode($row['address']) . ',' . urldecode($row['city_name']);
					$res['discount'] = $row['discount'];
					$res['latitude'] = $row['latitude'];
					$res['longitude'] = $row['longitude'];
					$res['discount_type'] = $row['discount_type'];

					$finalResponse[] = $res;
				}
			}
			$printarray['code'] = SUCCESS;
			$printarray['message'] = 'Success.';
			$printarray['result'] = $finalResponse;
		} catch (\Exception $e) {
			$printarray['code'] = 500;
			$printarray['message'] = $e->getMessage();
		}
		header('Content-type: application/json');
		echo json_encode($printarray);
	}
	public function search()
	{
		header('Content-type: application/x-www-form-urlencoded');
		try {
			$requestData = $this->parseJson();
			$search_keyword = trim(strtolower($requestData['search_keyword']));
			$bannerResponse = $mealDealResponse = array();
			$get_banner_restaurants = $this->restaurantModel->select("r.id, r.name, r.profile_image, r.address, r.pincode, s.name as state_name, ct.name as city_name, c.name as country_name, r.discount_type, r.discount, r.latitude, r.longitude, ROUND( AVG(rr.review),1 ) as review, r.is_available")->from(TBL_RESTAURANTS . ' as r')->join(TBL_STATE . ' as s', 's.id=r.state_id', 'INNER')->join(TBL_CITY . ' as ct', 'ct.id=r.city_id', 'INNER')->join(TBL_COUNTRY . ' as c', 'c.id=r.country_id', 'INNER')->join(TBL_RESTAURANT_REVIEW . ' as rr', 'rr.restaurant_id=r.id', 'LEFT')->where(array('r.status=' => 1, 's.status' => 1, 'ct.status' => 1, 'c.status' => 1))->groupStart()->like("LOWER(r.name)", urlencode($search_keyword))->groupEnd()->groupBy("r.id")->find();
			if (!empty($get_banner_restaurants)) {
				foreach ($get_banner_restaurants as $row) {
					$bannerRes['id'] = $row['id'];
					$bannerRes['review'] = $row['review'];
					$bannerRes['is_available'] = $row['is_available'];
					$bannerRes['name'] = urldecode($row['name']);
					$bannerRes['image'] = getImagePath(explode(',', $row['profile_image'])[0], 'restaurants/profile');
					$bannerRes['address'] = urldecode($row['address']) . ',' . urldecode($row['city_name']);
					$bannerRes['discount'] = $row['discount'];
					$bannerRes['latitude'] = $row['latitude'];
					$bannerRes['longitude'] = $row['longitude'];
					$bannerRes['discount_type'] = $row['discount_type'];

					$bannerResponse[] = $bannerRes;
				}
			}
			$get_mealdela = $this->subcategoryModel->select("r.id, r.latitude, r.longitude, f.title, f.image, r.address, f.discount_type, f.discount, f.price, r.name as restaurant_name, f.status as f_status, r.is_available")->from(TBL_SUBCATEGORIES . ' as f')->join(TBL_RESTAURANTS . ' as r', "r.id=f.restaurant_id")->join(TBL_STATE . ' as s', 's.id=r.state_id', 'INNER')->join(TBL_CITY . ' as ct', 'ct.id=r.city_id', 'INNER')->join(TBL_COUNTRY . ' as c', 'c.id=r.country_id', 'INNER')->where(array('r.status=' => 1,  's.status' => 1, 'ct.status' => 1, 'c.status' => 1))->groupStart()->like("LOWER(f.title)", urlencode($search_keyword))->groupEnd()->groupBy('f.id')->find();
			if (!empty($get_mealdela)) {
				foreach ($get_mealdela as $row) {
					$mealRes['id'] = $row['id'];
					$mealRes['name'] = urldecode($row['title']);
					$mealRes['is_available'] = $row['is_available'];
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
			$finalResponse['restaurents'] = $bannerResponse;
			$finalResponse['mealDeal'] = $mealDealResponse;
			$printarray['code'] = SUCCESS;
			$printarray['message'] = 'Success.';
			$printarray['result'] = $finalResponse;
		} catch (\Exception $e) {
			$printarray['code'] = 500;
			$printarray['message'] = $e->getMessage();
		}
		header('Content-type: application/json');
		echo json_encode($printarray);
	}
	function get_braintree_token()
	{
		header('Content-type: application/x-www-form-urlencoded');
		$requestData = $this->parseJson();
		$user_id = $requestData['user_id'];
		try {
			$printarray = array();
			$gateway = new \Braintree\Gateway([
				'environment' => $this->settings['braintree_environment'],
				'merchantId' => $this->settings['braintree_merchant_id'],
				'publicKey' => $this->settings['braintree_public_key'],
				'privateKey' => $this->settings['braintree_private_key']
			]);
			$result = $gateway->customer()->create([
				'firstName' => $user_id
			]);;
			if ($result->success) {
				$aCustomerId = $result->customer->id;

				if ($aCustomerId != "") {
					$clientToken = $gateway->clientToken()->generate([
						"customerId" => $aCustomerId
					]);
				} else {
					$clientToken = $gateway->clientToken()->generate();
				}
				$printarray['code'] = SUCCESS;
				$printarray['message'] = 'Success.';
				$printarray['result'] = $clientToken;
			} else {
				$printarray['code'] = FAILURE;
				$printarray['message'] = 'Error.';
			}
		} catch (\Exception $e) {
			$printarray['code'] = 500;
			$printarray['message'] = $e->getMessage();
		}
		header('Content-type: application/json');
		echo json_encode($printarray);
	}
	public function add_driver_review()
	{
		header('Content-type: application/x-www-form-urlencoded');
		try {
			$requestData = $this->parseJson();
			$addArr['customer_id'] = $requestData['customer_id'];
			$addArr['order_id'] = $requestData['order_id'];
			$addArr['review'] = $requestData['review'];
			$addArr['message'] = urlencode($requestData['message']);
			$addArr['driver_id'] = $requestData['driver_id'];
			$driverReviewModel = new DriversReviewModel();
			$get_data =  $driverReviewModel->select('id')->where(array('order_id' => $addArr['order_id'],  'customer_id' => $addArr['customer_id'], 'driver_id' => $addArr['driver_id']))->find();
			if (!empty($get_data)) {
				$printarray['code'] = EMAIL_EXIST;
				$printarray['message'] = 'Review already exist.';
				$printarray['result'] = [];
			} else {
				$insert = $driverReviewModel->insert($addArr);
				if ($insert) {
					$printarray['code'] = SUCCESS;
					$printarray['message'] = 'Success.';
					$printarray['result'] = [];
				} else {
					$printarray['code'] = FAILURE;
					$printarray['message'] = 'Failure.';
					$printarray['result'] = [];
				}
			}
		} catch (\Exception $e) {
			$printarray['code'] = 500;
			$printarray['message'] = $e->getMessage();
		}
		header('Content-type: application/json');
		echo json_encode($printarray);
	}
	public function add_restaurant_review()
	{
		header('Content-type: application/x-www-form-urlencoded');
		try {
			$requestData = $this->parseJson();
			$addArr['customer_id'] = $requestData['customer_id'];
			$addArr['order_id'] = $requestData['order_id'];
			$addArr['review'] = $requestData['review'];
			$addArr['message'] = urlencode($requestData['message']);
			$addArr['restaurant_id'] = $requestData['restaurant_id'];
			
			$get_data =  $this->restaurantReviewModel->select('id')->where(array('order_id' => $addArr['order_id'], 'status!=' => 2, 'customer_id' => $addArr['customer_id'], 'restaurant_id' => $addArr['restaurant_id']))->first();
			if (!empty($get_data)) {
				$printarray['code'] = EMAIL_EXIST;
				$printarray['message'] = 'Review already exist.';
				$printarray['result'] = [];
			} else {
				$insert = $this->restaurantReviewModel->insert($addArr);
				if ($insert) {

					$this->orderModel->update($requestData['order_id'], array('isReviewed' => 1));
					$printarray['code'] = SUCCESS;
					$printarray['message'] = 'Success.';
					$printarray['result'] = [];
				} else {
					$printarray['code'] = FAILURE;
					$printarray['message'] = 'Failure.';
					$printarray['result'] = [];
				}
			}
		} catch (\Exception $e) {
			$printarray['code'] = 500;
			$printarray['message'] = $e->getMessage();
		}
		header('Content-type: application/json');
		echo json_encode($printarray);
	}
	public function get_driver_location()
	{
		header('Content-type: application/x-www-form-urlencoded');
		try {
			$requestData = $this->parseJson();
			$driver_id = $requestData['driver_id'];
			$get_user =  $this->userModel->select("id, latitude, longitude")->where(array('id' => $driver_id, 'status' => 1))->first();
			if (!empty($get_user)) {
				$user['driver_id'] = $get_user['id'];
				$user['latitude'] = $get_user['latitude'];
				$user['longitude'] = $get_user['longitude'];

				$printarray['code'] = SUCCESS;
				$printarray['message'] = 'Success.';
				$printarray['result'] = $user;
			} else {

				$printarray['code'] = NO_DATA;
				$printarray['message'] = 'No Data Found.';
				$printarray['result'] = [];
			}
		} catch (\Exception $e) {
			$printarray['code'] = 500;
			$printarray['message'] = $e->getMessage();
		}
		header('Content-type: application/json');
		echo json_encode($printarray);
	}
	public function get_order_status()
	{
		header('Content-type: application/x-www-form-urlencoded');
		try {
			$requestData = $this->parseJson();
			$order_id = $requestData['order_id'];
			$get_data =  $this->orderModel->select('order_status')->where(array('id' => $order_id, 'status' => 1))->first();
			if (!empty($get_data)) {
				$get_driver = $this->driverOrderModel->select(" d.fullname, d.image, ROUND( AVG(dr.review),1 ) as review, d.phone")->from(TBL_ORDER_DRIVERS . " as od")->join(TBL_USERS . " as d","d.id = od.driver_id")->join(TBL_DRIVER_REVIEW . " as dr", "dr.driver_id = d.id")->where(["od.order_id"=>$order_id, "od.driver_status"=>1])->groupBy('od.id')->first();
				$driver_detail =(object)[];
				if (!empty($get_driver)) {
					$driver_detail['name'] = urldecode($get_driver['fullname']);
					$driver_detail['image'] = getImagePath($get_driver['image'], 'user');;
					$driver_detail['review'] = $get_driver['review'];
					$driver_detail['phone'] = $get_driver['phone'];
				}
				$user['order_status'] = $get_data['order_status'];
				$user['driver_details']  = $driver_detail;
				$printarray['code'] = SUCCESS;
				$printarray['message'] = 'Success.';
				$printarray['result'] = $user;
			} else {

				$printarray['code'] = NO_DATA;
				$printarray['message'] = 'No Data Found.';
				$printarray['result'] = [];
			}
		} catch (\Exception $e) {
			$printarray['code'] = 500;
			$printarray['message'] = $e->getMessage();
		}
		header('Content-type: application/json');
		echo json_encode($printarray);
	}
	public function cancel_order()
	{
		header('Content-type: application/x-www-form-urlencoded');
		try {
			$requestData = $this->parseJson();
			$order_id = $requestData['order_id'];
			$wallet_amount = 0;
			$get_data =  $this->orderModel->select('user_id, id, total_price, payment_type')->where(array('id' => $order_id, 'status' => 1))->first();
			if (!empty($get_data)) {
				if ($get_data['payment_type'] != 1) {
					$cancel_charge = ($get_data['total_price'] * $this->settings['cancellation_charge']) / 100;
					$wallet_amount = $get_data['total_price'] - $cancel_charge;
					$user_data =  $this->userModel->select('id, wallet_amount')->where(array('id' => $get_data->user_id, 'status' => 1))->first();
					$updated_amount = $wallet_amount + $user_data['wallet_amount'];
					$this->userModel->update($user_data['id'], array('wallet_amount' => $updated_amount));
				}
				$this->orderModel->update($get_data['id'], array('order_status' => 9, 'refund_amount' => $wallet_amount));
				$this->earningModel->where(['user_id' => $order_id])->set(['status' => 9])->update();
				$printarray['code'] = SUCCESS;
				$printarray['message'] = 'Success.';
				$printarray['result'] = [];
			} else {
				$printarray['code'] = NO_DATA;
				$printarray['message'] = 'Invalid order ID';
				$printarray['result'] = [];
			}
		} catch (\Exception $e) {
			$printarray['code'] = 500;
			$printarray['message'] = $e->getMessage();
		}
		header('Content-type: application/json');
		echo json_encode($printarray);
	}
	public function get_all_review()
	{
		header('Content-type: application/x-www-form-urlencoded');
		try {
			$requestData = $this->parseJson();
			$restaurant_id = $requestData['restaurant_id'];
			$reviewResponse = array();
			$get_last_review =  $this->restaurantReviewModel->select("rr.*, u.fullname, u.image, a.city as city_name")->from(TBL_RESTAURANT_REVIEW . ' as rr')->join(TBL_USERS . ' as u', 'u.id=rr.customer_id')->join(TBL_ORDERS . ' as o', 'o.id=rr.order_id')->join(TBL_ADDRESS . ' as a', 'a.id=o.address_id')->where(['rr.restaurant_id' => $restaurant_id, 'rr.status' => 1])->groupBy('rr.id')->orderBy('rr.id', "DESC")->find();
			if (!empty($get_last_review)) {
				foreach ($get_last_review as $rev) {
					$revRes['review'] = $rev['review'];
					$revRes['message'] = urldecode($rev['message']);
					$revRes['user_name'] = urldecode($rev['fullname']);
					$revRes['city'] = urldecode($rev['city_name']);
					$revRes['user_image'] = getImagePath($rev['image'], 'user');
					$revRes['date'] = date('d M, Y', strtotime($rev['created']));
					$reviewResponse[] = $revRes;
				}
				$printarray['code'] = SUCCESS;
				$printarray['message'] = 'Success.';
				$printarray['result'] = $reviewResponse;
			} else {
				$printarray['code'] = NO_DATA;
				$printarray['message'] = 'No Data Found.';
				$printarray['result'] = [];
			}
		} catch (\Exception $e) {
			$printarray['code'] = 500;
			$printarray['message'] = $e->getMessage();
		}
		header('Content-type: application/json');
		echo json_encode($printarray);
	}
	public function get_wallet_amount($user_id)
	{
		header('Content-type: application/x-www-form-urlencoded');
		try {
			$get_user =  $this->userModel->select('id, wallet_amount')->where(array('id' => $user_id, 'status' => 1))->first();
			if (!empty($get_user)) {
				$user['user_id'] = $get_user['id'];
				$user['wallet_amount'] = $get_user['wallet_amount'];
				$printarray['code'] = SUCCESS;
				$printarray['message'] = 'Success.';
				$printarray['result'] = $user;
			} else {
				$printarray['code'] = NO_DATA;
				$printarray['message'] = 'No Data Found.';
				$printarray['result'] = [];
			}
		} catch (\Exception $e) {
			$printarray['code'] = 500;
			$printarray['message'] = $e->getMessage();
		}
		header('Content-type: application/json');
		echo json_encode($printarray);
	}
	public function categories()
	{
		header('Content-type: application/x-www-form-urlencoded');
		try {
			$get_categories = $this->categoryModel->select("c.*, COUNT(s.category_id) as total")->from(TBL_CATEGORIES . ' as c')->join(TBL_SUBCATEGORIES . ' as s' , 's.category_id=c.id')->where(['c.status' => 1])->groupBy('c.id')->orderBy('title', 'ASC')->find();
			if (!empty($get_categories)) {

				foreach ($get_categories as $cats) {
					$catRes['category_name'] = urldecode($cats['title']);
					$catRes['image'] = getImagePath($cats['image'], 'category');;
					$catRes['category_id'] = $cats['id'];
					$catRes['total_count'] = $cats['total'];
					$catResponse[] = $catRes;
				}
				$printarray['code'] = SUCCESS;
				$printarray['message'] = 'Success.';
				$printarray['result'] = $catResponse;
			} else {
				$printarray['code'] = NO_DATA;
				$printarray['message'] = 'No Data Found.';
				$printarray['result'] = [];
			}
		} catch (\Exception $e) {
			$printarray['code'] = 500;
			$printarray['message'] = $e->getMessage();
		}
		header('Content-type: application/json');
		echo json_encode($printarray);
	}
	public function change_password()
	{
		header('Content-type: application/x-www-form-urlencoded');
		try {
			$requestData = $this->parseJson();
			$user_id = $requestData['user_id'];
			$old_password = $requestData['old_password'];
			$new_password = $requestData['new_password'];

			$get_user =  $this->userModel->select('status, id')->where(array('password' => md5($old_password), 'status=' => 1, 'is_social_login' => 0, 'id' => $user_id))->first();
			if (!empty($get_user)) {
				$addArr['password'] = md5($new_password);
				$update = $this->userModel->update($user_id, $addArr);
				$printarray['code'] = SUCCESS;
				$printarray['message'] = 'Password successfully updated';
			} else {
				$printarray['code'] = EMAIL_EXIST;
				$printarray['message'] = 'Invalid old password';
			}
		} catch (\Exception $e) {
			$printarray['code'] = 500;
			$printarray['message'] = $e->getMessage();
		}
		header('Content-type: application/json');
		echo json_encode($printarray);
	}
	public function check_promocode()
	{
		header('Content-type: application/x-www-form-urlencoded');
		try {
			$requestData = $this->parseJson();
			$user_id = $requestData['user_id'];
			$promocode = $requestData['promocode'];
			$current_date = date('Y-m-d');
			$get_code = $this->couponModel->select('id, discount, discount_type')->where(['start_date <=' => $current_date, 'end_date >=' => $current_date, 'status' => 1])->first();
			if (!empty($get_code)) {
				$check_code = $this->orderModel->select('id')->where(['promo_code' => $promocode, 'status=' => 1, 'user_id' => $user_id])->first();
				if (!empty($check_code)) {
					$printarray['code'] = EMAIL_EXIST;
					$printarray['message'] = 'This promocode is applicable only once.';
				} else {
					$printarray['code'] = SUCCESS;
					$printarray['message'] = 'Promocode successfully applied.';
					$printarray['data'] = ['discount_type' => $get_code->discount_type, 'discount' => $get_code->discount];
				}
			} else {
				$printarray['code'] = FAILURE;
				$printarray['message'] = 'Invalid promocode.';
			}
		} catch (\Exception $e) {
			$printarray['code'] = 500;
			$printarray['message'] = $e->getMessage();
		}
		header('Content-type: application/json');
		echo json_encode($printarray);
	}
	function checkOtp()
	{
		header('Content-type: application/x-www-form-urlencoded');
		try {
			$printarray = array();
			$requestData = $this->parseJson();
			$user_id = $requestData['user_id'];
			$otp = $requestData['otp'];
			if ($otp != '1234') {
				$printarray['code'] = FAILURE;
				$printarray['message'] = 'Invalid promocode.';
			} else {
				$printarray['code'] = SUCCESS;
				$printarray['message'] = "success";
			}
		} catch (\Exception $e) {
			$printarray['code'] = 500;
			$printarray['message'] = $e->getMessage();
		}
		header('Content-type: application/json');
		echo json_encode($printarray);
	}

	public function getDeliveryCharge()
	{

		$requestData = $this->parseJson();

		header('Content-type: application/x-www-form-urlencoded');
		$printarray = array();
		try {

			$latitude = $requestData['latitude'];
			$longitude = $requestData['longitude'];
			$shop_id = $requestData['shop_id'];
			$getshopdetails = $this->shopModel->select('latitude, longitude')->where(['status' => 1, 'id' => $shop_id])->first();



			if (!empty($getshopdetails)) {
				$getDistance = $this->GetDrivingDistance($latitude, $getshopdetails['latitude'], $longitude, $getshopdetails['longitude']);

				if ($getDistance) {
					$deliveryModel = new deliveryChargesModel();

					$getCharges =  $deliveryModel->select('charges')->where(array('status=' => 1))->where("'$getDistance' BETWEEN min_distance AND max_distance")->first();
					if (!empty($getCharges)) {

						$charges = $getCharges['charges'];
					} else {
						$charges = "0.00";
					}
					$printarray['code'] = SUCCESS;
					$printarray['message'] = 'Success';
					$printarray['data'] = strval($charges);
				} else {
					$printarray['code'] = FAILURE;
					$printarray['message'] = 'Error while getting distance';
				}
			} else {
				$printarray['code'] = FAILURE;
				$printarray['message'] = 'Invalid shop.';
			}
		} catch (\Exception $e) {
			$printarray['code'] = 500;
			$printarray['message'] = $e->getMessage();
		}
		header('Content-type: application/json');
		echo json_encode($printarray);
	}

	public function settings()
	{

		header('Content-type: application/x-www-form-urlencoded');
		$printarray = array();
		try {


			$result['phone'] = $this->settings['phone'];
			$result['email'] = urldecode($this->settings['phone']);
			$result['map_api_key'] = $this->settings['map_api_key'];
			$result['fcm_key'] = $this->settings['fcm_key'];
			
			$result['stripe_private_key'] = $this->settings['stripe_private_key'];
			$result['stripe_publish_key'] = $this->settings['stripe_publish_key'];
			$result['braintree_environment'] = $this->settings['braintree_environment'];
			$result['braintree_merchant_id'] = $this->settings['braintree_merchant_id'];
			$result['braintree_public_key'] = $this->settings['braintree_public_key'];
			$result['braintree_private_key'] = $this->settings['braintree_private_key'];
			$result['razorpay_key'] = $this->settings['razorpay_key'];
			$result['razorpay_secret'] = $this->settings['razorpay_secret'];
			$result['payment_methods'] = $this->settings['payment_methods'];
			$result['admin_charge'] = $this->settings['admin_charge'];

			$printarray['code'] = SUCCESS;
			$printarray['message'] = "Success";
			$printarray['result'] = $result;
		} catch (\Exception $e) {
			$printarray['code'] = 500;
			$printarray['message'] = $e->getMessage();
		}
		header('Content-type: application/json');
		echo json_encode($printarray);
	}
	
	    public function getAccessToken() {
      
    //   $ClientId = "83349068";
    //     $ClientSecret = "xiyEv0EXwL_bPiipAx9u22zhrQl4LpEOu6Wv2X8y3DU1";
    //      $ENCRP_KEY = "GWwAsumUM-r_gCAiwOH4y8epTr8PgC4z_5P1ezg-k1Tai4rWsylAjOjXclJFdO2D156OUTvufHjwZXtPbDpyHcgHAnNIeLWxJyKfXsninbI1";
    //     $URL = "https://pg.cbk.com";
        
        $ClientId = "83349068";
        $ClientSecret = "sen3hSEjWVdzKOIhe07OLu6-_d7A_ZCNqqGRvD_RiiQ1";
        $ENCRP_KEY = "rBFjTvQL6QrkzIORhhj6RQh1nUUJgnEy5Q6tysxllDAZ0VRnS6n800kwzbkWpPWtzVkEkPWuPCxD_a5mWK3p_RjnXAq9ARum31F-liCJJhQ1";
        $URL = "https://pgtest.cbk.com/";
        



 
    $postfield = array("ClientId" => $ClientId,
            "ClientSecret" => $ClientSecret,
            "ENCRP_KEY" => $ENCRP_KEY);
    
    $curl = curl_init();

     curl_setopt_array($curl, array(
                CURLOPT_URL =>  $URL ."/ePay/api/cbk/online/pg/merchant/Authenticate",
                CURLOPT_ENCODING => "",
                CURLOPT_FOLLOWLOCATION => 1,
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_SSL_VERIFYHOST=>0,
                CURLOPT_SSL_VERIFYPEER=>0,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_2TLS,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_FRESH_CONNECT => true,
                CURLOPT_POSTFIELDS => json_encode($postfield),
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Basic ' . base64_encode($ClientId. ":" . $ClientSecret),
                    "Content-Type: application/json",
                    "cache-control: no-cache"
                ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);
            
            curl_close($curl);



            
            
            $authenticateData = json_decode($response);
                
            if ($authenticateData->Status == "1") {
            //save access token till expiry
                return $authenticateData->AccessToken;
            } else {
                return false;
            }
    
    
    }


     public function request($amount, $trackid, $reference, $udf1 = '', $udf2 = '', $udf3 = '', $udf4 = '', $udf5 = '',  $paymentType = 1, $lang = 'en',
    $returl = 'https://dietaholics.com/webservices/callResponse') {

        // $ClientId = "83349068";
        // $ClientSecret = "xiyEv0EXwL_bPiipAx9u22zhrQl4LpEOu6Wv2X8y3DU1";
        //  $ENCRP_KEY = "GWwAsumUM-r_gCAiwOH4y8epTr8PgC4z_5P1ezg-k1Tai4rWsylAjOjXclJFdO2D156OUTvufHjwZXtPbDpyHcgHAnNIeLWxJyKfXsninbI1";
        // $URL = "https://pg.cbk.com";
        
        
         $ClientId = "83349068";
        $ClientSecret = "sen3hSEjWVdzKOIhe07OLu6-_d7A_ZCNqqGRvD_RiiQ1";
        $ENCRP_KEY = "rBFjTvQL6QrkzIORhhj6RQh1nUUJgnEy5Q6tysxllDAZ0VRnS6n800kwzbkWpPWtzVkEkPWuPCxD_a5mWK3p_RjnXAq9ARum31F-liCJJhQ1";
        $URL = "https://pgtest.cbk.com/";

	 
        //get access token 
        if ($AccessToken = $this->getAccessToken()) {
            //generate pg page 
            $formData = array(
                'tij_MerchantEncryptCode' => $ENCRP_KEY,
                'tij_MerchAuthKeyApi' => $AccessToken,
                'tij_MerchantPaymentLang' => $lang,
                'tij_MerchantPaymentAmount' => $amount,
                'tij_MerchantPaymentTrack' => $trackid,
                'tij_MerchantPaymentRef' => $reference,
                'tij_MerchantUdf1' => $udf1,
                'tij_MerchantUdf2' => $udf2,
				'tij_MerchantUdf3' => $udf3,
				'tij_MerchantUdf4' => $udf4,
				'tij_MerchantUdf5' => $udf5,
                'tij_MerchPayType' => $paymentType,
				'tij_MerchReturnUrl' => $returl
            );
            $url = $URL."/ePay/pg/epay?_v=" . $AccessToken;

            // print_r($url);exit;
            $form = "<form id='pgForm' method='post' action='$url' enctype='application/x-www-form-urlencoded'>";


            foreach ($formData as $k => $v) {
                $form .= "<input type='hidden' name='$k' value='$v'>";
            }
            $form .= "</form><div style='position: fixed;top: 50%;left: 50%;transform: translate(-50%, -50%;text-align:center'>Redirecting to PG ... <br> <b> DO NOT REFRESH</b></div><script type='text/javascript'>document.getElementById('pgForm').submit();</script>";

			
            return $form;
        } else {
            return "Authentication Failed";
        }
        
    }
    
    
    public function response($encrp) {

         $ClientId = "83349068";
        $ClientSecret = "sen3hSEjWVdzKOIhe07OLu6-_d7A_ZCNqqGRvD_RiiQ1";
        $ENCRP_KEY = "rBFjTvQL6QrkzIORhhj6RQh1nUUJgnEy5Q6tysxllDAZ0VRnS6n800kwzbkWpPWtzVkEkPWuPCxD_a5mWK3p_RjnXAq9ARum31F-liCJJhQ1";
        $URL = "https://pgtest.cbk.com/";


        if ($AccessToken = $this->getAccessToken()) {
            $url = $URL."/ePay/api/cbk/online/pg/GetTransactions/" . $encrp . "/" . $AccessToken;
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_ENCODING => "",
                CURLOPT_FOLLOWLOCATION => 1,
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Basic ' .base64_encode($ClientId. ":" . $ClientSecret),
                    "Content-Type: application/json",
                    "cache-control: no-cache"
                ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);


            $paymentDetails = json_decode($response);
            // print_r($paymentDetails);exit;
			if($paymentDetails->Status != "0" or $paymentDetails->Status != "-1")
			{
				return $paymentDetails;
			}
            else {
				return false;
			 }

       
        } else {
            return false;
        }
    }


    
    
     public function callResponse()
    {
        $printarray = [];
        $encrp = $_REQUEST['encrp'];
        $order_id = $_REQUEST['order_id'];
        
     

        $json = $this->response($encrp);

        //  print_r($json->Message);exit;

        $_json = json_encode($json);
        
        if($json->Message !='Failed')
        {
            // echo "helo";exit;
            
            $data = array(
                    'payment_status'=>1
                );
                
                	
                // 	$addArr['password'] = md5($new_password);
				// $update = $this->OrderModel->update($order_id, $data);
				
					$this->orderModel->update($requestData['order_id'], array('payment_status' => 1));
					
				    
				  
                	$printarray['code'] = SUCCESS;
					$printarray['message'] = 'Success.';
					$printarray['result'] = '';
					
				
					
				// 	print_r($printarray);
				// 	exit;
					
        }else{
            
            $printarray['code'] = FAILED;
					$printarray['message'] = 'Failed.';
					$printarray['result'] = '';
					
					echo json_encode($printarray);
					exit;
            
        }
        
        // echo "<pre>";dd($printarray);

        echo json_encode($printarray);



        
    }


}

<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\DriversReviewModel;
use App\Models\DeliveryChargesModel;

class Drivers extends BaseController
{
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		parent::initController($request, $response, $logger);
		$this->driversReviewModel = new DriversReviewModel();
	}
	public function index()
	{
		$this->load->view('index');
	}
	public function login()
	{
		header('Content-type: application/x-www-form-urlencoded');
		try {
			$requestData = $this->parseJson();
			$email = urlencode($requestData['email']);
			$password = $requestData['password'];
			$device_token = $requestData['device_token'];
			$latitude = $requestData['latitude'];
			$longitude = $requestData['longitude'];
			$get_user =  $this->userModel->select('status, id')->where(array('email' => $email, 'password' => md5($password), 'status!=' => 9, 'user_type' => 2))->first();
			if (!empty($get_user)) {
				$user_status = $get_user['status'];
				if ($user_status == 1) {
					$this->userModel->update($get_user['id'], array('is_available' => 1, 'latitude' => $latitude, 'longitude' => $longitude, 'device_token' => $device_token));
					$get_user =  $this->userModel->where(array('id' => $get_user['id']))->first();
					$getUserAddress = file_get_contents('https://maps.google.com/maps/api/geocode/json?latlng=' . trim($latitude) . ',' . trim($longitude) . '&key=' . $this->settings['map_api_key']);
					$addressData = json_decode($getUserAddress);
					$printarrayStatus = $addressData->status;
					$user['driver_id'] = $get_user['id'];
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
				$printarray['message'] = 'Invaid email or password.';
				$printarray['result'] = [];
			}
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
		try {
			$requestData = $this->parseJson();
			$email = $requestData['email'];
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
	public function logout()
	{
		header('Content-type: application/x-www-form-urlencoded');
		try {
			$requestData = $this->parseJson();
			$user_id = $requestData['user_id'];
			$this->userModel->update($user_id, array('is_available' => 0, 'device_token' => ""));
			$printarray['code'] = SUCCESS;
			$printarray['message'] = 'Logout successfully.';
		} catch (\Exception $e) {
			$printarray['code'] = 500;
			$printarray['message'] = $e->getMessage();
		}
		header('Content-type: application/json');
		echo json_encode($printarray);
	}
	public function order_details()
	{
		header('Content-type: application/x-www-form-urlencoded');
		try {
			$requestData = $this->parseJson();
			$order_id = $requestData['order_id'];
			$get_order = $this->orderModel->select("o.*, r.name, r.profile_image, r.address, a.address_line_1, a.address_line_2, a.phone, r.id as restaurant_id, a.latitude, a.longitude, r.email as r_email, r.phone as restaurant_contact, r.latitude as r_latitude, r.longitude as r_longitude")->from(TBL_ORDERS . " as o")->join(TBL_RESTAURANTS . " as r", "r.id=o.restaurent_id")->join(TBL_ADDRESS . " as a", "a.id=o.address_id")->where('o.status=1')->groupStart()->where('o.id', $order_id)->orWhere('md5(o.id)', $order_id)->groupEnd()->first();
			if (!empty($get_order)) {
				$restData['order_id'] = $get_order['id'];
				$restData['name'] = urldecode($get_order['name']);
				$restData['banner_image'] = getImagePath(explode(',', $get_order['profile_image'])[0], 'restaurants/profile');
				$restData['address'] = urldecode($get_order['address']);
				$restData['date'] = $get_order['created'];
				$restData['total_price'] = $get_order['total_price'];
				$restData['tip_price'] = $get_order['tip_price'];
				$restData['discount_price'] = $get_order['discount_price'];
				$restData['payment_type'] = $get_order['payment_type'];
				$restData['order_status'] = $get_order['order_status'];
				$restData['delivery_address'] = urldecode($get_order['address_line_1']) . ' ' . urldecode($get_order['address_line_2']);
				$restData['phone'] = $get_order['phone'];
				$restData['latitude'] = $get_order['latitude'];
				$restData['longitude'] = $get_order['longitude'];
				$restData['r_latitude'] = $get_order['r_latitude'];
				$restData['r_longitude'] = $get_order['r_longitude'];
				$restData['restaurant_contact'] = $get_order['restaurant_contact'];
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
				$printarray['code'] = SUCCESS;
				$printarray['message'] = 'Success.';
				$printarray['result'] = $restData;
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
	public function profile()
	{
		header('Content-type: application/x-www-form-urlencoded');
		try {
			$requestData = $this->parseJson();
			$user_id = $requestData['user_id'];
			$get_user =  $this->userModel->select("u.*, c.name as city_name, s.name as state_name, co.name as country_name")->from(TBL_USERS . " as u")->join(TBL_CITY . " as c", "c.id=u.city_id")->join(TBL_STATE . " as s", "s.id=u.state_id")->join(TBL_COUNTRY . " as co", "co.id=u.country_id")->where(["u.status" => 1, "u.id" => $user_id])->groupBy('u.id')->first();

			if (!empty($get_user)) {
				$get_total_tips = $this->orderModel->select("SUM(o.tip_price) AS total_tip, COUNT(o.id) as total_delivered_orders")->from(TBL_ORDERS . ' as o')->join(TBL_ORDER_DRIVERS . " as od", "od.order_id=o.id")->where(array('o.status' => 1, 'o.order_status' => 5, 'od.driver_id' => $user_id, 'od.driver_status' => 1, 'od.status' => 1))->find();
				$get_total_rejected_orders = $this->driverOrderModel->select("COUNT(id) as total_rejected_orders")->where(array('driver_id' => $user_id, 'driver_status' => 2, 'status' => 1))->find();
				$get_review = $this->driversReviewModel->select("'ROUND( AVG(review),1 ) as review")->where(array('driver_id' => $user_id))->groupBy('driver_id')->orderBy('id', 'desc')->find();
				$dateOfBirth = $get_user['date_of_birth'];
				$today = date("Y-m-d");
				$diff = date_diff(date_create($dateOfBirth), date_create($today));
				$user['driver_id'] = $get_user['id'];
				$user['avg_review'] = $get_review ? $get_review[0]['review'] : "0.0";
				$user['name'] = urldecode($get_user['fullname']);
				$user['email'] = urldecode($get_user['email']);
				$user['profile_image'] = getImagePath($get_user['image'], 'user');
				$user['identity_number'] = $get_user['identity_number'];
				$user['identity_image'] = getImagePath($get_user['identity_image'], 'user');
				$user['license_number'] = $get_user['license_number'];
				$user['license_image'] = getImagePath($get_user['license_image'], 'user');
				$user['phone'] = $get_user['phone'];
				$user['gender'] = $get_user['gender'];
				$user['date_of_birth'] = $get_user['date_of_birth'];
				$user['age'] = $diff->format('%Y');
				$user['is_available'] = $get_user['is_available'];
				$user['permenent_address'] = urldecode($get_user['address']) . ', ' . urldecode($get_user['city_name']) . ', ' . urldecode($get_user['state_name']) . ', ' . urldecode($get_user['country_name']) . '-' . $get_user['pincode'];
				$user['total_tip'] = $get_total_tips ? $get_total_tips[0]['total_tip'] : "0.00";
				$user['total_delivered_orders'] = $get_total_tips ? $get_total_tips[0]['total_delivered_orders'] : "0";
				$user['total_rejected_orders'] = $get_total_rejected_orders ? $get_total_rejected_orders[0]['total_rejected_orders'] : "0";
				$getUserAddress = file_get_contents('https://maps.google.com/maps/api/geocode/json?latlng=' . trim($get_user['latitude']) . ',' . trim($get_user['longitude']) . '&key=' . $this->settings['map_api_key']);
				$addressData = json_decode($getUserAddress);
				$printarrayStatus = $addressData->status;
				$user['current_address'] = "";
				if ($printarrayStatus == "OK") {
					$user['current_address'] = $addressData->results[0]->formatted_address;
				}
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
	public function accept_reject_order()
	{
		header('Content-type: application/x-www-form-urlencoded');
		try {
			$requestData = $this->parseJson();
			$addArr['driver_status'] = $requestData['status'];
			$update = $this->driverOrderModel->where(array('driver_id' => $requestData['user_id'], 'order_id' => $requestData['order_id']))->set($addArr)->update();
			if ($update) {
				$printarray['code'] = SUCCESS;
				$printarray['message'] = 'Status changed successfully.';
			} else {
				$printarray['code'] = FAILURE;
				$printarray['message'] = 'Failure.';
			}
		} catch (\Exception $e) {
			$printarray['code'] = 500;
			$printarray['message'] = $e->getMessage();
		}
		header('Content-type: application/json');
		echo json_encode($printarray);
	}
	function orders_list()
	{
		header('Content-type: application/x-www-form-urlencoded');
		try {
			$requestData = $this->parseJson();
			$user_id = $requestData['user_id'];
			$get_data = $this->orderModel->select("o.order_status, o.total_price, o.id, o.created, o.updated, od.driver_status,  r.name, r.profile_image, r.address, r.pincode, o.user_id")->from(TBL_ORDERS . ' as o')->join(TBL_RESTAURANTS . ' as r', "r.id=o.restaurent_id")->join(TBL_ORDER_DRIVERS . " as od", "od.order_id=o.id")->where(array('od.driver_id=' => $user_id, 'o.status' => 1, 'od.driver_status!=' => 2, 'o.order_status!=' => 5))->groupBy('o.id')->orderBy('o.id', "desc")->find();

			$ordResponse = array();
			if (!empty($get_data)) {
				foreach ($get_data as $ord) {
					$ordRes['name'] = urldecode($ord['name']);
					$ordRes['banner_image'] = getImagePath(explode(',', $ord['profile_image'])[0], 'restaurants/profile');
					$ordRes['address'] = urldecode($ord['address']);
					$ordRes['pincode'] = $ord['pincode'];
					$ordRes['order_id'] = $ord['id'];
					$ordRes['user_id'] = $ord['user_id'];
					$ordRes['order_status'] = $ord['order_status'];
					$ordRes['total_price'] = $ord['total_price'];
					$ordRes['created'] = $ord['created'];
					$ordRes['updated'] = $ord['updated'];
					$ordRes['driver_status'] = $ord['driver_status'];
					$ordResponse[] = $ordRes;
				}
				$printarray['code'] = SUCCESS;
				$printarray['message'] = 'Success.';
				$printarray['result'] = $ordResponse;
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
	public function change_order_status()
	{
		header('Content-type: application/x-www-form-urlencoded');
		try {
			$requestData = $this->parseJson();
			$driver_id = $requestData['driver_id'];
			$lat = $requestData['latitude'];
			$long = $requestData['longitude'];
			$addArr['order_status'] = $requestData['status'];
			if (isset($requestData['signature']) && $requestData['signature'] != "") {
				$image_base64 = base64_decode($requestData['signature']);
				$file_name = uniqid() . '.png';
				$file = FCPATH . 'public/uploads/signature/' . $file_name;
				file_put_contents($file, $image_base64);
				$addArr['signature'] = $file_name;
			}
			$getOrder =  $this->orderModel->select('restaurent_id')->where(array('id' => $requestData['restaurent_id'], 'status' => 1))->first();
			$update = $this->orderModel->update($requestData['order_id'], $addArr);
			if ($update) {
				$addNotification = array();
				$addNotification['type'] = "1";
				$addNotification['type_id'] = $requestData['order_id'];
				$addNotification['user_id'] = $requestData['user_id'];
				if ($addArr['order_status'] == 6) {
					$addNotification['title'] = urlencode("Order picked up");
					$addNotification['Description'] = urlencode("Your order has been picked up from restaurant.");
				} else if ($addArr['order_status'] == 5) {
					$addNotification['title'] = urlencode("Order Delivered");
					$addNotification['Description'] = urlencode("Your order delivered successfully");
					$getOwner =  $this->restaurantModel->select('owner_id')->where(array('id' => $getOrder['restaurent_id'], 'status' => 1))->first();
					$ownerNotification = array();
					$ownerNotification['title'] = urlencode("Order Delivered");
					$ownerNotification['Description'] = urlencode("Congratulations!!, Your order has been delivered.");
					$ownerNotification['type'] = "3";
					$ownerNotification['type_id'] = $requestData['order_id'];
					$ownerNotification['user_id'] = $getOwner->owner_id;
					$notification_id = $this->notificationModel->insert($ownerNotification);
					$this->sendPushNotification($getOwner->owner_id, $notification_id, 'owners');
				}
				$notification_id = $this->notificationModel->insert( $addNotification);
				$this->sendPushNotification($requestData['user_id'], $notification_id, "driver");
				$this->userModel->update($driver_id, array('latitude' => $lat, 'longitude' => $long));
				$printarray['code'] = SUCCESS;
				$printarray['message'] = 'Status changed successfully.';
			} else {
				$printarray['code'] = FAILURE;
				$printarray['message'] = 'Failure.';
			}
		} catch (\Exception $e) {
			$printarray['code'] = 500;
			$printarray['message'] = $e->getMessage();
		}
		header('Content-type: application/json');
		echo json_encode($printarray);
	}
	public function notifications()
	{
		header('Content-type: application/x-www-form-urlencoded');
		try {
			$requestData = $this->parseJson();
			$user_id = $requestData['user_id'];

			$list =   $this->notificationModel->where(['user_id'=>$user_id, 'status'=>1])->orderBy('id','DESC')->find();
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
	function orders_history()
	{
		header('Content-type: application/x-www-form-urlencoded');
		try {
			$requestData = $this->parseJson();
			$user_id = $requestData['user_id'];
			$get_data = $this->orderModel->select("o.order_status, o.total_price, o.id, o.created, o.updated, od.driver_status,  r.name, r.profile_image, r.address, r.pincode, o.user_id")->from(TBL_ORDERS . ' as o')->join(TBL_RESTAURANTS . ' as r', "r.id=o.restaurent_id")->join(TBL_ORDER_DRIVERS . " as od", "od.order_id=o.id")->where(array('od.driver_id=' => $user_id, 'o.status' => 1))->groupStart()->orWhere(["od.driver_status" =>2])->orGroupStart()->where(['od.driver_status'=>1, "o.order_status"=>5])->groupEnd()->groupEnd()->groupBy('o.id')->orderBy('o.id', "desc")->find();
			$ordResponse = array();
			if (!empty($get_data)) {
				foreach ($get_data as $ord) {
					$ordRes['name'] = urldecode($ord['name']);
					$ordRes['banner_image'] = getImagePath(explode(',', $ord['profile_image'])[0], 'restaurants/profile');
					$ordRes['address'] = urldecode($ord['address']);
					$ordRes['pincode'] = $ord['pincode'];
					$ordRes['order_id'] = $ord['id'];
					$ordRes['user_id'] = $ord['user_id'];
					$ordRes['order_status'] = $ord['order_status'];
					$ordRes['total_price'] = $ord['total_price'];
					$ordRes['created'] = $ord['created'];
					$ordRes['updated'] = $ord['updated'];
					$ordRes['driver_status'] = $ord['driver_status'];
					$ordResponse[] = $ordRes;
				}
				$printarray['code'] = SUCCESS;
				$printarray['message'] = 'Success.';
				$printarray['result'] = $ordResponse;
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
	public function change_availability_status()
	{
		header('Content-type: application/x-www-form-urlencoded');
		try {
			$requestData = $this->parseJson();
			$addArr['is_available'] = $requestData['status'];
			$update = $this->userModel->update($requestData['driver_id'], $addArr);
			if ($update) {
				$printarray['code'] = SUCCESS;
				$printarray['message'] = 'Status changed successfully.';
			} else {
				$printarray['code'] = FAILURE;
				$printarray['message'] = 'Failure.';
			}
		} catch (\Exception $e) {
			$printarray['code'] = 500;
			$printarray['message'] = $e->getMessage();
		}
		header('Content-type: application/json');
		echo json_encode($printarray);
	}
	public function update_driver_location()
	{
		header('Content-type: application/x-www-form-urlencoded');
		try {
			$requestData = $this->parseJson();
			$driver_id = $requestData['driver_id'];
			$addArr['latitude'] = $requestData['latitude'];
			$addArr['longitude'] = $requestData['longitude'];
			$this->userModel->update($driver_id, $addArr);
			$printarray['code'] = SUCCESS;
			$printarray['message'] = 'Success.';
			$printarray['result'] = [];
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
			$driver_id = $requestData['driver_id'];

			$reviewResponse = array();
			$get_last_review =  $this->driversReviewModel->select('dr.*, u.fullname, u.image, a.city as city_name')->from(TBL_DRIVER_REVIEW . ' as dr')->join(TBL_ORDERS . ' as o', 'o.id=dr.order_id')->join(TBL_ADDRESS . ' as a', 'a.id=o.address_id')->where(array('dr.driver_id' => $driver_id, 'dr.status' => 1))->groupBy('dr.id')->orderBy('dr.id', "desc")->find();
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
}

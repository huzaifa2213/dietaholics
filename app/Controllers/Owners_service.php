<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CityModel;
use App\Models\EarningModel;
use App\Models\RestaurantModel;
use App\Models\RestaurantReviewModel;
use App\Models\CountryModel;
use App\Models\StateModel;

class Owners_service extends BaseController
{
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		parent::initController($request, $response, $logger);
		$this->earningModel = new EarningModel();
		$this->restaurantModel = new RestaurantModel();
		$this->restaurantReviewModel = new RestaurantReviewModel();
		$this->countryModel = new CountryModel();
		$this->stateModel = new StateModel();
		$this->cityModel = new CityModel();
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
			$get_user =  $this->ownerModel->where(array('email' => $email, 'password' => md5($password), 'status!=' => 9))->first();
			if (!empty($get_user)) {
				$user_status = $get_user['status'];
				if ($user_status == 1) {
					$this->ownerModel->update($get_user['id'], array('device_token' => $device_token));
					$user['id'] = $get_user['id'];
					$user['name'] = urldecode($get_user['first_name'] . ' ' . $get_user['last_name']);
					$user['email'] = urldecode($get_user['email']);
					$user['profile_image'] = getImagePath($get_user['image'], 'owners');
					$user['phone'] = $get_user['phone'];
					$user['address'] = urldecode($get_user['address']);
					$user['pincode'] = $get_user['pincode'];
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
			$get_user =  $this->ownerModel->select('status, id')->where(array('email' => urlencode($email), 'status=' => 1))->first();
			if (!empty($get_user)) {
				$password = substr(str_shuffle("ABCDEFGH1234567890IGHIJKLMNOPQ@!$%^&*RSTUVWXYZ"), 0, 8);
				$addArr['password'] = md5($password);
				$sendEmail = $this->sendMailToUser($get_user['id'],  $email, 2, $password);
				if ($sendEmail) {
					$update = $this->ownerModel->update($get_user['id'], $addArr);
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
			$owner_id = $requestData['owner_id'];
			$this->ownerModel->update($owner_id, array('device_token' => ""));
			$printarray['code'] = SUCCESS;
			$printarray['message'] = 'Logout successfully.';
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
			$owner_id = $requestData['owner_id'];
			$old_password = $requestData['old_password'];
			$new_password = $requestData['new_password'];

			$get_user =  $this->ownerModel->select('status, id')->where(array('password' => md5($old_password), 'status=' => 1, 'id' => $owner_id))->first();
			if (!empty($get_user)) {
				$addArr['password'] = md5($new_password);
				$update = $this->ownerModel->update($owner_id, $addArr);
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
	public function profile()
	{
		header('Content-type: application/x-www-form-urlencoded');
		try {
			$requestData = $this->parseJson();
			$owner_id = $requestData['owner_id'];
			$get_user =  $this->ownerModel->where(array('id' => $owner_id, 'status' => 1))->first();
			if (!empty($get_user)) {
				$user['owner_id'] = $get_user['id'];
				$user['name'] = urldecode($get_user['first_name'] . ' ' . $get_user['last_name']);
				$user['email'] = urldecode($get_user['email']);
				$user['profile_image'] = getImagePath($get_user['image'], 'owners');
				$user['phone'] = $get_user['phone'];

				$total_orders = $this->orderModel->select('o.id')->from(TBL_ORDERS . ' as o')->join(TBL_RESTAURANTS . ' as r', "r.id=o.restaurent_id")->where(array('r.owner_id' => $owner_id, 'o.status' => 1))->groupBy('o.id')->find();

				$todays_orders = $this->orderModel->select('o.id')->from(TBL_ORDERS . ' as o')->join(TBL_RESTAURANTS . ' as r', "r.id=o.restaurent_id")->where(array('r.owner_id' => $owner_id, 'o.status' => 1, "DATE_FORMAT(o.created, '%Y-%m-%d')=" => date('Y-m-d')))->groupBy('o.id')->find();

				$new_orders = $this->orderModel->select('o.id')->from(TBL_ORDERS . ' as o')->join(TBL_RESTAURANTS . ' as r', "r.id=o.restaurent_id")->where(array('r.owner_id' => $owner_id, 'o.status' => 1, 'r.status' => 1, 'o.status' => 1, 'o.order_status <= ' => 2))->groupBy('o.id')->find();

				$total_earnings = $this->earningModel->select("SUM(e.owners_amount) AS earnings")->from(TBL_EARNINGS . ' as e ')->join(TBL_RESTAURANTS . ' as r', "e.restaurent_id=r.id")->where(array('e.status' => 1, "r.owner_id" => $owner_id))->find();

				$current_month_earnings = $this->earningModel->select("SUM(e.owners_amount) AS earnings")->from(TBL_EARNINGS . ' as e ')->join(TBL_RESTAURANTS . ' as r', "e.restaurent_id=r.id")->where(array('e.status' => 1, "r.owner_id" => $owner_id, 'MONTH(e.created)' => "MONTH(" . date('Y-m-d') . ")"))->find();
				$user['total_orders'] = strval(count($total_orders));
				$user['todays_orders'] = strval(count($todays_orders));
				$user['new_orders'] = strval(count($new_orders));
				$user['total_earnings'] = !empty($total_earnings) ? $total_earnings[0]['earnings'] : "0";
				$user['current_month_earnings'] = !empty($current_month_earnings) ? $current_month_earnings[0]['earnings'] : "0";
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
	public function restaurant_list()
	{
		header('Content-type: application/x-www-form-urlencoded');
		try {
			$requestData = $this->parseJson();
			$owner_id = $requestData['owner_id'];
			$finalResponse = array();

			$get_restaurants = $this->restaurantModel->select("r.id, r.name, r.profile_image, r.address, r.owner_id, r.pincode, r.status as r_status, r.is_available, s.status as s_status, ct.status as ct_status,  c.status as c_status, s.name as state_name, ct.name as city_name, c.name as country_name,  r.latitude, r.longitude, ROUND( AVG(rr.review),1 ) as review")->from(TBL_RESTAURANTS . ' as r')->join(TBL_STATE . ' as s', 's.id=r.state_id', 'INNER')->join(TBL_CITY . ' as ct', 'ct.id=r.city_id', 'INNER')->join(TBL_COUNTRY . ' as c', 'c.id=r.country_id', 'INNER')->join(TBL_RESTAURANT_REVIEW . ' as rr', 'rr.restaurant_id=r.id', 'LEFT')->where(['r.status' => 1, 's.status' => 1, 'ct.status' => 1, 'c.status' => 1, "r.owner_id" => $owner_id])->orderBy('r.name', 'ASC')->groupBy('r.id')->find();
			if (!empty($get_restaurants)) {
				foreach ($get_restaurants as $row) {
					$res['id'] = $row['id'];
					$res['review'] = $row['review'];
					$res['is_available'] = $row['is_available'];
					$res['name'] = urldecode($row['name']);
					$res['image'] = getImagePath(explode(',', $row['profile_image'])[0], 'restaurants/profile');
					$res['address'] = urldecode($row['address']) . ',' . urldecode($row['city_name']);
					$res['latitude'] = $row['latitude'];
					$res['longitude'] = $row['longitude'];

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
	function orders_list()
	{
		header('Content-type: application/x-www-form-urlencoded');
		try {
			$requestData = $this->parseJson();
			$owner_id = $requestData['owner_id'];
			$get_data =  $this->orderModel->select("o.*, r.name, r.profile_image, a.address_line_1, a.address_line_2, rr.review")->from(TBL_ORDERS . ' as o')->join(TBL_RESTAURANTS . ' as r', "r.id=o.restaurent_id")->join(TBL_RESTAURANT_REVIEW . ' as rr', "rr.order_id=o.id", 'LEFT')->join(TBL_ADDRESS . ' as a', "o.address_id=a.id", 'LEFT')->where(array('r.owner_id=' => $owner_id, 'o.status' => 1))->groupBy('o.id')->orderBy('o.id', 'DESC')->find();
			$ordResponse = array();
			if (!empty($get_data)) {
				foreach ($get_data as $ord) {
					$ordRes['name'] = urldecode($ord['name']);
					$ordRes['banner_image'] = getImagePath(explode(',', $ord['profile_image'])[0], 'restaurants/profile');
					$ordRes['address'] = urldecode($ord['address_line_1'] . ' ' . $ord['address_line_2']);
					$ordRes['order_id'] = $ord['id'];
					$ordRes['order_status'] = $ord['order_status'];
					$ordRes['total_price'] = $ord['total_price'];
					$ordRes['created'] = $ord['created'];
					$ordRes['payment_type'] = $ord['payment_type'];
					$ordRes['order_status'] = $ord['order_status'];
					$ordRes['review'] = urldecode($ord['review']);
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
	public function details($restaurant_id)
	{
		header('Content-type: application/x-www-form-urlencoded');
		try {
			$get_restaurant =  $this->restaurantModel->where(array('id' => $restaurant_id, 'status' => 1))->first();
			if (!empty($get_restaurant)) {
				$get_avg_review =  $this->restaurantReviewModel->select("ROUND( AVG(review),1 ) as review")->where(array('restaurant_id' => $restaurant_id, 'status' => 1))->find();
				$restData['restaurant_id'] = $restaurant_id;
				$restData['avg_review'] = null;
				if (!empty($get_avg_review)) {
					$restData['avg_review'] = $get_avg_review[0]['review'];
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

				$get_last_review =  $this->restaurantReviewModel->select("rr.*, u.fullname, u.image, a.city as city_name")->from(TBL_RESTAURANT_REVIEW . ' as rr')->join(TBL_USERS . ' as u', 'u.id=rr.customer_id')->join(TBL_ORDERS . ' as o', 'o.id=rr.order_id')->join(TBL_ADDRESS . ' as a', 'a.id=o.address_id')->where(['rr.restaurant_id' => $restaurant_id, 'rr.status' => 1])->groupBy('rr.id')->orderBy('rr.id', "DESC")->limit(2, 0)->find();
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
				$restData['reviews'] = $reviewResponse;
				$restData['categories'] = $catResponse;
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
	function order_details($order_id)
	{

		header('Content-type: application/x-www-form-urlencoded');
		try {
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
	public function getCountry()
	{
		header('Content-type: application/x-www-form-urlencoded');
		try {
			$get_country =  $this->countryModel->where(array('status' => 1))->find();
			if (!empty($get_country)) {

				foreach ($get_country as $cats) {
					$catRes['country_name'] = urldecode($cats['name']);
					$catRes['country_id'] = $cats['id'];
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
	public function getState($country_id)
	{
		header('Content-type: application/x-www-form-urlencoded');
		try {
			$get_state =  $this->stateModel->where(array('status' => 1,  'country_id' => $country_id))->find();
			if (!empty($get_state)) {

				foreach ($get_state as $cats) {
					$catRes['state_name'] = urldecode($cats['name']);
					$catRes['state_id'] = $cats['id'];
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
	public function getCity($state_id)
	{
		header('Content-type: application/x-www-form-urlencoded');
		try {
			$get_state =  $this->cityModel->where(array('status' => 1, 'state_id' => $state_id))->find();
			if (!empty($get_state)) {
				foreach ($get_state as $cats) {
					$catRes['city_name'] = urldecode($cats['name']);
					$catRes['city_id'] = $cats['id'];
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
	public function addUpdateRestaurant($restaurant_id = null)
	{
		header('Content-type: application/x-www-form-urlencoded');
		try {
			$requestData = $this->parseJson();
			$addArr['name'] = urlencode($requestData['name']);
			$addArr['owner_id'] = $requestData['owner_id'];
			$addArr['email'] = urlencode($requestData['email']);
			$addArr['phone'] = $requestData['phone'];
			$addArr['city_id'] = $requestData['city_id'];
			$addArr['state_id'] = $requestData['state_id'];
			$addArr['country_id'] = $requestData['country_id'];
			$addArr['pincode'] = $requestData['pincode'];
			$addArr['address'] = urlencode($requestData['address']);
			$addArr['discount'] = $requestData['discount'];
			$addArr['discount_type'] = $requestData['discount_type'];
			$addArr['average_price'] = $requestData['average_price'];
			$addArr['opening_time'] = date('H:i:s', strtotime($requestData['opening_time']));
			$addArr['closing_time'] = date('H:i:s', strtotime($requestData['closing_time']));
			$address = urldecode($addArr['address']) . ' ' . $addArr['pincode'];
			$prepAddr = str_replace(' ', '+', $address);
			$geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?address=' . $prepAddr . '&sensor=false' . '&key=' . $this->settings['map_api_key']);
			$output = json_decode($geocode);
			if ($output->results[0] && $output->results[0]->geometry && $output->results[0]->geometry->location && $output->results[0]->geometry->location->lat) {
				$latitude = $output->results[0]->geometry->location->lat;
				$longitude = $output->results[0]->geometry->location->lng;
				$addArr['latitude'] = $latitude;
				$addArr['longitude'] = $longitude;
				if (isset($requestData['profile_image']) && $requestData['profile_image'] != "") {
					$image_base64 = base64_decode($requestData['profile_image']);
					$file_name = uniqid() . '.jpg';
					$file = FCPATH . 'public/uploads/restaurants/profile/' . $file_name;
					file_put_contents($file, $image_base64);
					$addArr['profile_image'] = $file_name;
				}
				if ($restaurant_id) {
					$this->restaurantModel->update($restaurant_id, $addArr);
				} else {
					$this->restaurantModel->insert($addArr);
				}

				$printarray['code'] = SUCCESS;
				$printarray['message'] = 'Success.';
			} else {
				$printarray['code'] = NO_DATA;
				$printarray['message'] = 'Invalid Address';
			}
		} catch (\Exception $e) {
			$printarray['code'] = 500;
			$printarray['message'] = $e->getMessage();
		}
		header('Content-type: application/json');
		echo json_encode($printarray);
	}
	public function addUpdateProduct($product_id = null)
	{
		header('Content-type: application/x-www-form-urlencoded');
		try {
			$requestData = $this->parseJson();
			$addArr['title'] = urlencode($requestData['title']);
			$addArr['category_id'] = $requestData['category_id'];
			$addArr['type'] = $requestData['type'];
			$addArr['restaurant_id'] = $requestData['restaurant_id'];
			$addArr['discount_type'] = $requestData['discount_type'];
			$addArr['price'] = $requestData['price'];
			$addArr['discount'] = $requestData['discount'];
			$addArr['description'] = urlencode($requestData['description']);
			if (isset($requestData['image']) && $requestData['image'] != "") {
				$image_base64 = base64_decode($requestData['image']);
				$file_name = uniqid() . '.png';
				$file = FCPATH . 'public/uploads/subcategory/' . $file_name;
				file_put_contents($file, $image_base64);
				$addArr['image'] = $file_name;
			}
			if ($product_id) {
				$this->subcategoryModel->update($product_id, $addArr);
			} else {
				$this->subcategoryModel->insert($addArr);
			}
			$printarray['code'] = SUCCESS;
			$printarray['message'] = 'Success.';
		} catch (\Exception $e) {
			$printarray['code'] = 500;
			$printarray['message'] = $e->getMessage();
		}
		header('Content-type: application/json');
		echo json_encode($printarray);
	}
	public function get_all_review($restaurant_id)
	{
		header('Content-type: application/x-www-form-urlencoded');
		try {
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
	public function mealDeal($restaurant_id, $cat_id = null)
	{
		header('Content-type: application/x-www-form-urlencoded');
		try {
			$finalResponse = array();
			$append_where = "";
			if ($cat_id) {
				$append_where .= " and f.category_id=" . $cat_id;
			}
			$dataQuery = $this->subcategoryModel->select("f.id, r.id as res_id, r.latitude, r.longitude, f.title, f.image, r.address, f.discount_type, f.discount, f.price, r.name as restaurant_name,r.status as r_status, r.is_available, s.status as s_status, ct.status as ct_status,  c.status as c_status, f.status as f_status, f.category_id, cat.title as category_name, f.type, f.description")->from(TBL_SUBCATEGORIES . " as f")->join(TBL_CATEGORIES.' as cat', 'cat.id=f.category_id')->join(TBL_RESTAURANTS.' as r', 'r.id=f.restaurant_id', 'INNER')->join(TBL_STATE.' as s', 's.id=r.state_id', 'INNER')->join( TBL_CITY.' as ct', 'ct.id=r.city_id', 'INNER')->join(TBL_COUNTRY.' as c', 'c.id=r.country_id', 'INNER')->where(["r.id" => $restaurant_id , "r.status"=>1, "s.status"=>1, "ct.status"=>1, "c.status"=>1, 'f.status!='=>9]);
			if($cat_id) {
				$dataQuery->where("f.category_id", $cat_id);
			}
			$get_mealdela = $dataQuery->orderBy('f.title', "ASC")->groupBy('f.id')->find();
			if (!empty($get_mealdela)) {
				foreach ($get_mealdela as $row) {
					$mealRes['id'] = $row['id'];
					$mealRes['name'] = urldecode($row['title']);
					$mealRes['category_id'] = $row['category_id'];
					$mealRes['category_name'] = urldecode($row['category_name']);
					$mealRes['is_available'] = $row['is_available'];
					$mealRes['status'] = $row['f_status'];
					$mealRes['restaurant_name'] = urldecode($row['restaurant_name']);
					$mealRes['image'] = getImagePath(explode(',', $row['image'])[0], 'subcategory');;
					$mealRes['price'] = $row['price'];
					$mealRes['discount'] = $row['discount'];
					$mealRes['latitude'] = $row['latitude'];
					$mealRes['longitude'] = $row['longitude'];
					$mealRes['discount_type'] = $row['discount_type'];
					$mealRes['type'] = $row['type'];
					$mealRes['description'] = urldecode($row['description']);

					$finalResponse[] = $mealRes;
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
	public function notifications()
	{
		header('Content-type: application/x-www-form-urlencoded');
		try {
			$requestData = $this->parseJson();
			$owner_id = $requestData['owner_id'];
			$list = $this->notificationModel->where(['user_id'=>$owner_id, 'status'=>1])->orderBy('id','DESC')->find();
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
	public function accept_decline_order()
	{
		header('Content-type: application/x-www-form-urlencoded');
		try {
			$requestData = $this->parseJson();
			$updateArr['order_status'] = $requestData['order_status'];
			$this->orderModel->update($requestData['order_id'], $updateArr);
			$printarray['code'] = SUCCESS;
			$printarray['message'] = 'Success.';
		} catch (\Exception $e) {
			$printarray['code'] = 500;
			$printarray['message'] = $e->getMessage();
		}
		header('Content-type: application/json');
		echo json_encode($printarray);
	}
	public function change_restaurant_availability()
	{
		header('Content-type: application/x-www-form-urlencoded');
		try {
			$requestData = $this->parseJson();
			$updateArr['is_available'] = $requestData['is_available'];
			$this->restaurantModel->update($requestData['restaurant_id'], $updateArr);
			$printarray['code'] = SUCCESS;
			$printarray['message'] = 'Success.';
		} catch (\Exception $e) {
			$printarray['code'] = 500;
			$printarray['message'] = $e->getMessage();
		}
		header('Content-type: application/json');
		echo json_encode($printarray);
	}

	public function change_product_availability()
	{
		header('Content-type: application/x-www-form-urlencoded');
		try {
			$requestData = $this->parseJson();
			$updateArr['status'] = $requestData['status'];
			$this->subcategoryModel->update($requestData['product_id'], $updateArr);
			$printarray['code'] = SUCCESS;
			$printarray['message'] = 'Success.';
		} catch (\Exception $e) {
			$printarray['code'] = 500;
			$printarray['message'] = $e->getMessage();
		}
		header('Content-type: application/json');
		echo json_encode($printarray);
	}

	public function delete_product($product_id)
	{
		header('Content-type: application/x-www-form-urlencoded');
		try {
			$updateArr['status'] = 9;
			$this->subcategoryModel->update($product_id, $updateArr);
			$this->subcategoryModel->delete(['id', $product_id]);
			$printarray['code'] = SUCCESS;
			$printarray['message'] = 'Success.';
		} catch (\Exception $e) {
			$printarray['code'] = 500;
			$printarray['message'] = $e->getMessage();
		}
		header('Content-type: application/json');
		echo json_encode($printarray);
	}
	public function delete_restaurant($restaurant_id)
	{
		header('Content-type: application/x-www-form-urlencoded');
		try {
			$updateArr['status'] = 9;
			$this->restaurantModel->update($restaurant_id, $updateArr);
			$this->restaurantModel->delete(['id', $restaurant_id]);
			$printarray['code'] = SUCCESS;
			$printarray['message'] = 'Success.';
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
		try {
			$requestData = $this->parseJson();
			
			$get_user =  $this->ownerModel->select('id')->where(array('id' => $requestData['id'], 'status' => 1))->first();
			if (!empty($get_user)) {
				$addArr['first_name'] = $requestData['first_name'];
				$addArr['last_name'] = $requestData['last_name'];
				$addArr['phone'] = $requestData['phone'];
				if ($requestData['image']) {
					$image_base64 = base64_decode($requestData['image']);
					$file_name = uniqid() . '.png';
					$file = FCPATH . 'public/uploads/owners/' . $file_name;
					file_put_contents($file, $image_base64);
					$addArr['image'] = $file_name;
				}
				$update = $this->ownerModel->update($get_user['id'], $addArr);
				if ($update) {
					$get_user =  $this->ownerModel->where(array('id' => $requestData['id']))->first();
					$user['user_id'] = $get_user['id'];
					$user['name'] = urldecode($get_user['first_name'] . ' ' . $get_user['last_name']);
					$user['email'] = urldecode($get_user['email']);
					$user['profile_image'] = getImagePath($get_user['image'], 'owners');
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
	public function getDriverList()
	{
		header('Content-type: application/x-www-form-urlencoded');
		try {
			$requestData = $this->parseJson();
			$lat = $requestData['latitude'];
			$long = $requestData['longitude'];
			$list = $this->userModel->select("d.id, d.fullname, d.status,d.is_available, d.user_type, d.latitude, d.longitude, d.image,d.email, ( 3959 * acos( cos( radians(" . $lat . ") ) * cos( radians( d.latitude ) ) * cos( radians( d.longitude ) - radians(" . $long . ") ) + sin( radians(" . $lat . ") ) * sin(radians(d.latitude)) ) ) AS distance")->from( TBL_USERS . " as d")->groupBy("d.id")->having(["d.status"=>1, "d.is_available"=>1, "user_type"=>2])->orderBy('distance', 'ASC')->find();
			$Drivers = array();
			if (count($list) > 0 && !empty($list)) {
				foreach ($list as $lists) {
					$driver['fullname'] = urldecode($lists['fullname']);
					$driver['email'] = urldecode($lists['email']);
					$driver['driver_id'] = $lists['id'];
					$driver['latitude'] = $lists['latitude'];
					$driver['longitude'] = $lists['longitude'];
					$driver['image'] = getImagePath($lists['image'], 'user');;
					$Drivers[] = $driver;
				}
				$printarray['code'] = SUCCESS;
				$printarray['message'] = 'Success.';
				$printarray['result'] = $Drivers;
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
	public function assignDriver()
	{
		header('Content-type: application/x-www-form-urlencoded');
		try {
			$requestData = $this->parseJson();
			$addArr['order_id'] = $requestData['order_id'];
			$addArr['driver_id'] = $requestData['driver_id'];
			$addArr['owner_id'] = $requestData['owner_id'];
			$this->driverOrderModel->insert($addArr);
			$nArr['title'] = urlencode("Order Assigned");
			$nArr['description'] = urlencode("Order #" . $addArr['order_id'] . " has been assigned to you.");
			$nArr['type'] = 2;
			$nArr['user_id'] = $requestData['driver_id'];
			$nArr['type_id'] = $addArr['order_id'];
			$notification_id = $this->notificationModel->insert($nArr);
			if ($notification_id) {
				$this->sendPushNotification($addArr['driver_id'], $notification_id, 'driver');
			}
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
}

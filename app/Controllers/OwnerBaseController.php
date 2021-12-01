<?php

namespace App\Controllers;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

//use CodeIgniter\Controller;
use App\Models\SettingsModel;
use App\Models\OwnerModel;
use App\Models\CountryModel;
use App\Models\StateModel;
use App\Models\CityModel;
use App\Models\DeviceTokenModel;
use App\Models\NotificationModel;
use App\Models\OrderModel;
use App\Models\RestaurantModel;
use App\Models\UserModel;

class OwnerBaseController extends Controller
{

	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = ['filesystem', 'url', 'Common', 'form', 'cookie'];

	/**
	 * Constructor.
	 */
	protected $session;
	protected $router;
	protected $contoller;
	protected $method;
	protected $settings;
	protected $db;
	protected $adminModel;
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		//helper('Common');
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.:
		// $this->session = \Config\Services::session();


		parent::initController($request, $response, $logger);
		$this->session = \Config\Services::session();
		$this->db = \Config\Database::connect();
		$this->settingModel = new SettingsModel();
		$this->ownerModel = new OwnerModel();
		$this->settings = $this->settingModel->select('*')->where(['status' => 1])->first();
		$this->countryModel = new CountryModel();
		$this->cityModel = new CityModel();
		$this->stateModel = new StateModel();
		$this->notificationModel = new NotificationModel();
		$this->deviceTokenModel = new DeviceTokenModel();
		$this->userModel = new UserModel();
		$this->orderModel = new OrderModel();
		$this->restaurantModel = new RestaurantModel();

		$language = \Config\Services::language();
		$language->setLocale($this->session->lang);
	}

	protected function view_page($page = 'home', $data = array())
	{
		if (!is_file(APPPATH . '/Views/owner/' . $page . '.php')) {
			// Whoops, we don't have a page for that!
			throw new \CodeIgniter\Exceptions\PageNotFoundException($page);
		}


		$data['title'] = ucfirst($page); // Capitalize the first letter
		$data['session'] = $this->session;
		$data['settings'] = $this->settings;
		$data['session_detail'] = $this->session->owner_id ?  $this->ownerModel->where('id', $this->session->owner_id)->first() : array();
		echo view('owner/include/header', $data);
		echo view('owner/include/sidebar', $data);
		echo view('owner/' . $page, $data);
		echo view('owner/include/footer', $data);
		echo view('owner/include/close', $data);
	}


	protected function unlinkFile($image, $folder)
	{
		if ($image) {
			if (file_exists(FCPATH . 'public/uploads/' . $folder . '/' . $image)) {
				unlink(FCPATH . 'public/uploads/' . $folder . '/' . $image);
			}
		}
	}

	public function sendMailToAdmin($id, $password, $emailId)
	{
		$query = $this->ownerModel->where(array('id' => $id))->first();
		
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
		$subject = "New Password";

		$msg = '<html>
						<body>
							<table style="border-spacing:0"  border="1" cellpadding="10" align="center" width="100%" style="border-collapse: collapse;">
								<tr>
									<td>
										<table border="0" cellpadding="0" align="center" style="padding-bottom:20px;">
											<tr>
												<td><h3><font color="#283092">New Password</font></h3></td>
											</tr>
										</table>
										<table border="0" cellpadding="0" width="100%" style="padding-bottom:20px;">
											<tr>
												<td>Dear ' . ucwords(urldecode($query['first_name']) . ' ' . urldecode($query['last_name'])) . ',</td>
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

		$email->setSubject($subject);
		$email->setMessage($msg);

		if ($email->send()) {
			//	echo 'Email successfully sent';
		} else {
			$data = $email->printDebugger();
			// print_r($data);
		}
	}

	public function getState() {
        $country_id= $this->request->getVar('country_id');
        $getstate= $this->stateModel->select('id, name')->where(array('status'=>1, 'country_id'=>$country_id))->find();
        $result= '<option value="">'.lang('Admin.select_state').'</option>';
        foreach($getstate as $value) {
            $result.='<option value="'.$value['id'].'">'.urldecode($value['name']).'</option>';
        }
        echo $result;
    }
    public function getCity() {
        $state_id= $this->request->getVar('state_id');
        $getcity= $this->cityModel->select('id, name')->where(array('status'=>1, 'state_id'=>$state_id))->find();
        $result= '<option value="">'.lang('Admin.select_city').'</option>';
        foreach($getcity as $value) {
            $result.='<option value="'.$value['id'].'">'.urldecode($value['name']).'</option>';
        }
        echo $result;
    }
	

	protected function sendPushNotification($user_id,  $notification_id, $type = null)
	{

		if ($type == "driver") {
			$getToken = $this->userModel->where(array('status' => 1, 'id' => $user_id))->find();
		}else {
			$getToken = $this->deviceTokenModel->where(array('status' => 1, 'user_id' => $user_id))->find();
		
		}
		
		$token = array();
		foreach ($getToken as $getTokens) {
			$token[] = $getTokens['device_token'];
		}
		//print_r($token);
		$getNotification = $this->notificationModel->where(array('status' => 1, 'id' => $notification_id))->first();

		$title = urldecode($getNotification['title']);
		$message = urldecode($getNotification['description']);


		$path_to_firebase_cm = 'https://fcm.googleapis.com/fcm/send';


		$fields = array(
			'registration_ids' => $token,
			'priority' => 10,
			'notification' => array('title' => $title, 'body' =>  $message, 'sound' => 'default', 'badge' => "1", 'type_id' => $getNotification['type_id']),
		);
		$headers = array(
			'Authorization:key=' . $this->settings['fcm_key'],
			'Content-Type:application/json'
		);

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $path_to_firebase_cm);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		// Execute post   
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}

}

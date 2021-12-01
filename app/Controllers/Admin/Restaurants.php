<?php

namespace App\Controllers\Admin;

use App\Controllers\AdminBaseController;
use App\Models\CategoryModel;
use App\Models\SubcategoryModel;
use App\Models\EarningModel;
use App\Models\OwnerModel;

class Restaurants extends AdminBaseController
{

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->categoryModel = new CategoryModel();
        $this->subcategoryModel = new SubcategoryModel();
        $this->earningModel = new EarningModel();
        $this->ownerModel = new OwnerModel();
    }
    public function index()
    {


        $data['results'] = $this->restaurantModel->select("r.*, o.first_name, o.last_name, s.name as state_name, ct.name as city_name, c.name as country_name")->from(TBL_RESTAURANTS . ' as r')->join(TBL_STATE . ' as s', "s.id=r.state_id")->join(TBL_CITY . ' as ct', "ct.id=r.city_id")->join(TBL_COUNTRY . " as c", "c.id=r.country_id")->join(TBL_OWNERS . " as o", "o.id=r.owner_id", "LEFT")->where('r.deleted', NULL)->orderBy('r.id', 'DESC')->groupBy('r.id')->find();

        $this->view_page('restaurants/index', $data);
    }

    public function delete()
    {

        if(ENVIRONMENT!='demo') {
            $id= $this->request->getVar('id');
            $this->restaurantModel->update($id, ['status' => 9]);
            if($this->restaurantModel->delete(array('id' => $id))){
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

    public function multiple_delete()
    {
        if(ENVIRONMENT!='demo') {
            $ids= $this->request->getVar('id');
            foreach($ids as $id){
                $this->restaurantModel->update($id, ['status' => 9]);
                $this->restaurantModel->delete(array('id' => $id));
            }
            $data['success'] =1;
            $data['message'] = lang('Admin.data_deleted_successfully');
            
        }else {
            $data['message'] = lang('Admin.this_operation_not_permited_in_demo_mode');
        }
        echo json_encode($data);
    }

    public function add()
    {
        if ($_POST && !empty($_POST)) {

            $data_array['name'] = urlencode($this->request->getVar('name'));
            $data_array['owner_id'] = $this->request->getVar('owner_id');
            $data_array['email'] = urlencode($this->request->getVar('email_id'));
            $data_array['phone'] = $this->request->getVar('phone_number');
            $data_array['city_id'] = $this->request->getVar('city_id');
            $data_array['state_id'] = $this->request->getVar('state_id');
            $data_array['country_id'] = $this->request->getVar('country_id');
            $data_array['pincode'] = $this->request->getVar('pincode');
            $data_array['address'] = urlencode($this->request->getVar('address'));
            $data_array['discount'] = $this->request->getVar('discount');
            $data_array['discount_type'] = $this->request->getVar('discount_type');
            $data_array['average_price'] = $this->request->getVar('average_price');
            $data_array['opening_time'] = date('H:i:s', strtotime($this->request->getVar('opening_time')));
            $data_array['closing_time'] = date('H:i:s', strtotime($this->request->getVar('closing_time')));
            $data_array['profile_image'] = "";
            $address = urldecode($data_array['address']) . ' ' . $data_array['pincode']; // Google HQ
            $prepAddr = str_replace(' ', '+', $address);
            $geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?address=' . $prepAddr . '&sensor=false' . '&key=' . $this->settings['map_api_key']);
            $output = json_decode($geocode);
            if ($output->results[0] && $output->results[0]->geometry && $output->results[0]->geometry->location && $output->results[0]->geometry->location->lat) {
                $latitude = $output->results[0]->geometry->location->lat;
                $longitude = $output->results[0]->geometry->location->lng;
                $data_array['latitude'] = $latitude;
                $data_array['longitude'] = $longitude;
                if (!empty($_FILES['profile_image']['name'])) {

                    $img = $this->request->getFile('profile_image');
                    $newName = $img->getRandomName();
                    $img->move(FCPATH . 'public/uploads/restaurants/profile', $newName);
    
                    $data_array['profile_image'] = $img->getName();
                }
                if ($this->restaurantModel->insert($data_array)) {
                    $this->session->setFlashdata('success', lang('Admin.shop_added_successfully'));
                    return redirect()->to(base_url('admin/restaurants'));
                } else {
                    $this->session->setFlashdata('error', lang('Admin.error_try_again'));
                }
            } else {
                $this->session->setFlashdata('error', lang('Admin.invalid_address'));
            }
        }
        $data['country'] = $this->countryModel->select('id, name')->where(array('status' => 1))->find();
        $data['owners'] = $this->ownerModel->select('id, first_name, last_name')->where(array('status' => 1))->find();
        $this->view_page('restaurants/add', $data);
    }

    public function edit($id)
    {
        $data['results'] = $this->restaurantModel->where(array('id' => $id))->first();
        if (!$id || empty($data['results'])) {
            $this->session->setFlashdata('error', lang('Admin.data_not_found'));
            return redirect()->to(base_url('admin/restaurants'));
        }

        if ($_POST && !empty($_POST)) {

            $data_array['name'] = urlencode($this->request->getVar('name'));
            $data_array['owner_id'] = $this->request->getVar('owner_id');
            $data_array['email'] = urlencode($this->request->getVar('email_id'));
            $data_array['phone'] = $this->request->getVar('phone_number');
            $data_array['city_id'] = $this->request->getVar('city_id');
            $data_array['state_id'] = $this->request->getVar('state_id');
            $data_array['country_id'] = $this->request->getVar('country_id');
            $data_array['pincode'] = $this->request->getVar('pincode');
            $data_array['address'] = urlencode($this->request->getVar('address'));
            $data_array['discount'] = $this->request->getVar('discount');
            $data_array['discount_type'] = $this->request->getVar('discount_type');
            $data_array['average_price'] = $this->request->getVar('average_price');
            $data_array['opening_time'] = date('H:i:s', strtotime($this->request->getVar('opening_time')));
            $data_array['closing_time'] = date('H:i:s', strtotime($this->request->getVar('closing_time')));
            $address = urldecode($data_array['address']) . ' ' . $data_array['pincode']; // Google HQ
            $prepAddr = str_replace(' ', '+', $address);
            $geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?address=' . $prepAddr . '&sensor=false' . '&key=' . $this->settings['map_api_key']);
            $output = json_decode($geocode);

            if ($output->results[0] && $output->results[0]->geometry && $output->results[0]->geometry->location && $output->results[0]->geometry->location->lat) {
                $latitude = $output->results[0]->geometry->location->lat;
                $longitude = $output->results[0]->geometry->location->lng;
                $data_array['latitude'] = $latitude;
                $data_array['longitude'] = $longitude;
                if (!empty($_FILES['profile_image']['name'])) {

                    $img = $this->request->getFile('profile_image');
                    $newName = $img->getRandomName();
                    $img->move(FCPATH . 'public/uploads/restaurants/profile', $newName);
    
                    $data_array['profile_image'] = $img->getName();
                    $this->unlinkFile($data['results']['profile_image'], 'restaurants');
                }
                if ($this->restaurantModel->update($id, $data_array)) {
                    $this->session->setFlashdata('success', lang('Admin.shop_updated_successfully'));
                    return redirect()->to(base_url('admin/restaurants'));
                } else {
                    $this->session->setFlashdata('error', lang('Admin.error_try_again'));
                }
            } else {
                $this->session->setFlashdata('error', lang('Admin.invalid_address'));
            }
        }
        $data['owners'] = $this->ownerModel->select('id, first_name, last_name')->where(array('status' => 1))->find();
         $data['country'] = $this->countryModel->select('id, name')->where(array('status' => 1))->find();
        $data['state'] = $this->stateModel->select('id, name')->where(array('status' => 1, 'country_id' => $data['results']['country_id']))->find();
        $data['city'] = $this->cityModel->select('id, name')->where(array('status' => 1, 'state_id' => $data['results']['state_id']))->find();
        $this->view_page('restaurants/edit', $data);
    }

    

    public function view($id)
    {

        $data['restaurant_info'] =  $this->restaurantModel->select('r.*, ct.name as city_name, s.name as state_name, c.name as country_name')->from(TBL_RESTAURANTS . " as r")->join(TBL_CITY . " as ct", " ct.id=r.city_id", "INNER")->join(TBL_STATE . " as s ", " s.id=r.state_id", 'INNER')->join(TBL_COUNTRY . " as c ", " c.id=r.country_id", 'INNER')->where(['r.id' => $id])->first();
               
        $data['controller'] = $this;

        if (empty($data['restaurant_info'])) {
            $this->session->setFlashdata('error', lang('Admin.order_not_found'));
            return redirect()->to(base_url('admin/restaurants'));
        }

        $data['categories'] = $this->categoryModel->select("c.*")->from(TBL_CATEGORIES . ' as c')->join(TBL_SUBCATEGORIES . ' as s', "s.category_id=c.id")->where(array('s.restaurant_id=' => $id, 's.status' => 1))->groupBy('c.id')->find();

        $this->view_page("restaurants/view", $data);
    }

    function invoice($id)
    {

        $data['restaurant_id'] = $id;
        $data['invoice_info'] = $this->orderModel->select("o.*, e.admin_charge_amount, e.owners_amount, e.total_amount, e.payment_status, e.payment_date")->from(TBL_ORDERS . ' as o')->join(TBL_EARNINGS . ' as e' , "e.order_id=o.id", "INNER")->where(array('e.order_id=' => $id, 'o.status' => 1, 'e.status' => 1))->groupBy('o.id')->orderBy('o.id', 'DESC')->find();
        $this->view_page("restaurants/invoice", $data);
    }

    function pay($id, $payable_Amount)
    {


        if ($this->sendInvoiceEmailToOwner($id, $payable_Amount)) {
            $this->earningModel->where(array('restaurent_id' => $id, 'payment_status' => 0, 'status' => 1))->set(array('payment_status' => 1, 'payment_date' => date('Y-m-d H:i:s')))->update();
            
            $this->session->setFlashdata('success', lang('Admin.payment_mail_sent'));
        } else {
            $this->session->setFlashdata('error', lang('Admin.error_try_again'));
        }
        return redirect()->to(base_url('admin/restaurants') . '/invoice/' . $id);
    }

    public function getProducts($res_id, $cat_id){
        $data = $this->subcategoryModel->where(array('deleted'=>NULL, "category_id"=>$cat_id, "restaurant_id"=>$res_id))->find();

        return $data;
    }
}

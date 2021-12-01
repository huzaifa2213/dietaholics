<?php

namespace App\Models;

use CodeIgniter\Model;

class BaseModel extends Model
{
    protected $table      = 'tbl_admin';

    public function getCookDetails($cook_id)
    {

        $this->join('tbl_cook_ratings as r', 'u.id = r.cook_id', 'LEFT');
        $this->select('ROUND( AVG(r.review),1 ) as review, COUNT(r.id) as total_review');
        $this->select('u.name as cook_name, u.id as cook_id, u.latitude, u.longitude, u.email, u.phone, u.image, u.address_line_1, u.address_line_2, u.city, u.state, u.pincode, u.country');
        $this->from('tbl_users as u');
        $this->where(array('md5(u.id)' => $cook_id, 'u.status' => 1, 'u.user_type'=>2));
        $this->groupBy('u.id');
        $result = $this->first();
        if(!empty($result))
            $result['latest_reviews'] = $this->select('r.review, r.message, u.name, u.image, r.id')->from('tbl_cook_ratings as r')->join('tbl_users as u', 'u.id=r.customer_id', 'INNER')->where(['r.cook_id' => $cook_id, 'r.status' => 1])->orderBy('r.id', 'DESC')->limit(2, 0)->find();
        



        return  $result;
    }

    public function getCookDateWiseDishes($cook_id, $date, $dish_id=null, $limit=null) {

       $this->select('d.name, d.id, d.banner_image, d.description, d.discount, d.price, d.cutoff_time, d.discount_type, d.type, ct.title as category, c.title as cuisine, d.start_time, d.end_time, d.is_delivery, d.is_takeaway')->from('tbl_dishes as d')->join('tbl_available_dates as ad', 'ad.dish_id=d.id', 'INNER')->join('tbl_categories as ct', 'ct.id=d.category_id', 'INNER')->join('tbl_cuisines as c', 'c.id=d.cuisine_id')->where(['d.status'=>1, 'ad.status'=>1, 'ad.date'=>date('Y-m-d', strtotime($date)), 'd.cook_id'=>$cook_id]);
    //    $current_date= strtotime(date('Y-m-d'));
    //    if($current_date ==strtotime($date)) {
    //     $this->where('d.cutoff_time>=', date('H:i:s'));
    //    }
       if($dish_id) {
           $this->where('d.id!=', $dish_id);
       }
       if($limit) {
        $this->limit($limit,0);
       }
       
       $data = $this->groupBy('d.id')->find();
        return $data;

    }

    public function getCartData($customer_id) {
        //$data =$this->select('c.id as cart_id, d.name, d.id as dish_id, d.banner_image, d.description, d.type, c.pickup_date, c.is_pickup, c.quantity, c.dish_price, c.discount_price, c.note, c.cook_id, u.name as cook_name, u.image as cook_image, u.address_line_1, u.address_line_2, u.pincode, u.city, u.state, c.pickup_time')->from('tbl_cart as c')->join('tbl_dishes as d', 'c.dish_id=d.id', 'INNER')->join('tbl_users as u', 'c.cook_id=u.id', 'INNER')->where(['d.status'=>1, 'c.status'=>0, 'c.customer_id'=>$customer_id])->groupBy('c.id')->find();

        $data =$this->select('u.name as cook_name, u.image as cook_image, u.address_line_1, u.address_line_2, u.pincode, u.city, u.state, u.id')->from('tbl_cart as c')->join('tbl_dishes as d', 'c.dish_id=d.id', 'INNER')->join('tbl_users as u', 'c.cook_id=u.id', 'INNER')->where(['d.status'=>1, 'c.status'=>0, 'c.customer_id'=>$customer_id])->groupBy('c.id')->find();

        
        return $data;

    }

    public function getCustomerDetails($customer_id) {
        $this->select('u.name as customer_name, u.email, u.phone, u.image, u.id');
        $this->from('tbl_users as u');
        $this->where(array('u.id' => $customer_id, 'u.status' => 1));
        $result = $this->first();

        return  $result;

    }

    public function getOrderList($customer_id, $parentID=null) {
        $getRecord =$this->select('o.id as order_id, o.customer_id, o.cook_id, o.total_price, o.delivery_charge, o.discount_price, o.grand_total, o.address, o.pincode, o.city, o.state, o.latitude, o.longitude, o.created, u.name as cook_name, u.city as user_city, u.state as user_state, u.pincode as user_pincode, u.address_line_1 as user_address_line_1, u.address_line_2 as user_address_line_2, u.image, o.order_status, , o.transaction_id, o.order_date, o.isReviewed, o.parent_order_id, u.email as cook_email, u.phone as cook_phone')->from('tbl_orders as o')->join('tbl_users as u', 'u.id=o.cook_id', 'INNER');
        
        $getRecord->where(['o.status'=>1, 'o.customer_id'=>$customer_id]);
        if($parentID){
            $getRecord->where(['o.parent_order_id'=>$parentID]);
        }
        $getRecord->groupBy('o.id')->orderBy('o.id', 'desc');
        $data = $getRecord->find();
        // print_r($data);
        // die;
        return $data;
    }

    public function getOrderDetails($order_id) {
        $this->select('o.id as order_id, o.customer_id, o.cook_id, o.total_price, o.delivery_charge, o.discount_price, o.grand_total, o.admin_charge, o.address, o.pincode, o.city, o.state, o.latitude, o.longitude, o.created, o.promo_code, u.name as cook_name, u.image, u.email as cook_email, u.phone as cook_phone, c.phone as customer_phone, c.email as customer_email, u.address_line_1 as c_address_line_1, u.address_line_2 as c_address_line_2, u.city as c_city, u.state as c_state, u.country as c_country, u.pincode as c_pincode, u.latitude as c_latitude, u.longitude as c_longitude, c.name as customer_name, , o.order_status, o.transaction_id');
        $this->from('tbl_orders as o');
        $this->join('tbl_users as u', 'u.id=o.cook_id', 'INNER');
        $this->join('tbl_users as c', 'c.id=o.customer_id', 'INNER');
        $this->where(array('md5(o.id)' => $order_id, 'o.status' => 1));
        $result = $this->first();


        return  $result;
    }

    public function getBookmarkedCooks($customer_id, $latitude, $longitude) {
        $data = $this->db->query("select *, ROUND( AVG(tbl.review),1 ) as review from (select u.id, f.status, f.cook_id, f.customer_id, u.name, u.address_line_1, u.address_line_2, u.city, r.review, u.image, u.state, u.country, u.pincode,  u.status as user_status, u.delivery_distance, u.latitude, u.longitude, ( 3959 * acos( cos( radians(" . $latitude . ") ) * cos( radians( latitude ) ) 
        * cos( radians( longitude ) - radians(" . $longitude . ") ) + sin( radians(" . $latitude . ") ) * sin(radians(latitude)) ) ) AS distance FROM tbl_follow_cook as f INNER JOIN tbl_users as u  ON u.id=f.cook_id LEFT JOIN tbl_cook_ratings as r ON r.cook_id=u.id  HAVING u.status=1 and f.status=1 and f.customer_id = ".$customer_id."  ORDER BY f.id DESC ) as tbl group by tbl.id")->getResult();
        
        return $data;
    }

    public function getWishlistData($customer_id, $latitude, $longitude) {
        $getDishes = $this->db->query("select f.customer_id, f.status, d.id as dish_id, u.id as cook_id, u.name as cook_name, d.name, ct.title as category, c.title as cuisine, d.discount_type, d.discount, d.price, d.banner_image, is_takeaway, is_delivery, cutoff_time, d.start_time, d.end_time, type, u.status as user_status, d.status as dish_status, u.delivery_distance, u.image, u.state as cook_state, u.city as cook_city, u.pincode as cook_pincode,u.latitude, u.longitude, ( 3959 * acos( cos( radians(" . $latitude . ") ) * cos( radians( latitude ) ) 
            * cos( radians( longitude ) - radians(" . $longitude . ") ) + sin( radians(" . $latitude . ") ) * sin(radians(latitude)) ) ) AS distance from tbl_favorite_dishes as f INNER JOIN  tbl_dishes as d ON d.id=f.dish_id INNER JOIN tbl_users as u ON u.id=d.cook_id LEFT JOIN tbl_categories as ct ON ct.id=d.category_id LEFT JOIN tbl_cuisines as c ON c.id=d.cuisine_id HAVING u.status=1 and d.status=1 AND f.status=1 AND f.customer_id=".$customer_id." ORDER BY f.id")->getResult();
        //     $sql = $this->db->getLastQuery()->getQuery();
        // echo $sql;
        // die;
            return $getDishes;
    }
    public function getCookCuisines($cook_id) {
        $this->join('tbl_users as u', 'u.id = d.cook_id', 'INNER');
        $this->join('tbl_cuisines as cu', 'cu.id = d.cuisine_id', 'INNER');
         $this->select('cu.title as cuisine');
        $this->from('tbl_dishes as d ');
        $this->where(array('u.id'=>$cook_id, 'd.status'=>1, 'cu.status'=>1));
        $this->groupBy('cu.id');
        $result = $this->findAll();
          
        return  $result;
    }

    public function getDistance($latitude, $longitude, $cook_id) {
        $getData =$this->db->query("select u.id,  ( 3959 * acos( cos( radians(" . $latitude . ") ) * cos( radians( latitude ) ) 
        * cos( radians( longitude ) - radians(" . $longitude . ") ) + sin( radians(" . $latitude . ") ) * sin(radians(latitude)) ) ) AS distance from tbl_users as u HAVING u.id=".$cook_id)->getResult();
        return distanceFormat($getData[0]->distance);
       // die;
    }


}

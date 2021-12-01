<?php

namespace App\Controllers\Admin;

use App\Controllers\AdminBaseController;
use App\Models\CouponModel;

class Coupons extends AdminBaseController
{

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->couponModel = new CouponModel();
    }
    public function index()
    {
        $data['results'] =  $this->couponModel->orderBy('id', 'desc')->find();

        $this->view_page('coupons/index', $data);
    }

    public function delete()
    {

        if(ENVIRONMENT!='demo') {
            $id= $this->request->getVar('id');
            $this->couponModel->update($id, ['status' => 9]);
            if($this->couponModel->delete(array('id' => $id))){
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
                $this->couponModel->update($id, ['status' => 9]);
                $this->couponModel->delete(array('id' => $id));
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

            $data_array['coupon_code'] = $this->request->getVar('coupon_code');
            $data_array['description'] = urlencode($this->request->getVar('description'));
            $data_array['start_date'] = date('Y-m-d', strtotime($this->request->getVar('start_date')));
            $data_array['end_date'] = date('Y-m-d', strtotime($this->request->getVar('end_date')));
            $data_array['discount'] = $this->request->getVar('discount');
            $data_array['discount_type'] = $this->request->getVar('discount_type');
            if (!empty($_FILES['image']['name'])) {

                $img = $this->request->getFile('image');
                $newName = $img->getRandomName();
                $img->move(FCPATH . 'public/uploads/coupons', $newName);

                $data_array['image'] = $img->getName();
            }

            if ($this->couponModel->insert($data_array)) {
                $this->session->setFlashdata('success', lang('Admin.coupon_added_successfully'));
                return redirect()->to(base_url('admin/coupons'));
            } else {
                $this->session->setFlashdata('error', lang('Admin.error_try_again'));
            }
        }
        $this->view_page('coupons/add');
    }

    public function edit($id)
    {
        $data['results'] = $this->couponModel->where(array('id' => $id))->first();
        if (!$id || empty($data['results'])) {
            $this->session->setFlashdata('error', lang('Admin.data_not_found'));
            return redirect()->to(base_url('admin/coupons'));
        }

        if ($_POST && !empty($_POST)) {

            $data_array['coupon_code'] = $this->request->getVar('coupon_code');
            $data_array['description'] = urlencode($this->request->getVar('description'));
            $data_array['start_date'] = date('Y-m-d', strtotime($this->request->getVar('start_date')));
            $data_array['end_date'] = date('Y-m-d', strtotime($this->request->getVar('end_date')));
            $data_array['discount'] = $this->request->getVar('discount');
            $data_array['discount_type'] = $this->request->getVar('discount_type');
            if (!empty($_FILES['image']['name'])) {

                $img = $this->request->getFile('image');
                $newName = $img->getRandomName();
                $img->move(FCPATH . 'public/uploads/coupons', $newName);

                $data_array['image'] = $img->getName();
                $this->unlinkFile($data['results']['image'], 'user');
            }
            if ($this->couponModel->update($id, $data_array)) {
                $this->session->setFlashdata('success', lang('Admin.coupon_updated_successfully'));
                return redirect()->to(base_url('admin/coupons'));
            } else {
                $this->session->setFlashdata('error', lang('Admin.error_try_again'));
            }
        }
        $this->view_page('coupons/edit', $data);
    }
}

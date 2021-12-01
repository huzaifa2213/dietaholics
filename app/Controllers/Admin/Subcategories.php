<?php

namespace App\Controllers\Admin;

use App\Controllers\AdminBaseController;
use App\Models\CategoryModel;
use App\Models\SubcategoryModel;

class SubCategories extends AdminBaseController
{

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->categoryModel = new CategoryModel();
        $this->subcategoryModel = new SubcategoryModel();
    }
    public function index()
    {
        $data['results'] = $this->subcategoryModel->select("s.*, c.title as cat_title, r.name as restaurant_name")->from(TBL_SUBCATEGORIES . ' as s')->join(TBL_CATEGORIES . ' as c', "c.id=s.category_id")->join(TBL_RESTAURANTS . ' as r', "r.id=s.restaurant_id")->where(array('s.status!=' => 9))->orderBy('s.id', 'desc')->groupBy('s.id')->find();
        $this->view_page('subcategories/index', $data);
    }
    public function add($restaurant_id = false)
    {
        if ($_POST && !empty($_POST)) {

            $data_array['title'] = urlencode($this->request->getVar('title'));
            $data_array['category_id'] = $this->request->getVar('category_id');
            $data_array['type'] = $this->request->getVar('type');
            $data_array['restaurant_id'] = $this->request->getVar('restaurant_id');
            $data_array['description'] = urlencode($this->request->getVar('description'));
            $data_array['discount_type'] = $this->request->getVar('discount_type');
            $data_array['price'] = $this->request->getVar('price');
            $data_array['discount'] = $this->request->getVar('discount');
            $data_array['image'] = "";

            if (!empty($_FILES['image']['name'])) {

                $img = $this->request->getFile('image');
                $newName = $img->getRandomName();
                $img->move(FCPATH . 'public/uploads/subcategory', $newName);

                $data_array['image'] = $img->getName();
            }
            if ($this->subcategoryModel->insert($data_array)) {
                $this->session->setFlashdata('success', lang('Admin.subcategory_added_successfully'));
                return redirect()->to(base_url('admin/subcategories'));
            } else {
                $this->session->setFlashdata('error', lang('Admin.error_try_again'));
            }
        }
        $data['restaurant_id'] = $restaurant_id;
        $data['restaurants'] = $this->restaurantModel->select('id, name')->where(array('status' => 1))->find();
        $data['foodcategory'] = $this->categoryModel->select('id, title')->where(array('status' => 1))->find();
        $this->view_page('subcategories/add', $data);
    }
    public function delete()
    {

        if(ENVIRONMENT!='demo') {
            $id= $this->request->getVar('id');
            $this->subcategoryModel->update($id, ['status' => 9]);
            if($this->subcategoryModel->delete(array('id' => $id))){
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
                $this->subcategoryModel->update($id, ['status' => 9]);
                $this->subcategoryModel->delete(array('id' => $id));
            }
            $data['success'] =1;
            $data['message'] = lang('Admin.data_deleted_successfully');
            
        }else {
            $data['message'] = lang('Admin.this_operation_not_permited_in_demo_mode');
        }
        echo json_encode($data);
    }

    public function edit($id)
    {
        $data['results'] = $this->subcategoryModel->where(array('id' => $id))->first();
        if (!$id || empty($data['results'])) {
            $this->session->setFlashdata('error', lang('Admin.data_not_found'));
            return redirect()->to(base_url('admin/subcategories'));
        }

        if ($_POST && !empty($_POST)) {

            $data_array['title'] = urlencode($this->request->getVar('title'));
            $data_array['category_id'] = $this->request->getVar('category_id');
            $data_array['type'] = $this->request->getVar('type');
            $data_array['restaurant_id'] = $this->request->getVar('restaurant_id');
            $data_array['description'] = urlencode($this->request->getVar('description'));
            $data_array['discount_type'] = $this->request->getVar('discount_type');
            $data_array['price'] = $this->request->getVar('price');
            $data_array['discount'] = $this->request->getVar('discount');
            if (!empty($_FILES['image']['name'])) {

                $img = $this->request->getFile('image');
                $newName = $img->getRandomName();
                $img->move(FCPATH . 'public/uploads/subcategory', $newName);

                $data_array['image'] = $img->getName();
                $this->unlinkFile($data['results']['image'], 'subcategory');
            }
            if ($this->subcategoryModel->update($id, $data_array)) {
                $this->session->setFlashdata('success', lang('Admin.subcategory_updated_successfully'));
                return redirect()->to(base_url('admin/subcategories'));
            } else {
                $this->session->setFlashdata('error', lang('Admin.error_try_again'));
            }
        }
        $data['restaurants'] = $this->restaurantModel->select('id, name')->where(array('status' => 1))->find();
        $data['foodcategory'] = $this->categoryModel->select('id, title')->where(array('status' => 1))->find();
        $this->view_page('subcategories/edit', $data);
    }
}

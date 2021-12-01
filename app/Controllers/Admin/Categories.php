<?php

namespace App\Controllers\Admin;

use App\Controllers\AdminBaseController;
use App\Models\CategoryModel;

class Categories extends AdminBaseController
{

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->categoryModel = new CategoryModel();
    }
    public function index()
    {
        $data['results'] =  $this->categoryModel->orderBy('id', 'desc')->find();
        $this->view_page('categories/index', $data);
    }
    public function add()
    {
        if ($_POST && !empty($_POST)) {

            $data_array['title'] = urlencode($this->request->getVar('title'));
            $data_array['image'] = "";

            if (!empty($_FILES['image']['name'])) {

                $img = $this->request->getFile('image');
                $newName = $img->getRandomName();
                $img->move(FCPATH . 'public/uploads/category', $newName);

                $data_array['image'] = $img->getName();
            }
            if ($this->categoryModel->insert($data_array)) {
                $this->session->setFlashdata('success', lang('Admin.category_added_successfully'));
                return redirect()->to(base_url('admin/categories'));
            } else {
                $this->session->setFlashdata('error', lang('Admin.error_try_again'));
            }
        }
        $this->view_page('categories/add');
    }
    public function delete()
    {
        if(ENVIRONMENT!='demo') {
            $id= $this->request->getVar('id');
            $this->categoryModel->update($id, ['status' => 9]);
            if($this->categoryModel->delete(array('id' => $id))){
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
                $this->categoryModel->update($id, ['status' => 9]);
                $this->categoryModel->delete(array('id' => $id));
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
        $data['results'] = $this->categoryModel->where(array('id' => $id))->first();
        if (!$id || empty($data['results'])) {
            $this->session->setFlashdata('error', lang('Admin.data_not_found'));
            return redirect()->to(base_url('admin/categories'));
        }
        if ($_POST && !empty($_POST)) {

            $data_array['title'] = urlencode($this->request->getVar('title'));
            if (!empty($_FILES['image']['name'])) {

                $img = $this->request->getFile('image');
                $newName = $img->getRandomName();
                $img->move(FCPATH . 'public/uploads/category', $newName);

                $data_array['image'] = $img->getName();
                $this->unlinkFile($data['results']['image'], 'category');
            }
            if ($this->categoryModel->update($id, $data_array)) {
                $this->session->setFlashdata('success', lang('Admin.category_updated_successfully'));
                return redirect()->to(base_url('admin/categories'));
            } else {
                $this->session->setFlashdata('error', lang('Admin.error_try_again'));
            }
        }

        $this->view_page('categories/edit', $data);
    }
}

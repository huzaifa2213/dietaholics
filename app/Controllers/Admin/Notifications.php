<?php

namespace App\Controllers\Admin;

use App\Controllers\AdminBaseController;

class Notifications extends AdminBaseController
{

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }
    public function index()
    {
        $data['results'] =  $this->notificationModel->where(array('type' => 0))->find();
        $this->view_page('notification/index', $data);
    }
    public function add()
    {
        if ($_POST && !empty($_POST)) {

            $data_array['title'] = urlencode($this->request->getVar('title'));
            $data_array['description'] = urlencode($this->request->getVar('description'));
            $notification_id = $this->notificationModel->insert($data_array);
            if ($notification_id) {
                $get_all_users = $this->userModel->select("id")->where(array('status' => 1))->find();
                foreach ($get_all_users as $rows) {
                    $this->sendPushNotification($rows['id'], $notification_id);
                }

                $this->session->setFlashdata('success', lang('Admin.notification_added_successfully'));
                return redirect()->to(base_url('admin/notifications'));
            } else {
                $this->session->setFlashdata('error', lang('Admin.error_try_again'));
            }
        }
        $this->view_page('notification/add');
    }
    public function delete()
    {
        if(ENVIRONMENT!='demo') {
            $id= $this->request->getVar('id');
            if($this->notificationModel->delete(array('id' => $id))){
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
                $this->notificationModel->delete(array('id' => $id));
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
        $data['results'] = $this->notificationModel->where(array('id' => $id))->first();
        if (!$id || empty($data['results'])) {
            $this->session->setFlashdata('error', lang('Admin.data_not_found'));
            return redirect()->to(base_url('admin/notifications'));
        }

        if ($_POST && !empty($_POST)) {

            $data_array['title'] = urlencode($this->request->getVar('title'));
            $data_array['description'] = urlencode($this->request->getVar('description'));
            if ($this->notificationModel->update($id, $data_array)) {
                $this->session->setFlashdata('success', lang('Admin.notification_updated_successfully'));
                return redirect()->to(base_url('admin/notifications'));
            } else {
                $this->session->setFlashdata('error', lang('Admin.error_try_again'));
            }
        }

        $this->view_page('notification/edit', $data);
    }
}

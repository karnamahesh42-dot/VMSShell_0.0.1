<?php

namespace App\Controllers;

use App\Models\NotificationModel;
use App\Models\NotificationUserModel;

class NotificationController extends BaseController
{
    protected $notificationModel;
    protected $notificationUserModel;

    public function __construct()
    {
        $this->notificationModel = new NotificationModel();
        $this->notificationUserModel = new NotificationUserModel();
    }

    public function index()
    {
        $data['notifications'] = $this->notificationModel
            ->orderBy('id','DESC')
            ->findAll();

        $data['users'] = db_connect()->table('users')->get()->getResultArray();
        
        // Fetch departments and roles
        $data['departments'] = db_connect()->table('departments')->get()->getResultArray();
        $data['roles'] = db_connect()->table('roles')->get()->getResultArray();

        return view('dashboard/notifications', $data);
    }

    public function store()
    {
        $file = $this->request->getFile('attachment');
        $filePath = null;

        if ($file && $file->isValid()) {
            $newName = $file->getRandomName();
            $file->move('uploads/notifications/', $newName);
            $filePath = 'uploads/notifications/' . $newName;
        }

        $notificationId = $this->notificationModel->insert([
            'title' => $this->request->getPost('title'),
            'message' => $this->request->getPost('message'),
            'type' => $this->request->getPost('type'),
            'category' => $this->request->getPost('category'),
            'attachment' => $filePath
        ]);

        // Get selected departments and roles
        $selectedDepartments = $this->request->getPost('departments');
        $selectedRoles = $this->request->getPost('roles');

        // Build query to get users based on selection
        $db = db_connect();
        $query = $db->table('users');

        // Apply filters based on selections
        if (!empty($selectedDepartments) || !empty($selectedRoles)) {
            if (!empty($selectedDepartments) && !empty($selectedRoles)) {
                // If both are selected, get users matching ANY department AND ANY role
                $query->whereIn('department_id', $selectedDepartments)
                      ->whereIn('role_id', $selectedRoles);
            } elseif (!empty($selectedDepartments)) {
                // If only departments selected
                $query->whereIn('department_id', $selectedDepartments);
            } elseif (!empty($selectedRoles)) {
                // If only roles selected
                $query->whereIn('role_id', $selectedRoles);
            }
        }

        $selectedUsers = $query->select('id')->get()->getResultArray();
        // Insert selected users into notification_users
        if ($selectedUsers) {
            foreach ($selectedUsers as $user) {
                $this->notificationUserModel->insert([
                    'notification_id' => $notificationId,
                    'user_id' => $user['id'],
                    'is_read' => 0
                ]);
            }
        }

        return $this->response->setJSON([
            "status" => "success",
            "message" => "Notification Created Successfully"
        ]);
    }

    public function delete($id)
    {
        $this->notificationModel->delete($id);

        return $this->response->setJSON([
            "status" => "success",
            "message" => "Deleted Successfully"
        ]);
    }

        public function update()
        {
            $id = $this->request->getPost('id');

            $data = [
                'title'   => $this->request->getPost('title'),
                'message' => $this->request->getPost('message'),
                'type'    => $this->request->getPost('type'),
                'category' => $this->request->getPost('category'),
            ];

            $file = $this->request->getFile('attachment');

            if ($file && $file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move('uploads/notifications/', $newName);
                $data['attachment'] = 'uploads/notifications/' . $newName;
            }

            $this->notificationModel->update($id, $data);

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Notification updated successfully'
            ]);
        }


public function markRead()
{
    $session = session();
    $userId = $session->get('user_id');

    $model = new \App\Models\NotificationUserModel();

    $model->where('user_id', $userId)
          ->where('is_read', 0)
          ->set(['is_read' => 1, 'read_at' => date('Y-m-d H:i:s')])
          ->update();

    return $this->response->setJSON(['status' => 'success']);
}

    
public function getUnread()
{
    $session = session();
    $userId = $session->get('user_id');

    $model = new \App\Models\NotificationUserModel();

    $notifications = $model->select('notifications.*')
        ->join('notifications', 'notifications.id = notification_users.notification_id')
        ->where('notification_users.user_id', $userId)
        ->where('notification_users.is_read', 0)
        ->where('notifications.status', 1)
        ->orderBy('notifications.created_at', 'DESC')
        ->findAll();
    
    return $this->response->setJSON($notifications);
}


public function getAll()
{
    $session = session();
    $userId = $session->get('user_id');

    $model = new \App\Models\NotificationUserModel();

    $notifications = $model->select('notifications.*')
        ->join('notifications', 'notifications.id = notification_users.notification_id')
        ->where('notification_users.user_id', $userId)
        ->where('notifications.status', 1)
        ->orderBy('notifications.created_at', 'DESC')
        ->findAll();
    
    return $this->response->setJSON($notifications);
}

public function toggleStatus($id)
{
    $notification = $this->notificationModel->find($id);
    
    if (!$notification) {
        return $this->response->setJSON(['status' => 'error', 'message' => 'Notification not found']);
    }

    $newStatus = $notification['status'] == 1 ? 0 : 1;
    
    $this->notificationModel->update($id, ['status' => $newStatus]);

    return $this->response->setJSON([
        'status' => 'success',
        'message' => 'Status updated successfully',
        'new_status' => $newStatus
    ]);
}

}
<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\DepartmentModel;
use App\Models\RoleModel;
use App\Models\CompanyModel;



class User extends BaseController
{
    public function index()
    {   
        $deptModel = new DepartmentModel();
        $companyModel = new CompanyModel();

        $data['departments'] = $deptModel->findAll();
        $data['companies']   = $companyModel->findAll();

        return view('dashboard/user', $data);
    }


    public function create()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $username = $this->request->getPost('username');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password'); 
        $userModel = new \App\Models\UserModel();

        //  Check if username already exists
        if ($userModel->where('username', $username)->first()) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Username already exists. Please choose another.'
            ]);
        }

        //  Optional: Check if email exists
        if ($userModel->where('email', $email)->first()) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Email already registered.'
            ]);
        }

        // Insert Data
        $data = [
            'name'           => $this->request->getPost('name'),
            'priority'       => $this->request->getPost('priority'),
            'company_name'   => $this->request->getPost('company_name'),
            'department_id'  => $this->request->getPost('department_id'),
            'email'          => $email,
            'employee_code'  => $this->request->getPost('employee_code'),
            'username'       => $username,
            'password'       => md5($password . "HASHKEY123"),
            'role_id'        => $this->request->getPost('role_id'),
            'hash_key'       => "HASHKEY123",
            'active'         => 1,
            'created_by'     => session()->get('user_id')
        ];

        if (!$userModel->insert($data)) {
        
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Failed to create user'
            ]);
        }

        // Save encrypted password in vault table
        $userId = $userModel->getInsertID();
        $db = \Config\Database::connect();
        $db->table('user_password_vault')->insert([
            'user_id'      => $userId,
            'password_enc' => $password
        ]);

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'User created successfully'
        ]);
    }


    public function userListData()
    {
        $session      = session();
        $deptModel    = new DepartmentModel();
        $roleModel    = new RoleModel();
        $userModel    = new UserModel();
        $companyModel = new CompanyModel();
        
        $userRole     = $session->get('role_id');          // 1 = Admin, 2 = Department Head
        $userDept     = $session->get('department_id');    // Logged user's dept
        $company      = $this->request->getGet('company');
        $department   = $this->request->getGet('department');
        $role         = $this->request->getGet('role');
        $username         = $this->request->getGet('username');

        // Base Query
        $userModel
            ->select('users.*, departments.department_name, roles.role_name')
            ->join('departments', 'departments.id = users.department_id', 'left')
            ->join('roles', 'roles.id = users.role_id', 'left');

        // Restrict department for role_id = 2
        if ($userRole == 2) {
            $userModel->where('users.department_id', $userDept);
        }

        // Apply filters
        if (!empty($company)) {
            $userModel->where('users.company_name', $company);
        }

        if (!empty($department)) {
            $userModel->where('users.department_id', $department);
        }

        if (!empty($role)) {
            $userModel->where('users.role_id', $role);
        }
        if (!empty($username)) {
            $userModel->where('users.username', $username);
        }

        // Fetch data
        $data['users']       = $userModel->findAll();
        $data['departments'] = $deptModel->findAll();
        $data['roles']       = $roleModel->findAll();
        $data['companies']   = $companyModel->findAll();
        return view('dashboard/userlist', $data);
    }



    public function update()
    {
        $id = $this->request->getPost('id');
        $new_password = $this->request->getPost('new_password');
        
        if(!$new_password){
             return $this->response->setJSON(['status'=>'error','message'=>'User Password Required']);
        }

        $data = [
            'company_name'  => $this->request->getPost('company_name'),
            'department_id' => $this->request->getPost('department_id'),
            'email'         => $this->request->getPost('email'),
            'employee_code' => $this->request->getPost('employee_code'),
            'name'          => $this->request->getPost('name'),
            'priority'      => $this->request->getPost('priority'),
            'password'      =>  md5($new_password . "HASHKEY123"),
        ];

        (new UserModel())->update($id, $data);

        $db = \Config\Database::connect();
        $vault = $db->table('user_password_vault');

        // check if row exists
        $exists = $vault->where('user_id', $id)->get()->getRow();

        if ($exists) {
            //UPDATE
            $vault->where('user_id', $id)->update([
                'password_enc' => $new_password
            ]);
        } else {
            // INSERT
            $vault->insert([
                'user_id'      => $id,
                'password_enc' => $new_password
            ]);
        }
        return $this->response->setJSON(['status'=>'success','message'=>'User Updated']);
    }


    public function get($id)
    {
      
        $db = \Config\Database::connect();
        $user = $db->table('users u')
        ->select('
            u.*,
            v.password_enc
        ')
        ->join('user_password_vault v', 'v.user_id = u.id', 'left')
        ->where('u.id', $id)
        ->get()
        ->getRowArray();

        return $this->response->setJSON($user);

    }



    


    public function toggleStatus()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getPost('id');
            $userModel = new \App\Models\UserModel();

            // Find user
            $user = $userModel->find($id);
            if (!$user) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'User not found!'
                ]);
            }

            // Toggle status
            $newStatus = ($user['active'] == 1) ? 0 : 1;
            $userModel->update($id, ['active' => $newStatus]);

            return $this->response->setJSON([
                'status'  => 'success',
                'message' => $newStatus ? 'User Activated' : 'User Deactivated',
                'new_status' => $newStatus
            ]);
        }

        // Non-AJAX fallback
        return redirect()->back()->with('error', 'Invalid request');
    }

}

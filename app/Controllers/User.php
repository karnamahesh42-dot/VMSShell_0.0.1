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

///////////////////////////////////////////////////////////////////////////////////////////////////
    // download user import template
    public function downloadUserTemplate()
    {
        $filename = "User_Import_Template.csv";

        // CSV Header Row
        $header = [
            "S.No",
            "Name",
            "Priority",
            "Company Name",
            "Department ID",
            "Email",
            "Employee Code",
            "Username",
            "Password",
            "Role ID",
            "Active"
        ];

        // Allowed values / help row
        $allowedPriority = "Options: 1|2|3";
        $roleType   = "Options: 2=Approver | 3=User";
        $allowedActive   = "Options: 1=Active | 0=Inactive";


        // Sample rows
        $sampleRows = [
            [
                1,
                "Mahesh Kumar",
                1,
                "UKMPL",
                2,
                "mahesh@test.com",
                "EMP001",
                "mahesh",
                "Welcome@123",
                3,
                1
            ],
            [
                2,
                "Ravi Kumar",
                2,
                "UKMPL",
                1,
                "ravi@test.com",
                "EMP002",
                "ravi",
                "Welcome@123",
                2,
                1
            ]
        ];

        // Force CSV download
        header("Content-Type: text/csv");
        header("Content-Disposition: attachment; filename={$filename}");

        $output = fopen("php://output", "w");

        // write header
        fputcsv($output, $header);

        // write help/options row
        fputcsv($output, [
            "",
            "Type : String",
            $allowedPriority,
            "Type : Integer",
            "Type : String",
            "Type : String",
            "",
            "",
            "",
            $roleType,
            $allowedActive
        ]);

        // write sample data
        foreach ($sampleRows as $row) {
            fputcsv($output, $row);
        }

        fclose($output);
        exit;
    }

////////////////////////////////////Import //////////////////////////////////////////////////////////////

public function importUsers()
{
    if (!$this->request->isAJAX()) {
        return redirect()->back();
    }

    $file = $this->request->getFile('file');

    if (!$file || !$file->isValid()) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Please upload valid CSV file'
        ]);
    }

    $userModel = new \App\Models\UserModel();
    $db = \Config\Database::connect();

    $handle = fopen($file->getTempName(), "r");

    // skip header + options row
    fgetcsv($handle);
    fgetcsv($handle);

    // 🚀 preload existing users (BIG performance boost)
    $existingUsers  = array_column($userModel->select('username')->findAll(), 'username');
    $existingEmails = array_column($userModel->select('email')->findAll(), 'email');

    $inserted = 0;
    $skipped  = 0;
    $errors   = 0;

    $db->transStart(); // transaction start

    while (($row = fgetcsv($handle)) !== false) {

        try {

            // trim all columns
            $row = array_map('trim', $row);

            // skip empty rows
            if (!array_filter($row)) continue;

            [
                $sno,
                $name,
                $priority,
                $company_name,
                $department_id,
                $email,
                $employee_code,
                $username,
                $password,
                $role_id,
                $active
            ] = $row;

            // normalize
            $email    = strtolower($email);
            $username = strtolower($username);

            // required check
            if (!$username || !$email || !$password) {
                $skipped++;
                continue;
            }

            // duplicate check (no DB hit now)
            if (in_array($username, $existingUsers) || in_array($email, $existingEmails)) {
                $skipped++;
                continue;
            }

            // clean name spaces
            $name = preg_replace('/\s+/', ' ', $name);

            $data = [
                'name'           => $name,
                'priority'       => (int)$priority,
                'company_name'   => $company_name,
                'department_id'  => (int)$department_id,
                'email'          => $email,
                'employee_code'  => $employee_code,
                'username'       => $username,
                'password'       => md5($password . "HASHKEY123"),
                'role_id'        => (int)$role_id,
                'hash_key'       => "HASHKEY123",
                'active'         => ($active !== '' ? (int)$active : 1),
                'created_by'     => session()->get('user_id')
            ];

            $userModel->insert($data);

            $userId = $userModel->getInsertID();

            $db->table('user_password_vault')->insert([
                'user_id'      => $userId,
                'password_enc' => $password
            ]);

            // add to arrays to avoid duplicates inside same file
            $existingUsers[]  = $username;
            $existingEmails[] = $email;

            $inserted++;

        } catch (\Throwable $e) {
            $errors++;
        }
    }

    fclose($handle);

    $db->transComplete(); // commit

    return $this->response->setJSON([
        'status'  => 'success',
        'message' => "✅ Imported: $inserted | ⏭ Skipped: $skipped | ❌ Errors: $errors"
    ]);
}

//////////////////////////////////////////////////////////////////////////////////////////////////

    public function changePassView()
    {
           return view('dashboard/change_password');
    }
    

    public function changePass(){

        $id = session()->get('user_id');
        $new_password = $this->request->getPost('new_password');
        
        if(!$new_password){
            return $this->response->setJSON(['status'=>'error','message'=>'User Password Required']);
        }

        $data = [
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

        $userModel ->orderBy('users.id', 'DESC');
              
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


    function expoerUserData(){
    
        $expDataQry = "SELECT u.company_name AS Company, 
        LTRIM(dp.department_name) AS Department,
        CASE WHEN LOWER(rl.role_name) = 'admin' THEN 'Approver' WHEN LOWER(rl.role_name) = 'user' THEN 'User' WHEN LOWER(rl.role_name) = 'security' THEN 'Security' ELSE rl.role_name END AS Role, 
        LTRIM(u.name) AS Name,
        u.username AS Username FROM users u 
        LEFT JOIN departments dp ON u.department_id = dp.id 
        LEFT JOIN roles rl ON u.role_id = rl.id 
        ORDER BY u.company_name, dp.department_name;";
    }


        public function exportUsers()
        {
            // session validation first
            if (!session()->get('user_id') || !session()->get('username')) {
                return redirect()->to('/login');
            }

            $db = \Config\Database::connect();

            $builder = $db->table('users u');
            $builder->select("
            u.id,
            u.name,
            u.priority,
            u.company_name,
            d.department_name as department_name,
            u.email,
            u.employee_code,
            u.username,

            CASE
            WHEN u.role_id = 1 THEN 'Superadmin'
            WHEN u.role_id = 2 THEN 'Approver'
            WHEN u.role_id = 3 THEN 'User'
            WHEN u.role_id = 4 THEN 'Security'
            WHEN u.role_id = 5 THEN 'Superuser'
            ELSE 'Unknown'
            END AS role_name,

            u.active
            ", false); 


            $builder->join('departments d', 'd.id = u.department_id', 'left');
            $builder->orderBy('u.id', 'DESC');

            $users = $builder->get()->getResultArray();

            $filename = "Users_Export_" . date('Ymd_His') . ".csv";

            header("Content-Type: text/csv");
            header("Content-Disposition: attachment; filename={$filename}");

            $output = fopen("php://output", "w");

            // header row
            fputcsv($output, [
                "USER ID",
                "Name",
                "Priority",
                "Company",
                "Department",
                "Email",
                "Employee Code",
                "Username",
                "Role",
                "Active"
            ]);

            foreach ($users as $row) {
                fputcsv($output, [
                    $row['id'],
                    $row['name'],
                    $row['priority'],
                    $row['company_name'],
                    $row['department_name'],
                    $row['email'],
                    $row['employee_code'],
                    $row['username'],
                    $row['role_name'],
                    $row['active'] ? 'Active' : 'Inactive'
                ]);
            }

            fclose($output);
            exit;
        }

}

<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';

    protected $allowedFields = [
    'name',
    'priority',
    'company_name',
    'department_id',
    'email',
    'employee_code',
    'username',
    'password',
    'role_id',
    'active',
    'hash_key',
    'created_by',
    'last_login_at',
    'created_at'
    ];

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();  // <--- FIX
    }

    // // Secure Login Function
    // public function checkLoginModel($username, $password)
    // {
    //     $sql = "SELECT * FROM users WHERE username = ?  AND active = 1 LIMIT 1";
    //     $query = $this->db->query($sql, [$username]);
    //     $user = $query->getRow();

    //     if (!$user) {
    //         return false;
    //     }

    //     $userPassword = md5($password."HASHKEY123");
     
    //     if ($userPassword !== $user->password) {
    //     return false; // wrong password
    //     }

    //     return $user;
        
    // }

    // Secure Login Function with Role & Department Join
        public function checkLoginModel($username, $password)
        {
            $sql = "SELECT 
                        u.*, 
                        r.role_name, 
                        d.department_name,
                        d.id as dep_id
                    FROM users u
                    LEFT JOIN roles r ON r.id = u.role_id
                    LEFT JOIN departments d ON d.id = u.department_id
                    WHERE u.username = ? 
                    AND u.active = 1
                    LIMIT 1";

            $query = $this->db->query($sql, [$username]);
            $user = $query->getRow();

            if (!$user) {
                return false;
            }

            // Secure password hash check
            $userPassword = md5($password . 'HASHKEY123');

            if ($userPassword !== $user->password) {
                return false; // Wrong password
            }

            return $user; // return user with joined role_name & department_name
        }

    
    public function get($id)
    {
        $model = new UserModel();
        return $this->response->setJSON($model->find($id));
    }
}

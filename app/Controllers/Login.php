<?php

namespace App\Controllers;

class Login extends BaseController
{
    public function index()
    {
        return view('auth/login');
    }

    public function checkLogin()
    {
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');

            $userModel = new \App\Models\UserModel();
            $user = $userModel->checkLoginModel($username, $password);

            if (!$user) {
                return redirect()->to('login')->with('error', 'Invalid username or password');
            }
            $userModel
                ->where('username', $username)
                ->set('last_login_at', date('Y-m-d H:i:s'))
                ->update();

            // session()->set([
            //     'user_id'    => $user->id,
            //     'username'   =>  $user->username,
            //     'role_id'    => $user->role_id,
            //     'department_id'    => $user->department_id,
            //     'isLoggedIn' => true,
            // ]);
            
            session()->set([
                'user_id'         => $user->id,
                'username'        => $user->username,
                'role_id'         => $user->role_id,
                'role_name'       => $user->role_name,
                'department_id'   => $user->department_id,
                'department_name' => $user->department_name,
                'name'            => $user->name,
                'email'           => $user->email,
                'employee_code'   => $user->employee_code,
                'company_name'    => $user->company_name,
                'dep_id'          => $user->dep_id,
                'isLoggedIn'      => true,
                
            ]);

            // header("Location: " . base_url('/'));
            // return view('dashboard/dashboard');
            return redirect()->to(base_url('/'));
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('/login'));
    
    }
}

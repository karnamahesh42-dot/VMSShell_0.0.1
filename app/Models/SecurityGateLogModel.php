<?php

namespace App\Models;

use CodeIgniter\Model;

class SecurityGateLogModel extends Model
{
    protected $table = 'security_gate_logs';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'visitor_request_id',
        'v_code',
        'check_in_time',
        'check_out_time',
        'verified_by',
        'updated_by',

    ];

    protected $useTimestamps = false; // We are manually storing times
    

    public function getRecentAuthorized($limit = 10)
    {
        $session = session();
        $roleId  = $_SESSION['role_id'];
        $userId  = $_SESSION['user_id'];
        $departmentName = $_SESSION['department_name'];

        $todayStart = date('Y-m-d 00:00:00');
        $todayEnd   = date('Y-m-d 23:59:59');

        $builder = $this->select("
                security_gate_logs.*,
                visitors.visitor_name,
                visitors.visitor_phone,
                visitors.purpose,
                visitors.v_code,
                usersdata.name as created_by_name,
                referred_user.name as referred_name
            ")
            ->join(
                'visitors',
                'visitors.id = security_gate_logs.visitor_request_id',
                'left'
            )
            ->join(
                'visitor_request_header',
                'visitor_request_header.id = visitors.request_header_id',
                'left'
            )
             ->join(
                'users as usersdata',
                'usersdata.id = visitors.created_by',
                'left'
            )
             ->join(
                'users AS referred_user',
                'referred_user.id = visitor_request_header.referred_by',
                'left'
             );

        if ($roleId == 3) {
        $builder
        ->where('visitors.status', 'approved')
        ->where('security_gate_logs.check_in_time >=', $todayStart)
        ->where('security_gate_logs.check_in_time <=', $todayEnd)
        ->where('visitors.created_by', $userId);
        }
        else if($roleId == 2){
             $builder
        ->where('visitors.status', 'approved')
        ->where('security_gate_logs.check_in_time >=', $todayStart)
        ->where('security_gate_logs.check_in_time <=', $todayEnd)
        ->where('visitor_request_header.department', $departmentName);
        }
        else{
         $builder
        ->where('visitors.status', 'approved');

        }

        return $builder
            ->orderBy('security_gate_logs.check_in_time', 'DESC')
            ->limit($limit)
            ->find();
    }


    public function getRecentAuthorizedForSecurityList($limit = 50)
    {
        return $this->select("
                security_gate_logs.*,
                visitors.visitor_name,
                visitors.visitor_phone,
                visitors.purpose,
                visitors.v_code,
                visitor_request_header.department AS department_name,
                users.name AS created_by_name
            ")
            ->join('visitors', 'visitors.id = security_gate_logs.visitor_request_id', 'left')
            ->join('visitor_request_header', 'visitor_request_header.id = visitors.request_header_id', 'left')
            ->join('users', 'users.id = visitors.created_by', 'left') 
            ->where('visitors.status', 'approved')
            ->orderBy('security_gate_logs.check_in_time', 'DESC')
            ->limit($limit)
            ->find();
    }

}

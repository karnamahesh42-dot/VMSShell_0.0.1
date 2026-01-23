<?php

namespace App\Models;

use CodeIgniter\Model;

class VisitorRequestHeaderModel extends Model
{
    protected $table            = 'visitor_request_header';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields = [
        'header_code',
        'requested_by',
        'referred_by',
        'description',
        'purpose',
        'requested_date',
        'requested_time',
        'department',
        'email',
        'company',
        'total_visitors',
        'status',
        'remarks'
    ];

    // Optional timestamps if table has created_at / updated_at
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';


     /* ============================================================
       JOIN HEADER + VISITORS TABLE
       visitors.request_header_id = visitor_request_header.id
    ============================================================ */
   
  public function getHeaderWithVisitors($headerId)
{
    // return $this->select("
    //         visitor_request_header.*,
    //         visitors.*,
    //         users.name AS visitor_created_by_name,
    //         users.email AS visitor_created_by_email
    //     ")
    //     ->join('visitors', 'visitors.request_header_id = visitor_request_header.id', 'left')
    //     ->join('users', 'users.id = visitors.created_by', 'left') // 👈 corrected
    //      ->join('users', 'users.id = visitor_request_header.referred_by', 'left') // 👈 corrected
        
    //     ->where('visitor_request_header.id', $headerId)
    //     ->findAll();
    return $this->select("
        visitor_request_header.*,
        visitors.*,
        recce_details.recce_type,
        recce_details.art_director,
        recce_details.company as productio,
        recce_details.contact_person,
        recce_details.shooting_date,
        recce_details.mail_id,
        recce_details.mobile,
        vendors.category as v_category,
        vendors.status as v_status,
        vendors.company as v_company,
        vendors.location as v_location,
        vendors.contact_person as v_contact_person,
        vendors.email as v_email,
        vendors.mobile as v_mobile,
        u1.name AS visitor_created_by_name,
        u1.email AS visitor_created_by_email,
        u2.name AS referred_by_name,
        u2.email AS referred_by_email,
        security_gate_logs.check_in_time as check_in,
        security_gate_logs.check_out_time as check_out,
        u3.name as check_in_by,
        u4.name as check_out_by,

    ")
    ->join('visitors', 'visitors.request_header_id = visitor_request_header.id', 'left')
    ->join('users u1', 'u1.id = visitors.created_by', 'left')
    ->join('users u2', 'u2.id = visitor_request_header.referred_by', 'left')
    ->join('recce_details', 'recce_details.header_id = visitor_request_header.id', 'left')
    ->join('vendors', 'vendors.header_id = visitor_request_header.id', 'left')
    ->join('security_gate_logs', 'security_gate_logs.visitor_request_id = visitors.id', 'left')
    ->join('users u3', 'u3.id = security_gate_logs.verified_by', 'left')
    ->join('users u4', 'u4.id = security_gate_logs.updated_by', 'left')
    ->where('visitor_request_header.id', $headerId)
    ->findAll();
}


public function getHeaderWithVisitorsMailData($headerId)
{
    return $this->select("
            visitor_request_header.*,
            visitors.visitor_name,
            visitors.visitor_email,
            visitors.visitor_phone,
            visitors.proof_id_type, 
            visitors.proof_id_number, 
            visitors.v_code, 
            visitors.qr_code, 
            visitors.vehicle_no,
            visitors.visit_date,
            visitors.visit_time, 
            visitors.vehicle_type,    
            users.name AS created_by_name,
            users.email AS created_by_email,
            u2.name AS referred_by_name,
            departments.department_name,
            recce_details.recce_type,
            recce_details.art_director,
            recce_details.company as productio,
            recce_details.contact_person,
            recce_details.shooting_date,
            recce_details.mail_id,
            recce_details.mobile,
            vendors.category as v_category,
            vendors.status as v_status,
            vendors.company as v_company,
            vendors.location as v_location,
            vendors.contact_person as v_contact_person,
            vendors.email as v_email,
            vendors.mobile as v_mobile,
        ")
        ->join(
            'visitors',
            'visitors.request_header_id = visitor_request_header.id',
            'left'
        )
        ->join(
            'users',
            'users.id = visitors.created_by',
            'left'
        )
        ->join(
            'users u2',
            'u2.id = visitor_request_header.referred_by',
            'left'
        )
        ->join(
            'departments',
            'departments.id = users.department_id',
            'left'
        )->join('recce_details', 'recce_details.header_id = visitor_request_header.id', 'left')
         ->join('vendors', 'vendors.header_id = visitor_request_header.id', 'left')
        ->where('visitor_request_header.id', $headerId)
        ->findAll();
}




public function getHeaderWithVisitorsMailDataByVCode($vCode)
{
    return $this->select([
            'visitor_request_header.*',
            'visitors.id as v_id',
            'visitors.visitor_name',
            'visitors.visitor_email',
            'visitors.meeting_status',
            'visitors.visitor_phone',
            'visitors.proof_id_type',
            'visitors.proof_id_number',
            'visitors.v_code',
            'visitors.qr_code',
            'visitors.vehicle_no',
            'visitors.visit_date',
            'visitors.visit_time',
            'visitors.vehicle_type',
            'visitors.v_phopto_path',
            'visitors.securityCheckStatus',
            'users.name as created_by_name',
            'users.email as created_by_email',
            'refUser.name as referred_by_name',
            'departments.department_name'
        ])
        ->join('visitors', 'visitors.request_header_id = visitor_request_header.id', 'left')
        ->join('users', 'users.id = visitors.created_by', 'left')
        ->join('users AS refUser', 'refUser.id = visitor_request_header.referred_by', 'left')
        ->join('departments', 'departments.id = users.department_id', 'left')
        ->where('visitors.v_code', $vCode)
        ->findAll();
}

}

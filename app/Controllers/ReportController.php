<?php

namespace App\Controllers;
use App\Models\DepartmentModel;
use App\Models\PurposeModel;
use App\Models\CompanyModel;

class ReportController extends BaseController
{

public function dailyVisitorReport()
{
    $db = \Config\Database::connect();

    //  Filters

        //  Default today date
    $today = date('Y-m-d');

    //  Filters (fallback to today)
    $fromDate   = $this->request->getGet('from_date') ?? $today;
    $toDate     = $this->request->getGet('to_date') ?? $today;

    // $fromDate  = $this->request->getGet('from_date');
    // $toDate    = $this->request->getGet('to_date');
    $company   = $this->request->getGet('company');
    $department= $this->request->getGet('department');
    $vCode     = $this->request->getGet('v_code');

    $builder = $db->table('visitors vr');

    $builder->select("
        vr.id,
        vr.group_code,
        vr.v_code,
        vr.visitor_name,
        vr.visitor_email,
        vr.visitor_phone,
        vr.purpose,
        vr.visit_date,
        vr.visit_time,
        vr.vehicle_no,
        vr.vehicle_type,
        vr.securityCheckStatus,
        vr.status,
        vr.spendTime,
        vrh.company,
        vrh.department,
        ref_by.name as reffered_by,
        sgl.check_in_time AS check_in_time,
        sgl.check_out_time AS check_out_time,
    ");

    $builder->join(
        'visitor_request_header vrh',
        'vrh.id = vr.request_header_id',
        'left'
    );

    $builder->join(
        'security_gate_logs sgl',
        'sgl.visitor_request_id = vr.id',
        'left'
    );

    $builder->join(
        'users ref_by',
        'ref_by.id = vrh.referred_by',
        'left'
    );

    //  Date filter
    if ($fromDate && $toDate) {
        $builder->where('DATE(vr.visit_date) >=', $fromDate);
        $builder->where('DATE(vr.visit_date) <=', $toDate);
    }

    //  Company filter
    if (!empty($company)) {
        $builder->where('vrh.company', $company);
    }

    //  Department filter
    if (!empty($department)) {
        $builder->where('vrh.department', $department);
    }

    //  V-Code filter
    if (!empty($vCode)) {
        $builder->where('vr.v_code', $vCode);
    }

    $builder->where('vr.status', 'approved');

    //  Important to avoid duplicates
    $builder->groupBy('vr.id');

    $builder->orderBy('check_in_time', 'DESC');


        //  Fetch distinct departments
    $deptBuilder = $db->table('visitor_request_header');

    // $departments = $deptBuilder
    //     ->select('DISTINCT(department) as department')
    //     ->where('department IS NOT NULL')
    //     ->orderBy('department', 'ASC')
    //     ->get()
    //     ->getResultArray();

    // $data['departments'] = $departments;

    
        //  Load Departments dynamically
    $departmentModel = new DepartmentModel();
    $data['departments'] = $departmentModel
        ->orderBy('department_name', 'ASC')
        ->findAll();


    $companyModel = new CompanyModel();
    $data['companies'] = $companyModel->orderBy('company_name', 'ASC')->findAll();


    $data['fromDate'] = $fromDate;
    $data['toDate'] = $toDate;

    $data['report'] = $builder->get()->getResultArray();

    return view('dashboard/reports/daily_visitor_report', $data);
}


public function requestToCheckoutReport()
{
    $db = \Config\Database::connect();
    $request = service('request');

    //  Get filter values
    $department     = $request->getGet('department');
    $company        = $request->getGet('company');
    $status         = $request->getGet('status');
    $meetingStatus  = $request->getGet('meeting_status');
    $fromDate       = $request->getGet('from_date');
    $toDate         = $request->getGet('to_date');
    $purpose         = $request->getGet('purpose');
    $group_code         = $request->getGet('group_code');

    $builder = $db->table('visitors vr');

    $builder->select("
        vr.*, 
        vrh.department,
        vrh.company,
        vrh.total_visitors,
        ref_user.name AS referred_by,
        sgl.check_in_time,
        sgl.check_out_time,
        rqst_created_by.name AS rqst_created_by,
        rqst_Approved_by.name AS rqst_Approved_by,
        s_checkin_by.name AS s_checkin_by,
        s_checkout_by.name AS s_checkout_by
    ");

    $builder->join('visitor_request_header vrh', 'vrh.id = vr.request_header_id', 'left');
    $builder->join('users ref_user', 'ref_user.id = vrh.referred_by', 'left');
    $builder->join('users rqst_created_by', 'rqst_created_by.id = vrh.requested_by', 'left');
    $builder->join('users rqst_Approved_by', 'rqst_Approved_by.id = vrh.updated_by', 'left');
    $builder->join('security_gate_logs sgl', 'sgl.visitor_request_id = vr.id', 'left');
    $builder->join('users s_checkin_by', 's_checkin_by.id = sgl.verified_by', 'left');
    $builder->join('users s_checkout_by', 's_checkout_by.id = sgl.updated_by', 'left');

    /* ================= FILTER CONDITIONS ================= */

    if (!empty($department)) {
        $builder->where('vrh.department', $department);
    }

    if (!empty($company)) {
        $builder->where('vrh.company', $company);
    }

    if (!empty($status)) {
        $builder->where('vr.status', $status);
    }

    if ($meetingStatus !== '' && $meetingStatus !== null) {
        $builder->where('vr.meeting_status', $meetingStatus); // 1 or 0
    }

    if ($purpose !== '' && $purpose !== null) {
        $builder->where('vr.purpose', $purpose); 
    }

    if (!empty($fromDate) && !empty($toDate)) {
        $builder->where('vr.visit_date >=', $fromDate)
                ->where('vr.visit_date <=', $toDate);
    }

    
    if (!empty($group_code)) {
        $builder->where('vr.group_code ', $group_code);
    }


    /* ===================================================== */

    $builder->orderBy('vr.created_at', 'DESC');

    $data['report'] = $builder->get()->getResultArray();


        //  Load Departments dynamically
    $departmentModel = new DepartmentModel();
    $data['departments'] = $departmentModel
        ->orderBy('department_name', 'ASC')
        ->findAll();


    $companyModel = new CompanyModel();
    $data['companies'] = $companyModel->orderBy('company_name', 'ASC')->findAll();
    
        

        
$purposeModel = new PurposeModel();

$data['purposes'] = $purposeModel
    ->where('status', 1)
    ->orderBy('purpose_name', 'ASC')
    ->findAll();

    return view('dashboard/reports/request_to_checkout_report', $data);
}


}

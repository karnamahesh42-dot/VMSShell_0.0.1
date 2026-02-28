<?php

namespace App\Controllers;
use App\Models\DepartmentModel;
use App\Models\PurposeModel;
use App\Models\CompanyModel;

class ReportController extends BaseController
{

// public function dailyVisitorReport()
// {
//     $db = \Config\Database::connect();

//     //  Filters

//         //  Default today date
//     $today = date('Y-m-d');

//     //  Filters (fallback to today)
//     $fromDate   = $this->request->getGet('from_date') ?? $today;
//     $toDate     = $this->request->getGet('to_date') ?? $today;

//     // $fromDate  = $this->request->getGet('from_date');
//     // $toDate    = $this->request->getGet('to_date');
//     $company   = $this->request->getGet('company');
//     $department= $this->request->getGet('department');
//     $vCode     = $this->request->getGet('v_code');

//     $builder = $db->table('visitors vr');

//     $builder->select("
//         vr.id,
//         vr.group_code,
//         vr.v_code,
//         vr.visitor_name,
//         vr.visitor_email,
//         vr.visitor_phone,
//         vr.purpose,
//         vr.visit_date,
//         vr.visit_time,
//         vr.vehicle_no,
//         vr.vehicle_type,
//         vr.securityCheckStatus,
//         vr.status,
//         vr.spendTime,
//         vrh.company,
//         vrh.department,
//         ref_by.name as reffered_by,
//         sgl.check_in_time AS check_in_time,
//         sgl.check_out_time AS check_out_time,
//     ");

//     $builder->join(
//         'visitor_request_header vrh',
//         'vrh.id = vr.request_header_id',
//         'left'
//     );

//     $builder->join(
//         'security_gate_logs sgl',
//         'sgl.visitor_request_id = vr.id',
//         'left'
//     );

//     $builder->join(
//         'users ref_by',
//         'ref_by.id = vrh.referred_by',
//         'left'
//     );

//     //  Date filter
//     if ($fromDate && $toDate) {
//         $builder->where('DATE(vr.visit_date) >=', $fromDate);
//         $builder->where('DATE(vr.visit_date) <=', $toDate);
//     }

//     //  Company filter
//     if (!empty($company)) {
//         $builder->where('vrh.company', $company);
//     }

//     //  Department filter
//     if (!empty($department)) {
//         $builder->where('vrh.department', $department);
//     }

//     //  V-Code filter
//     if (!empty($vCode)) {
//         $builder->where('vr.v_code', $vCode);
//     }

//     $builder->where('vr.status', 'approved');

//     //  Important to avoid duplicates
//     $builder->groupBy('vr.id');

//     $builder->orderBy('check_in_time', 'DESC');
//     $builder->limit(500);



//         //  Fetch distinct departments
//     $deptBuilder = $db->table('visitor_request_header');
//         //  Load Departments dynamically
//     $departmentModel = new DepartmentModel();
//     $data['departments'] = $departmentModel
//         ->orderBy('department_name', 'ASC')
//         ->findAll();


//     $companyModel = new CompanyModel();
//     $data['companies'] = $companyModel->orderBy('company_name', 'ASC')->findAll();


//     $data['fromDate'] = $fromDate;
//     $data['toDate'] = $toDate;

//     $data['report'] = $builder->get()->getResultArray();

//     return view('dashboard/reports/daily_visitor_report', $data);
// }

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
                vr.validity_type,
                vr.valid_from,
                vr.valid_to,
                vr.securityCheckStatus,
                vr.status,
                vr.spendTime,
                vrh.company,
                vrh.department,
                ref_by.name as reffered_by,
                sgl.check_in_time AS sd_check_in,
                sgl.check_out_time AS sd_check_out,
                md.check_in_time AS md_check_in,
                md.check_out_time AS md_check_out
            ");

            $builder->join('visitor_request_header vrh', 'vrh.id = vr.request_header_id', 'left');

            $builder->join('security_gate_logs sgl', 'sgl.visitor_request_id = vr.id', 'left');

            $builder->join('security_gate_logs_md md', 'md.v_code = vr.v_code', 'left');

            $builder->join('users ref_by', 'ref_by.id = vrh.referred_by', 'left');

            $builder->where('vr.status', 'approved');


            // 🔥 DATE FILTER (SD + MD Combined Logic)
            if ($fromDate && $toDate) {

                $builder->groupStart()

                    // Single Day Visitors
                    ->groupStart()
                        ->where('vr.validity_type', 'SD')
                        ->where('vr.visit_date >=', $fromDate)
                        ->where('vr.visit_date <=', $toDate)
                    ->groupEnd()

                    ->orGroupStart()

                        //  Multi Day Visitors
                        ->where('vr.validity_type', 'MD')
                        ->where('vr.valid_from <=', $toDate)
                        ->where('vr.valid_to >=', $fromDate)

                    ->groupEnd()

                ->groupEnd();
            }


            // Company filter
            if (!empty($company)) {
                $builder->where('vrh.company', $company);
            }

            // Department filter
            if (!empty($department)) {
                $builder->where('vrh.department', $department);
            }

            // V-Code filter
            if (!empty($vCode)) {
                $builder->where('vr.v_code', $vCode);
            }

            $builder->groupBy('vr.id');
            $builder->orderBy('sd_check_in', 'DESC');
            $builder->limit(500);

            //  Fetch distinct departments
            $deptBuilder = $db->table('visitor_request_header');
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



// public function requestToCheckoutReport()
// {
//     $db = \Config\Database::connect();
//     $request = service('request');
//     $session = session();

//     $sessionDep_id     = $session->get('dep_id');
//     $sessionRole_id    = $session->get('role_id');
    
//     $sessionUser_id    = $session->get('user_id');
//     $sessionCompany    = $session->get('company_name');
//     $sessionDepartment    = $session->get('department_name');


//     //  Get filter values
//     $department     = $request->getGet('department');
//     $company        = $request->getGet('company');
//     $status         = $request->getGet('status');
//     $meetingStatus  = $request->getGet('meeting_status');
//     $fromDate       = $request->getGet('from_date');
//     $toDate         = $request->getGet('to_date');
//     $purpose         = $request->getGet('purpose');
//     $group_code         = $request->getGet('group_code');

//     $builder = $db->table('visitors vr');

//     $builder->select("
//         vr.*, 
//         vrh.department,
//         vrh.company,
//         vrh.total_visitors,
//         ref_user.name AS referred_by,
//         sgl.check_in_time,
//         sgl.check_out_time,
//         rqst_created_by.name AS rqst_created_by,
//         rqst_Approved_by.name AS rqst_Approved_by,
//         s_checkin_by.name AS s_checkin_by,
//         s_checkout_by.name AS s_checkout_by
//     ");

//     $builder->join('visitor_request_header vrh', 'vrh.id = vr.request_header_id', 'left');
//     $builder->join('users ref_user', 'ref_user.id = vrh.referred_by', 'left');
//     $builder->join('users rqst_created_by', 'rqst_created_by.id = vrh.requested_by', 'left');
//     $builder->join('users rqst_Approved_by', 'rqst_Approved_by.id = vrh.updated_by', 'left');
//     $builder->join('security_gate_logs sgl', 'sgl.visitor_request_id = vr.id', 'left');
//     $builder->join('users s_checkin_by', 's_checkin_by.id = sgl.verified_by', 'left');
//     $builder->join('users s_checkout_by', 's_checkout_by.id = sgl.updated_by', 'left');

//     /* ================= FILTER CONDITIONS ================= */

//     if (!empty($department)) {
//         $builder->where('vrh.department', $department);
//     }else if(!in_array($sessionRole_id, [1,5])){ // If not super admin, then apply session department filter
//         $builder->where('vrh.department', $sessionDepartment);
//     }

//     if (!empty($company)) {
//         $builder->where('vrh.company', $company);
//     }else if(!in_array($sessionRole_id, [1,5])){ // If not super admin, then apply session company filter
//          $builder->where('vrh.company', $sessionCompany);
//     }

//     if (!empty($status)) {
//         $builder->where('vr.status', $status);
//     }

//     if ($meetingStatus !== '' && $meetingStatus !== null) {
//         $builder->where('vr.meeting_status', $meetingStatus); // 1 or 0
//     }

//     if ($purpose !== '' && $purpose !== null) {
//         $builder->where('vr.purpose', $purpose); 
//     }

//     if (!empty($fromDate) && !empty($toDate)) {
//         $builder->where('vr.visit_date >=', $fromDate)
//                 ->where('vr.visit_date <=', $toDate);
//     }

    
//     if (!empty($group_code)) {
//         $builder->where('vr.group_code ', $group_code);
//     }


//     /* ===================================================== */

//     $builder->orderBy('vr.created_at', 'DESC');
//     $builder->limit(500);

//     $data['report'] = $builder->get()->getResultArray();
    

//         //  Load Departments dynamically
//     $departmentModel = new DepartmentModel();
//     $data['departments'] = $departmentModel
//         ->orderBy('department_name', 'ASC')
//         ->findAll();


//     $companyModel = new CompanyModel();
//     $data['companies'] = $companyModel->orderBy('company_name', 'ASC')->findAll();
    
            
//     $purposeModel = new PurposeModel();

//     $data['purposes'] = $purposeModel
//         ->where('status', 1)
//         ->orderBy('purpose_name', 'ASC')
//         ->findAll();

//         return view('dashboard/reports/request_to_checkout_report', $data);
// }



        public function requestToCheckoutReport()
        {
            $db = \Config\Database::connect();
            $request = service('request');
            $session = session();

            $sessionRole_id    = $session->get('role_id');
            $sessionCompany    = $session->get('company_name');
            $sessionDepartment = $session->get('department_name');

            // Filters
            $department     = $request->getGet('department');
            $company        = $request->getGet('company');
            $status         = $request->getGet('status');
            $meetingStatus  = $request->getGet('meeting_status');
            $fromDate       = $request->getGet('from_date');
            $toDate         = $request->getGet('to_date');
            $purpose        = $request->getGet('purpose');
            $group_code     = $request->getGet('group_code');
            $validity_type  = $request->getGet('validity_type');
            $builder = $db->table('visitors vr');

            // $builder->select("
            //     vr.*,
            //     vr.validity_type,
            //     vr.valid_from,
            //     vr.valid_to,
            //     vrh.department,
            //     vrh.company,
            //     vrh.total_visitors,
            //     ref_user.name AS referred_by,
            //     rqst_created_by.name AS rqst_created_by,
            //     rqst_Approved_by.name AS rqst_Approved_by,

            //     -- SD logs
            //     sgl.check_in_time AS sd_check_in,
            //     sgl.check_out_time AS sd_check_out,
            //     s_checkin_by.name AS sd_checkin_by,
            //     s_checkout_by.name AS sd_checkout_by,

            //     -- MD logs
            //     md.check_in_time AS md_check_in,
            //     md.check_out_time AS md_check_out
            // ");
                $builder->select("
                    vr.*, 
                    vrh.department,
                    vrh.company,
                    vrh.total_visitors,
                    ref_user.name AS referred_by,

                   
                    sgl.check_in_time  AS sd_check_in,
                    sgl.check_out_time AS sd_check_out,

              
                    md.check_in_time   AS md_check_in,
                    md.check_out_time  AS md_check_out,

                    rqst_created_by.name AS rqst_created_by,
                    rqst_Approved_by.name AS rqst_Approved_by,
                    s_checkin_by.name AS s_checkin_by,
                    s_checkout_by.name AS s_checkout_by
                ");

            $builder->join('visitor_request_header vrh', 'vrh.id = vr.request_header_id', 'left');
            $builder->join('users ref_user', 'ref_user.id = vrh.referred_by', 'left');
            $builder->join('users rqst_created_by', 'rqst_created_by.id = vrh.requested_by', 'left');
            $builder->join('users rqst_Approved_by', 'rqst_Approved_by.id = vrh.updated_by', 'left');

            // SD logs
            $builder->join('security_gate_logs sgl', 'sgl.visitor_request_id = vr.id', 'left');
            $builder->join('users s_checkin_by', 's_checkin_by.id = sgl.verified_by', 'left');
            $builder->join('users s_checkout_by', 's_checkout_by.id = sgl.updated_by', 'left');

            // MD logs
            $builder->join('security_gate_logs_md md', 'md.v_code = vr.v_code', 'left');

            /* ================= FILTERS ================= */

            // Department filter
            if (!empty($department)) {
                $builder->where('vrh.department', $department);
            } else if (!in_array($sessionRole_id, [1,5])) {
                $builder->where('vrh.department', $sessionDepartment);
            }

            // Company filter
            if (!empty($company)) {
                $builder->where('vrh.company', $company);
            } else if (!in_array($sessionRole_id, [1,5])) {
                $builder->where('vrh.company', $sessionCompany);
            }

            if (!empty($status)) {
                $builder->where('vr.status', $status);
            }

            if ($meetingStatus !== '' && $meetingStatus !== null) {
                $builder->where('vr.meeting_status', $meetingStatus);
            }

            if (!empty($purpose)) {
                $builder->where('vr.purpose', $purpose);
            }

            if (!empty($group_code)) {
                $builder->where('vr.group_code', $group_code);
            }

            if (!empty($validity_type)) {
                $builder->where('vr.validity_type', $validity_type);
            }

            /*
            🔥 IMPORTANT: DATE FILTER (SD + MD LOGIC)
            */

            if (!empty($fromDate) && !empty($toDate)) {

                $builder->groupStart()

                    // SD Visitors
                    ->groupStart()
                        ->where('vr.validity_type', 'SD')
                        ->where('vr.visit_date >=', $fromDate)
                        ->where('vr.visit_date <=', $toDate)
                    ->groupEnd()

                    ->orGroupStart()

                        // MD Visitors
                        ->where('vr.validity_type', 'MD')
                        ->where('vr.valid_from <=', $toDate)
                        ->where('vr.valid_to >=', $fromDate)

                    ->groupEnd()

                ->groupEnd();
            }

            $builder->where('vr.status', 'approved');

            $builder->groupBy('vr.id'); // prevent duplicates
            $builder->orderBy('vr.created_at', 'DESC');
            $builder->limit(500);

            $data['report'] = $builder->get()->getResultArray();

            // Load dropdown data
            $departmentModel = new DepartmentModel();
            $data['departments'] = $departmentModel
                ->orderBy('department_name', 'ASC')
                ->findAll();

            $companyModel = new CompanyModel();
            $data['companies'] = $companyModel
                ->orderBy('company_name', 'ASC')
                ->findAll();

            $purposeModel = new PurposeModel();
            $data['purposes'] = $purposeModel
                ->where('status', 1)
                ->orderBy('purpose_name', 'ASC')
                ->findAll();

            return view('dashboard/reports/request_to_checkout_report', $data);
        }

}

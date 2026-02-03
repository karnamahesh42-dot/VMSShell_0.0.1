<?php

namespace App\Controllers;

use App\Models\VisitorRequestModel;
use App\Models\VisitorLogModel;
use App\Models\VisitorRequestHeaderModel;
use App\Models\ExpiredVisitorPassModel;
use App\Models\PurposeModel;
use App\Models\RecceDetailsModel;
use App\Models\VendorModel;
  

class VisitorRequest extends BaseController
{
    protected $visitorModel;
    protected $logModel;
    protected $VisitorRequestHeaderModel;
    protected $ExpiredVisitorPassModel;
    protected $RecceDetailsModel;
    protected $VendorModel;


    public function __construct()
    {
        $this->visitorModel                 = new VisitorRequestModel();
        $this->logModel                     = new VisitorLogModel();
        $this->VisitorRequestHeaderModel    = new VisitorRequestHeaderModel();
        $this->ExpiredVisitorPassModel      = new ExpiredVisitorPassModel();
        $this->recceDetailsModel            = new RecceDetailsModel();
        $this->VendorModel                  = new VendorModel();
    }

    // public function index(): string
    // {
    //     return view('dashboard/visitorequest');
    // }

    public function index(): string
    {
        $session = session();
        $dep_id     = $session->get('dep_id');
        $role_id    = $session->get('role_id');
        $user_id    = $session->get('user_id');
        $company    = $session->get('company_name');

        $userModel = new \App\Models\UserModel();

        // CASE 1: Super Admin (role_id = 1) → Show ALL Admins ordered by priority
        if ($role_id == 1) {
            $admins = $userModel
                        ->where('role_id', 2)
                        ->orderBy('priority', 'ASC')
                        ->findAll();
        }
        elseif ($role_id == 2) {
            $admins = $userModel
                        ->where('id', $user_id)
                        ->orderBy('priority', 'ASC')
                        ->findAll();
        }
        // CASE 2: Admin (role_id = 2) → Show ONLY same department admins ordered by priority
        else {
            $admins = $userModel
                        ->where('role_id', 2)
                        ->where('department_id', $dep_id)
                        ->where('company_name', $company)
                        ->orderBy('priority', 'ASC')
                        ->findAll();
        }

        $data = [
            'admins' => $admins,
            'logged_user_id' => $user_id,
        ];

        $purposeModel = new PurposeModel();
        $data['purposes'] = $purposeModel
            ->where('status', 1)
            ->orderBy('purpose_name', 'ASC')
            ->findAll();

        $db = \Config\Database::connect();
        $data['recceTypes'] = $db->table('category_master')
            ->where('status', 1)
            ->where('purpose', 'Recce')
            ->orderBy('category_name', 'ASC')
            ->get()
            ->getResultArray();

        $data['vendorTypes'] = $db->table('category_master')
            ->where('status', 1)
            ->where('purpose', 'Vendor')
            ->orderBy('category_name', 'ASC')
            ->get()
            ->getResultArray();

        return view('dashboard/visitorequest', $data);
    }

    public function groupVisitorRequestForm(): string
    {
        $session = session();
        $dep_id     = $session->get('dep_id');
        $role_id    = $session->get('role_id');
        $user_id    = $session->get('user_id');
        $company    = $session->get('company_name');

        $userModel = new \App\Models\UserModel();
        if ($role_id == 1) {
            $admins = $userModel
                        ->where('role_id', 2)
                        ->orderBy('priority', 'ASC')
                        ->findAll();
        }
        elseif ($role_id == 2) {
            $admins = $userModel
                        ->where('id', $user_id)
                        ->orderBy('priority', 'ASC')
                        ->findAll();
        }
        else {
            $admins = $userModel
                    ->where('role_id', 2)
                    ->where('department_id', $dep_id)
                    ->where('company_name', $company)
                    ->orderBy('priority', 'ASC')
                    ->findAll();
        }
        $data = [
            'admins' => $admins,
            'logged_user_id' => $user_id,
        ];

        $purposeModel = new PurposeModel();
        $data['purposes'] = $purposeModel
            ->where('status', 1)
            ->orderBy('purpose_name', 'ASC')
            ->findAll();

        $db = \Config\Database::connect();
            $data['recceTypes'] = $db->table('category_master')
            ->where('status', 1)
            ->where('purpose', 'Recce')
            ->orderBy('category_name', 'ASC')
            ->get()
            ->getResultArray();

        $data['vendorTypes'] = $db->table('category_master')
            ->where('status', 1)
            ->where('purpose', 'Vendor')
            ->orderBy('category_name', 'ASC')
            ->get()
            ->getResultArray();

        return view('dashboard/group_visitor_request',$data);
    }

    /* ------------------------------------------------------------------
        FILE UPLOAD HELPER (Reusable, Fast)
    ------------------------------------------------------------------ */
    private function uploadFile($file, $path)
    {
        if ($file && $file->isValid()) {
            $name = $file->getRandomName();
            $file->move($path, $name);
            return $name;
        }
        return "";
    }

    /* ------------------------------------------------------------------
        MAIL SEND HELPER
    ------------------------------------------------------------------ */
    private function sendMailAsync($payload)
    {
        service('curlrequest')->post(
            base_url('send-email'),
            ['form_params' => $payload]
        );
    }

    /* ------------------------------------------------------------------
        AUTO QR GENERATION (Single Point Control)
    ------------------------------------------------------------------ */
    private function generateQRcode($vCode)
    {
        $fileName = "visitor_{$vCode}_qr.png";
        $qrUrl = "https://quickchart.io/qr?text=" . urlencode($vCode) . "&size=300";
        $savePath = FCPATH . "public/uploads/qr_codes/{$fileName}";

        if (!is_dir(FCPATH . "public/uploads/qr_codes")) {
            mkdir(FCPATH . "public/uploads/qr_codes", 0777, true);
        }

        file_put_contents($savePath, file_get_contents($qrUrl));
        return $fileName;
    }

    /* ------------------------------------------------------------------
        LOG HELPER
    ------------------------------------------------------------------ */
    private function insertLog($id, $action, $old, $new, $remarks = '--')
    {
        $this->logModel->insert([
            'visitor_request_id' => $id,
            'action_type'        => $action,
            'old_status'         => $old,
            'new_status'         => $new,
            'remarks'            => $remarks,
            'performed_by'       => session()->get('user_id'),
        ]);
    }

    public function submit()
    {
        if (!$this->request->isAJAX()) return;

        // Uploads
        $vehicleID = $this->uploadFile($this->request->getFile('vehicle_id_proof'), 'public/uploads/vehicle');
        $visitorID = $this->uploadFile($this->request->getFile('visitor_id_proof'), 'public/uploads/visitor');

        // Auto codes
        $codeGen   = new GenerateCodesController();
        $vCode     = $codeGen->generateVisitorsCode();
        $groupCode = $codeGen->generateGroupVisitorsCode();

        // $status = (session()->get('role_id') == 1 || session()->get('role_id') == 5) ? "approved" : "pending";
        $status = in_array(session()->get('role_id'), [1,2,5]) ? 'approved' : 'pending';

        // Generate QR
        $qrFile = ($status === 'approved') ? $this->generateQRcode($vCode) : "";

        /* =======================================================
        STEP 1 — INSERT INTO visitor_request_header FIRST
        ======================================================= */

        $headerData = [
            'header_code'     => $groupCode,
            'requested_by'    => session()->get('user_id'),
            'referred_by'  => $this->request->getPost('referred_by'),
            'requested_date'  => $this->request->getPost('visit_date'),
            'requested_time'  => $this->request->getPost('visit_time'),
            'department'      => session()->get('department_name'),
            'company'      => session()->get('company_name'),
            'total_visitors'  => 1,
            'status'          => $status,
            'remarks'         => '',
            'purpose'         => $this->request->getPost('purpose'),
            'description'         => $this->request->getPost('description'), 
            'email'         => $this->request->getPost('visitor_email'), 
        ];

        $headerId = $this->VisitorRequestHeaderModel->insert($headerData);

        /* =======================================================
        STEP 2 — INSERT INTO visitors (link to header)
        ======================================================= */

        $visitorData = [
            'request_header_id' => $headerId,   // NEW IMPORTANT LINK
            'v_code'            => $vCode,
            'group_code'        => $groupCode,
            'visitor_name'      => $this->request->getPost('visitor_name'),
            'visitor_email'     => $this->request->getPost('visitor_email'),
            'visitor_phone'     => $this->request->getPost('visitor_phone'),
            'purpose'           => $this->request->getPost('purpose'),
            'proof_id_type'     => $this->request->getPost('proof_id_type'),
            'proof_id_number'   => $this->request->getPost('proof_id_number'),
            'visit_date'        => $this->request->getPost('visit_date'),
            'visit_time'        => $this->request->getPost('visit_time'),
            'description'       => $this->request->getPost('description'),
            'vehicle_no'        => $this->request->getPost('vehicle_no'),
            'vehicle_type'      => $this->request->getPost('vehicle_type'),
            'vehicle_id_proof'  => $vehicleID,
            'visitor_id_proof'  => $visitorID,
            'host_user_id'      => session()->get('user_id'),
            'status'            => $status,
            'qr_code'           => $qrFile,
            'created_by'        => session()->get('user_id'),
        ];

        $visitorId = $this->visitorModel->insert($visitorData);

        if ($headerId && $this->request->getPost('purpose') == 'Recce') {

            $recceData = [
                'header_id'      => $headerId,
                'recce_type'     => $this->request->getPost('recce_type'),
                'art_director'   => $this->request->getPost('art_director'),
                'company'        => $this->request->getPost('company'),
                'contact_person' => $this->request->getPost('contact_person'),
                'shooting_date'  => $this->request->getPost('shooting_date'),
                'mail_id'        => $this->request->getPost('contact_person_email'),
                'mobile'         => $this->request->getPost('contact_person_phone'),
                'created_at'     => date('Y-m-d H:i:s'),
                'created_by'     => session()->get('user_id'),
            ];

            $this->recceDetailsModel->insert($recceData);
        }

        if ($headerId && $this->request->getPost('purpose') == 'Vendor') {

            $vendorData = [
                'header_id'        => $headerId,
                'category' => $this->request->getPost('vendor_category'),
                'status'   => $this->request->getPost('vendor_status'),
                'company'  => $this->request->getPost('vendor_company'),
                'location' => $this->request->getPost('vendor_location'),
                'contact_person'  => $this->request->getPost('vendor_contact_name'),
                'email'           => $this->request->getPost('vendor_email'),
                'mobile'          => $this->request->getPost('vendor_mobile'),
                'created_at'      => date('Y-m-d H:i:s'),
                'created_by'      => session()->get('user_id'),
            ];

            $this->VendorModel->insert($vendorData);
        }

        // Log entry
        $this->insertLog($visitorId, 'Created', null, $status);

        // Auto email logic
        if ($status === "approved") {
            $mail_data[] = [
                'head_id' => $headerId,
                'name'    => $visitorData['visitor_name'],
                'email'   => $visitorData['visitor_email'],
                'phone'   => $visitorData['visitor_phone'],
                'purpose' => $visitorData['purpose'],
                'vid'     => $visitorId,
                'v_code'  => $vCode,
                'qr_path' => $qrFile,
            ];
            return $this->response->setJSON([
                'status' => 'success',
                'head_id' => $headerId,
                'submit_type' => 'admin'
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'mail_data' => '',
            'submit_type' => 'user'
        ]);
    }


public function groupSubmit()
{
    if (!$this->request->isAJAX()) return;
        $codeGen = new GenerateCodesController();
        $groupCode = $codeGen->generateGroupVisitorsCode();
        $names  = $this->request->getPost('visitor_name');
        $head_email = $this->request->getPost('email');
        $phones = $this->request->getPost('visitor_phone');
        $visit_time   = $this->request->getPost('visit_time');
        $visit_date   = $this->request->getPost('visit_date');
        $purpose   = $this->request->getPost('purpose');
        $description   = $this->request->getPost('description');
        $autoApprove = (in_array(session()->get('role_id'), [1,2,5]));
        $vehicleFiles = $this->request->getFileMultiple('vehicle_id_proof');
        $visitorFiles = $this->request->getFileMultiple('visitor_id_proof');
        $mailDataList = []; // Collect mail data

         
    // 1️ Insert Header Record
    $headerData = [
        'header_code'    => $groupCode,
        'requested_by'   => session()->get('user_id'),
        'referred_by'  => $this->request->getPost('referred_by'),
        'requested_date' => $visit_date, // Take from first visitor
        'requested_time' => $visit_time,
        'department'     => session()->get('department_name'),
        'company'        => session()->get('company_name'),
        'total_visitors' => count($names),
        'status'         => $autoApprove ? 'approved' : 'pending',
        'remarks'        => '',
        'purpose'        => $purpose,
        'description'    => $this->request->getPost('description'),
        'email'          => $head_email,
        'updated_by'         => $autoApprove ? session()->get('user_id') : ''
    ];

      $headerId = $this->VisitorRequestHeaderModel->insert($headerData);


    
    if ($headerId && $this->request->getPost('purpose') == 'Recce') {

        $recceData = [
            'header_id'      => $headerId,
            'recce_type'     => $this->request->getPost('recce_type'),
            'art_director'   => $this->request->getPost('art_director'),
            'company'        => $this->request->getPost('company'),
            'contact_person' => $this->request->getPost('contact_person'),
            'shooting_date'  => $this->request->getPost('shooting_date'),
            'mail_id'        => $this->request->getPost('contact_person_email'),
            'mobile'         => $this->request->getPost('contact_person_phone'),
            'created_at'     => date('Y-m-d H:i:s'),
            'created_by'     => session()->get('user_id'),
        ];

        $this->recceDetailsModel->insert($recceData);
    }


    if ($headerId && $this->request->getPost('purpose') == 'Vendor') {

        $vendorData = [
            'header_id'        => $headerId,
            'category' => $this->request->getPost('vendor_category'),
            'status'   => $this->request->getPost('vendor_status'),
            'company'  => $this->request->getPost('vendor_company'),
            'location' => $this->request->getPost('vendor_location'),
            'contact_person'  => $this->request->getPost('vendor_contact_name'),
            'email'           => $this->request->getPost('vendor_email'),
            'mobile'          => $this->request->getPost('vendor_mobile'),
            'created_at'      => date('Y-m-d H:i:s'),
            'created_by'      => session()->get('user_id'),
        ];

        $this->VendorModel->insert($vendorData);
    }


    // 2️ Loop through visitors
    foreach ($names as $i => $name)
    {
        $vCode  = $codeGen->generateVisitorsCode();
        $status = $autoApprove ? "approved" : "pending";
        $qrFile = $autoApprove ? $this->generateQRcode($vCode) : "";

        $data = [
            'group_code'        => $groupCode,
            'v_code'            => $vCode,
            'request_header_id' => $headerId, // link to header
            'visitor_name'      => $name,
            'visitor_email'     => $this->request->getPost('visitor_email')[$i],
            'visitor_phone'     => $phones[$i],
            'purpose'           => $purpose,
            'proof_id_type'     => $this->request->getPost('proof_id_type')[$i],
            'proof_id_number'   => $this->request->getPost('proof_id_number')[$i],
            'visit_date'        => $visit_date,
            'visit_time'        => $visit_time,
            'description'       => $description,
            'vehicle_no'        => $this->request->getPost('vehicle_no')[$i],
            'vehicle_type'      => $this->request->getPost('vehicle_type')[$i],
            'vehicle_id_proof'  => $this->uploadFile($vehicleFiles[$i], 'public/uploads/vehicle'),
            'visitor_id_proof'  => $this->uploadFile($visitorFiles[$i], 'public/uploads/visitor'),
            'host_user_id'      => session()->get('user_id'),
            'status'            => $status,
            'qr_code'           => $qrFile,
            'created_by'        => session()->get('user_id'),
        ];

        $vRequestId = $this->visitorModel->insert($data);

        $this->insertLog($vRequestId, 'Created', null, $status);
      
    }

    return $this->response->setJSON([
        'status'      => 'success',
        'submit_type' => $autoApprove ? 'admin' : 'user',
        'head_id'   => $headerId
    ]);
}


    /* ==================================================================
       APPROVAL PROCESS
    ================================================================== */

    public function approvalProcess()
    {

            $head_id  = $this->request->getPost('head_id');
            $status   = $this->request->getPost('status');
            $remark   = $this->request->getPost('comment');

            // ------------------------------
            // 1. GET ALL VISITORS BY HEAD ID
            // ------------------------------
            $visitors = $this->visitorModel
                            ->where('request_header_id', $head_id)
                            ->findAll();

            if (empty($visitors)) {
                return $this->response->setJSON([
                    "status"  => "error",
                    "message" => "No visitors found for this head_id"
                ]);
            }

            // // ------------------------------------
            // // 2. UPDATE EACH VISITOR + ADD LOG
            // // ------------------------------------
                $mail_data = [];  
                foreach ($visitors as $v) {

                    // Generate QR
                    $qrFile = $this->generateQRcode($v['v_code']);

                    // Update visitor Table status
                    
                    $this->visitorModel->update($v['id'], [
                        'status'  => $status,
                        'qr_code' => $qrFile
                    ]);

                    // Insert log

                    $this->insertLog(
                        $v['id'],        // visitor_id
                        $status,         // new status
                        $v['status'],    // old status
                        $status,         // updated status
                        $remark          // comment
                    );

                }

            // -----------------------------------
            // 3. UPDATE HEAD TABLE STATUS
            // -----------------------------------

            $this->VisitorRequestHeaderModel->update($head_id, [
                'status' => $status,
                'remarks' => $remark,
                'updated_by' => session()->get('user_id'),
            ]);

            
            // -----------------------------------
            // 4. SEND RESPONSE
            // -----------------------------------

            return $this->response->setJSON([
                "status"  => "success",
                "message" => "Head status & all visitors updated successfully!",
                "head_id" => $head_id
            ]);

    }


    /* ==================================================================
       VISITOR LIST
    ================================================================== */
    public function visitorDataListView()
    {
        return view('dashboard/visitorrequestlist');
    }

    public function visitorData()
    {
            $role = session()->get('role_id');
            $uid  = session()->get('user_id');

            $query = $this->VisitorRequestHeaderModel
                      ->orderBy('id', 'DESC')
                      ->limit(200);

            // Role-wise conditions
            if ($role == 2) {
                // Department Admin → Requests referred to him
                $query->where('referred_by', $uid);

            } elseif ($role == 3) {
                // Normal User → Requests created by him
                $query->where('requested_by', $uid);
            }

            // Role 1 → Super Admin → No where condition
            // Show everything

            return $this->response->setJSON($query->findAll());
    }

       

    /* ==================================================================
       VISITOR LIST By GV-Code
    ================================================================== */

    public function getVisitorRequastDataById($id)
    {
        $headerModel = new \App\Models\VisitorRequestHeaderModel();

        $data = $headerModel->getHeaderWithVisitors($id);

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => $data
        ]);
    }

    public function getVisitorRequastDataByVCode()
    {
        $v_code = $this->request->getPost('v_code');

        $headerModel = new \App\Models\VisitorRequestHeaderModel();
        $data = $headerModel->getHeaderWithVisitorsMailDataByVCode($v_code);

        //  If no record found
        if (empty($data)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Invalid V-Code or visitor not found',
                'data'    => null
            ]);
        }

        // Success response
        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Visitor details fetched successfully',
            'data'    => $data[0]
        ]);

        // return $this->response->setJSON($data[0]);
    }



        // downloadCsvTemplate
        public function downloadCsvTemplate()
        {
            $filename = "Visitor_Template.csv";

            // CSV Header Row
            $header = [
                "S.No",
                "Visitor Name",
                "Email",
                "Phone",
                "ID Type",
                "ID Number",
                "Vehicle No",
                "Vehicle Type",
                "Vehicle ID Proof",
                "Visitor ID Proof",
                "Action"
            ];

            // Dropdown options (CSV cannot have dropdowns, so we provide allowed values)
            $allowedIdTypes = "Options: Aadhaar Card| PAN Card| Voter ID | Passport | Driving License";
            $allowedVehicleTypes = "Options: Bike | Car | Van | Bus | Auto | Truck";

            // Sample Rows
            $sampleRows = [
                [
                    1, "Prakash", "john@example.com", "9876543210", 
                    "Aadhaar Card", "123456789012", "TN10AB1234", "Car", "Yes", "Yes", ""
                ],
                [
                    2, "Sharath", "mary@example.com", "9876501234",
                    "PAN Card", "ABCDE1234F", "TN09XY9876", "Bike", "No", "Yes", ""
                ]
            ];

            // Output CSV
            header("Content-Type: text/csv");
            header("Content-Disposition: attachment; filename={$filename}");

            $output = fopen("php://output", "w");

            // Write header
            fputcsv($output, $header);

            // Write allowed options row (row 2)
            fputcsv($output, [
                "",
                "",
                "",
                "",
                $allowedIdTypes,
                "",
                "",
                $allowedVehicleTypes,
                "",
                "",
                ""
            ]);

            // Write sample rows
            foreach ($sampleRows as $row) {
                fputcsv($output, $row);
            }

            fclose($output);
            exit;
        }

         // Upload CSV Template
        public function uploadCsv()
        {
            $file = $this->request->getFile('excel_file');

            if (!$file->isValid()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid File']);
            }

            $path = $file->getTempName();
            $csv = array_map('str_getcsv', file($path));

            $finalData = [];

            foreach ($csv as $index => $row) {

            if ($index == 0) continue; // Skip header
            if (empty($row[1])) continue; // Skip empty rows

            $finalData[] = [
                'sno'            => $row[0],
                'visitor_name'   => $row[1],
                'email'          => $row[2],
                'phone'          => $row[3],
                'id_type'        => $row[4],
                'id_number'      => $row[5],
                'vehicle_no'     => $row[6],
                'vehicle_type'   => $row[7],
                'vehicle_id'     => $row[8],
                'visitor_id'     => $row[9],
            ];
            }

            return $this->response->setJSON([
            'status' => 'success',
            'data'   => $finalData
            ]);
        }


        public function updateVisitorValidity()
        {
            // Get all expired visitors (older than 1 day & validity = 1)
            $visitorRequestModelObj = new VisitorRequestModel();
            $expiredVisitorPassModel = new ExpiredVisitorPassModel();
                
            $expiredVisitors = $visitorRequestModelObj
                                ->where('validity', 1)
                                ->where('securityCheckStatus', 0)    // Visitor not checked in / not in gate log
                                ->where('visit_date <', date('Y-m-d'))  // Visit date older than today
                                ->findAll();

                // print_r($expiredVisitors);

            foreach ($expiredVisitors as $visitor) {

                // Insert into expired_visitor_passes table
                $expiredVisitorPassModel->insert([
                    'visitor_request_id' => $visitor['id'],
                    'v_code'       => $visitor['v_code'],   // change column names if needed
                    'header_code'        => $visitor['group_code'],    // change column names if needed
                    'expired_at'         => date('Y-m-d H:i:s')
                ]);
                
                $visitorRequestModelObj->update($visitor['id'], ['validity' => 0]);     
            }

            return $this->response->setJSON([
                'status' => 'success',
                'expired_count' => count($expiredVisitors),
                'message' => 'Expired visitor passes stored successfully'
            ]);
        }



public function completeMeeting()
{
        $v_code = $this->request->getPost('v_code');

        $visitorModel = new \App\Models\VisitorRequestModel();

        $visitor = $visitorModel->where('v_code', $v_code)->first();

        if (!$visitor) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Visitor not found'
            ]);
        }

        if ($visitor['securityCheckStatus'] != 1) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Visitor is not inside'
            ]);
        }

        $visitorModel->update($visitor['id'], [
            'meeting_status' => 1,
            'meeting_completed_at' => date('Y-m-d H:i:s')
        ]);

        return $this->response->setJSON([
            'status' => 'success',
            'id' => $visitor['request_header_id']
        ]);
}

}

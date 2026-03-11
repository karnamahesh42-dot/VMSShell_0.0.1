<?php

namespace App\Controllers;

use App\Models\VisitorRequestModel;
use App\Models\VisitorLogModel;
use App\Models\SecurityGateLogModel;
use App\Models\VisitorRequestHeaderModel;
use App\Models\CompanyModel;
use App\Models\DepartmentModel;


class Dashboard extends BaseController
{
    protected $visitorModel;
    protected $logModel;
    protected $SecurityGateLogModel;
    protected $VisitorRequestHeaderModel;


    

    public function __construct()
    {
        $this->visitorModel = new VisitorRequestModel();
        $this->logModel     = new VisitorLogModel();
        $this->SecurityGateLogModel     = new SecurityGateLogModel();
        $this->VisitorRequestHeaderModel     = new VisitorRequestHeaderModel();
       
    }


     
  

    public function index()
    {
                // Visits today
                $session = session();

                if (!$session->has('isLoggedIn') || !$session->has('user_id') || !$session->has('username') || !$session->has('role_id')) {
                    header("Location: " . base_url('/login'));
                    exit;
                }

                $today = date('Y-m-d');
                $roleId       = $_SESSION['role_id'];
                $userId       = $_SESSION['user_id'];
                $departmentId = $_SESSION['department_id'];
                $departmentName = $_SESSION['department_name'];
                $compenyName = $_SESSION['company_name'];
                
       
                $pendingQuery = $this->visitorModel
                ->join(
                'visitor_request_header', 
                'visitor_request_header.id = visitors.request_header_id'
                )
                ->where('visitors.status', 'pending')
                ->where('visitors.visit_date', $today);

                if ($roleId == 2) {
                    $pendingQuery->where('visitor_request_header.department', $departmentName);
                } elseif ($roleId == 3) {
                    $pendingQuery->where('visitors.created_by', $userId);
                }
                $pendingVisitors = $pendingQuery->countAllResults();

            
        ///////////////////////////////////////////////////////////////////////////////

                $approvedQuery = $this->visitorModel
                ->join(
                'visitor_request_header',
                'visitor_request_header.id = visitors.request_header_id'
                )
                ->where('visitors.status', 'approved')
                ->where('visitors.visit_date', $today);
                if ($roleId == 2) {
                    $approvedQuery->where('visitor_request_header.department', $departmentName);
                } elseif ($roleId == 3) {
                    $approvedQuery->where('created_by', $userId);
                }
                $approved = $approvedQuery->countAllResults();

        //////////////////////////////////////////////////////////////////////////////////

                $rejectedQuery = $this->visitorModel
                ->join(
                'visitor_request_header',
                'visitor_request_header.id = visitors.request_header_id'
                )
                ->where('visitors.status', 'rejected')
                ->where('visitors.visit_date', $today);
                if ($roleId == 2) {
                    $rejectedQuery->where('visitor_request_header.department', $departmentName);
                } elseif ($roleId == 3) {
                    $rejectedQuery->where('created_by', $userId);
                }
                $rejected = $rejectedQuery->countAllResults();

        //////////////////////////////////////////////////////////////////////////////////////

                // $visitQuery = $this->visitorModel
                // ->join(
                // 'visitor_request_header',
                // 'visitor_request_header.id = visitors.request_header_id'
                // )
                // ->where('visitors.status', 'approved')
                // ->where('visit_date', $today);
                // if ($roleId == 2) {
                //     $visitQuery->where('visitor_request_header.department', $departmentName);
                // } elseif ($roleId == 3) {
                //     $visitQuery->where('created_by', $userId);
                // }
                // $visitsToday = $visitQuery->countAllResults();


                    $visitQuery = $this->visitorModel
                        ->join(
                            'visitor_request_header',
                            'visitor_request_header.id = visitors.request_header_id'
                        )
                        ->where('visitors.status', 'approved')
                        ->groupStart()

                            // ✅ Single Day Visitors
                            ->groupStart()
                                ->where('visitors.validity_type', 'SD')
                                ->where('visitors.visit_date', $today)
                            ->groupEnd()

                            ->orGroupStart()

                                // ✅ Multi Day Visitors
                                ->where('visitors.validity_type', 'MD')
                                ->where('visitors.valid_from <=', $today)
                                ->where('visitors.valid_to >=', $today)

                            ->groupEnd()

                        ->groupEnd();

                    if ($roleId == 2) {
                        $visitQuery->where('visitor_request_header.department', $departmentName);
                    } elseif ($roleId == 3) {
                        $visitQuery->where('visitors.created_by', $userId);
                    }

                    $visitsToday = $visitQuery->countAllResults();
        //////////////////////////////////////////////////////////////////////////////////////////

                $todayStart = date('Y-m-d') . ' 00:00:00';
                $todayEnd   = date('Y-m-d') . ' 23:59:59';

                $db = \Config\Database::connect();

                $sdQuery = $db->table('security_gate_logs')
                    ->select('security_gate_logs.id')
                    ->join('visitors', 'visitors.id = security_gate_logs.visitor_request_id')
                    ->join('visitor_request_header', 'visitor_request_header.id = visitors.request_header_id')
                    ->where('security_gate_logs.check_in_time >=', $todayStart)
                    ->where('security_gate_logs.check_in_time <=', $todayEnd);

                if ($roleId == 2) {
                    $sdQuery->where('visitor_request_header.department', $departmentName);
                } elseif ($roleId == 3) {
                    $sdQuery->where('visitors.created_by', $userId);
                }

                $sdCount = $sdQuery->countAllResults();

                $mdQuery = $db->table('security_gate_logs_md')
                    ->select('security_gate_logs_md.id')
                    ->join('visitors', 'visitors.v_code = security_gate_logs_md.v_code')
                    ->join('visitor_request_header', 'visitor_request_header.id = visitors.request_header_id')
                    ->where('security_gate_logs_md.check_in_time >=', $todayStart)
                    ->where('security_gate_logs_md.check_in_time <=', $todayEnd);

                if ($roleId == 2) {
                    $mdQuery->where('visitor_request_header.department', $departmentName);
                } elseif ($roleId == 3) {
                    $mdQuery->where('visitors.created_by', $userId);
                }

                $mdCount = $mdQuery->countAllResults();

                $gateEntries = $sdCount + $mdCount;


        //////////////////////////////////////////////////////////////////////////////////////////
            
                // Prepare card data
                $data['smallCards'] = [
                    ['title'=>'Today Visitors','value'=>$visitsToday,'icon'=>'fa-calendar-day','color'=>'c6','subtitle'=>'Visits Count Today'],
                    ['title'=>'Gate Entries','value'=>$gateEntries,'icon'=>'fa-door-open','color'=>'c5','subtitle'=>'Gate Entries Today'],
                    ['title'=>'Pending Approvals','value'=>$pendingVisitors,'icon'=>'fa-file-alt','color'=>'c2','subtitle'=>'Pending Visitors Today'],
                    ['title'=>'Approved','value'=>$approved,'icon'=>'fa-check-circle','color'=>'c3','subtitle'=>'Approved Today'],
                    ['title'=>'Rejected','value'=>$rejected,'icon'=>'fa-times-circle','color'=>'c4','subtitle'=>'Rejected Today'],
                ];


        //////////////////////////// Pending Request List Data /////////////////////////////////////////////////////

                $builder = $this->VisitorRequestHeaderModel
            ->select("
                visitor_request_header.id,
                visitor_request_header.header_code,
                visitor_request_header.purpose,
                visitor_request_header.requested_date,
                visitor_request_header.requested_time,
                visitor_request_header.total_visitors,
                visitor_request_header.description,
                visitor_request_header.status,
                GROUP_CONCAT(visitors.visitor_name SEPARATOR ', ') AS visitor_names
            ")

                ->join('visitors', 'visitors.request_header_id = visitor_request_header.id', 'left')
                ->where('visitor_request_header.status', 'pending');
                
            if ($roleId == 2) {
                $builder->where('visitor_request_header.referred_by', $userId);
            } elseif ($roleId == 3) {
                $builder->where('visitor_request_header.requested_by', $userId);
            }elseif ($roleId == 5){
                $builder->where('visitor_request_header.department', $departmentName);
            }

            $pendingList = $builder
            ->groupBy('visitor_request_header.id')
            ->orderBy('visitor_request_header.id', 'DESC')
            ->limit(5)
            ->findAll();

        $data['pendingList'] = $pendingList;


// //////////////////////////////////////// ------ Dashboard Count Display Valus  Start ------/////////////////////////////////////////////////   

$db = \Config\Database::connect();

function getCheckinCount($db, $startDate, $endDate)
{
    // Convert to full datetime range
    $startDateTime = $startDate . ' 00:00:00';
    $endDateTime   = $endDate . ' 23:59:59';

    // -------- SD TABLE COUNT --------
    $sdCount = $db->table('security_gate_logs')
        ->where('check_in_time >=', $startDateTime)
        ->where('check_in_time <=', $endDateTime)
        ->countAllResults();

    // -------- MD TABLE COUNT --------
    $mdCount = $db->table('security_gate_logs_md')
        ->where('check_in_time >=', $startDateTime)
        ->where('check_in_time <=', $endDateTime)
        ->countAllResults();

    return $sdCount + $mdCount;
}

$today = date('Y-m-d');
$todayVisitors = getCheckinCount($db, $today, $today);

$weekStart = date('Y-m-d', strtotime('monday this week'));
$weekEnd   = date('Y-m-d', strtotime('sunday this week'));

$weekVisitors = getCheckinCount($db, $weekStart, $weekEnd);

$monthStart = date('Y-m-01');
$monthEnd   = date('Y-m-t');

$monthVisitors = getCheckinCount($db, $monthStart, $monthEnd);

$yearStart = date('Y-01-01');
$yearEnd   = date('Y-12-31');

$thisYearVisitors = getCheckinCount($db, $yearStart, $yearEnd);

$data['meds'] = [
    [ 'title' => 'Today Visited',
        'count' => $todayVisitors,
        'icon'  => 'fa-users',
        'desc'  => $todayVisitors . ' People Visited Today.'],
    ['title' => 'This Week',
        'count' => $weekVisitors,
        'icon'  => 'fa-calendar-week',
        'desc'  => $weekVisitors . ' Visitors This Week.'],
    ['title' => 'This Month',
        'count' => $monthVisitors,
        'icon'  => 'fa-calendar',
        'desc'  => $monthVisitors . ' Visitors This Month.'],
    [ 'title' => 'This Year',
        'count' => $thisYearVisitors,
        'icon'  => 'fa-user',
        'desc'  => $thisYearVisitors . ' Visitors This Year.'],];

                
        $recentAuthorized = $this->SecurityGateLogModel->getRecentAuthorized(10);

        $data['recentAuthorized'] = $recentAuthorized;

            $companyModel = new CompanyModel();
            $departmentModel = new DepartmentModel();

            $data['companies'] = $companyModel
                ->orderBy('company_name', 'ASC')
                ->findAll();

            $data['departments'] = $departmentModel
                ->orderBy('department_name', 'ASC')
                ->findAll();

        return view('dashboard/dashboard', $data);
    }

    
      public function usermanuals(){
          return view('dashboard/usermanuals');
      }

      public function about(){
          return view('dashboard/about');
      }


        public function requestToCheckoutDataDashboard()
        {
            $db = \Config\Database::connect();
            $request = service('request');
            $session = session();

            $roleId       = $session->get('role_id');
            $fromDate     = $request->getGet('from_date') ?? date('Y-m-01');
            $toDate       = $request->getGet('to_date') ?? date('Y-m-d');
            $company      = $request->getGet('company');
            $department   = $request->getGet('department');
            $statusFilter = $request->getGet('status');

            $builder = $db->table('visitors vr')
                ->select('vrh.department, COUNT(DISTINCT vr.id) as total')
                ->join('visitor_request_header vrh', 'vrh.id = vr.request_header_id', 'left')
                ->join('security_gate_logs sgl', 'vr.id = sgl.visitor_request_id AND DATE(sgl.check_in_time) >= "'. $fromDate .'" AND DATE(sgl.check_in_time) <= "'. $toDate .'"', 'left')
                ->join('security_gate_logs_md md', 'vr.v_code = md.v_code AND DATE(md.check_in_time) >= "'. $fromDate .'" AND DATE(md.check_in_time) <= "'. $toDate .'"', 'left');

            // Apply the date filters properly to include visit date limits across ranges
            $builder->groupStart()
                ->where("DATE(sgl.check_in_time) >=", $fromDate)
                ->where("DATE(sgl.check_in_time) <=", $toDate)
                ->orGroupStart()
                    ->where("DATE(md.check_in_time) >=", $fromDate)
                    ->where("DATE(md.check_in_time) <=", $toDate)
                ->groupEnd()
                ->orGroupStart()
                    ->where("vr.visit_date >=", $fromDate)
                    ->where("vr.visit_date <=", $toDate)
                ->groupEnd()
            ->groupEnd();

            if (!empty($company)) {
                $builder->where('vrh.company', $company);
            }

            if (!empty($department)) {
                $builder->where('vrh.department', $department);
            }

            /*
            ==========================
            STATUS FILTERS
            ==========================
            */
            if (!empty($statusFilter)) {
                if ($statusFilter === 'pending') {
                    $builder->where('vr.status', 'pending');
                } elseif ($statusFilter === 'approved') {
                    $builder->where('vr.status', 'approved');
                } elseif ($statusFilter === 'rejected') {
                    $builder->where('vr.status', 'rejected');
                } elseif ($statusFilter === 'not_entered') {
                    $builder->where('vr.status', 'approved');
                    $builder->groupStart()
                        ->where('sgl.check_in_time IS NULL')
                        ->where('md.check_in_time IS NULL')
                    ->groupEnd();
                } elseif ($statusFilter === 'inside') {
                    $builder->where('vr.status', 'approved');
                    $builder->groupStart()
                        ->groupStart()
                            ->where('sgl.check_in_time IS NOT NULL')
                            ->where('sgl.check_out_time IS NULL')
                        ->groupEnd()
                        ->orGroupStart()
                            ->where('md.check_in_time IS NOT NULL')
                            ->where('md.check_out_time IS NULL')
                        ->groupEnd()
                    ->groupEnd();
                } elseif ($statusFilter === 'checkout') {
                    $builder->where('vr.status', 'approved');
                    $builder->groupStart()
                        ->where('sgl.check_out_time IS NOT NULL')
                        ->orWhere('md.check_out_time IS NOT NULL')
                    ->groupEnd();
                }
            } else {
                // By default, if no status is selected, only show approved visitors who checked in (matches old behavior)
                // Adjust if you want the default to be EVERYTHING
                $builder->where('vr.status', 'approved');
                $builder->groupStart()
                    ->where('sgl.check_in_time IS NOT NULL')
                    ->orWhere('md.check_in_time IS NOT NULL')
                ->groupEnd();
            }

            $builder->where('vrh.department IS NOT NULL');
            $builder->where('vrh.department !=', '');
            $builder->groupBy('vrh.department');

            $results = $builder->get()->getResultArray();

            $finalData = [];
            foreach ($results as $row) {
                $finalData[$row['department']] = $row['total'];
            }

            return $this->response->setJSON([
                'labels' => empty($finalData) ? [] : array_keys($finalData),
                'counts' => empty($finalData) ? [] : array_values($finalData)
            ]);
        }
    
}

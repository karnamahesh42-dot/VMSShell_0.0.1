<?php

namespace App\Controllers;

use App\Models\VisitorRequestModel;
use App\Models\VisitorLogModel;
use App\Models\SecurityGateLogModel;
use App\Models\VisitorRequestHeaderModel;


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

                // Dynamic counts from DB
            
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

                $visitQuery = $this->visitorModel
                ->join(
                'visitor_request_header',
                'visitor_request_header.id = visitors.request_header_id'
                )
                ->where('visitors.status', 'approved')
                ->where('visit_date', $today);
                if ($roleId == 2) {
                    $visitQuery->where('visitor_request_header.department', $departmentName);
                } elseif ($roleId == 3) {
                    $visitQuery->where('created_by', $userId);
                }
                $visitsToday = $visitQuery->countAllResults();

        //////////////////////////////////////////////////////////////////////////////////////////

                $gateQuery = $this->SecurityGateLogModel
                    ->select('security_gate_logs.id')
                ->join(
                    'visitors',
                    'visitors.id = security_gate_logs.visitor_request_id'
                )
                ->join(
                    'visitor_request_header',
                    'visitor_request_header.id = visitors.request_header_id'
                )
                ->where('visitors.visit_date', $today);

                if ($roleId == 2) {
                    $gateQuery->where('visitor_request_header.department', $departmentName);
                } elseif ($roleId == 3) {
                    $gateQuery->where('visitors.created_by', $userId);
                }
                $gateEntries = $gateQuery->countAllResults();

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
                // $builder = $this->VisitorRequestHeaderModel
                //     ->select("
                //         id,
                //         header_code,
                //         purpose,
                //         requested_date,
                //         requested_time,
                //         total_visitors,
                //         description,
                //         status
                //     ")
                //     ->where('status', 'pending');

                // // Condition: Role wise filtering
                // if ($roleId == 2) {
                //     // Department Admin → show requests referred to him
                //     $builder->where('referred_by', $userId);

                // } elseif ($roleId == 3) {
                //     // Normal user → show only requests he created
                //     $builder->where('requested_by', $userId);
                // }
                // // roleId == 1 → no filter → show all

                // $pendingList = $builder
                //     ->orderBy('id', 'DESC')
                //     ->limit(5)
                //     ->findAll();

                // $data['pendingList'] = $pendingList;


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


        //////////////////////////////////////////////////////////////////////////////////////////

        $visitorsModel = new VisitorRequestModel();

        $yearStart = date('Y-01-01');
        $yearEnd   = date('Y-12-31');

        $yearQuery = $visitorsModel
            ->join(
                'visitor_request_header',
                'visitor_request_header.id = visitors.request_header_id',
                'inner'
            )
            ->where('visitors.securityCheckStatus !=', 0)
            ->where('visitors.visit_date >=', $yearStart)
            ->where('visitors.visit_date <=', $yearEnd);

        if ($roleId == 2) {
            $yearQuery
                ->where('visitor_request_header.department', $departmentName)
                ->where('visitor_request_header.company', $compenyName);
        } elseif ($roleId == 3) {
            $yearQuery->where('visitors.created_by', $userId);
        }

        $thisYearVisitors = $yearQuery->countAllResults();
        /////-----------------------------------------------------/////////

        $monthStart = date('Y-m-01');
        $monthEnd   = date('Y-m-t');

        $monthQuery = $visitorsModel
            ->join('visitor_request_header', 'visitor_request_header.id = visitors.request_header_id')
            ->where('visitors.securityCheckStatus !=', 0)
            ->where('visitors.visit_date >=', $monthStart)
            ->where('visitors.visit_date <=', $monthEnd);

        if ($roleId == 2) {
            $monthQuery
                ->where('visitor_request_header.department', $departmentName)
                ->where('visitor_request_header.company', $compenyName);
        } elseif ($roleId == 3) {
            $monthQuery->where('visitors.created_by', $userId);
        }

        $monthVisitors = $monthQuery->countAllResults();

        ///////////-------------------------------------------------------///////////////

        $weekStart = date('Y-m-d', strtotime('monday this week'));
        $weekEnd   = date('Y-m-d', strtotime('sunday this week'));

        $weekQuery = $visitorsModel
            ->join('visitor_request_header', 'visitor_request_header.id = visitors.request_header_id')
            ->where('visitors.securityCheckStatus !=', 0)
            ->where('visitors.visit_date >=', $weekStart)
            ->where('visitors.visit_date <=', $weekEnd);

        if ($roleId == 2) {
            $weekQuery
                ->where('visitor_request_header.department', $departmentName)
                ->where('visitor_request_header.company', $compenyName);
        } elseif ($roleId == 3) {
            $weekQuery->where('visitors.created_by', $userId);
        }

        $weekVisitors = $weekQuery->countAllResults();

        ////////////////-------------------------------------------------////////////////
        $today = date('Y-m-d');

        $todayQuery = $visitorsModel
            ->join('visitor_request_header', 'visitor_request_header.id = visitors.request_header_id')
            ->where('visitors.securityCheckStatus !=', 0)
            ->where('visitors.visit_date', $today);

        if ($roleId == 2) {
            $todayQuery
                ->where('visitor_request_header.department', $departmentName)
                ->where('visitor_request_header.company', $compenyName);
        } elseif ($roleId == 3) {
            $todayQuery->where('visitors.created_by', $userId);
        }

        $todayVisitors = $todayQuery->countAllResults();

//////////////////////////////////////////////////////////////////////////////////////////

                // Security alerts — example (0 for now, or fetch from DB)
                // $alerts = 0;

        $data['meds'] = [
        ['title' => 'Today Visited', 'count' => $todayVisitors, 'icon' => 'fa-users', 'desc' => $todayVisitors . ' people visited today.'],
        ['title' => 'This Week', 'count' => $weekVisitors, 'icon' => 'fa-calendar-week', 'desc' => $weekVisitors . ' visitors this week.'],
        ['title' => 'This Month', 'count' => $monthVisitors, 'icon' => 'fa-calendar', 'desc' => $monthVisitors . ' visitors this month.'],
        ['title' => 'This Year', 'count' => $thisYearVisitors, 'icon' => 'fa-user', 'desc' => $thisYearVisitors . ' visitors this Year.'],  
        ];
// ['title' => 'Alerts', 'count' => $alerts, 'icon' => 'fa-bell', 'desc' => $alerts == 0 ? 'No security alerts.' : $alerts . ' alerts pending.'],
                
        $recentAuthorized = $this->SecurityGateLogModel->getRecentAuthorized(10);

        $data['recentAuthorized'] = $recentAuthorized;

        return view('dashboard/dashboard', $data);
    }


      public function about(){
          return view('dashboard/about');
      }
    
}

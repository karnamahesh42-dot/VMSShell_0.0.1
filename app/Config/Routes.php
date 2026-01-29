<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Dashboard::index');
$routes->get('/home', 'Dashboard::index');
$routes->get('about', 'Dashboard::about');
$routes->get('/login', 'Login::index');
$routes->get('/logout', 'Login::logout');
$routes->get('/usermanuals', 'Dashboard::usermanuals');

$routes->post('/login', 'Login::checkLogin');

$routes->get('/user', 'User::index');
$routes->post('/user/create', 'User::create');
$routes->get('/userlist', 'User::userListData');
$routes->get('/user/get/(:num)', 'User::get/$1');
$routes->post('user/update', 'User::update');
$routes->post('user/toggleStatus', 'User::toggleStatus');
$routes->get('/user/changePass', 'User::changePassview');
$routes->post('/user/cahangePass', 'User::changePass');

$routes->post('send-otp', 'MobileOTPController::sendOtp');// Mobile Otp Contriollr


$routes->get('/visitorequest', 'VisitorRequest::index'); // add User Form
$routes->get('/group_visito_request', 'VisitorRequest::groupVisitorRequestForm'); // add User Form
$routes->get('/visitorlistdata', 'VisitorRequest::visitorData'); //to get The visiter Reuest List Data 
$routes->get('/visitorequestlist', 'VisitorRequest::visitorDataListView'); // //to get The visiter Reuest View
$routes->post('/visitorequest/create','VisitorRequest::submit');
$routes->post('/visitorequest/create_group','VisitorRequest::groupSubmit');
$routes->post('/updateVisitorValidity','VisitorRequest::updateVisitorValidity');


$routes->post('/approvalprocess', 'VisitorRequest::approvalProcess');//To Approval Process 
$routes->get('/getvisitorrequestdata/(:num)', 'VisitorRequest::getVisitorRequastDataById/$1'); //To get Visito Request Data By ID
$routes->post('/get-visitor-details', 'VisitorRequest::getVisitorRequastDataByVCode'); //To get Visito Request Data By ID

$routes->get('/visitor-template-download', 'VisitorRequest::downloadCsvTemplate');
$routes->post('/visitor-template-upload', 'VisitorRequest::uploadCsv');
$routes->post('/visitor/complete-meeting', 'VisitorRequest::completeMeeting');


// $routes->get('send-email', 'MailController::sendMail');
$routes->post('send-email', 'MailController::sendMail');
$routes->post('mail/group-qr', 'MailController::sendGroupQrMail');

// $routes->post('send-email', 'MailController::sendMailTwo');



$routes->get('reference', 'ReferenceControllere::index');
$routes->post('/reference_save', 'ReferenceControllere::create');
$routes->get('/referenceData', 'ReferenceControllere::getReferencePersons');


// $routes->get('/reference-visitor-request/create', 'ReferenceVisitorRequestController::createForm');// Form
$routes->post('/rvr_save', 'ReferenceVisitorRequestController::create');// Save
$routes->get('reference_visitor_request', 'ReferenceVisitorRequestController::index'); // View reference visitor request
$routes->get('/rvr_list', 'ReferenceVisitorRequestController::getAllReferenceVisitorRequest'); // List Data (AJAX)
$routes->get('/get_reference_list', 'ReferenceVisitorRequestController::getAllReference'); // get list Of reference Data  (AJAX)
$routes->get('rvr_request_by_id/(:num)', 'ReferenceVisitorRequestController::getReferenceVisitorRequestById/$1'); //reference Request Data By id 

// Redirect using RVR code
$routes->get('rvr_redirect/(:any)', 'RVRDetailsController::rvr_redirect/$1');

// Load the visitor form page
$routes->get('rvr_details_sheet', 'RVRDetailsController::rvr_details_sheet');

$routes->get('/security_authorization', 'SecurityController::index');
$routes->get('/authorized_visitors_list', 'SecurityController::View_authorized_visitor_list');
$routes->get('/security/authorized_visitors_list_data', 'SecurityController::authorized_visitors_list_data');
$routes->get('/security/todayVisitorListOfDashboard', 'SecurityController::todayVisitorListOfDashboard');
$routes->post('/security/detBelongingsData', 'SecurityController::detBelongingsData');

$routes->post('/security/verify', 'SecurityController::verifyVisitor');
$routes->post('/security/saveBelongings', 'SecurityController::saveBelongings');
// $routes->post('/security/checkin', 'SecurityController::checkIn');
// $routes->post('/security/checkout', 'SecurityController::checkOut');
$routes->post('/security/securityAction', 'SecurityController::securityAction');
$routes->post('/visitor/uploadPhoto', 'SecurityController::uploadPhoto');
///////////////////////////////////// Reports  Start /////////////////////////////////////////////////////////////
$routes->get('/daily_visitor_report', 'ReportController::dailyVisitorReport');
$routes->get('/request_to_checkout', 'ReportController::requestToCheckoutReport');

///////////////////////////////////// Reports  End /////////////////////////////////////////////////////////////
$routes->get('/masterdata', 'MasterDataController::index');
$routes->post('master/save', 'MasterDataController::save');


// $routes->get('/', 'VisitorController::create');
// $routes->get('/visitor/create','VisitorController::create');
// $routes->post('/visitor/submit','VisitorController::submit');
// $routes->get('/visitor/success','VisitorController::success');

// $routes->get('/admin/pending','AdminController::pending');
// $routes->post('/admin/approve','AdminController::approve');

// $routes->get('/security/scanner','SecurityController::scannerView');
// $routes->post('/security/verify','SecurityController::verify');
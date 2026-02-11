<?php
$session = session();
// session check
if (!$session->has('isLoggedIn') || !$session->has('user_id') || !$session->has('username') || !$session->has('role_id')) {
    header("Location: " . base_url('/login'));
    exit;
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>RFC Access360</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <!-- <restrict Google Console Acces > -->
  <meta name="robots" content="noindex,nofollow"> 

  <link rel="icon" type="image/png" href="<?= base_url('public/dist/ramoji-logo-3.png') ?>">
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.5/dist/sweetalert2.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <link rel="stylesheet" href="<?= base_url('public/dist/css/costomstyle.css') ?>">
  <link rel="stylesheet" href="<?= base_url('public/dist/css/tabstylesheet.css') ?>">
  
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">

<style>
 body {
    font-family: 'Nunito', sans-serif !important;
} 
/* h1, h2, h3, h4, .card-title {
    font-family: 'Playfair Display', serif !important;
} */
/* 
body {
    font-family: 'Lato', sans-serif;
}

h1, h2, h3 {
    font-family: 'Playfair Display', serif;
    font-weight: 700;
} */
</style>

  <style>
  .card-header{
      background: #398aaaff;
  }

.sidebar::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: url('<?= base_url("public/dist/sidebarpic.png") ?>');
    background-size: cover;
    background-position: center;
    opacity: 0.8;
    z-index: -1;
}


    /* Sidebar */
    .sidebar {
      position: fixed;
      top: 0;
      left: 0;
      width: var(--sidebar-width);
      height: 100%;
      /* background: linear-gradient(180deg, #4aa8ff,#ff7272); */
      background: rgba(129, 129, 129, 0.65);
      color: #fff;
      transition: all 0.3s ease;
      overflow-y: auto;
      padding: 0px 10px;
      z-index: 1040;
    }
</style>

</head>
<body>

<!-- Sidebar -->
<nav class="sidebar" id="sidebar">
  
  <div class="brand-area">
      <img src="<?= base_url('public/dist/access360logo.png') ?>" alt="Logo">
  </div>

  <ul class="nav flex-column">

      <li>
        <a class="nav-link <?= (uri_string()=='' || uri_string()=='dashboard') ? 'active' : '' ?>" 
          href="<?= base_url('/') ?>">
          <i class="bi bi-house-fill"></i> Home
        </a>
      </li>

      <?php if($_SESSION['role_id'] == '1'){ ?>
      <li><a class="nav-link <?= (uri_string()=='userlist') ? 'active' : '' ?>" 
             href="<?= base_url('userlist') ?>">
             <i class="bi bi-people-fill"></i> User Management
      </a></li>

        <li><a class="nav-link <?= (uri_string()=='masterdata') ? 'active' : '' ?>" 
             href="<?= base_url('masterdata') ?>">
           <i class="bi bi-kanban-fill"></i>  Master Data
      </a></li>
      <?php } ?>

      <?php if(in_array($_SESSION['role_id'], ['1','2','3','5'])){ ?>
      <li><a class="nav-link <?= (uri_string()=='visitorequestlist') ? 'active' : '' ?>" 
             href="<?= base_url('visitorequestlist') ?>">
             <i class="bi bi-person-check-fill"></i> Request Management
      </a></li>
      <?php } ?>

      <?php if($_SESSION['role_id'] == '6'){ ?>
      <li><a class="nav-link <?= (uri_string()=='reference') ? 'active' : '' ?>" 
             href="<?= base_url('reference') ?>">
             <i class="bi bi-journal-text"></i> Reference
      </a></li>

      <li><a class="nav-link <?= (uri_string()=='reference_visitor_request') ? 'active' : '' ?>" 
             href="<?= base_url('reference_visitor_request') ?>">
             <i class="bi bi-journal-check"></i> Reference Visitor Request
      </a></li>
      <?php } ?>

      <?php if(in_array($_SESSION['role_id'], [1,4,5])){ ?>
      <!-- <li><a class="nav-link <?= (uri_string()=='security_authorization') ? 'active' : '' ?>" 
             href="<?= base_url('security_authorization') ?>">
             <i class="bi bi-shield-lock-fill"></i> Security Authorization
      </a></li> -->

       <li><a class="nav-link <?= (uri_string()=='authorized_visitors_list') ? 'active' : '' ?>" 
             href="<?= base_url('authorized_visitors_list') ?>">
             <i class="bi bi-card-checklist"></i> Authorized Visitor List
      </a></li>

      <?php } ?>

      
<?php if (in_array($_SESSION['role_id'], ['1','2','5'])) { ?>
<li class="nav-item">
    <a class="nav-link <?= in_array(uri_string(), [
            'report/daily',
            'report/current',
            'report/history'
        ]) ? 'active' : '' ?>"
       data-bs-toggle="collapse"
       href="#reportMenu"
       role="button"
       aria-expanded="false"
       aria-controls="reportMenu">

        <i class="bi bi-file-earmark-text-fill"></i> Report
        <i class="bi bi-chevron-down float-end"></i>
    </a>

    <ul class="collapse list-unstyled ps-3 <?= in_array(uri_string(), [
            'daily_visitor_report',
            'request_to_checkout',
            'report/history'
        ]) ? 'show' : '' ?>" id="reportMenu">

        <li>
            <a class="nav-link <?= (uri_string()=='daily_visitor_report') ? 'active' : '' ?>"
               href="<?= base_url('daily_visitor_report') ?>">
               <i class="bi bi-calendar-day"></i> Daily Visitor Report
            </a>
        </li>

        <li>
            <a class="nav-link <?= (uri_string()=='request_to_checkout') ? 'active' : '' ?>"
               href="<?= base_url('request_to_checkout') ?>">
               <i class="bi bi-person-check-fill"></i> Request to Checkout Report
            </a>
        </li>

        <li>
            <a class="nav-link <?= (uri_string()=='report/history') ? 'active' : '' ?>"
               href="#">
               <i class="bi bi-clock-history"></i> Visitor History
            </a>
        </li>
    </ul>
</li>
<?php } ?>

    
    <li>
        <a class="nav-link <?= (uri_string()=='feedback') ? 'active' : '' ?>"
            href="<?= base_url('feedback') ?>">
            <i class="fa fa-comments"></i>  Feedback
        </a>
    </li>

    
    <li>
        <a class="nav-link <?= (uri_string()=='about') ? 'active' : '' ?>"
            href="<?= base_url('about') ?>">
            <i class="bi bi-grid-1x2"></i>  About Access360
        </a>
    </li>

     <li>
        <a class="nav-link <?= (uri_string()=='usermanuals') ? 'active' : '' ?>"
            href="<?= base_url('usermanuals') ?>">
            <i class="bi bi-collection-play"></i> User Manuals
        </a>
    </li>

    <li>
        <a class="nav-link <?= (uri_string()=='user/changePass') ? 'active' : '' ?>"
        href="<?= base_url('user/changePass') ?>">
        <i class="bi bi-lock"></i> Change Password
        </a>
    </li>

    <li>
        <a class="nav-link" href="<?= base_url('logout') ?>">
        <i class="bi bi-box-arrow-right"></i> Logout
        </a>
    </li>

  </ul>

</nav>


<!-- Overlay -->
<div class="overlay" id="overlay"></div>

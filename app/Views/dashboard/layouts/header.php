<?php
$session = session();
// session check (keeps your logic)
if (!$session->has('isLoggedIn') || !$session->has('user_id') || !$session->has('username') || !$session->has('role_id')) {
    header("Location: " . base_url('/login'));
    exit;
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Smart VMS Portal — Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css">

  <!-- ApexCharts (optional if you want charts) -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css">

  <!-- SweetAlert -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.5/dist/sweetalert2.min.css">

  <!-- ===== Custom CSS (all in one place) ===== -->
  <style>
    :root{
      --rfc-dark: #001f3f;
      --rfc-blue: #0056b3;
      --rfc-red: #d60000;
      --rfc-light-bg: #f5f7fb;
    }

    html,body {height:100%;}
    body {
      font-family: "Inter", "Segoe UI", Arial, sans-serif;
      background: var(--rfc-light-bg);
      color: #0b2238;
      margin:0;
    }

    /* ---------- Top Navbar ---------- */
    .topbar {
      height:64px;
      background: #ffffff;
      border-bottom: 1px solid #e6ecf5;
      display:flex;
      align-items:center;
      padding:0 18px;
      position:fixed;
      top:0;
      left:0;
      right:0;
      z-index:1050;
    }
    .topbar .brand {
      font-weight:700;
      color: var(--rfc-dark);
      font-size:18px;
      display:flex;
      align-items:center;
      gap:10px;
    }
    .topbar .brand img { height:40px; }

    .topbar .top-actions { margin-left:auto; display:flex; align-items:center; gap:12px; }

    

    /* ---------- Layout wrapper ---------- */
    .layout {
      display:flex;
      width:100%;
      min-height:100vh;
      padding-top:64px; /* account for fixed topbar */
    }

    /* ---------- Sidebar ---------- */
    .sidebar {
      
      border-radius: 0px 25px 25px 0px;
      width:220px;
      background: linear-gradient(180deg, #071531 0%, #0b2a57 100%);
      color:#fff;
      padding:16px 12px;
      position:fixed;
      top:64px;
      left:0;
      bottom:0;
      overflow:auto;
      transition: transform .25s ease;
      z-index:1040;
    }
    .sidebar.closed { transform: translateX(-280px); }
    .sidebar .brand-area {
      text-align:center;
      padding:5px 6px 5px 6px;
      border-bottom:1px solid rgba(255,255,255,0.06);
      margin-bottom:8px;
    }
    .sidebar .brand-area img { max-width:140px; display:inline-block; }

    .sidebar .nav .nav-link {
      color: rgba(255,255,255,0.92);
      padding:5px;
      border-radius:8px;
      margin:4px 4px;
      display:flex;
      align-items:center;
      gap:8px;
      font-weight:600;
      font-size: 14px;
    }
    .sidebar .nav .nav-link i { color: #ffd94d; } /* icon accent */
    .sidebar .nav .nav-link:hover { background: rgba(247, 127, 127, 0.04); color:#fff; text-decoration:none; }
    .sidebar .nav .nav-link.active { background: var(--rfc-blue); color:#fff; }

    /* ---------- Content area ---------- */
    .content {
      margin-left: 210px;
      padding: 25px;
      width:100%;
      transition: margin-left .25s ease;
    }
    .content.expanded { margin-left:0; }

    /* Responsive: collapse sidebar */
    @media (max-width: 991px) {
      .sidebar { transform: translateX(-280px); position:fixed; }
      .sidebar.open { transform: translateX(0); }
      .content { margin-left:0; }
      .overlay { display:block; position:fixed; inset:0; background: rgba(0,0,0,0.35); z-index:1035; }
    }
    .overlay { display:none; }

    /* ---------- Dashboard Cards ---------- */
    .dash-header h2 { color: var(--rfc-dark); font-weight:700; }
    .dash-row { display:grid; gap:18px; margin-bottom:22px; }

    .row-small { grid-template-columns: repeat(6, 1fr); }
    .row-medium { grid-template-columns: repeat(4, 1fr); }
    .row-large { grid-template-columns: 2fr 1fr; }

    @media (max-width:1200px){ .row-small { grid-template-columns: repeat(3, 1fr); } }
    @media (max-width:768px){ .row-small { grid-template-columns: repeat(2, 1fr); } .row-medium { grid-template-columns: repeat(2, 1fr);} .row-large { grid-template-columns:1fr; } }

    .card-dash {
      background:white;
      border-radius:10px;
      padding:18px;
      box-shadow: 0 6px 20px rgba(3,16,46,0.06);
      border-left: 6px solid var(--rfc-blue);
      display:flex;
      flex-direction:column;
      justify-content:space-between;
      min-height:110px;
    }
    .card-dash .title { font-weight:700; color:var(--rfc-dark); font-size:14px; }
    .card-dash .value { font-size:22px; color:var(--rfc-red); font-weight:800; margin-top:8px; }

    .card-medium { min-height:140px; }
    .card-large { min-height:300px; padding:22px; }

    .pending-list { list-style:none; padding:0; margin:0; }
    .pending-list li { padding:12px 10px; border-radius:8px; margin-bottom:8px; background:#fbfbfd; border:1px solid #eef3fb; display:flex; justify-content:space-between; align-items:center; }
    .quick-links a { display:block; padding:10px 8px; color:var(--rfc-dark); border-radius:8px; margin-bottom:8px; background:#fff; border:1px solid #f0f4fb; text-decoration:none; }

    /* footer */
    .app-footer { font-size : 14px; padding:14px 22px; text-align:center; background:#fff; border-top:1px solid #e8eef8; color:#333; margin-top:20px; }

    /* small helper */
    .muted { color:#677a8a; font-size:13px; }
    .badge-pending { background:#ffefc6; color:#6a4b00; padding:6px 8px; border-radius:6px; font-weight:700; }
    .badge-approved { background:#d9f6e2; color:#08723b; padding:6px 8px; border-radius:6px; font-weight:700; }

  </style>
</head>
<body>

  <!-- === Topbar === -->
  <header class="topbar">
    <div class="brand">
       <!-- toggle sidebar -->
      <button class="btn btn-outline-secondary d-md-none" id="mobileSidebarToggle" aria-label="Toggle sidebar">
        <i class="bi bi-list"></i>
      </button>

      <!-- desktop toggle (collapse) -->
      <button class="btn btn-outline-secondary d-none d-md-inline" id="sidebarCollapse" title="Toggle sidebar">
        <i class="bi bi-list"></i>
      </button>

      <!-- small logo left (change src if you have a logo file) -->
      <!-- <img src="https://www.nicepng.com/png/detail/37-376583_ramoji-film-city-hyderabad-logo.png" alt="logo"> -->
      <span>Smart VMS Portal</span>
    </div>

    <div class="top-actions">
     
      <!-- search icon -->
      <button class="btn btn-outline-secondary" id="searchBtn" title="Search"><i class="bi bi-search"></i></button>

      <!-- fullscreen -->
      <button class="btn btn-outline-secondary" id="fullScreenBtn" title="Fullscreen"><i class="bi bi-arrows-fullscreen"></i></button>

      <!-- user dropdown -->
      <div class="dropdown">
        <a class="btn btn-light dropdown-toggle" href="#" role="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="bi bi-person-circle"></i> <?= esc($_SESSION['username']) ?>
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
          <li><a class="dropdown-item" href="<?= base_url('profile') ?>">Profile</a></li>
          <li><a class="dropdown-item" href="<?= base_url('change-password') ?>">Change Password</a></li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item text-danger" href="<?= base_url('logout') ?>">Sign Out</a></li>
        </ul>
      </div>
    </div>
  </header>

  <div class="layout">
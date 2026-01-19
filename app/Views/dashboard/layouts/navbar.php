<!-- Topbar -->
<header class="topbar" id="topbar">
  <button class="btn btn-outline-secondary d-md-none me-2" id="mobileSidebarToggle"><i class="bi bi-list"></i></button>
  <button class="btn btn-outline-secondary d-none d-md-inline me-3" id="sidebarCollapse"><i class="bi bi-list"></i></button>
  <!-- <div class="brand">Visitor Management System <div class="brand-subtitle">Manage Every Visitor Digitally and Securely</div> </div> -->
 <div class="brand nav-logo">
    <img src="<?= base_url('public/dist/access360logo.png') ?>" 
         alt="Visitor Management System"
         class="brand-logo">
</div>
  
  <div class="top-actions">
    <button class="btn btn-outline-secondary" id="fullScreenBtn" title="Fullscreen"><i class="bi bi-arrows-fullscreen"></i></button>
    <div class="dropdown">
    <a class="btn btn-light dropdown-toggle profile-btn" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-person-circle"></i><span id="navebarUserName"> <?= session()->get('name'); ?></span>
    </a>

    <ul class="dropdown-menu dropdown-menu-end profile-dropdown">

    <!-- Profile Header -->
    <li class="profile-box">
        <div class="profile-icon">
            <i class="bi bi-person-fill"></i>
        </div>
        <div class="profile-info">
            <h6 class="mb-0"><?= session()->get('name'); ?></h6>
            <small class="text-muted"><?= session()->get('role_name'); ?></small>
        </div>
    </li>

    <li><hr class="dropdown-divider"></li>

    <!-- Employee Code -->
    <li class="px-3 py-2 d-flex align-items-center profile-item">
        <i class="bi bi-hash profile-item-icon"></i>
        <span><?= session()->get('employee_code'); ?></span>
    </li>

    <!-- Username -->
    <li class="px-3 py-2 d-flex align-items-center profile-item">
        <i class="bi bi-building profile-item-icon"></i>
        <span> <?= session()->get('company_name'); ?> - <?= session()->get('department_name'); ?></span>
    </li>

    <!-- Role -->
    <li class="px-3 py-2 d-flex align-items-center profile-item">
        <i class="bi bi-person-badge profile-item-icon"></i>
        <span><?= session()->get('role_name'); ?></span>
    </li>

    <!-- Email -->
    <li class="px-3 py-2 d-flex align-items-center profile-item">
        <i class="bi bi-envelope profile-item-icon"></i>
        <span><?= session()->get('email'); ?></span>
    </li>

    <li><hr class="dropdown-divider"></li>

    <!-- Logout Button -->
    <li class="logout-box">
        <a class="btn btn-danger w-100" href="<?= base_url('/logout'); ?>">
            <i class="bi bi-box-arrow-right"></i> Logout
        </a>
    </li>

</ul>

        </div>

  </div>
</header>

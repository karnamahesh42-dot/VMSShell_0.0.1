<?= $this->include('/dashboard/layouts/sidebar') ?>
<?= $this->include('/dashboard/layouts/navbar') ?>


<main class="main-content" id="mainContent">
   <div class="container-fluid">

          <!-- Edit User Modal -->

            <!-- Edit User Modal -->

                <div class="row d-flex justify-content-center">
                    <div class="col-md-12">
                        <div class="card visitor-list-card">
                            <div class="card-header d-flex justify-content-between align-items-center card-header-actions">
                                <h5 class="mb-0">Daily Visitor Report</h5>
                            </div>

                            <div class="card-body table-responsive">

                            <form method="get" class="row g-3 mb-3 align-items-end">

                                <!-- From Date -->
                                <div class="col-md-2">
                                    <label class="form-label fw-bold">From Date</label>
                                    <input type="date" name="from_date" class="form-control"
                                    value="<?= esc($fromDate) ?>">
                                </div>

                                <!-- To Date -->
                                <div class="col-md-2">
                                    <label class="form-label fw-bold">To Date</label>
                                                                    
                                    <input type="date" name="to_date" class="form-control"
                                        value="<?= esc($toDate) ?>">
                                </div>

                                <!-- Company (Static Dropdown) -->
                                <div class="col-md-2">
                                    <label class="form-label fw-bold">Company</label>
                                    <?php if(in_array($_SESSION['role_id'], [1,5]) ){?>

                                    <select name="company" class="form-select">
                                        <option value="">All Companies</option>
                                            <?php foreach ($companies as $comp): ?>
                                                <option value="<?= $comp['company_name'] ?>" <?= (($_GET['company'] ?? '') == $comp['company_name']) ? 'selected' : '' ?>>
                                                    <?= esc($comp['company_name']) ?></option>
                                            <?php endforeach; ?>
                                    </select>
                                    <?php }else{ ?>
                                            
                                      <input type="text" name="company" class="form-control" value="<?php echo $_SESSION['company_name']?>">

                                    <?php } ?>
                                </div>


                                <!-- Department (Dynamic Dropdown) -->
                                <div class="col-md-2">
                                    <label class="form-label fw-bold">Department</label>
                                    <?php if(in_array($_SESSION['role_id'], [1,5]) ){?>
                                        <select name="department" class="form-select">
                                            <option value="">All Departments</option>
                                            <?php foreach ($departments as $dept): ?>
                                                <option value="<?= esc($dept['department_name']) ?>"
                                                    <?= (@$_GET['department'] == $dept['department_name']) ? 'selected' : '' ?>>
                                                    <?= esc($dept['department_name']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                      <?php }else{ ?>
                                            
                                      <input type="text" name="department" class="form-control" value="<?php echo $_SESSION['department_name']?>">

                                    <?php } ?>
                                </div>

                                <!-- V-Code -->
                                <div class="col-md-2">
                                    <label class="form-label fw-bold">V-Code</label>
                                    <input type="text" name="v_code" class="form-control"
                                        placeholder="V000001"
                                        value="<?= esc($_GET['v_code'] ?? '') ?>">
                                </div>
                                <!-- Filter -->
                                <div class="col-md-1">
                                    <label class="form-label invisible">Filter</label>
                                    <button type="submit" class="btn btn-primary w-100" title="Filter">
                                        <i class="fas fa-filter"></i>
                                    </button>
                                </div>

                                <!-- Reload -->
                                <div class="col-md-1">
                                    <label class="form-label invisible">Reload</label>
                                    <a href="<?= base_url('/daily_visitor_report') ?>" class="btn btn-secondary w-100" title="Reload">
                                        <i class="fas fa-rotate-right"></i>
                                    </a>
                                </div>
                            </form>
                                
                            <div class='table-scroll'>

                                <table class="table table-bordered table-hover">
                                   <thead>
                                    <tr>
                                        <th>Request ID</th>
                                        <th>V-Code</th>
                                        <th>Visitor</th>
                                        <th>Phone</th>
                                        <th>Purpose</th>
                                        <th>Company</th>
                                        <th>Department</th>
                                        <th>Visit Date</th>
                                        <th>Referred By</th>
                                        <th>Check-In</th>
                                        <th>Check-Out</th>
                                        <th>Time Spent</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                        <?php foreach ($report as $row): ?>

                                        <?php
                                            // ------------------------------
                                            // VALIDITY TYPE LOGIC (SD / MD)
                                            // ------------------------------
                                            $validityType = $row['validity_type'] ?? 'SD';

                                            if ($validityType === 'MD') {

                                                $checkIn  = $row['md_check_in']  ?? null;
                                                $checkOut = $row['md_check_out'] ?? null;

                                                $validFrom = $row['valid_from'] ?? '-';
                                                $validTo   = $row['valid_to']   ?? '-';

                                                $visitDateDisplay = $validFrom . ' to ' . $validTo;

                                            } else {

                                                $checkIn  = $row['sd_check_in']  ?? null;
                                                $checkOut = $row['sd_check_out'] ?? null;

                                                $visitDateDisplay = $row['visit_date'] ?? '-';
                                            }

                                            // ------------------------------
                                            // STATUS LOGIC
                                            // ------------------------------
                                            if (empty($checkIn)) {
                                                $statusText = "Not Entered";
                                                $badgeClass = "bg-secondary";
                                            } elseif (!empty($checkIn) && empty($checkOut)) {
                                                $statusText = "Inside";
                                                $badgeClass = "bg-primary";
                                            } else {
                                                $statusText = "Exit";
                                                $badgeClass = "bg-success";
                                            }
                                        ?>

                                        <tr>
                                            <td><?= esc($row['group_code'] ?? '-') ?></td>
                                            <td><?= esc($row['v_code'] ?? '-') ?></td>
                                            <td><?= esc($row['visitor_name'] ?? '-') ?></td>
                                            <td><?= esc($row['visitor_phone'] ?? '-') ?></td>
                                            <td><?= esc($row['purpose'] ?? '-') ?></td>
                                            <td><?= esc($row['company'] ?? '-') ?></td>
                                            <td><?= esc($row['department'] ?? '-') ?></td>

                                            <!-- Visit Date -->
                                            <td><?= esc($visitDateDisplay) ?></td>

                                            <td><?= esc($row['referred_by'] ?? '-') ?></td>

                                            <!-- Check In -->
                                            <td><?= esc($checkIn ?? '-') ?></td>

                                            <!-- Check Out -->
                                            <td><?= esc($checkOut ?? '-') ?></td>

                                            <td><?= esc($row['spendTime'] ?? '-') ?></td>

                                            <!-- Status -->
                                            <td>
                                                <span class="badge <?= $badgeClass ?>">
                                                    <?= $statusText ?>
                                                </span>
                                            </td>
                                        </tr>

                                        <?php endforeach; ?>
                                        </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
           </div>
</main>




<?= $this->include('/dashboard/layouts/footer') ?>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const urlParams = new URLSearchParams(window.location.search);

    // Submit only if no filters exist
    if (!urlParams.has('from_date') && !urlParams.has('to_date')) {
        document.querySelector("form").submit();
    }

});

</script>


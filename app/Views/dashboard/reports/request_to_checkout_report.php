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
                                <h5 class="mb-0"> Request to Checkout Report </h5>
                            </div>

                            <div class="card-body table-responsive" >

                                <form method="get" class="row g-2 mb-3">
                                    <div class="col-md-2">
                                    <label>Company</label>
                                     <!-- <select name="company" class="form-control" required>
                                            <option value=""> -- Select Company --</option>
                                            <option value="UKMPL">UKMPL</option>
                                            <option value="DHPL">DHPL</option>
                                            <option value="ETPL">ETPL</option>
                                        </select> -->

                                         <select name="company" class="form-control" required>
                                            <option value="">Select Department</option>
                                            <?php foreach ($companies as $comp): ?>
                                                <option value="<?= $comp['company_name'] ?>"><?= esc($comp['company_name']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <label>Department</label>
                                        <select name="department" class="form-control">
                                               <option value="">-- Select Department --</option>
                                            <?php foreach ($departments as $dept): ?>
                                                <option value="<?= esc($dept['department_name']) ?>"
                                                    <?= (($_GET['department'] ?? '') == $dept['department_name']) ? 'selected' : '' ?>>
                                                    <?= esc($dept['department_name']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <label>Request Id </label>
                                        <input type="text" name="group_code" class="form-control"
                                            value="<?= esc($_GET['group_code'] ?? '') ?>" placeholder="Enter Req ID Ex : 'GV0000XX'">
                                    </div>

                                    <div class="col-md-2">
                                        <label>Purpose</label>
                                        <select name="purpose" class="form-control">
                                            <option value="">-- Select Purpose --</option>
                                            <?php foreach ($purposes as $p): ?>
                                                <option value="<?= esc($p['purpose_name']) ?>"
                                                    <?= (old('purpose') == $p['purpose_name']) ? 'selected' : '' ?>>
                                                    <?= esc($p['purpose_name']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>


                                    <div class="col-md-2">
                                       <label>Request Status</label>  
                                        <select name="status" class="form-control">
                                            <option value="">--Select Request Status --</option>
                                            <option value="pending">Pending</option>
                                            <option value="approved">Approved</option>
                                            <option value="rejected">Rejected</option>
                                        </select>
                                    </div>



                                    <div class="col-md-2">
                                         <label>Meeting Status</label>
                                        <select name="meeting_status" class="form-control">
                                            <option value="">-- Select Meeting Status --</option>
                                            <option value="1">Completed</option>
                                            <option value="0">Pending</option>
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <label> Visit Date From</label>
                                        <input type="date" name="from_date" class="form-control"
                                            value="<?= esc($_GET['from_date'] ?? '') ?>">
                                    </div>

                                    <div class="col-md-2">
                                        <label>Visit Date To</label>
                                        <input type="date" name="to_date" class="form-control"
                                            value="<?= esc($_GET['to_date'] ?? '') ?>">
                                    </div>

                                <div class="col-md-2 text-end">
                                    <label>Actions</label><br>

                                    <!-- Filter -->
                                    <button class="btn btn-primary btn-sm" title="Filter">
                                        <i class="bi bi-funnel-fill"></i>
                                    </button>

                                    <!-- Export -->
                                    <button class="btn btn-success btn-sm"
                                            title="Export"
                                            onclick="exportTableById('checkoutTable')">
                                        <i class="bi bi-download"></i>
                                    </button>

                                    <!-- Reset -->
                                    <a href="<?= base_url('request_to_checkout') ?>"
                                    class="btn btn-secondary btn-sm"
                                    title="Reset">
                                        <i class="bi bi-arrow-clockwise"></i>
                                    </a>
                                </div>

                                </form>
                                  <div class="table-scroll">              
                                   <table class="table table-bordered table-hover table-sm" id="checkoutTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th>S.no</th>
                                            <th>Request ID</th>
                                            <th>Visitor Code</th>
                                            <th>Company</th>
                                            <th>Department</th>
                                            <th>Visitor Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Purpose</th>
                                            <th>Description</th>
                                            <th>Visit Date</th>
                                            <th>Visit Time</th>
                                            <th>Total Visitors</th>
                                            <th>Referred By</th>
                                            <th>Request Created By</th>
                                            <th>Vehicle No</th>
                                            <th>Vehicle Type</th>
                                            <th>Proof Type</th>
                                            <th>Proof Number</th>
                                            <th>Request Status</th> 
                                            <th>Meeting Status</th>
                                            <th>Meeting Completed At</th>      
                                            <th>Check-In By</th>
                                            <th>Check In At</th>
                                            <th>Check-Out By</th>
                                            <th>Check Out At</th>
                                            <th>Time Spent</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i = 1; foreach ($report as $row): ?>
                                    <tr>
                                        <td><?= $i ?></td>     
                                        <td><?= esc($row['group_code']) ?></td>
                                        <td><?= esc($row['v_code']) ?></td>
                                        <td><?= esc($row['company']) ?></td>
                                        <td><?= esc($row['department']) ?></td>
                                        <td><?= esc($row['visitor_name']) ?></td>
                                        <td><?= esc($row['visitor_email']) ?></td>
                                        <td><?= esc($row['visitor_phone']) ?></td>
                                        <td><?= esc($row['purpose']) ?></td>
                                        <td><?= esc($row['description']) ?></td>
                                        <td><?= esc($row['visit_date']) ?></td>
                                        <td><?= esc($row['visit_time']) ?></td>
                                        <td><?= esc($row['total_visitors']) ?></td>
                                        <td><?= esc($row['referred_by'] ?? '-') ?></td>
                                        <td><?= esc($row['rqst_created_by'] ?? '-') ?></td>
                                        <td><?= esc($row['vehicle_no']) ?></td>
                                        <td><?= esc($row['vehicle_type']) ?></td>
                                        <td><?= esc($row['proof_id_type']) ?></td>
                                        <td><?= esc($row['proof_id_number']) ?></td>
                                        <td><?= esc($row['status']) ?></td>
                                        <td><?= $row['meeting_status'] ? 'Completed' : 'Pending' ?></td>
                                        <td><?= esc($row['meeting_completed_at'] ?? '-') ?></td>
                                        <td><?= esc($row['s_checkin_by'] ?? '-') ?></td>
                                        <td><?= esc($row['created_at']) ?></td>
                                        <td><?= esc($row['s_checkout_by'] ?? '-') ?> </td>
                                        <td><?= esc($row['updated_at']) ?></td>
                                        <td><?= esc($row['spendTime'] ?? '-') ?></td>
                                    </tr>
                                    <?php $i++; endforeach; ?>
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
function exportTableById(tableId) {

    const table = document.getElementById(tableId);

    if (!table) {
        alert("Table not found!");
        return;
    }

    const rows = table.querySelectorAll("tr");

    if (rows.length <= 1) {
        alert("No data available to export!");
        return;
    }

    let csv = [];

    rows.forEach(row => {
        const cols = row.querySelectorAll("th, td");
        let rowData = [];

        cols.forEach(col => {
            let text = col.innerText
                .replace(/\n/g, " ")
                .replace(/"/g, '""')
                .trim();

            rowData.push(`"${text}"`);
        });

        csv.push(rowData.join(","));
    });

    const csvContent = csv.join("\n");
    const blob = new Blob([csvContent], { type: "text/csv;charset=utf-8;" });

    const link = document.createElement("a");
    link.href = URL.createObjectURL(blob);
    link.download = "checkout_report.csv";

    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}
</script>

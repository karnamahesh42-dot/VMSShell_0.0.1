<?= $this->include('/dashboard/layouts/sidebar') ?>
<?= $this->include('/dashboard/layouts/navbar') ?>


<main class="main-content" id="mainContent">
   <div class="container-fluid">

                        <!-- Edit User Modal -->
                <div class="modal fade" id="editUserModal">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content shadow-lg border-0">

                            <!-- Header -->
                            <div class="card-header text-white py-3">
                                <h5 class="fw-semibold">
                                    <i class="fas fa-user-edit me-2"></i>Edit User Details
                                </h5>
                            
                            </div>

                            <form id="editUserForm">
                                <?= csrf_field() ?>

                                <div class="modal-body">

                                <div class="row">

                                    <input type="hidden" id="edit_id" name="id">

                                    <!-- Company -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-medium">Company</label>
                                        <input type="text" id="edit_company" name="company_name"
                                            class="form-control p-2" readonly>
                                    </div>

                                    <!-- Department -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-medium">Department</label>
                                        <select id="edit_department" name="department_id"
                                                class="form-control p-2">
                                            <?php foreach ($departments as $dept): ?>
                                                <option value="<?= $dept['id'] ?>"><?= $dept['department_name'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                    <!-- Row 1 -->
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-medium">Name</label>
                                            <input type="text" id="name" name="name" class="form-control p-2">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-medium">Email</label>
                                            <input type="email" id="edit_email" name="email" class="form-control p-2">
                                        </div>
                                    </div>

                                    <!-- Row 2 -->
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-medium">Priority</label>
                                            <input type="number" id="priority" name="priority" class="form-control p-2">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-medium">Employee Code</label>
                                            <input type="text" id="edit_empcode" name="employee_code" class="form-control p-2">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-medium">Username</label>
                                            <input type="text" id="edit_usename" name="edit_usename" class="form-control p-2" readonly>
                                        </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-medium">Password</label>

                                        <div class="input-group">
                                            <input type="password"
                                                    id="edit_password"
                                                    name="new_password"
                                                    class="form-control p-2"
                                                    required>

                                            <span class="input-group-text" style="cursor:pointer"
                                                    onclick="togglePassword()">
                                                <i id="toggleEye" class="fa fa-eye"></i>
                                            </span>
                                        </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Footer -->
                                <div class="modal-footer d-flex justify-content-end">
                                    <button type="submit" class="btn btn-success px-4">
                                        <i class="fas fa-save me-1"></i> Update
                                    </button>
                                    <button type="button" class="btn btn-danger px-4" data-bs-dismiss="modal">
                                        Close
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
                <!-- Edit User Modal -->

                    <div class="row d-flex justify-content-center">
                        <div class="col-md-12">
                            <div class="card visitor-list-card">
                                <div class="card-header d-flex justify-content-between align-items-center card-header-actions">
                                    <h5 class="mb-0">User Management</h5>

                                    <a href="<?= base_url('user') ?>" class="btn btn-warning">
                                        <i class="bi bi-person-plus-fill"></i> New User
                                    </a>
                                </div>

                                <div class="card-body table-responsive">

                            <!-- Filters Section -->
                            <form method="GET" class="mb-3" id="filterform">
                                <div class="row">

                                <!-- Company Filter -->
                                <div class="col-md-2 mb-2">
                                    <!-- <select name="company" class="form-control" onchange="this.form.submit()">
                                        <option value="">All Companies</option>
                                        <option value="UKMPL" <?= (isset($_GET['company']) && $_GET['company']=="UKMPL")?'selected':'' ?>>UKMPL</option>
                                        <option value="DHPL" <?= (isset($_GET['company']) && $_GET['company']=="DHPL")?'selected':'' ?>>DHPL</option>
                                        <option value="ETPL" <?= (isset($_GET['company']) && $_GET['company']=="ETPL")?'selected':'' ?>>ETPL</option>
                                    </select> -->


                                <select name="company" id='companyfilter' class="form-control select2" >
                                        <option value="">All Companies</option>
                                        <?php if(isset($_GET['company_name'])){
                                            echo $_GET['company_name'];
                                        } foreach ($companies as $comp): ?>
                                                <option value="<?= $comp['company_name'] ?>" 
                                                    <?= (isset($_GET['company']) && $_GET['company']==$comp['company_name'])?'selected':'' ?>>
                                                    <?= $comp['company_name'] ?>
                                                </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <!-- Department Filter -->
                                <div class="col-md-2 mb-2">
                                    <select name="department" id='departmentfilter' class="form-control select2" >
                                        <option value="">All Departments</option>
                                        <?php foreach ($departments as $dept): ?>
                                            <option value="<?= $dept['id'] ?>" 
                                                <?= (isset($_GET['department']) && $_GET['department']==$dept['id'])?'selected':'' ?>>
                                                <?= $dept['department_name'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <!-- Role Filter -->
                                <div class="col-md-2 mb-2">
                                    <select name="role" class="form-control" onchange="this.form.submit()">
                                        <option value="">All Roles</option>

                                        <?php foreach ($roles as $role): ?>
                                            <option value="<?= $role['id'] ?>"
                                                <?= (isset($_GET['role']) && $_GET['role']==$role['id'])?'selected':'' ?>>
                                                <?= $role['role_name'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>


                                
                                <!-- Role Filter -->
                                <div class="col-md-2 mb-2">
                                    <select name="username" id="usernamefilter" class="form-control select2">
                                        <option value="">All Usernames</option>

                                        <?php foreach ($users as $user): ?>
                                            <option value="<?= $user['username'] ?>"
                                                <?= (isset($_GET['username']) && $_GET['username']==$user['username'])?'selected':'' ?>>
                                                <?= $user['username']?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                       
                                    <div class="col-md-4 mb-2">
                                            <!-- Reset Button -->
                                        <a href="<?= base_url('userlist') ?>" class="btn btn-secondary ">
                                            <i class="fa fa-rotate-left me-1"></i> 
                                        </a>

                                          <!-- Download Button -->
                                        <a href="<?= base_url('user/download-template') ?>" 
                                        class="btn btn-success" title = 'Download Users Template'>
                                        <i class="fa fa-download" ></i>
                                        </a>

                                        <!-- Import Button  -->                                      
                                        <a href="javascript:void(0)"
                                        class="btn btn-primary"
                                        title="Import Users Template"
                                        onclick="document.getElementById('userImportFile').click()">
                                            <i class="fa fa-upload"></i>
                                        </a>
                                        <input type="file"
                                            id="userImportFile"
                                            hidden
                                            accept=".csv"
                                            onchange="uploadUsers(this.files[0])">

                                        <a href="<?= base_url('user/export') ?>" 
                                                class="btn btn-info"
                                                title="Export Users"  title="Export Users">
                                             <i class="fa fa-file-export"></i>
                                        </a>

                                    </div>
                            </div>
                        </form>

                                <table class="table table-bordered table-hover" id="userTable">
                                     <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Company</th>
                                            <th>Department</th>
                                            <th>Name</th>
                                            <th>Username</th>
                                            <th>Role</th>
                                            <th>Priority</th>
                                            <th>Recent Login At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php if (!empty($users)): ?>
                                            <?php $i = 1; foreach ($users as $user): ?>
                                                <tr>
                                                    <td><?= $i++ ?></td>
                                                    
                                                    <td><?= $user['company_name'] ?></td>
                                                    <td><?= $user['department_name'] ?></td>
                                                    <td><?= $user['name'] ?></td>
                                                    <td><?= $user['username'] ?></td>
                                                    <td><?= $user['role_name'] ?></td>
                                                    <td><?= $user['priority'] ?></td>
                                                    <td><?= !empty($user['last_login_at']) ? $user['last_login_at'] : "<span class='text-danger'>Not Logged In </span>" ?></td>
                                                    <td>

                                                    <!-- Edit -->
                                                    <button class="btn btn-sm btn-primary editUserBtn" data-id="<?= $user['id'] ?>">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button>

                                                    <!-- Toggle Active/Inactive -->
                                                    <button class="btn btn-sm toggleStatusBtn 
                                                        <?= ($user['active']==1?'btn-warning':'btn-success') ?>"
                                                        data-id="<?= $user['id'] ?>"
                                                        data-active="<?= $user['active'] ?>">
                                                        
                                                        <?php if ($user['active']==1): ?>
                                                            <i class="bi bi-x-circle"></i>
                                                        <?php else: ?>
                                                            <i class="bi bi-check-circle"></i>
                                                        <?php endif; ?>
                                                    </button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                            <?php endif; ?>
                                        </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

   </div>
</main>




<?= $this->include('/dashboard/layouts/footer') ?>

<script>

// Load User Data into Modal
$(document).on("click", ".editUserBtn", function () {
    let userId = $(this).data("id");

    $.ajax({
        url: "<?= base_url('user/get/') ?>" + userId,
        type: "GET",
        dataType: "json",
        success: function(res) {

            $("#edit_id").val(res.id);
            $("#edit_company").val(res.company_name);
            $("#edit_department").val(res.department_id);
            $("#edit_email").val(res.email);
            $("#edit_empcode").val(res.employee_code);
            $("#name").val(res.name);
            $("#priority").val(res.priority);
            $("#edit_usename").val(res.username);
            $("#edit_password").val(res.password_enc ?? '' );
            $("#editUserModal").modal("show");

            
        }
    });
});


// Submit Edit Form
$("#editUserForm").on("submit", function(e){
    e.preventDefault();

    $.ajax({
        url: "<?= base_url('user/update') ?>",
        type: "POST",
        data: $(this).serialize(),
        dataType: "json",
        success: function(res){

            if (res.status === "success") {
                Swal.fire({
                    icon: "success",
                    title: "Updated Successfully",
                    timer: 1500,
                    showConfirmButton: false
                });

                setTimeout(() => location.reload(), 1500);

            } else {
                Swal.fire("Error", res.message, "error");
            }
        }
    });
});


$(".toggleStatusBtn").on("click", function () {

    let btn = $(this);
    let userId = btn.data("id");

    $.ajax({
        url: "<?= base_url('user/toggleStatus') ?>",
        type: "POST",
        data: {
            id: userId,
            <?= csrf_token() ?>: "<?= csrf_hash() ?>"
        },
        dataType: "json",
        success: function(res){

            // Show popup
            Swal.fire({
                icon: "success",
                title: res.message,
                timer: 1000,
                showConfirmButton: false
            });

            // Change icon & button color instantly
            if (btn.data("active") == 1) {
                // Was Active → Make Inactive
                btn.removeClass("btn-warning").addClass("btn-success");
                btn.html('<i class="bi bi-check-circle"></i>');
                btn.data("active", 0);

            } else {
                // Was Inactive → Make Active
                btn.removeClass("btn-success").addClass("btn-warning");
                btn.html('<i class="bi bi-x-circle"></i>');
                btn.data("active", 1);
            }
        }
    });
});

function togglePassword() {
    const passwordInput = document.getElementById("edit_password");
    const eyeIcon = document.getElementById("toggleEye");

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        eyeIcon.classList.remove("fa-eye");
        eyeIcon.classList.add("fa-eye-slash");
    } else {
        passwordInput.type = "password";
        eyeIcon.classList.remove("fa-eye-slash");
        eyeIcon.classList.add("fa-eye");
    }
}


$(document).ready(function () {

    $('.select2').select2({
        width: '100%',
        allowClear: false
    });

    $('#companyfilter, #departmentfilter, #usernamefilter').on('change', function () {
        $('#filterform').submit();
    });

});

function uploadUsers(file) {

    if (!file) return;

    let fd = new FormData();
    fd.append("file", file);

    fetch("<?= base_url('user/import') ?>", {
        method: "POST",
        body: fd,
        headers:{
             "X-Requested-With": "XMLHttpRequest"
        }
    })
    .then(res => res.json())
    .then(res => {
        alert(res.message);
        // location.reload(); // optional refresh
    })
    .catch(() => alert("Import failed"));
}

</script>


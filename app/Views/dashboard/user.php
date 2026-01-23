  <?= $this->include('/dashboard/layouts/sidebar') ?>
  <?= $this->include('/dashboard/layouts/navbar') ?>
     
   <main class="main-content" id="mainContent">
        <div class="container-fluid">

             <div class="row d-flex justify-content-center" >
              <!-- /.col-md-6 -->
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h5>New User</h5>
                        </div>

                        <form class="form-horizontal" method="post" id="createUserForm">
                            <div class="card-body">

                                <!-- Company Name -->
                                <div class="form-group row mb-1">
                                    <label class="col-sm-4 col-form-label">Company</label>
                                    <div class="col-sm-8">
                                          <select name="company_name" class="form-control" required>
                                            <option value="">Select Department</option>
                                            <?php foreach ($companies as $comp): ?>
                                                <option value="<?= $comp['company_name'] ?>"><?= esc($comp['company_name']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>


                                <!-- Department -->
                                <div class="form-group row mb-1">
                                    <label class="col-sm-4 col-form-label">Department</label>
                                    <div class="col-sm-8">
                                        <select name="department_id" class="form-control" required>
                                            <option value="">Select Department</option>
                                            <?php foreach ($departments as $dept): ?>
                                                <option value="<?= $dept['id'] ?>"><?= esc($dept['department_name']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- Name -->
                                <div class="form-group row mb-1">
                                    <label class="col-sm-4 col-form-label">Name</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="name" class="form-control" placeholder="Enter Name" required>
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="form-group row mb-1">
                                    <label class="col-sm-4 col-form-label">Email</label>
                                    <div class="col-sm-8">
                                        <input type="email" name="email" class="form-control" placeholder="Enter Email" required>
                                    </div>
                                </div>

                                <!-- Employee Code -->
                                <div class="form-group row mb-1">
                                    <label class="col-sm-4 col-form-label">Employee Code</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="employee_code" class="form-control" placeholder="Enter Employee Code" required>
                                    </div>
                                </div>

                                <!-- Username -->
                                <div class="form-group row mb-1">
                                    <label class="col-sm-4 col-form-label">Username</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="username" class="form-control" placeholder="Enter Username" required>
                                    </div>
                                </div>

                                <!-- Password -->
                                <div class="form-group row mb-1">
                                    <label class="col-sm-4 col-form-label">Password</label>
                                    <div class="col-sm-8">
                                        <input type="password" name="password" class="form-control" placeholder="Enter Password" required>
                                    </div>
                                </div>

                                <div class="form-group row mb-1">
                                    <label class="col-sm-4 col-form-label">Priority</label>
                                    <div class="col-sm-8">
                                        <input type="number" name="priority" value="10" class="form-control" placeholder="Enter Password" required>
                                    </div>
                                </div>

                                <!-- Role -->
                                <div class="form-group row mb-1">
                                    <label class="col-sm-4 col-form-label">Role</label>
                                    <div class="col-sm-8">
                                        <select name="role_id" class="form-control" required>
                                            <option value="">Select Role</option>
                                            <option value="2">Admin</option>
                                            <option value="3">User</option>
                                            <option value="4">Security</option>
                                            <option value="5">Super User</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Save User</button>
                                <a href="<?= base_url('userlist')?>" class="btn btn-danger float-right">Back</a>
                            </div>
                        </form>

                    </div>
                </div>
              <!-- /.col-md-6 -->
            </div>

        </div>
    </main>
  
     
  <?= $this->include('/dashboard/layouts/footer') ?>

  <script>
        $("#createUserForm").on("submit", function(e) {
            e.preventDefault();

            $.ajax({
                url: "<?= base_url('user/create') ?>",
                type: "POST",
                data: $(this).serialize(),
                dataType: "json",

                success: function(res){
                    if (res.status === "success") {
                        Swal.fire({
                            icon: "success",
                            title: "User Created!",
                            text: res.message,
                            timer: 1500,
                            showConfirmButton: false
                        });

                        setTimeout(() => {
                            window.location.href = "<?= base_url('userlist') ?>";
                        }, 1500);

                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: res.message
                        });
                    }
                }
            });
        });
  </script>
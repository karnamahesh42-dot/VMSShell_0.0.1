  <?= $this->include('/dashboard/layouts/sidebar') ?>
  <?= $this->include('/dashboard/layouts/navbar') ?>     
    <style>
    .toggle-password {
        position: absolute;
        top: 50%;
        right: 15px;
        transform: translateY(-50%);
        cursor: pointer;
        font-size: 1.2rem;
        color: #6c757d;
    }

    .toggle-password:hover {
        color: #000;
    }
    </style>


   <main class="main-content" id="mainContent">
        <div class="container-fluid">

             <div class="row d-flex justify-content-center" >
              <!-- /.col-md-6 -->
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h5>Change Password</h5>
                        </div>

                        <form class="form-horizontal" method="post" id="changePassworsdForm">
                            <div class="card-body">
                                <!-- Username -->
                                <div class="form-group row mb-1">
                                    <label class="col-sm-4 col-form-label">Username</label>
                                    <div class="col-sm-8">
                                        <input type="text" name="username" value='<?= $_SESSION['username']?>' class="form-control" placeholder="Enter Username" required>
                                    </div>
                                </div>
                                                                
                                                                <!-- New Password -->
                                <div class="form-group row mb-1">
                                    <label class="col-sm-4 col-form-label">New Password</label>
                                    <div class="col-sm-8 position-relative">
                                        <input type="password" name="new_password" id="new_password"
                                            class="form-control pe-5" placeholder="Enter New Password" required>
                                        <i class="bi bi-eye-slash toggle-password"
                                        data-target="new_password"></i>
                                    </div>
                                </div>

                                <!-- Confirm Password -->
                                <div class="form-group row mb-1">
                                    <label class="col-sm-4 col-form-label">Confirm Password</label>
                                    <div class="col-sm-8 position-relative">
                                        <input type="password" name="confirm_password" id="confirm_password"
                                            class="form-control pe-5" placeholder="Confirm Password" required>
                                        <i class="bi bi-eye-slash toggle-password"
                                        data-target="confirm_password"></i>
                                    </div>
                                </div>

                            </div>

                            <!-- Buttons -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Update</button>
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
$("#changePassworsdForm").on("submit", function(e) {
    e.preventDefault();

    const newPassword = $("#new_password").val();
    const confirmPassword = $("#confirm_password").val();

    if (newPassword !== confirmPassword) {
        Swal.fire({
            icon: "warning",
            title: "Password Mismatch",
            text: "New Password and Confirm Password must be the same"
        });
        return;
    }

    $.ajax({
        url: "<?= base_url('user/cahangePass') ?>",
        type: "POST",
        data: $(this).serialize(),
        dataType: "json",
        success: function(res){
            if (res.status === "success") {
                Swal.fire({
                    icon: "success",
                    title: "Password Updated Successfully!",
                    timer: 1500,
                    showConfirmButton: false
                });

                setTimeout(() => {
                    window.location.href = "<?= base_url('/') ?>";
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




document.querySelectorAll(".toggle-password").forEach(icon => {
    icon.addEventListener("click", function () {
        const input = document.getElementById(this.dataset.target);

        if (input.type === "password") {
            input.type = "text";
            this.classList.remove("bi-eye-slash");
            this.classList.add("bi-eye");
        } else {
            input.type = "password";
            this.classList.remove("bi-eye");
            this.classList.add("bi-eye-slash");
        }
    });
});
</script>

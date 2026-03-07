<?= $this->include('/dashboard/layouts/sidebar') ?>
<?= $this->include('/dashboard/layouts/navbar') ?>


<main class="main-content" id="mainContent">
<div class="container-fluid">
<!-- Add Notification Modal -->
<div class="modal fade" id="addNotificationModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content shadow-lg border-0">

            <!-- Header -->
            <div class="card-header text-white py-3">
                <h5 class="fw-semibold">
                    <i class="fas fa-bell me-2"></i>Add Notification
                </h5>
            </div>

            <form id="notificationForm" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <div class="modal-body">

                    <div class="row">

                        <!-- Title -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-medium">Title</label>
                            <input type="text" 
                                   name="title" 
                                   class="form-control p-2"
                                   placeholder="Enter Notification Title"
                                   required>
                        </div>

                        <!-- Notification Type -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-medium">Notification Type</label>
                            <select name="type" class="form-control p-2" required>
                                <option value="">Select Type</option>
                                <option value="New Feature">New Feature</option>
                                <option value="Module Extension">Module Extension</option>
                                <option value="System Update">System Update</option>
                                <option value="Bug Fix">Bug Fix</option>
                                <option value="Visitor Alert">Visitor Alert</option>
                                <option value="Security Alert">Security Alert</option>
                                <option value="Admin Announcement">Admin Announcement</option>
                                <option value="Reminder">Reminder</option>
                                <option value="Urgent Notice">Urgent Notice</option>
                            </select>
                        </div>

                    </div>

                    <!-- Message -->
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-medium">Message</label>
                            <textarea name="message"
                                      class="form-control p-2"
                                      rows="4"
                                      placeholder="Enter Notification Message"
                                      required></textarea>
                        </div>
                    </div>

                    <!-- Attachment -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-medium">Attachment</label>
                            <input type="file"
                                   name="attachment"
                                   class="form-control p-2">
                            <small class="text-muted">
                                Allowed: PDF, JPG, PNG, DOCX (Max 2MB)
                            </small>
                        </div>
                    </div>

                  <!-- Department Selection -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-medium">Select Departments</label>
                            <select name="departments[]" id="departments" class="form-control p-2" multiple>
                                <option value="">-- Select Departments --</option>
                                <?php foreach ($departments as $dept): ?>
                                    <option value="<?= $dept['id'] ?>"><?= esc($dept['department_name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <small class="text-muted">Hold Ctrl/Cmd to select multiple departments</small>
                        </div>

                        <!-- Role Selection -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-medium">Select Roles</label>
                            <select name="roles[]" id="roles" class="form-control p-2" multiple>
                                <option value="">-- Select Roles --</option>
                                <?php foreach ($roles as $role): ?>
                                    <option value="<?= $role['id'] ?>"><?= esc($role['role_name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <small class="text-muted">Hold Ctrl/Cmd to select multiple roles</small>
                        </div>
                    </div>

                </div>

                <!-- Footer -->
                <div class="modal-footer d-flex justify-content-end">
                    <button type="submit" class="btn btn-success px-4">
                        <i class="fas fa-save me-1"></i> Save
                    </button>
                    <button type="button"
                            class="btn btn-danger px-4"
                            data-bs-dismiss="modal">
                        Close
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
<!-- Add Notification Modal -->
<!--  End Add Form  -->

<!-- Edit Notification Modal -->
<div class="modal fade" id="editNotificationModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content shadow-lg border-0">

            <!-- Header -->
            <div class="card-header text-white py-3">
                <h5 class="fw-semibold">
                    <i class="fas fa-edit me-2"></i>Edit Notification
                </h5>
            </div>

            <form id="editNotificationForm" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <div class="modal-body">

                    <input type="hidden" name="id" id="edit_id">

                    <div class="row">

                        <!-- Title -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-medium">Title</label>
                            <input type="text" 
                                   id="edit_title"
                                   name="title"
                                   class="form-control p-2"
                                   required>
                        </div>

                        <!-- Type -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-medium">Notification Type</label>
                            <select id="edit_type" 
                                    name="type" 
                                    class="form-control p-2"
                                    required>
                                <option value="">Select Type</option>
                                <option value="New Feature">New Feature</option>
                                <option value="Module Extension">Module Extension</option>
                                <option value="System Update">System Update</option>
                                <option value="Bug Fix">Bug Fix</option>
                                <option value="Visitor Alert">Visitor Alert</option>
                                <option value="Security Alert">Security Alert</option>
                                <option value="Admin Announcement">Admin Announcement</option>
                                <option value="Reminder">Reminder</option>
                                <option value="Urgent Notice">Urgent Notice</option>
                            </select>
                        </div>

                    </div>

                    <!-- Message -->
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-medium">Message</label>
                            <textarea id="edit_message"
                                      name="message"
                                      class="form-control p-2"
                                      rows="4"
                                      required></textarea>
                        </div>
                    </div>

                    <!-- Attachment -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-medium">Replace Attachment</label>
                            <input type="file"
                                   name="attachment"
                                   class="form-control p-2">
                            <small class="text-muted">
                                Leave blank to keep existing file
                            </small>
                        </div>
                    </div>

                </div>

                <!-- Footer -->
                <div class="modal-footer d-flex justify-content-end">
                    <button type="submit" class="btn btn-success px-4">
                        <i class="fas fa-save me-1"></i> Update
                    </button>
                    <button type="button"
                            class="btn btn-danger px-4"
                            data-bs-dismiss="modal">
                        Close
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
<!--  End Edit Form   -->

<div class="row">
<div class="col-md-12">

<div class="card">
<div class="card-header d-flex justify-content-between">
<h5>Notification List</h5>

<!-- Add Button -->
<button class="btn btn-warning" data-toggle="modal" onclick="addNotificationPop()" >
<i class="fa fa-plus"></i> Add Notification
</button>

</div>

<div class="card-body table-responsive table-scroll"  id="tableScrollWrapper">
    <table class="table table-bordered table-striped" style="table-layout: fixed;"  >
        <thead>
        <tr>
        <th style="width: 10%;">Type</th>
        <th style="width: 15%;">Title</th>
        <th style="width: 45%;">Message</th>
        <th style="width: 15%;">Attachment</th>
        <th style="width: 10%;">Status</th>
        <th style="width: 15%;">Action</th>
        </tr>
        </thead>
        <tbody>

        <?php foreach ($notifications as $n): ?>
        <tr>
        <td><?= esc($n['type']) ?></td>
        <td><?= esc($n['title']) ?></td>
        <td><?= esc($n['message']) ?></td>
        <td>
            
        <?php if($n['attachment']): ?>
        <a href="<?= base_url($n['attachment']) ?>" target="_blank" class="btn btn-sm btn-info">
        <i class="fa fa-download"></i>
        </a>
        <?php endif; ?>
        </td>
        <td>
            <span class="badge <?= $n['status'] == 1 ? 'bg-success' : 'bg-danger' ?>">
                <?= $n['status'] == 1 ? 'Active' : 'Inactive' ?>
            </span>
        </td>

        <td>
            <button class="btn btn-primary btn-sm editBtn"
                data-id="<?= $n['id'] ?>"
                data-title="<?= esc($n['title']) ?>"
                data-message="<?= esc($n['message']) ?>"
                data-type="<?= esc($n['type']) ?>"
                data-attachment="<?= esc($n['attachment']) ?>">
                <i class="fa fa-edit"></i>
            </button>

            <button class="btn btn-warning btn-sm toggleStatusBtn"
                data-id="<?= $n['id'] ?>"
                data-status="<?= $n['status'] ?>">
                <i class="fa <?= $n['status'] == 1 ? 'fa-eye-slash' : 'fa-eye' ?>"></i>
            </button>

            <button class="btn btn-danger btn-sm deleteBtn"
                data-id="<?= $n['id'] ?>">
                <i class="fa fa-trash"></i>
            </button>
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
</main>

<?= $this->include('/dashboard/layouts/footer') ?>

<script>

$("#editNotificationForm").on("submit", function(e){
    e.preventDefault();

    let formData = new FormData(this);

    $.ajax({
        url: "<?= base_url('notification/update') ?>",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        dataType: "json",
        success: function(res){
            if(res.status == 'success'){
               $('#editNotificationModal').modal('hide');

                Swal.fire({
                    icon: "success",
                    title: res.message,
                    timer: 1500,
                    showConfirmButton: false
                });

                setTimeout(() => location.reload(), 1500);
            }else{

                   Swal.fire({
                    icon: "success",
                    title: res.message,
                    timer: 1500,
                    showConfirmButton: false
                });

            }
         
        }
    });
});




// Open Edit Modal & Fill Data
$(document).on("click", ".editBtn", function(){

    $("#edit_id").val($(this).data("id"));
    $("#edit_title").val($(this).data("title"));
    $("#edit_message").val($(this).data("message"));
    $("#edit_type").val($(this).data("type"));

    $("#editNotificationModal").modal("show");
});


function addNotificationPop(){
$('#addNotificationModal').modal('show');
}


$("#notificationForm").on("submit", function(e){
e.preventDefault();

let formData = new FormData(this);

$.ajax({
url: "<?= base_url('notification/store') ?>",
type: "POST",
data: formData,
processData: false,
contentType: false,
dataType: "json",
success: function(res){

$('#addNotificationModal').modal('hide');

Swal.fire({
icon: "success",
title: res.message,
timer: 1500,
showConfirmButton: false
});

setTimeout(() => location.reload(), 1500);
}
});
});

$(".deleteBtn").click(function(){
let id = $(this).data("id");

Swal.fire({
title: "Are you sure?",
icon: "warning",
showCancelButton: true
}).then((result) => {

if (result.isConfirmed) {

$.get("<?= base_url('notification/delete/') ?>" + id, function(res){

Swal.fire({
icon: "success",
title: res.message,
timer: 1200,
showConfirmButton: false
});

setTimeout(() => location.reload(), 1200);

}, "json");

}

});
});


$("#editNotificationForm").on("submit", function(e){
    e.preventDefault();

    let formData = new FormData(this);

    $.ajax({
        url: "<?= base_url('notification/update') ?>",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        dataType: "json",
        success: function(res){

            $('#editNotificationModal').modal('hide');

            Swal.fire({
                icon: "error",
                title: res.message,
                timer: 1500,
                showConfirmButton: false
            });

            setTimeout(() => location.reload(), 1500);
        }
    });
});

// Toggle Status Functionality
$(document).on("click", ".toggleStatusBtn", function(){
    let id = $(this).data("id");
    let currentStatus = $(this).data("status");
    let newStatus = currentStatus == 1 ? 0 : 1;
    let statusText = newStatus == 1 ? 'activate' : 'deactivate';
    let confirmText = `Are you sure you want to ${statusText} this notification?`;

    Swal.fire({
        title: "Confirm Status Change",
        text: confirmText,
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: newStatus == 1 ? "#28a745" : "#dc3545",
        cancelButtonColor: "#6c757d",
        confirmButtonText: newStatus == 1 ? "Activate" : "Deactivate"
    }).then((result) => {
        if (result.isConfirmed) {
            $.post("<?= base_url('notification/toggleStatus/') ?>" + id, function(res){
                if(res.status === 'success'){
                    Swal.fire({
                        icon: "success",
                        title: "Status Updated",
                        text: res.message,
                        timer: 1200,
                        showConfirmButton: false
                    });

                    setTimeout(() => location.reload(), 1200);
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: res.message
                    });
                }
            }, "json");
        }
    });
});

</script>
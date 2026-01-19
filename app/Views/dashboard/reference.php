<?= $this->include('/dashboard/layouts/sidebar') ?>
  <?= $this->include('/dashboard/layouts/navbar') ?>
     
<main class="main-content" id="mainContent">
     <div class="container-fluid">
           <div class="card card-primary">
                <div class="card-header">
                    <h4 class="card-title">Reference List</h4>

                <div class="text-end">
                   <!-- <a href="#" data-bs-toggle="modal" data-bs-target="#addReferenceModal" class="btn btn-warning mt-1"> New Reference</a> -->
                  <!-- <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#addReferenceModal">
                        New Reference
                    </button> -->
                </div>

                  <div class="card-tools">
                        <div class="input-group input-group-sm mx-2">
                           <a href="#" class="btn btn-warning mt-1"  data-bs-toggle="modal" data-bs-target="#addReferenceModal">New Reference</a>
                        </div>
                  </div>
                </div>
               
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Role</th>
                                <th>Address</th>
                                <th>Description</th>
                            </tr>
                        </thead>

                        <tbody id="referenceTableBody">
                            <tr><td colspan="7" class="text-center">Loading...</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>  
    
    </div>
</main>

<!-- ===================== MODAL POPUP ===================== -->
<div class="modal fade" id="addReferenceModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

        <div class="modal-header bg-primary text-white">
            <h5 class="modal-title">Add Reference Person</h5>
            <button class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">

            <form id="referenceForm">

                <div class="row">

                    <div class="col-md-6 mb-2">
                        <label>Reference Person Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter reference person full name" required>
                    </div>

                    <div class="col-md-6 mb-2">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter email address" required>
                    </div>

                    <div class="col-md-6 mb-2">
                        <label>Phone</label>
                        <input type="text" name="phone" class="form-control" placeholder="Enter contact number">
                    </div>

                    <div class="col-md-6 mb-2">
                        <label>Role</label>
                        <select name="reference_person_role" class="form-control" required>
                            <option value="">-- Select Role --</option>
                            <option value="Supervisor">Supervisor</option>
                            <option value="Manager">Manager</option>
                            <option value="Mediator">Mediator</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-2">
                        <label>Address</label>
                        <textarea name="address" class="form-control" rows="3" placeholder="Enter address"></textarea>
                    </div>

                    <div class="col-md-6 mb-2">
                        <label>Description</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Additional notes or details"></textarea>
                    </div>

                </div>

                <button type="submit" class="btn btn-primary mt-3">Save</button>

            </form>
        </div>

    </div>
  </div>
</div>
<!-- ===================== END MODAL ======================= -->

<?= $this->include('/dashboard/layouts/footer') ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {

    loadReferences();

    // Load table with AJAX
    function loadReferences() {
        $.ajax({
            url: "<?= base_url('referenceData') ?>",
            type: "GET",
            dataType: "json",
            success: function(data) {
                let html = "";
                let i = 1;

                if (data.length === 0) {
                    html = `<tr><td colspan="7" class="text-center">No data found</td></tr>`;
                } else {
                    data.forEach(row => {
                        html += `
                            <tr>
                                <td>${i++}</td>
                                <td>${row.name}</td>
                                <td>${row.email}</td>
                                <td>${row.phone ?? '-'}</td>
                                <td>${row.reference_person_role}</td>
                                <td>${row.address ?? '-'}</td>
                                <td>${row.description ?? '-'}</td>
                            </tr>
                        `;
                    });
                }

                $("#referenceTableBody").html(html);
            }
        });
    }

    // Save Reference via AJAX
    $("#referenceForm").submit(function(e) {
        e.preventDefault();

        $.ajax({
            url: "<?= base_url('reference_save') ?>",
            type: "POST",
            data: $(this).serialize(),
            success: function() {

                $("#addReferenceModal").modal('hide');
                $("#referenceForm")[0].reset();
                loadReferences();
            }
        });
    });

});
</script>

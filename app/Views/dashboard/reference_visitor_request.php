<?= $this->include('/dashboard/layouts/sidebar') ?>
  <?= $this->include('/dashboard/layouts/navbar') ?>
     
   <main class="main-content" id="mainContent">
    <div class="container-fluid">
         <div class="card card-primary">
                <div class="card-header">
                    <h4 class="card-title">RVR List</h4>

                <div class="text-end">
                   <!-- <a href="#" data-bs-toggle="modal" data-bs-target="#addReferenceModal" class="btn btn-warning mt-1"> New Reference</a> -->
                  <!-- <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#addReferenceModal">
                        New Reference
                    </button> -->
                </div>

                  <div class="card-tools">
                        <div class="input-group input-group-sm mx-2">
                           <a href="#" class="btn btn-warning mt-1"  data-bs-toggle="modal" data-bs-target="#addReferenceModal">New Request</a>
                        </div>
                  </div>
                </div>
               
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>RVR Code</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Purpose</th>
                                <th>Date of Visit</th>
                                <th>No. of Visitors</th>
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
            <h5 class="modal-title">Add Reference Visitor Request</h5>
            <button class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">

            <form id="createForm">
              

                <div class="modal-body">
                    <div class="row">

                        <!-- Reference Person -->
                        <div class="col-md-6 mb-3">
                            <label>Reference Person</label>
                            <select name="reference_person_id" id="reference_person_id" class="form-control" required>
                            <option value="">-- Select Reference Person --</option>
                            </select>
                        </div>

                        <!-- Purpose -->
                        <div class="col-md-6 mb-3">
                            <label>Purpose of Visit</label>
                            <input type="text" name="purpose" class="form-control"
                                   placeholder="Enter purpose" required>
                        </div>

                        <!-- Visit Date -->
                        <div class="col-md-6 mb-3">
                            <label>Visit Date</label>
                            <input type="date" name="visit_date" class="form-control" required>
                        </div>

                        <!-- Visitor Count -->
                        <div class="col-md-6 mb-3">
                            <label>No. of Visitors</label>
                            <input type="number" name="visitor_count" min="1"
                                   class="form-control" placeholder="Enter number of visitors" required>
                        </div>

                        <!-- Description -->
                        <div class="col-md-12 mb-3">
                            <label>Description</label>
                            <textarea name="description" class="form-control" rows="3"
                                      placeholder="Additional notes"></textarea>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit">Save</button>
                    <button class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
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
            url: "<?= base_url('rvr_list') ?>",
            type: "GET",
            dataType: "json",
            success: function(data) {
           
                console.log(data)
                let html = "";
                let i = 1;

                if (data.length === 0) {
                    html = `<tr><td colspan="7" class="text-center">No data found</td></tr>`;
                } else {
                    data.forEach(row => {
                        html += `
                            <tr>
                                <td>${i++}</td>
                                <td>${row.rvr_code}</td>
                                <td>${row.name}</td>
                                <td>${row.email}</td>
                                <td>${row.purpose}</td>
                                <td>${row.visit_date ?? '-'}</td>
                                <td>${row.visitor_count}</td>
                                <td>${row.description}</td>
                                <td>  <a href="#" class="btn btn-primary" onclick="GetVisitorReferenceRequestDataById(${row.id})" >Send</a></td>
                            </tr>`;
                    });
                }

                $("#referenceTableBody").html(html);
            }
        });
    }


    // Save form using AJAX
    $("#createForm").submit(function (e) {
        e.preventDefault();

        $.ajax({
            url: "<?= base_url('rvr_save') ?>",
            method: "POST",
            data: $(this).serialize(),
            success: function (res) {
                if (res.status === 'success') {
                    $("#addReferenceModal").modal('hide');
                    $("#createForm")[0].reset();
                    loadReferences();
                } else {
                    alert("Error: " + res.message);
                }
            }
        });
    });

});


$(document).ready(function () {

    $.ajax({
        url: "<?= base_url('get_reference_list') ?>",
        type: "GET",
        dataType: "json",
        success: function (response) {

            let dropdown = $('#reference_person_id');
            dropdown.empty();
            dropdown.append('<option value="">-- Select Reference Person --</option>');

            if (response.length > 0) {
                response.forEach(function (item) {
                    dropdown.append(
                        `<option value="${item.id}">${item.name}</option>`
                    );
                });
            } else {
                dropdown.append('<option value="">No reference found</option>');
            }
        },
        error: function () {
            alert("Failed to load reference person data");
        }
    });

});


function GetVisitorReferenceRequestDataById(idVal) {
    $.ajax({
        url: "<?= base_url('rvr_request_by_id/') ?>" + idVal,
        type: "GET",
        dataType: "json",
        success: function(data) {
            if(data.rvr_code){
               window.location.href = "<?= base_url('rvr_redirect/') ?>" + data.rvr_code;
            } else {
                alert("RVR Code not found!");
            }
        },
        error: function() {
            alert("Error fetching RVR data.");
        }
    });
}







</script>

<?php
$visitorCount = $data['visitor_count'] ?? 1;

// print_r($data);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Visitor Form</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; padding: 20px; }
        .card { border-radius: 10px; margin-bottom: 20px; }
        .card-header { background-color: #0d6efd; color: #fff; font-weight: bold; }
        .table th, .table td { vertical-align: middle; white-space: nowrap; }
        .table-wrapper { max-height: 500px; overflow: auto; }
        .form-control, .form-select { min-height: 38px; }
        .btn-submit { min-width: 120px; }

            /* Make bottom card fill screen */
        .full-height-card {
        height: calc(100vh - 320px); /* Adjust top space */
        display: flex;
        flex-direction: column;
        }

        /* Scroll only inside table body */
        .table-scroll {
        flex-grow: 1;
        overflow-y: auto;
        overflow-x: auto;
        }

        /* Make table head sticky */
        .table thead th {
        position: sticky;
        top: 0;
        z-index: 10;
        color: #3568b3;
        }


    </style>

    
<style>
    /* Logo Hover Effect */
    .logo-hover {
        transition: transform 0.4s ease, filter 0.4s ease;
    }
    .logo-hover:hover {
        transform: scale(1.1);
        filter: brightness(1.2);
    }

    /* Card Styling */
    .ref-card {
        background: linear-gradient(to bottom right, #f4f7ff, #ffffff);
        border-top: 5px solid #3b7ddd;
        border-radius: 12px;
        padding: 5px 10px 10px 10px;
    }

    .main-title {
        font-size: 1.5rem;
        color: #1e3f8f;
        font-weight: bold;
        margin-top: 5px;
        margin-bottom: 5px;
    }

    /* Detail Box Styling */
    .detail-box {
        background: #f3d8d9;
        border: 1px solid #cfcbcb;
        border-radius: 35px;
        padding: 5px 25px 5px 25px;
    }

    .detail-title {
        font-size: 1.1rem;
        font-weight: bold;
        color: #ec1d25;
        margin-bottom: 5px;
        text-align: center;
    }

    .detail-rows {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        font-size: 0.95rem;
    }

    .detail-rows div {
        margin: 5px 0;
        white-space: nowrap;
    }

    .detail-rows strong {
        color: #2d4d8f;
    }
</style>

</head>
<body>
<!-- Reference Person Card -->
  <div class="mb-3">

    <!-- Logo Top Center -->
    <div class="text-center">
        <img src="<?= base_url('public/dist/ramoji-logo.png')?>" 
             alt="Logo" class="img-fluid logo-hover"
             style="max-height: 100px;">
    </div>

    <!-- MAIN TITLE -->
    <div class="text-center main-title">
        Reference Visitor Request Form
    </div>

    <!-- Details Box -->
    <div class="detail-box">

        <!-- Small title inside the details box -->
        <div class="detail-title">Reference Person Details</div>

        <!-- All Details in Single Line -->
        <div class="detail-rows">

            <div>
                <strong>Name:</strong> <?= htmlspecialchars($data['name'] ?? '-') ?>
            </div>

            <div>
                <strong>Email:</strong> <?= htmlspecialchars($data['email'] ?? '-') ?>
            </div>

            <div>
                <strong>Phone:</strong> <?= htmlspecialchars($data['phone'] ?? '-') ?>
            </div>

            <div>
                <strong>Purpose:</strong> <?= htmlspecialchars($data['purpose'] ?? '-') ?>
            </div>

            <div>
                <strong>Date:</strong> <?= htmlspecialchars($data['visit_date'] ?? '-') ?>
            </div>

            <div>
                <strong>Visitors:</strong> <?= htmlspecialchars($data['visitor_count'] ?? '-') ?>
            </div>
        </div>
    </div>
</div>


<!-- Visitor Grid Card -->
<div class="card shadow full-height-card card-primary">

<div class="card-header d-flex justify-content-between align-items-center">
    <h3 class="card-title m-0">Visitors Details</h3>

    <div>
        <button type="button" class="btn btn-warning btn-sm me-2" id="saveBtn">
            <b>Save</b>
        </button>

        <button type="submit" class="btn btn-info btn-sm" form="visitorForm">
          <b>  Submit</b>
        </button>
    </div>
</div>

    <!-- Scroll only BODY -->
    <div class="card-body p-2 table-scroll">
        <form id="visitorForm" enctype="multipart/form-data">
            <input type="hidden" name="rvr_code" value="<?= $data['rvr_code'] ?>">

            <table class="table table-bordered table-striped align-middle m-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Visitor Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>ID Type</th>
                        <th>ID Number</th>
                        <th>Purpose</th>
                        <th>Visit Time</th>
                        <th>Description</th>
                        <th>Vehicle No</th>
                        <th>Vehicle Type</th>
                        <th>Vehicle ID Proof</th>
                        <th>Visitor ID Proof</th>
                    </tr>
                </thead>

                <tbody>
                    <?php for($i=1; $i<=$visitorCount; $i++): ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><input type="text" name="visitors[<?= $i ?>][visitor_name]" class="form-control" required></td>
                        <td><input type="email" name="visitors[<?= $i ?>][visitor_email]" class="form-control" required></td>
                        <td><input type="text" name="visitors[<?= $i ?>][visitor_phone]" class="form-control" required></td>

                        <td>
                            <select name="visitors[<?= $i ?>][proof_id_type]" class="form-select" required>
                                <option value="">Select</option>
                                <option>Aadhar Card</option>
                                <option>PAN Card</option>
                                <option>Voter ID</option>
                                <option>Passport</option>
                                <option>Driving License</option>
                                <option>Employee / Student ID</option>
                                <option>Other</option>
                            </select>
                        </td>

                        <td><input type="text" name="visitors[<?= $i ?>][proof_id_number]" class="form-control" required></td>

                        <td>
                            <select name="visitors[<?= $i ?>][purpose]" class="form-select" required>
                                <option value="">Select</option>
                                <option>General Visit</option>
                                <option>Meeting</option>
                                <option>Interview</option>
                                <option>Document Submission</option>
                                <option>Verification / Approval</option>
                                <option>Event Visit</option>
                                <option>Tourism Visit</option>
                                <option>Personal Visit</option>
                                <option>Site Inspection</option>
                                <option>Maintenance / Service</option>
                                <option>Other</option>
                            </select>
                        </td>

                        <td><input type="time" name="visitors[<?= $i ?>][visit_time]" class="form-control" required></td>
                        <td><textarea name="visitors[<?= $i ?>][description]" class="form-control" rows="1"></textarea></td>
                        <td><input type="text" name="visitors[<?= $i ?>][vehicle_no]" class="form-control"></td>

                        <td>
                            <select name="visitors[<?= $i ?>][vehicle_type]" class="form-select">
                                <option value="">Select</option>
                                <option>Bike</option>
                                <option>Car</option>
                                <option>Van</option>
                                <option>Bus</option>
                                <option>Auto</option>
                                <option>Truck</option>
                            </select>
                        </td>

                        <td><input type="file" name="visitors[<?= $i ?>][vehicle_id_proof]" class="form-control"></td>
                        <td><input type="file" name="visitors[<?= $i ?>][visitor_id_proof]" class="form-control"></td>
                    </tr>
                    <?php endfor; ?>
                </tbody>
            </table>
        </form>
    </div>
</div>


<!-- Bootstrap 5 JS + jQuery -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // AJAX save function
    $('#saveReferenceBtn').click(function(){
        let referenceData = $('#referenceForm').serialize();
        $.ajax({
            url: '<?= base_url("save_reference_details") ?>',
            type: 'POST',
            data: referenceData,
            success: function(res){
                alert('Reference details saved successfully!');
            },
            error: function(){
                alert('Error saving reference details.');
            }
        });
    });

    // AJAX submit function for visitors
    $('#submitReferenceBtn').click(function(){
        let visitorData = new FormData($('#visitorForm')[0]);
        $.ajax({
            url: '<?= base_url("save_reference_visitor_details") ?>',
            type: 'POST',
            data: visitorData,
            processData: false,
            contentType: false,
            success: function(res){
                alert('Visitors saved successfully!');
            },
            error: function(){
                alert('Error saving visitors.');
            }
        });
    });
</script>
</body>
</html>

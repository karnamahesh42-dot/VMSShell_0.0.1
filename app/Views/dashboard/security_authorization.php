<?= $this->include('/dashboard/layouts/sidebar') ?>
  <?= $this->include('/dashboard/layouts/navbar') ?>

  <style>
    /* Card Styling */
.visitor-details-smart {
    border-radius: 15px;
    overflow: hidden;
    background: #ffffff;
    border: none;
    backdrop-filter: blur(8px);
    transition: 0.3s;
}

.visitor-details-smart:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.2);
}

/* Header */
.bg-gradient-success {
    background: linear-gradient(90deg, #28a745, #1e7e34);
}

/* Profile Icon */
.profile-icon {
    width: 65px;
    height: 65px;
    background: #e9f7ef;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    color: #28a745;
    margin-right: 15px;
}

/* Name */
.visitor-name {
    margin-bottom: 2px;
    color: #1e7e34;
    font-weight: 700;
}

/* Info Line */
.info-line {
    font-size: 15px;
    color: #333;
    margin-bottom: 6px;
}

.info-line i {
    width: 20px;
    color: #28a745;
}

/* Status Badge */
.visitor-status {
    padding: 8px 15px;
    border-radius: 20px;
    font-weight: 600;
    text-transform: capitalize;
}

/* Smart Buttons */
.smart-btn {
    font-size: 16px;
    padding: 10px;
    border-radius: 10px;
    transition: 0.3s;
}

.smart-btn:hover {
    transform: scale(1.02);
}

  </style>
     
   <main class="main-content" id="mainContent">
        <div class="container-fluid">
             <div class="row d-flex justify-content-center">
            <div class="col-md-8 col-sm-8 col-8">

            <!-- Search Box -->
                <div class="card card-primary mb-3">
                    <div class="card-header text-white d-flex align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-qrcode"></i> Visitor Access Verification
                        </h5>

                        <button id="toggleAutoScan" class="btn btn-light btn-sm ms-auto">
                            <i class="fas fa-check-circle"></i> Auto Scan: ON
                        </button>

                        <!-- Auto Scan Hidden Input -->
                         <input type="hidden" value="" id="auto_scan_btn">
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <label class="fw-bold">Scan / Enter V-Code</label>

                            <div class="col-9 col-md-9 col-sm-9">
                                <input type="text" id="vcodeInput" class="form-control"
                                    placeholder="Example: V00001 or Scan QR">
                            </div>

                            <div class="col-3 col-md-3 col-sm-3">
                                <a href="#" class="btn btn-primary" id="searchBtn">
                                    <i class="fas fa-search"></i> Verify
                                </a>
                            </div>

                            <small class="text-muted mt-2">
                                <label><b>Note :</b></label>
                                Security can manually enter the V-Code or scan it using a gate QR scanner.
                            </small>
                        </div>
                    </div>
                </div>
         <!-- Search Box End -->

                    <!-- Visitor Details Card Start -->

    


                <!-- Visitor Details Card Start -->
<div id="visitorDetails" class="card visitor-details-smart shadow-lg mb-5 d-none">

    <!-- Header -->
    <div class="card-header bg-gradient-success text-white d-flex align-items-center">
        <i class="fas fa-id-card fa-lg me-2"></i>
        <h5 class="mb-0">Visitor Information</h5>
    </div>

    <div class="card-body">

        <!-- Profile + Status -->
        <div class="d-flex justify-content-between align-items-center mb-3">

            <!-- Profile -->
            <div class="d-flex align-items-center">
                <div class="profile-icon">
                    <i class="fas fa-user"></i>
                </div>

                <div>
                    <h4 id="vName" class="visitor-name"></h4>
                    <div class="text-muted small">
                        <i class="fas fa-envelope"></i> <span id="vEmail"></span><br>
                        <i class="fas fa-hashtag"></i> <span id="vCode"></span>
                    </div>
                </div>
            </div>

            <!-- Status -->
            <span id="vStatus" class="visitor-status"></span>

        </div>

        <hr>

        <!-- 2 Column Smart Info Layout -->
        <div class="row g-3">

            <div class="col-md-6 pl-5">

                <p class="info-line"><i class="fas fa-phone"></i> <span id="vPhone"></span></p>

                <p class="info-line"><i class="fas fa-bullseye"></i> <span id="vPurpose"></span></p>

                <p class="info-line"><i class="fas fa-users"></i> <span id="vGroupCode"></span></p>

                <p class="info-line"><i class="fas fa-car"></i> <span id="vVehicleNo"></span></p>

            </div>

            <div class="col-md-6">

                <p class="info-line"><i class="fas fa-calendar"></i> <span id="vExpVisitDate"></span></p>

                <p class="info-line"><i class="fas fa-clock"></i> <span id="vExpVisitTime"></span></p>

                <p class="info-line"><i class="fas fa-id-badge"></i> <span id="vIdProofType"></span></p>

                <p class="info-line"><i class="fas fa-barcode"></i> <span id="vIdProofNo"></span></p>

            </div>

            <div class="col-12">
                <p class="info-line"><i class="fas fa-comment-alt"></i> <span id="vDescription"></span></p>
            </div>

        </div>

        <input type="hidden" id="visitorRequestId">
        <input type="hidden" id="securityCheckStatus">

        <!-- Action Buttons -->
        <div class="mt-4">
            <button class="btn btn-success smart-btn mb-2 d-none" id="allowEntryBtn">
                <i class="fas fa-door-open"></i> Allow Entry
            </button>

            <button class="btn btn-danger smart-btn d-none" id="markExitBtn">
                <i class="fas fa-door-closed"></i> Mark Exit
            </button>
        </div>

    </div>
</div>
<!-- Visitor Details Card End -->

                
                    <!-- Visitor Details Card End -->
                </div>
            </div>
        </div>
    </main>

<?= $this->include('/dashboard/layouts/footer') ?>


<!-- JS -->
<script>


$(document).ready(function () {

    let autoScan = true; // default ON
    $('#auto_scan_btn').val('on');
    // Focus input on load
    setTimeout(() => $("#vcodeInput").focus(), 300);

    // Auto Scan Toggle Button
    $("#toggleAutoScan").click(function () {
        autoScan = !autoScan;
        if (autoScan) {
            $(this).html('<i class="fas fa-check-circle"></i> Auto Scan: ON');
            $(this).removeClass("btn-danger").addClass("btn-light");
             $('#auto_scan_btn').val('on');
        } else {
            $(this).html('<i class="fas fa-times-circle"></i> Auto Scan: OFF');
            $(this).removeClass("btn-light").addClass("btn-danger");
            $('#auto_scan_btn').val('off');
        }
        setTimeout(() => $("#vcodeInput").focus(), 300);
    });

    // Auto verify when autoScan is true
    $("#vcodeInput").on("input", function () {
        if (!autoScan) return;  // ignore when OFF

        let code = $(this).val().trim();

        if (code.length === 7) {   // V000008 (7 chars)
            $("#searchBtn").click();
        }
    });
});




// -----------------------------------------------------
//  MANUAL + AUTO VERIFY FUNCTION (ALREADY TRIGGERED BY AUTO SCAN)
// -----------------------------------------------------
$("#searchBtn").on('click', function () {

    let vcode = $("#vcodeInput").val().trim();

    if (vcode === "") {
        Swal.fire("Required", "Please enter a V-Code.", "warning");
        return;
    }

    $.ajax({
        url: "<?= base_url('/security/verify') ?>",
        type: "POST",
        data: { v_code: vcode },
        success: function (res) {

            if (res.status === "error") {
              
                Swal.fire({icon:"error",title:"Not Found",text:"Visitor record not found!",timer:1500,timerProgressBar:true,showConfirmButton:false});
                return;
            }

            if (res.status === "not_approved") {
              
                  Swal.fire({icon:"warning",title:"Not Approved",text:"Visitor is not approved yet.",timer:1500,timerProgressBar:true,showConfirmButton:false});
                return;
            }

            // Show the card
            $("#visitorDetails").removeClass("d-none");

            // Fill visitor data
            $("#visitorRequestId").val(res.visitor.id);
            $("#vName").text(res.visitor.visitor_name);
            $("#vPhone").text(res.visitor.visitor_phone);
            $("#vEmail").text(res.visitor.visitor_email);
            $("#vPurpose").text(res.visitor.purpose);
            $('#vCode').text(res.visitor.v_code)
            $("#vGroupCode").text(res.visitor.group_code);
            $("#vVehicleNo").text(res.visitor.vehicle_no);
            $("#vExpVisitTime").text(res.visitor.visit_time);
            $("#vExpVisitDate").text(res.visitor.visit_date);
            $("#vIdProofNo").text(res.visitor.proof_id_number);
            $("#vIdProofType").text(res.visitor.proof_id_type);
            $("#vDescription").text(res.visitor.description);

            // Status Badge
            let badge = $("#vStatus");
            badge.removeClass("bg-secondary bg-warning bg-success text-dark");

            if (res.visitor.securityCheckStatus == 0) {
                badge.text("Not Entered").addClass("bg-secondary");
            }
            else if (res.visitor.securityCheckStatus == 1) {
                badge.text("Inside").addClass("bg-warning text-dark");
            }
            else if (res.visitor.securityCheckStatus == 2) {
                badge.text("Completed").addClass("bg-success");
            }

            // Show / Hide Buttons Manually
            $("#allowEntryBtn").addClass("d-none");
            $("#markExitBtn").addClass("d-none");

            if (res.visitor.securityCheckStatus == 0) {
                $("#allowEntryBtn").removeClass("d-none");
            }
            if (res.visitor.securityCheckStatus == 1) {
                $("#markExitBtn").removeClass("d-none");
            }

            // -------------------------------------
            // AUTO APPROVAL (AUTO CHECK-IN)
            // -------------------------------------
            
            if (res.visitor.securityCheckStatus == 0 && $('#auto_scan_btn').val() == "on") {
                 console.log("Auto approving entry...");
                 $("#allowEntryBtn").click();
            }
        
            $("#vcodeInput").val('');

        }
    });
});



// -----------------------------------------------------
//  ALLOW ENTRY (CHECK-IN)
// -----------------------------------------------------
$("#allowEntryBtn").on('click', function () {

    $.ajax({
        url: "<?= base_url('/security/checkin') ?>",
        type: "POST",
        data: {
            visitor_request_id: $("#visitorRequestId").val(),
            v_code: $('#vCode').text()
        },
        success: function (res) {

            if (res.status === "exists") {
                
                alert(res.status);
                Swal.fire({icon:"info",title:"Already Inside",text:"Visitor already checked in.",timer:1500,timerProgressBar:true,showConfirmButton:false});
                return;
            }

             $("#vStatus").text("Inside").addClass("bg-warning text-dark");
             $("#allowEntryBtn").addClass("d-none");
             $("#markExitBtn").removeClass("d-none");
             Swal.fire({icon:"success",title:"success",text:"Visitor entry recorded.",timer:1500,timerProgressBar:true,showConfirmButton:false});

        }
    });
});



// -----------------------------------------------------
//  MARK EXIT
// -----------------------------------------------------
$("#markExitBtn").on('click', function () {

    $.ajax({
        url: "<?= base_url('/security/checkout') ?>",
        type: "POST",
        data: { visitor_request_id: $("#visitorRequestId").val() },
        success: function (res) {

            if (res.status === "no_entry") {
                // Swal.fire("No Entry", "Visitor has no entry record.", "warning");
                Swal.fire({icon:"warning",title:"No Entry",text:"Visitor has no entry record.",timer:1500,timerProgressBar:true,showConfirmButton:false});
                return;
            }
            
            $("#vStatus").removeClass("bg-warning text-dark");
            $("#vStatus").text("Completed").addClass("bg-success");
            $("#markExitBtn").addClass("d-none");
            // Swal.fire("Recorded", "Visitor exit recorded.", "success");
            Swal.fire({icon:"success",title:"Recorded",text:"Visitor exit recorded.",timer:1500,timerProgressBar:true,showConfirmButton:false});

        }
    });
});

</script>

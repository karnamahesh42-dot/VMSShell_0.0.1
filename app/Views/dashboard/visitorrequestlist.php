<?= $this->include('/dashboard/layouts/sidebar') ?>
<?= $this->include('/dashboard/layouts/navbar') ?>

<main class="main-content" id="mainContent">
        <div class="container-fluid">

                 <!-- Satart view Visitor Request Form Pop-Up  -->
                    <!-- Visitor Request Modal -->
<div class="modal fade" id="visitorModal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content shadow-lg rounded-4 border-0">

            <!-- HEADER -->
            <div class="modal-header card-header text-white rounded-top-4">
                <h5 class="modal-title">Visitor Request Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <!-- BODY -->
            <div class="modal-body">

                <!-- HEADER INFO CARD -->
                <div class="card mb-2 border-0 shadow-sm rounded-4">
                    <div class="card-body visitor-card">
    
                        <div class="row g-2">

                            <div class="col-md-3 col-6">
                                <label class="fw-semibold">Request ID:</label>
                                <div id="h_code" class="text-primary  cardData"></div>
                            </div>

                            <div class="col-md-3 col-6">
                                <label class="fw-semibold">Requested By:</label>
                                <div id="h_requested_by" class="cardData"></div>
                            </div>

                             <div class="col-md-3 col-6">
                                <label class="fw-semibold">Referred By:</label>
                                <div id="referred_by" class="cardData"></div>
                            </div>
                              
                            <div class="col-md-3 col-6">
                                <label class="fw-semibold">Company:</label>
                                <div id="h_company" class="cardData"></div>
                            </div>

                             <div class="col-md-3 col-6">
                                <label class="fw-semibold">Department</label>
                                <div id="h_department" class="cardData"></div>
                            </div>

                             <div class="col-md-3 col-6">
                                <label class="fw-semibold">Visitors Count </label>
                                <div id="h_count" class="cardData"></div>
                            </div>

                             <div class="col-md-3 col-6">
                                <label class="fw-semibold">Email</label>
                                <div id="h_email" class="cardData"></div>
                            </div>

                            <div class="col-md-3 col-6">
                                <label class="fw-semibold">Purpose </label>
                                <div id="h_purpose" class="cardData"></div>
                            </div>

                            <div class="col-md-3 col-6">
                                <label class="fw-semibold">Visit Date & Time </label>
                                <div id="h_date" class="cardData"></div>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="fw-semibold">Description </label>
                                <div id="h_description" class="cardData"></div>
                            </div>

                            <div class="col-md-3 col-6">
                                <label class="fw-semibold">Actions</label>
                                <?php if(session()->get('role_id') <= 2){ ?>
                               
                                <div id= "actionBtns"></div>
                                
                                <?php } ?>
                                  <p class="text-danger" id="remarkLablle"><p>      
                            </div>
                                <!-- Reccee Details -->
                                <div class="row" id="recceData" style="display:none;" >
                                    <h5 class="text-primary font-weight-bold m-2">Recce Details</h5>
                                    <div class="col-md-3 col-sm-6 col-6">
                                        <label class="fw-semibold">Type of Recce</label>
                                        <div id="typeOfRecce" class="cardData"></div>
                                    </div>

                                    <div class="col-md-3 col-sm-6 col-6">
                                        <label class="fw-semibold">Art Director / Director</label>
                                         <div id="director" class="cardData"></div>
                                    </div>

                                    <div class="col-md-3 col-sm-6 col-6">
                                        <label class="fw-semibold">Company / Production</label>
                                        <div id="production" class="cardData"></div>
                                    </div>

                                    <div class="col-md-3 col-sm-6 col-6">
                                        <label class="fw-semibold">Tentative Shooting Date</label>
                                         <div id="shootingDate" class="cardData"></div>
                                    </div>

                                    <div class="col-md-3 col-sm-6 col-6">
                                        <label class="fw-semibold">Contact Person</label>
                                        <div id="contactPerson" class="cardData"></div>
                                    </div>

                                    <div class="col-md-3 col-sm-6 col-6">
                                        <label class="fw-semibold">Contact Peson Mail</label>
                                        <div id="contactPersonEmail" class="cardData"></div>
                                    </div>

                                      <div class="col-md-3 col-sm-6 col-6">
                                        <label class="fw-semibold">Contact Peson Mobile</label>
                                        <div id="contactPersonMobile" class="cardData"></div>
                                    </div>
                                </div>


                                <!-- Vendor Details -->
                                <div class="row" id="vendorData" style="display:none;">
                                    <h5 class="text-primary font-weight-bold m-2">Vendor Details</h5>

                                    <div class="col-md-3 col-sm-6 col-6">
                                        <label class="fw-semibold">Vendor Category</label>
                                        <div id="vendorCategory" class="cardData"></div>
                                    </div>

                                    <div class="col-md-3 col-sm-6 col-6">
                                        <label class="fw-semibold">Vendor Status</label>
                                        <div id="vendorStatus" class="cardData"></div>
                                    </div>

                                    <div class="col-md-3 col-sm-6 col-6">
                                        <label class="fw-semibold">Company</label>
                                        <div id="vendorCompany" class="cardData"></div>
                                    </div>

                                    <div class="col-md-3 col-sm-6 col-6">
                                        <label class="fw-semibold">Location</label>
                                        <div id="vendorLocation" class="cardData"></div>
                                    </div>

                                    <div class="col-md-3 col-sm-6 col-6">
                                        <label class="fw-semibold">Contact Person</label>
                                        <div id="vendorContactPerson" class="cardData"></div>
                                    </div>

                                    <div class="col-md-3 col-sm-6 col-6">
                                        <label class="fw-semibold">Email</label>
                                        <div id="vendorEmail" class="cardData"></div>
                                    </div>

                                    <div class="col-md-3 col-sm-6 col-6">
                                        <label class="fw-semibold">Mobile</label>
                                        <div id="vendorMobile" class="cardData"></div>
                                    </div>
                                </div>

                        </div>
                    </div>
                </div>

                <!-- VISITOR CARDS -->
                     <!-- <div class="row mx-1" id="visitorCardsContainer"></div> -->
                <!-- VISITOR CARDS END -->
                <!-- VISITOR CARDS-2  -->
                 <h6 class="fw-bold text-primary">| Visitor Details</h6>
                   
                   
                        <div id="visitorCardsDetails" style="height:250px; width:100%; overflow:auto; overflow-x:hidden;">
                        </div>
                <!-- VISITOR CARDS-2  -->
            </div>
            <!-- FOOTER -->
            <div class="modal-footer justify-content-between">
                <button class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

                <!-- End view Visitor Request Form Pop-Up  -->
                <div class="col-12">
                    <div class="card  visitor-list-card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Visitor Request Management</h5>

                            <div class="card-header-actions">
                                <a href="<?= base_url('group_visito_request') ?>" class="btn btn-warning mx-1">
                                    <i class="fa-solid fa-users"></i> Group Request
                                </a>

                                <a href="<?= base_url('visitorequest') ?>" class="btn btn-warning mx-1">
                                    <i class="fa-solid fa-user"></i> New Request
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                         <!-- /.card-body -->
                            <div class="card-body table-responsive">
                                <table class="table table-bordered table-hover"  id="visitorTable">
                                    <thead class="bg-light">
                                    <tr>
                                    <th>#</th>
                                    <th>Request ID</th>
                                    <th>Department</th>
                                    <th>Purpose</th>
                                    <th style="width:250px;" >Description</th>
                                    <th>Visit Date</th>
                                    <th>Visitors Count</th>
                                    <th>Status</th>
                                    <?php if(in_array($_SESSION['role_id'] , [1,2,5] )){?>
                                    <th style="width:150px;" colspan="2">Actions</th>
                                    <?php }?>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>

                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
    </div>
</main>

<?= $this->include('/dashboard/layouts/footer') ?>

<script>
$(document).ready(function() {
    loadVisitorList();
});



//  CORRECT function
function loadVisitorList() {

    $.ajax({
        url: "<?= base_url('/visitorlistdata') ?>",
        type: "GET",
        dataType: "json",
        success: function(data) {
            // console.log(data);

            let rows = "";
            let i = 1;

            data.forEach(function(item){

                // Status badge
                let statusBadge =
                    item.status === "approved" ? `<span class="badge bg-success">Approved</span>` :
                    item.status === "rejected" ? `<span class="badge bg-danger">Rejected</span>` :
                    `<span class="badge bg-warning">Pending</span>`;

                // Action buttons only for pending
                let actions = "";
                let shareMail="";
                if (item.status === "pending") {
                    actions = `
                        <button class="btn btn-success btn-sm approvalBtn mx-1" onclick = approvalProcess(${item.id},'approved','${item.header_code}','') ><i class="fa-solid fa-check"></i></button>
                        <button class="btn btn-danger btn-sm approvalBtn mx-1" onclick = rejectComment(${item.id},'rejected','${item.header_code}','') ><i class="fa-solid fa-xmark"></i></button>
                    `;
                } else {
                    actions = ``;
                    shareMail = `
                    <i class="bi bi-envelope-fill text-warning fs-5"
                    role="button"
                    title="Resend Mail"
                    onclick="confirmResendMail('${item.email}','${item.id}')">
                    </i>`;
                }

                rows += `
                    <tr> 
                        <td onclick="view_visitor(${item.id})">${i++}</td>
                        <td onclick="view_visitor(${item.id})">${item.header_code}</td>
                        <td onclick="view_visitor(${item.id})">${item.department}</td>
                        <td onclick="view_visitor(${item.id})">${item.purpose}</td>
                        <td onclick="view_visitor(${item.id})">${item.description}</td>
                        <td onclick="view_visitor(${item.id})">${item.requested_date}</td>
                        <td onclick="view_visitor(${item.id})">${item.total_visitors ?? ''}</td>
                        <td onclick="view_visitor(${item.id})">${statusBadge}</td>
                        </a>
                        
                        <td style="text-align:center"><?php if($_SESSION['role_id'] == '1' || $_SESSION['role_id'] == '2'){ ?> 
                            ${actions} 
                            <?php } ?>
                        ${shareMail}
                        </td>
                        
                        <td style="text-align:center">
                        <button class="btn btn-info btn-sm " onclick="view_visitor(${item.id})" >
                        <i class="fa-solid fa-eye"></i>
                        </button>
                        </td>
                    </tr>
                `;
            });

            $("#visitorTable tbody").html(rows);
        }
    });
}

// View Visitor Details Section

function view_visitor(id){

    // alert(id);
    $.ajax({
        url: "<?= base_url('getvisitorrequestdata/') ?>" + id,
        type: "GET",
        dataType: "json",

        success: function (res) {

              console.log(res)
            if (res.status !== "success" || res.data.length === 0) {
                alert("No data found");
                return;
            }  

            // Fill header
            let actionButtons = "";
            let h = res.data[0];

            console.log(res)
           // console.log(h.status);
            
            if (h.status === "pending" ) {

                    actionButtons = `
                        <button class="btn btn-success btn-sm"
                            onclick="approvalProcess(${h.request_header_id}, 'approved', '${h.header_code}')">
                            <i class="fas fa-check-circle"></i> Approve
                        </button>

                        <button class="btn btn-danger btn-sm"
                            onclick="rejectComment(${h.request_header_id }, 'rejected', '${h.header_code}')">
                            <i class="fas fa-times-circle"></i> Reject
                        </button>
                    `;
                } 
        
            $("#actionBtns").html(actionButtons);
            $("#h_code").text(h.header_code);
            $("#h_requested_by").text(h.requested_by);
            $("#h_department").text(h.department);
            $("#h_email").text(h.email ?? "-");
            $("#h_company").text(h.company);
            $("#h_count").text(h.total_visitors);
            $("#h_requested_by").text(h.visitor_created_by_name);
            $("#h_purpose").text(h.purpose);
            $("#h_date").text(h.requested_date +" & "+ h.requested_time);
            $("#h_description").text(h.description);
            $("#remarkLablle").text(h.remarks);
            $("#referred_by").text(h.referred_by_name);
        
            
            $("#director").text(h.art_director);
            $("#production").text(h.productio);
            $("#contactPerson").text(h.contact_person);
            $("#typeOfRecce").text(h.recce_type);
            $("#shootingDate").text(h.shooting_date);
            $("#contactPersonEmail").text(h.mail_id);
            $("#contactPersonMobile").text(h.mobile);

        
            if (h.purpose === "Vendor") {

                $('#vendorData').show();
                $('#recceData').hide();

                $("#vendorCategory").text(h.v_category);
                $("#vendorStatus").text(h.v_status);
                $("#vendorCompany").text(h.v_company);
                $("#vendorLocation").text(h.v_location);
                $("#vendorContactPerson").text(h.v_contact_person);
                $("#vendorEmail").text(h.v_email);
                $("#vendorMobile").text(h.v_mobile);
            }


            if (h.purpose === "Recce") {

                $('#recceData').show();
                $('#vendorData').hide();
                $("#typeOfRecce").text(h.recce_type);
                $("#director").text(h.art_director);
                $("#production").text(h.company);
                $("#shootingDate").text(h.shooting_date);
                $("#contactPerson").text(h.contact_person);
                $("#contactPersonEmail").text(h.mail_id);
                $("#contactPersonMobile").text(h.mobile);
            }
  

            let htmlvisitorCard = '';

            res.data.forEach((v, index) => {
                let qrImg = v.qr_code 
                    ? `<img src="<?= base_url('public/uploads/qr_codes/') ?>${v.qr_code}" class="visitor-qr" style="height:50px;">`
                    : "--";

                let actionBtn = "";
                let meetStatus = "";
                if (v.securityCheckStatus == 0 && v.status == 'approved') {
                // Visitor not inside → Resend QR
                actionBtn = `<button class="btn btn-warning btn-md" onclick="resendqr('${v.v_code}')">
                       <i class="fas fa-paper-plane" title="Re-send Gate Pass"></i>
                    </button> 
                    <a href=" <?= base_url('public/uploads/gate_pass_pdf/GatePass_')?>${v.v_code}.pdf"
                    class="btn btn-success btn-md"
                    download>
                        <i class="fas fa-download" title="Download Gate Pass"></i>
                    </a>`;
                }

                if (v.securityCheckStatus == 1 && v.meeting_status == 0) {
                    // Visitor inside → Meeting pending (click to complete)
                    meetStatus = `
                        <span class="btn cursor-pointer meetingCmpleteBtn"
                            style="cursor:pointer "
                            onclick="markMeetingCompleted('${v.v_code}')">
                            ${v.purpose} <br>
                            Not Yet Completed
                        </span>
                    `;
                }
                

              
        window.BASE_URL = "<?= base_url() ?>";
          let imgPath =  window.BASE_URL + 'public/dist/User_Profile.png'

        if (v.v_phopto_path && v.v_phopto_path !== '') {
          imgPath = window.BASE_URL + 'public/uploads/visitor_photos/' + v.v_phopto_path;
        } else {
          imgPath = window.BASE_URL + 'public/dist/User_Profile.png'
        }

         htmlvisitorCard += `
                          <div class="card shadow-sm p-2 mb-2"  style="background-color:#f9feff">
                             <div class="row align-items-center">

                                <!-- VISITOR PHOTO (3 columns) -->
                                <div class="col-md-3 text-center mb-3 mb-md-0">
                                    <div class="photo-wrapper">
                                        <img id="visitorPhotoPreview"
                                            src="${imgPath}"
                                            alt="Visitor Photo" class="zoomable">
                                    </div>
                                </div>

                                <!-- VISITOR DETAILS (9 columns) -->
                                    <div class="col-md-9">
                                        <div class="row mt-2">

                                            <div class="col-md-4 col-6">
                                                <label class="fw-semibold">Visitor Code</label>
                                                <div id="v_code" class="cardData text-primary">${v.v_code}</div>
                                            </div>

                                            <div class="col-md-4 col-6">
                                                <label class="fw-semibold">Visitor Name</label>
                                                <div id="v_name" class="cardData">${v.visitor_name}</div>
                                            </div>

                                            <div class="col-md-4 col-6">
                                                <label class="fw-semibold">Visitor Phone</label>
                                                <div id="v_phone" class="cardData">${v.visitor_phone}</div>
                                            </div>

                                            <div class="col-md-4 col-6">
                                                <label class="fw-semibold">Visitor Email</label>
                                                <div id="v_email" class="cardData">${v.visitor_email}</div>
                                            </div>

                                            <div class="col-md-4 col-6">
                                                <label class="fw-semibold">Vehicle No</label>
                                                <div id="v_vehicle_no" class="cardData">${v.vehicle_no}</div>
                                            </div>

                                            <div class="col-md-4 col-6">
                                                <label class="fw-semibold">Vehicle Type</label>
                                                <div id="v_vehicle_type" class="cardData">${v.vehicle_type}</div>
                                            </div>

                                            <div class="col-md-4 col-6">
                                                <label class="fw-semibold">Vehicle Type</label>
                                                <div id="v_vehicle_type" class="cardData">${v.vehicle_type}</div>
                                            </div>

                                            <div class="col-md-4 col-6">
                                            <label class="fw-semibold">Actions</label>
                                            <div class="cardData"> ${actionBtn} ${meetStatus}</div>
                                          </div>
                                        </div>
                                    </div>
                                </div>



                                <!-- Status Tracker start -->
                                <div class="status-tracker" id="statusTraker">
                                    <div class="status-tracker-horizontal"
                                        style="--progress: ${
                                            v.securityCheckStatus >= 2 ? '100%' :
                                            v.meeting_status >= 1 ? '75%' :
                                            v.securityCheckStatus >= 1 ? '50%' :
                                            v.status == 'approved' ? '25%' : '0%'
                                             }; margin-top:-20px;">

                                        <div class="step ${v.status == 'approved' ? 'active' : ''}">
                                            <span class="circle">
                                                <i class="fa-solid fa-file-circle-check"></i>
                                            </span>
                                            <span class="label">Request Approved</span>
                                        </div>

                                        <div class="step ${v.securityCheckStatus >= 1 ? 'active' : ''}">
                                            <span class="circle">
                                                <i class="fa-solid fa-right-to-bracket"></i>
                                            </span>
                                            <span class="label">Check In</span>
                                            <span class="label"  style="margin-top:-6px;">${v.check_in ? v.check_in  : '' } </br> ${v.check_in_by ? v.check_in_by : ''}</span>

                                        </div>

                                        <div class="step ${v.meeting_status >= 1 ? 'active' : ''}">
                                            <span class="circle">
                                                <i class="fa-solid fa-people-arrows"></i>
                                            </span>
                                            <span class="label">Session Complete</span>
                                        </div>

                                        <div class="step ${v.securityCheckStatus >= 2 ? 'active' : ''}">
                                            <span class="circle">
                                                <i class="fa-solid fa-right-from-bracket"></i>
                                            </span>
                                            <span class="label">Check Out</span>
                                           <span class="label" style="margin-top:-6px;">${v.check_out ? v.check_out : '' }<br>${v.check_out_by ? v.check_out_by : '' }</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                         `;

             });

        
            $("#visitorCardsDetails").html(htmlvisitorCard);

            
            $("#visitorModal").modal("show");
        }
    });

}



function rejectComment(head_id, status, header_code, comment) {
    Swal.fire({
        title: "Reject Visitor Request",
        input: "text",
        inputLabel: "Enter rejection comment",
        inputPlaceholder: "Write your comment...",
        showCancelButton: true,
        confirmButtonText: "Submit",
    }).then((result) => {
        if (result.isConfirmed) {
            let comment = result.value; // user comment
            // Call your approval process with comment
            approvalProcess(head_id, status, header_code, comment);
        }
    });
}

function sendMail(head_id) {
    // alert(head_id);
    $.ajax({
        url: "<?= base_url('/send-email') ?>",
        type: "POST",
        data:{head_id : head_id },
        dataType: "json",
        success: function (mailRes) {
            console.log(mailRes);
        },
        error: function () {
            console.log("Email sending failed");
        }
    });
}

let approvalInProgress = false; // prevent Duble Click On approvel

function approvalProcess(head_id, status, header_code, comment) {

    if (approvalInProgress) {
        return; // prevent double call
    }

    approvalInProgress = true;

    $.ajax({
        url: "<?= base_url('/approvalprocess') ?>",
        type: "POST",
        data: { 
            head_id: head_id, 
            status: status, 
            header_code: header_code, 
            comment: comment 
        },
        dataType: "json",

        success: function (res) {
            if (res.status === "success") {

                Swal.fire({
                    icon: 'success',
                    title: 'Action Completed Successfully!',
                    showConfirmButton: false,
                    timer: 900
                });
                
                $("#visitorModal").modal("hide");
                sendMail(res.head_id);
                loadVisitorList();

            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Update Failed!',
                    text: res.message ?? "Please try again",
                    confirmButtonColor: '#d33'
                });
            }
        },

        complete: function () {
            approvalInProgress = false; //  unlock after request finishes
        },

        error: function () {
            approvalInProgress = false;
        }
    });
}


// Resend QR To Mail Function 
function resendqr(v_code) {

    $.ajax({
        url: "<?= base_url('send-email') ?>",
        type: "POST",
        data:{ re_send : v_code },
        dataType: "json",
        success: function(data) {

        }
    });

    Swal.fire({
        position: 'top-end',
        toast: true,
        icon: 'success',
        title: 'Mail Sent Successfully',
        showConfirmButton: false,
        timer: 2000
    });
}


function markMeetingCompleted(v_code) {
   
    Swal.fire({
        title: "Complete Meeting?",
        text: "Confirm that the visitor meeting is completed.",
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "Yes, Complete",
        cancelButtonText: "Cancel"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "<?= base_url('/visitor/complete-meeting') ?>",
                type: "POST",
                data: { v_code: v_code },
                dataType: "json",
                success: function (res) {
                    if (res.status === "success") {
                        Swal.fire({
                            icon: "success",
                            title: "Meeting Completed",
                            timer: 1500,
                            showConfirmButton: false
                        });

                        view_visitor(res.id);
                        loadVisitorList(); // refresh table
                    } else {
                        Swal.fire("Error", res.message, "error");
                    }
                }
            });
        }
    });
}



function confirmResendMail(mailId, header_id) {
    Swal.fire({
        title: "Resend Gate Pass..?",
        html: `
            <input id="resendEmail"
                   type="email"
                   class="swal2-input"
                   value="${mailId || ''}"
                   placeholder="Enter email address">
        `,
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "Yes, Send",
        cancelButtonText: "Cancel",
        confirmButtonColor: "#198754",
        cancelButtonColor: "#dc3545",
        focusConfirm: false,

        preConfirm: () => {
            const email = document.getElementById("resendEmail").value.trim();

            if (!email) {
                Swal.showValidationMessage("Email is required");
                return false;
            }

            // basic email validation
            if (!/^\S+@\S+\.\S+$/.test(email)) {
                Swal.showValidationMessage("Enter a valid email");
                return false;
            }

            return email;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            re_send_group_qr(result.value, header_id);
        }
    });
}


function re_send_group_qr(email, header_id) {

        Swal.fire({
            icon: 'success',
            title: 'Mail Sent',
            text: 'Group QR mail sent successfully'
        });

    $.ajax({
        url: "<?= base_url('mail/group-qr') ?>",
        type: "POST",
        data: {
            head_id: header_id,
            email: email,
            mailType : 're_send'

        },
        dataType: "json",

        success: function (res) {
            
            // if (res.status === 'success') {
              
            // } else {
            //     Swal.fire({
            //         icon: 'error',
            //         title: 'Failed',
            //         text: res.message || 'Something went wrong'
            //     });
            // }
        },

        error: function () {
           
            Swal.fire({
                icon: 'error',
                title: 'Server Error',
                text: 'Unable to send mail'
            });
        }
    });
}


//// focuss  the user image ///
const photo = document.getElementById("visitorPhotoPreview");

photo?.addEventListener("click", () => {
    photo.scrollIntoView({
        behavior: "smooth",
        block: "center"
    });
});


</script>


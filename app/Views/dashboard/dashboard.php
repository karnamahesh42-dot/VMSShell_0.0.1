
  <?= $this->include('/dashboard/layouts/sidebar') ?>
  <?= $this->include('/dashboard/layouts/navbar') ?>
        
      <!-- Main Content -->
      <main class="main-content" id="mainContent">
        <div class="container-fluid">
    <!-- Satart view Visitor Request Form Pop-Up  -->
                    <!-- Visitor Request Modal -->
<div class="modal fade" id="visitorModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content shadow-lg rounded-4 border-0">

            <!-- HEADER -->
            <div class="modal-header bg-primary text-white rounded-top-4">
                <h5 class="modal-title">Visitor Request Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <!-- BODY -->
            <div class="modal-body">

                <!-- HEADER INFO CARD -->
                <div class="card mb-4 border-0 shadow-sm rounded-4">
                    <div class="card-body visitor-card">
                       
                        <div class="row g-2">
                            <div class="col-md-3 col-sm-6 col-4">
                                <label class="fw-semibold">Request ID:</label>
                                <div id="h_code" class="text-primary" class="cardData"></div>
                            </div>

                            <div class="col-md-3 col-sm-6 col-4">
                                <label class="fw-semibold">Requested By:</label>
                                <div id="h_requested_by" class="cardData"></div>
                            </div>


                             <div class="col-md-3 col-sm-6 col-4">
                                <label class="fw-semibold">Referred By:</label>
                                <div id="referred_by" class="cardData"></div>
                            </div>
                              
                            <div class="col-md-3 col-sm-6 col-4">
                                <label class="fw-semibold">Company:</label>
                                <div id="h_company" class="cardData"></div>
                            </div>

                             <div class="col-md-3 col-sm-6 col-4">
                                <label class="fw-semibold">Department</label>
                                <div id="h_department" class="cardData"></div>
                            </div>

                             <div class="col-md-3 col-sm-6 col-4">
                                <label class="fw-semibold">Visitors Count </label>
                                <div id="h_count" class="cardData"></div>
                            </div>

                             <div class="col-md-3 col-sm-6 col-4">
                                <label class="fw-semibold">Email</label>
                                <div id="h_email" class="cardData"></div>
                            </div>

                            <div class="col-md-3 col-sm-6 col-4">
                                <label class="fw-semibold">Purpose </label>
                                <div id="h_purpose" class="cardData"></div>
                            </div>

                            <div class="col-md-3 col-sm-6 col-4">
                                <label class="fw-semibold">Visit Date & Time </label>
                                <div id="h_date" class="cardData"></div>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="fw-semibold">Description </label>
                                <div id="h_description" class="cardData"></div>
                            </div>

                            <div class="col-md-3 col-sm-6 col-6">
                            <label class="fw-semibold">Actions</label>
                            <?php if(session()->get('role_id') <= 2){ ?>
                            
                            <div id= "actionBtns"></div>
                            <?php } ?>
                            </div>

                              <!-- <div class="row" id="recceData" style="display:none">
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
                                        <label class="fw-semibold">Contact Person</label>
                                        <div id="contactPerson" class="cardData"></div>
                                    </div>

                                    <div class="col-md-3 col-sm-6 col-6">
                                        <label class="fw-semibold">Tentative Shooting Date</label>
                                         <div id="shootingDate" class="cardData"></div>
                                    </div>
                                </div> -->

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
             
                <div class="row g-4" id="visitorCardsContainer"></div>
            </div>
            <!-- FOOTER -->
            <div class="modal-footer justify-content-between">
                <button class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

          <!-- End view Visitor Request Form Pop-Up  -->

          <!-- ROW 1: Small Cards -->
            <section class="dash-row">
              <?php foreach($smallCards as $c): ?>
                  <div class="card-dash-sm <?= $c['color'] ?>">
                      <div class="left">
                          <div class="title"><?= esc($c['title']) ?></div>
                          <div class="value"><?= esc($c['value']) ?></div>
                      </div>
                      <div class="right">
                          <i class="fa <?= esc($c['icon']) ?> fa-2x"></i>
                      </div>
                  </div>
              <?php endforeach; ?>
            </section>
          <!-- ROW 2: Medium Cards -->
    <?php if (!in_array($_SESSION['role_id'], [3, 4])) { ?>
    <section class="dash-row row-medium mb-3">
        <?php foreach($meds as $m): ?>
        <div class="card-dash card-medium">
            <!-- Icon + Title side-by-side -->
            <div class="title-row">
                <i class="fa <?= esc($m['icon']) ?> icon"></i>
                <span class="title"><?= esc($m['title']) ?></span>
            </div>

            <!-- Big Count -->
            <div class="count-number"><?= esc($m['count']) ?></div>

            <!-- Small Description -->
            <div class="muted"><?= esc($m['desc']) ?></div>

        </div>
        <?php endforeach; ?>
    </section>
    <?php } ?>

        
        <section class="row row-large mb-3">
            <!-- ROW 3: Pending  List -->
            <?php if($_SESSION['role_id'] != 4){?>
                <div class="col-md-9"> 
                    <div class="card-dash card-large">
                    <div class="d-flex justify-content-between align-items-center mb-1 pending-header">
                        <div>
                            <h5 class="mb-0">Pending Approvals</h5>
                            <div class="muted">Requests that need action</div>
                        </div>
                        <div><a href="<?= base_url('visitorequestlist') ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-list"></i></a></div>
                    </div>
                        <ul class="pending-list mt-2">
                            <?php 
                            //   print_r($pendingList);
                              if (!empty($pendingList)): ?>
                                <?php foreach ($pendingList as $item): ?>
                                    <li style="cursor:pointer;">
                                        <!-- <li onclick="testamile(<?= $item['id'] ?>)" style="cursor:pointer;"> -->
                                        
                                        <div>
                                        
                                            <!-- Purpose + date + persons -->
                                             <span class="muted">
                                                 <!-- GV Code -->
                            
                                               <span style="font-weight: 600; font-size:16px;"><?= $item['purpose'] ?> - <?= $item['description'] ?> </span> • 
                                                <?= $item['header_code'] ?>  • 
                                                <?= $item['requested_date'] ?> <?= $item['requested_time'] ?> •
                                                <?= $item['total_visitors'] ?> Persons • <?= $item['visitor_names'] ?>  
                                             </span>
                                            <!-- <small class="muted">
                                                   

                                                
                                            </small> -->
                                        </div>

                                        <div class="text-end">
                                             <?php if (in_array($_SESSION['role_id'], [1, 2])) { ?>
                                                <!-- Accept -->
                                                <a href="#" class="btn btn-sm btn-outline-success" title="Accept"   onclick="approvalProcess(<?= $item['id'] ?>, 'approved', '<?= $item['header_code'] ?>')" >
                                                    <i class="fas fa-check"></i>
                                                </a>
                                                <!-- Reject -->
                                                <a href="#" class="btn btn-sm btn-outline-danger" title="Reject"   onclick="rejectComment(<?= $item['id'] ?>, 'rejected', '<?= $item['header_code'] ?>')">
                                                    <i class="fas fa-times"></i>
                                                </a>
                                                     <?php }?>
                                            <a href="#" class="btn btn-sm btn-outline-primary"  onclick="view_visitor(<?= $item['id'] ?>)" ><i class="fa fa-eye"></i></a>
                                            <!-- <span class="badge-pending"> Pending </span> -->
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <li>
                                    <div class="text-center text-muted w-100">No pending requests</div>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            <?php } ?>
                <!--  Pending List End  -->
                <!-- Recent Entries Example Table -->
                <?php if($_SESSION['role_id'] == 4){?>
                  <div class="col-md-9 mt-2"> 
                    <div class="card visitor-list-card" >
                            <div class="card-header text-white d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">
                                    <i class="fas fa-users"></i>  Today Visitor List
                                </h5>
                             <div><a href="<?= base_url('authorized_visitors_list') ?>" class="btn btn-light"><i class="bi bi-card-checklist"></i></a></div>
                            </div>
                        <div class="card-body p-2">
                              <div class="table-responsive" style="font-size: 14px;">
                            <table class="table mb-0  table-bordered">
                                <thead class="table-light" id="authorizedVisitorTablehead">
                                    <tr>
                                        <!-- <th>S.No</th> -->
                                        <!-- <th>Request Code</th> -->
                                        <!-- <th>V-Code</th> -->
                                        <th>Visit Date</th>
                                        <th>Company</th>
                                        <th>Department</th>
                                        <th>Referred</th>
                                        <th>Rquested By</th>
                                        <th>Visitor</th>
                                        <th>Contact</th>
                                        <th>Purpose</th>
                                        <th>QR Validity</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody id="todayVisitorsList" style="table-scroll "></tbody>
                            </table>
                        </div>
                        </div>
                      
                    </div>
                </div>
                <?php } ?>
                <!-- Recent Entries Example Table end -->
                <!-- Quick Links -->
                <div class="col-md-3"> 
                    <div class="card-dash card-large">
                    <h5 class="mb-1">Quick Links</h5>
                        <div class="title-underline">
                            <span></span>
                        </div>
                    <div class="quick-links">
                        <a href="<?= base_url('visitorequest') ?>"><i class="bi bi-person-plus me-2"></i> Create Visitor Request</a>
                        <a href="<?= base_url('group_visito_request') ?>"><i class="bi bi-people me-2"></i> Create Group Request</a>
                        <a href="<?= base_url('visitorequestlist') ?>"><i class="bi bi-people me-2"></i> Request Management</a>
                     <?php if (in_array($_SESSION['role_id'], [1,4])) { ?>
                        <a href="<?= base_url('authorized_visitors_list') ?>"><i class="bi bi-card-checklist me-2"></i>Authorized Visitors</a>
                     <?php } ?>
                     
                     <?php if (in_array($_SESSION['role_id'], [1])) { ?>
                        <a href="<?= base_url('userlist') ?>"><i class="bi bi-gear me-2"></i>User Management</a>
                     <?php } ?>
                      
                        <!-- <a href="<?= base_url('security_authorization') ?>"><i class="bi bi-shield-lock-fill me-2"></i> Security Authorization</a> -->
                      
                    </div>
                    </div>
                </div>
                <!-- Quick Links end -->
                <?php if(in_array($_SESSION['role_id'], [1,3,2])) { ?>

                <!--//////////////// Recent Otherisation List To the User ///////////////////  -->
               
                    <div class="col-md-12 mt-3 mb-5">

                      <!-- AUTHORIZED VISITOR LIST -->
                        <div class="card visitor-list-card">
                            <div class="card-header text-white d-flex">
                                <h5 class="mb-0">
                                    <i class="fas fa-users"></i> Recent Authorized Visitor List
                                </h5>
                                <!-- <span class="badge bg-light text-success fw-bold" id="authCount">0</span> -->
                            </div>
                         
                            <div class="card-body p-0">

                            <!-- NOTE SECTION -->
                            <div class="d-flex justify-content-end mb-2">
                                <small class="text-muted">
                                    <i class="bi bi-info-circle-fill text-primary"></i>
                                <strong>Note:</strong> Please click the <span class="text-primary fw-bold">blue button</span> to complete the Session.
                                </small>
                            </div>

                                <div class="table-responsive">                            
                                    <table class="table table-hover mb-0 table-bordered">
                                        <thead class="table-light" id="authorizedVisitorTablehead">
                                            <tr>
                                                <!-- <th>S.No</th> -->
                                                <!-- <th>Request Code</th> -->
                                                <!-- <th>V-Code</th> -->
                                               <th>Visit Date</th>
                                                <th>Company</th>
                                                <th>Department</th>
                                                <th>Referred</th>
                                                <th>Rquested By</th>
                                                <th>Visitor</th>
                                                <th>Contact</th>
                                                <th>Purpose</th>
                                                <th>QR Validity</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody id="authorizedVisitorTable" ></tbody>
                                    </table>
                                </div>
                            </div>
                            </div>
                        </div>
                        <!-- AUTHORIZED VISITOR LIST  Card End -->
                   </div>
                 <!--///////////////////// Recent Otherisation List To the User End  ///////////////  -->    
                <?php } ?>

          </section>
        </div>
      </main>

  <?= $this->include('/dashboard/layouts/footer') ?>

  <script>

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

            // console.log(h)
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
            $("#referred_by").text(h.referred_by_name);

         
            // if (h.purpose === "Recce") {
            // $('#recceData').show();   // Recce Details
            // $("#director").text(h.art_director);
            // $("#production").text(h.productio);
            // $("#contactPerson").text(h.contact_person);
            // $("#typeOfRecce").text(h.recce_type);
            // $("#shootingDate").text(h.shooting_date);
            // }

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



                           
            
            let cardsHtml = "";

            res.data.forEach(v => {

                let qrImg = v.qr_code 
                    ? `<?= base_url('public/uploads/qr_codes/') ?>${v.qr_code}`
                    : "";
                let resendButton = " <span>--</span>";

                
                if (v.status === "approved") {
                    resendButton = `
                        <button class="btn btn-warning btn-sm w-100"
                            onclick="resendqr('${v.v_code}')">
                            <i class="fas fa-paper-plane"></i> Re-send QR
                        </button>`;
                }

                cardsHtml += `
                <div class="card visitor-card p-3 p-md-4 col-12 col-sm-6 col-md-4 m-2">
                        <div class="row visitor-card-body">
                            <!-- Visitor Details -->
                            <div class="col-12 visitor-details">
                                <h5 class="visitor-name">
                                    <i class="fas fa-user text-primary me-2"></i> ${v.visitor_name}
                                </h5>
                                <p class="visitor-email">${v.visitor_email}</p>
                                <p class="visitor-code">Code: ${v.v_code}</p>
                                <p class="visitor-info"><b>Phone :</b> ${v.visitor_phone}</p>
                                <p class="visitor-info"><b>Vehicle Type :</b> ${v.vehicle_type}</p>
                                <p class="visitor-info"><b>ID Type :</b> ${v.proof_id_type}</p>
                                <p class="visitor-info"><b>ID Number :</b> ${v.proof_id_number}</p>
                                <p class="visitor-info"><b>Vehicle No :</b> ${v.vehicle_no}</p>
                            </div>
                            <!-- QR & Resend -->
                        </div>
                    </div>`;
            });

            $("#visitorCardsContainer").html(cardsHtml);
            $("#visitorModal").modal("show");
        }
    });
}


function rejectComment(head_id, status, header_code, comment) {

     $("#visitorModal").modal("hide");

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


/////////////////////////////////Approvel Process Start ////////////////////////////////////////////////////

let approvalInProgress = false;  // Prevent double click / double call

function approvalProcess(head_id, status, header_code, comment) {

    if (approvalInProgress) {
        return;
    }

    approvalInProgress = true; // lock

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
                    showConfirmButton: true,
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                         sendMail(res.head_id);
                         // loadAuthorizedVisitors();
                         location.reload();
                    }
                });

            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Update Failed!',
                    text: res.message ?? "Please try again",
                    confirmButtonColor: '#d33'
                });
            }
        },

        error: function () {
            Swal.fire({
                icon: 'error',
                title: 'Server Error!',
                text: 'Please try again later'
            });
        },

        complete: function () {
            approvalInProgress = false; // 🔓 unlock after request completes
        }
    });
}


function sendMail(head_id) {
        $.ajax({
        url: "<?= base_url('/send-email') ?>",
        type: "POST",
        data: { head_id: head_id },   // 🔥 single variable
        success: function(res) {
        console.log(res);
        }
        });
}
///////////////////////////////////////Approvel Process End //////////////////////////////////////////////////////

$(document).ready(function () {
    updateVisitorValidity();
    loadAuthorizedVisitors();
    todayVisitorsList()
});

function updateVisitorValidity() {
 $.ajax({
        url: "<?= base_url('/updateVisitorValidity') ?>",
        type: "POST",
        dataType: "json",
        success: function (res) {
            console.log(res);
        },
        error: function (xhr) {
            console.log(xhr);
        }
    });
}


function todayVisitorsList() {

    $.ajax({
        url: "<?= base_url('/security/todayVisitorListOfDashboard') ?>",
        type: "GET",
        dataType: "json",
        data: {
            company: $("#filterCompany").val(),
            department: $("#filterDepartment").val(),
            securityCheckStatus: $("#filterSecurity").val(),
            requestcode:  $("#requestcode").val(),
            v_code:   $("#f_v_code").val()
        },
        success: function(res) {

            // console.log(res[0].meeting_status);
            
            let tbody = $("#todayVisitorsList");
            tbody.empty();

            if (!res.length) {
                tbody.append(`
                    <tr>
                        <td colspan='13' class='text-center text-muted'> No authorized visitors scheduled for today.</td>
                    </tr>
                `);
                return;
            }

            res.forEach((v, index) => {
         
                let statusBadge = "";
                if (v.securityCheckStatus == 0) {
                    statusBadge = `
                        <span class="badge bg-secondary">
                            Not Entered
                        </span>
                    `;
                } else if (v.securityCheckStatus == 1 && v.meeting_status == 0) {

                           <?php if($_SESSION['role_id'] == '2' || $_SESSION['role_id'] == '1'){?>
                            statusBadge = ` <span class="btn meetingCmpleteBtn cursor-pointer" onclick="markMeetingCompleted('${v.v_code}')">
                                        Inside <br>
                                        Session Not Yet Completed <br>
                                    In: ${v.check_in_time ?? '-'} <br>
                                    Out: ${v.check_out_time ?? '-'} <br>
                                </span> `;
                             
                          <?php }else{ ?>
                                statusBadge = `<span class="badge bg-primary text-lite" >
                                        Inside <br>
                                        Session Not Yet Completed <br>
                                        In: ${v.check_in_time ?? '-'} <br>
                                        Out: ${v.check_out_time ?? '-'} <br>
                                      </span>`;
                          <?php } ?>
                } 
                else if (v.securityCheckStatus == 1 && v.meeting_status == 1){
                      statusBadge = `
                        <span class="badge bg-warning text-dark" >
                             Inside <br>
                             Session Completed <br>
                            In: ${v.check_in_time ?? '-'} <br>
                            Out: ${v.check_out_time ?? '-'} <br>
                          
                        </span>
                    `;
                }else {
                    statusBadge = `
                        <span class="badge bg-success">
                            Completed <br>
                            In: ${v.check_in_time ?? '-'} <br>
                            Out: ${v.check_out_time ?? '-'} <br>
                          
                        </span>
                    `;
                }
                let validityBadge = "";
           
                if (v.validity == 1) {
                     validityBadge = `<i class="bi bi-check-circle text-success" style="font-size: large; font-weight: bold;"></i>`;
                } 
                else {
                   validityBadge = `<i class="bi bi-x-circle text-danger" style="font-size: large; font-weight: bold;"></i>`;
                }


                tbody.append(`
                    <tr>
                        <td>${v.visit_date}</td>
                        <td>${v.company}</td>
                        <td>${v.department_name}</td>
                        <td>${v.referred_by_name}</td>
                        <td>${v.created_by_name}</td>
                        <td>${v.visitor_name}</td>
                        <td>${v.visitor_phone}</td>
                        <td>${v.purpose}</td>
                        <td>${validityBadge}</td>
                        <td>${statusBadge}</td>
                    </tr>
                `);
            });
        }
    });
}







function loadAuthorizedVisitors() {

    $.ajax({
        url: "<?= base_url('/security/authorized_visitors_list_data') ?>",
        type: "GET",
        dataType: "json",
        data: {
            company: $("#filterCompany").val(),
            department: $("#filterDepartment").val(),
            securityCheckStatus: $("#filterSecurity").val(),
            requestcode:  $("#requestcode").val(),
            v_code:   $("#f_v_code").val()
        },
        success: function(res) {

            // console.log(res[0].meeting_status);
            
            let tbody = $("#authorizedVisitorTable");
            tbody.empty();

            if (!res.length) {
                tbody.append(`
                    <tr>
                        <td colspan='13' class='text-center text-muted'>No authorized visitors found</td>
                    </tr>
                `);
                return;
            }

            res.forEach((v, index) => {
         
                let statusBadge = "";
                if (v.securityCheckStatus == 0) {
                    statusBadge = `
                        <span class="badge bg-secondary">
                            Not Entered
                        </span>
                    `;
                } else if (v.securityCheckStatus == 1 && v.meeting_status == 0) {

                           <?php if($_SESSION['role_id'] == '2' || $_SESSION['role_id'] == '1'){?>
                            statusBadge = ` <span class="btn meetingCmpleteBtn cursor-pointer" onclick="markMeetingCompleted('${v.v_code}')">
                                        Inside <br>
                                        ${v.purpose} Not Yet Completed <br>
                                    In: ${v.check_in_time ?? '-'} <br>
                                    Out: ${v.check_out_time ?? '-'} <br>
                                </span> `;
                             
                          <?php }else{ ?>
                                statusBadge = `<span class="badge bg-primary text-lite" >
                                        Inside <br>
                                        ${v.purpose} Not Yet Completed <br>
                                        In: ${v.check_in_time ?? '-'} <br>
                                        Out: ${v.check_out_time ?? '-'} <br>
                                      </span>`;
                          <?php } ?>
                } 
                else if (v.securityCheckStatus == 1 && v.meeting_status == 1){
                      statusBadge = `
                        <span class="badge bg-warning text-dark" >
                             Inside <br>
                ${v.purpose} Completed <br>
                            In: ${v.check_in_time ?? '-'} <br>
                            Out: ${v.check_out_time ?? '-'} <br>
                          
                        </span>
                    `;
                }else {
                    statusBadge = `
                        <span class="badge bg-success">
                            Completed <br>
                            In: ${v.check_in_time ?? '-'} <br>
                            Out: ${v.check_out_time ?? '-'} <br>
                          
                        </span>
                    `;
                }
                let validityBadge = "";
           
                if (v.validity == 1) {
                     validityBadge = `<i class="bi bi-check-circle text-success" style="font-size: large; font-weight: bold;"></i>`;
                } 
                else {
                   validityBadge = `<i class="bi bi-x-circle text-danger" style="font-size: large; font-weight: bold;"></i>`;
                }


                tbody.append(`
                    <tr>
                        <td>${v.visit_date}</td>
                        <td>${v.company}</td>
                        <td>${v.department_name}</td>
                        <td>${v.referred_by_name}</td>
                        <td>${v.created_by_name}</td>
                        <td>${v.visitor_name}</td>
                        <td>${v.visitor_phone}</td>
                        <td>${v.purpose}</td>
                        <td>${validityBadge}</td>
                        <td>${statusBadge}</td>
                    </tr>
                `);
            });
        }
    });
}


function markMeetingCompleted(v_code) {
    Swal.fire({
        title: "Complete Session?",
        text: "Confirm that the visitor Session is completed.",
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
                            title: "Session Completed",
                            timer: 1500,
                            showConfirmButton: false
                        });
                        location.reload();
                    
                    } else {
                        Swal.fire("Error", res.message, "error");
                    }
                }
            });
        }
    });
}





  </script>
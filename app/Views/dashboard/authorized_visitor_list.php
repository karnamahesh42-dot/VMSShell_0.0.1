<?= $this->include('/dashboard/layouts/sidebar') ?>
  <?= $this->include('/dashboard/layouts/navbar') ?>

   <main class="main-content" id="mainContent">
    <div class="container-fluid">
 

  <!-- Full Screen QR Scanner -->
<div id="qrScannerOverlay">
    <div id="qr-reader"></div>

    <button id="closeScanner" class="btn btn-danger">
        ✕ Close
    </button>
</div>

<!---- Camera PopUp Start --->


    <!-- view Pop-up Form start  -->
    <div class="modal fade" id="visitorModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content shadow-lg rounded-4 border-0">

                <!-- HEADER -->
                <div class="modal-header bg-primary text-white rounded-top-4">
                    <h5 class="modal-title">Visitor Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <!-- BODY -->
                <div class="modal-body">

                    <!-- HEADER INFO CARD -->
                    <div class="card mb-4 border-0 shadow-sm rounded-4">
                        <div class="card-body visitor-card">
                            <div class="row g-2">

                                <div class="col-md-3 col-6">
                                    <label class="fw-semibold">Request Code:</label>
                                    <div id="h_code" class="cardData text-primary"></div>
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
                                    <label class="fw-semibold">Department:</label>
                                    <div id="h_department" class="cardData"></div>
                                </div>

                                <div class="col-md-3 col-6">
                                    <label class="fw-semibold">Visitors Count:</label>
                                    <div id="h_count" class="cardData"></div>
                                </div>

                                <div class="col-md-3 col-6">
                                    <label class="fw-semibold">Email:</label>
                                    <div id="h_email" class="cardData"></div>
                                </div>

                                <div class="col-md-3 col-6">
                                    <label class="fw-semibold">Purpose:</label>
                                    <div id="h_purpose" class="cardData"></div>
                                </div>

                                <div class="col-md-3 col-6">
                                    <label class="fw-semibold">Visit Date & Time:</label>
                                    <div id="h_date" class="cardData"></div>
                                </div>

                                <div class="col-md-6">
                                    <label class="fw-semibold">Description:</label>
                                    <div id="h_description" class="cardData"></div>
                                </div>

                                
                                <div class="col-md-3 col-6">
                                    <label class="fw-semibold">Actions:</label>
                                   
                                    <div id="actionBtns"></div>
                                   
                                </div>

   
                                <!-- SINGLE VISITOR DETAILS CARD -->
                            
                            <!-- Status Tracker start -->
                            <div class="status-tracker" id="statusTraker">
                               
                            </div>
                            <!-- Status Tracker End -->
                                <hr>
                                <h5 class="fw-bold text-primary">Visitor Details</h5>
                                    <div class="card shadow-sm p-3">
                                        <div class="row align-items-center">

                                            <!-- VISITOR PHOTO (3 columns) -->
                                            <div class="col-md-3 text-center mb-3 mb-md-0">
                                                <div class="photo-wrapper">
                                                    <img id="visitorPhotoPreview"
                                                        src="<?= base_url('public/dist/User_Profile.png') ?>"
                                                        alt="Visitor Photo">

                                                    <div class="camera-upload heartbeat" id="camIcon"
                                                        onclick="document.getElementById('visitorPhoto').click()">
                                                        <i class="fa fa-camera"></i>
                                                    </div>
                                                </div>

                                                <input type="file"
                                                    id="visitorPhoto"
                                                    accept="image/*"
                                                    capture="environment"
                                                    style="display:none"
                                                    onchange="uploadVisitorPhoto(this)">

                                        <div class="photo-loader text-center" style="display:none;">
                                        <div class="spinner-border text-primary" role="status"></div>
                                        <div class="mt-2">Uploading photo...</div>
                                        </div>
                                        </div>

                                            <!-- VISITOR DETAILS (9 columns) -->
                                            <div class="col-md-9">
                                                <div class="row mt-2">

                                                    <div class="col-md-4 col-6">
                                                        <label class="fw-semibold">Visitor Code:</label>
                                                        <div id="v_code" class="cardData text-primary"></div>
                                                    </div>

                                                    <div class="col-md-4 col-6">
                                                        <label class="fw-semibold">Visitor Name:</label>
                                                        <div id="v_name" class="cardData"></div>
                                                    </div>

                                                    <div class="col-md-4 col-6">
                                                        <label class="fw-semibold">Visitor Phone:</label>
                                                        <div id="v_phone" class="cardData"></div>
                                                    </div>

                                                    <div class="col-md-4 col-6">
                                                        <label class="fw-semibold">Visitor Email:</label>
                                                        <div id="v_email" class="cardData"></div>
                                                    </div>

                                                    <div class="col-md-4 col-6">
                                                        <label class="fw-semibold">Vehicle No:</label>
                                                        <div id="v_vehicle_no" class="cardData"></div>
                                                    </div>

                                                    <div class="col-md-4 col-6">
                                                        <label class="fw-semibold">Vehicle Type:</label>
                                                        <div id="v_vehicle_type" class="cardData"></div>
                                                    </div>

                                                    <!-- ADD 3 MORE IF REQUIRED -->
                                                    <!-- <div class="col-md-4 col-6">
                                                        <label class="fw-semibold">Purpose:</label>
                                                        <div id="v_purpose" class="cardData"></div>
                                                    </div>

                                                    <div class="col-md-4 col-6">
                                                        <label class="fw-semibold">Host Name:</label>
                                                        <div id="v_host" class="cardData"></div>
                                                    </div>

                                                    <div class="col-md-4 col-6">
                                                        <label class="fw-semibold">Check-In Time:</label>
                                                        <div id="v_checkin" class="cardData"></div>
                                                    </div> -->

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                    <!-- VISITOR CARDS -->
                    <div class="row g-4" id="visitorCardsContainer">
                     

                    </div>
                </div>

                <!-- FOOTER -->
                <div class="modal-footer justify-content-between">
                    <button class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>

    <!-- view Pop-up Form End   -->
 
             <div class="row d-flex justify-content-center">
                <div class="col-md-12">

                  <!-- AUTHORIZED VISITOR LIST -->
                    <div class="card visitor-list-card">
                        <div class="card-header text-white d-flex">
                            <h5 class="mb-0">
                                <i class="fas fa-users"></i> Authorized Visitor List
                            </h5>
                            <!-- <span class="badge bg-light text-success fw-bold" id="authCount">0</span> -->
                        </div>

                        <div class="card-body px-2">
                            <div class="card mb-3">
                              
                            <div class="card-body" >
                                <div class="row g-2">
                                    <div class="col-md-2">
                                        <label class="form-label">Request Code</label>
                                    <input type ='text' id="requestcode" placeholder="Enter GV-Code" class="form-control">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">V-Code</label>
                                        <input type ='text' id="f_v_code" placeholder="Enter V-Code" class="form-control">
                                    </div>

                                    <div class="col-md-2">
                                        <label class="form-label">Company</label>
                                        <!-- <select id="filterCompany" class="form-select">
                                            <option value="">All</option>
                                            <option value="UKMPL">UKMPL</option>
                                            <option value="DHPL">DHPL</option>
                                            <option value="ETPL">ETPL</option>
                                        </select> -->

                                        <select name="filterCompany" id="filterCompany" class="form-control" >
                                            <option value="">--Select Department--</option>
                                            <?php foreach ($companies as $comp): ?>
                                                <option value="<?= $comp['company_name'] ?>"><?= esc($comp['company_name']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <label class="form-label">Department</label>
                                        <select id="filterDepartment" class="form-select">
                                            <option value="">All</option>
                                            <?php foreach ($departments as $dept): ?>
                                                <option value="<?= $dept['department_name'] ?>">
                                                    <?= $dept['department_name'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <label class="form-label">Security Status</label>
                                        <select id="filterSecurity" class="form-select">
                                            <option value="">All</option>
                                            <option value="0">Not Entered</option>
                                            <option value="1">Inside</option>
                                            <option value="2">Completed</option>
                                        </select>
                                    </div>

                                    <div class="col-md-2 d-flex align-items-end gap-1">

                                        <!-- Search Button -->
                                        <button class="btn btn-primary" onclick="loadAuthorizedVisitors()" title="Search">
                                            <i class="fas fa-search"></i>
                                        </button>

                                        <!-- Reset Button -->
                                        <button class="btn btn-secondary" onclick="resetFilters()" title="Reset Filters">
                                            <i class="fas fa-sync-alt"></i>
                                        </button>

                                        <!-- Scan Button -->
                                        <!-- <button class="btn btn-success active" id="scanBtn" onclick="toggleScan()" title="Scan">
                                                <i class="fas fa-qrcode"></i>
                                        </button> -->

                                            <!-- Mobile Scan Button
                                        <button class="btn btn-success" id="scanBtnMbl">
                                            <i class="fas fa-qrcode"></i>
                                        </button> -->

                                        <!--///////////// Mobile Scan Button ////////////-->
                                        <button class="btn btn-success" id="scanBtnMblPic">
                                            <i class="fas fa-qrcode"></i>
                                        </button>
                                        <input type="file"
                                            id="qrImageInput"
                                            accept="image/*"
                                            capture="environment" hidden> 
                                        <div id="temp-reader" hidden></div>

                                     
                                        <!--////////// Hidden File Input /////////////-->


                                        <?php if(in_array($_SESSION['role_id'],[1])){?>
                                            <!-- Export Button -->
                                            <button class="btn btn-success" onclick="exportTable()" title="Export Data">
                                                <i class="fas fa-file-export"></i>
                                            </button>
                                        <?php }?>
                                    </div>
                                </div>
                            </div>

                         </div>
                         <div class="card-body p-0">
                            <div class="table-responsive">                            
                                <table class="table table-hover mb-0  table-bordered">
                                    <thead class="table-light" id="authorizedVisitorTablehead">
                                        <tr>
                                            <!-- <th>S.No</th> -->
                                            <!-- <th>Request Code</th> -->
                                            <!-- <th>V-Code</th> -->
                                            <th>Visit Date</th>
                                            <th>Company</th>
                                            <th>Department</th>
                                            <th>Referred</th>
                                            <th>Requested By</th>
                                            <th>Visitor</th>
                                            <th>Contact</th>
                                            <th>Purpose</th>
                                            <th>Check-In By</th>
                                            <!-- <th>Check-Out By</th> -->
                                            <th>Validity</th>
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
            </div>
        </div>
    </main>
<?= $this->include('/dashboard/layouts/footer') ?>
<script src="https://unpkg.com/html5-qrcode"></script>

<!-- JS -->
 <script>
$(document).ready(function () {
    loadAuthorizedVisitors();
    // $('#f_v_code').focus();
})

// document.getElementById('f_v_code').addEventListener('input', function () {
  
//     const vCode = this.value.trim();
//     // const scanBtn = document.getElementById('scanBtn');
//     // // Conditions:
//     // if (scanBtn.classList.contains('active') && vCode.length === 7) {
//     // }

//       if (vCode.length === 7) {
//          processSecurity(vCode);
//          $('#f_v_code').val('');
//       }
// });



function processSecurity(vCode) {
    $.ajax({
        url: "<?= base_url('/security/securityAction') ?>",
        type: "POST",
        data: { v_code: vCode },
        success: function (res) {

            if (res.status === 'checkin_success') {
                Swal.fire("Success", "Visitor Checked In", "success");
                openVisitorPopup(res.v_code);
            }
            else if (res.status === 'checkout_success') {
                Swal.fire("Success", "Visitor Checked Out", "success");
                openVisitorPopup(res.v_code);
            }
            else if (res.status === 'meeting_not_completed') {
                let hostDetails = `
                <div style="text-align:center; font-size:14px; line-height:1.6;">
                    <div style="margin-bottom:1px;">
                        <i class="fa fa-user" style="color:#0d6efd; margin-right:6px;"></i>
                        ${res.name ?? '--'}
                    </div>
                    <div style="margin-bottom:1px;">
                        <i class="fa fa-building" style="color:#0d6efd; margin-right:6px;"></i>
                        ${res.company_name ?? '--'}
                    </div>
                    <div style="margin-bottom:1px;">
                        <i class="fa fa-envelope" style="color:#0d6efd; margin-right:6px;"></i>
                       ${res.email ?? '--'}
                    </div>
                </div>
                `;

                Swal.fire({
                    icon: 'warning',
                    title: 'Action Restricted',
                    html: `
                        <p><b class="text-primary">${res.purpose ?? '--'}</b> has not been completed by the host.</p>
                        <p><b>Please contact the host to complete the session.</b></p>
                        <hr>
                        ${hostDetails}
                    `,
                    confirmButtonText: 'OK'
                });

            }
            else if (res.status === 'invalid') {
                Swal.fire("Denied", res.message, "error");
            }
            else if (res.status === 'already_used') {
                Swal.fire("Warning", "This visitor code has already been used", "warning");
            }
            else {
                Swal.fire("Error", res.message || "Something went wrong", "error");
            }
           
            // $("#visitorModal").modal("hide");
            loadAuthorizedVisitors();
        }
    });
}

////////////////////////////////Mobile Scane Start //////////////////////////////////////////////

let html5QrCode = null;

document.getElementById("scanBtnMblPic").addEventListener("click", () => {

    // show scanner
    document.getElementById("qrScannerOverlay").style.display = "block";

    html5QrCode = new Html5Qrcode("qr-reader");

    html5QrCode.start(
        { facingMode: "environment" }, // rear camera
        {
            fps: 10,
            qrbox: { width: 280, height: 280 }
        },
        (decodedText) => {

            // stop camera & hide
            html5QrCode.stop().then(() => {
                document.getElementById("qrScannerOverlay").style.display = "none";
            });

            processSecurity(decodedText); // your existing function
        }
    ).catch(err => {
        Swal.fire("Error", "Camera permission denied", "error");
    });
});

// close manually
document.getElementById("closeScanner").addEventListener("click", () => {
    if (html5QrCode) {
        html5QrCode.stop().then(() => {
            document.getElementById("qrScannerOverlay").style.display = "none";
        });
    }
});

   
// const scanBtn = document.getElementById("scanBtnMblPic");
// const fileInput = document.getElementById("qrImageInput");

// scanBtn.addEventListener("click", () => {
//     fileInput.value = "";
//     fileInput.click();
// });

// fileInput.addEventListener("change", async () => {
//     const file = fileInput.files[0];
//     if (!file) return;

//     try {
//         const processedFile = await preprocessImage(file);

//         const html5QrCode = new Html5Qrcode("temp-reader");

//         html5QrCode.scanFile(processedFile, true)
//             .then(decodedText => {
//                 processSecurity(decodedText);
//             })
//             .catch(() => {
//                 Swal.fire(
//                     "Warning",
//                     "No QR code found in image, Capture Proper QR",
//                     "warning"
//                 );
//             });

//     } catch (err) {
//         Swal.fire("Error", "Image processing failed", "error");
//     }
// });

/*  FIX IMAGE FOR MOBILE CAMERA */

function preprocessImage(file) {
    return new Promise((resolve, reject) => {
        const img = new Image();
        const reader = new FileReader();

        reader.onload = e => {
            img.src = e.target.result;
        };

        img.onload = () => {
            const canvas = document.createElement("canvas");
            const ctx = canvas.getContext("2d");

            // Resize (very important)
            const maxSize = 1200;
            let width = img.width;
            let height = img.height;

            if (width > maxSize || height > maxSize) {
                if (width > height) {
                    height = height * maxSize / width;
                    width = maxSize;
                } else {
                    width = width * maxSize / height;
                    height = maxSize;
                }
            }

            canvas.width = width;
            canvas.height = height;

            ctx.drawImage(img, 0, 0, width, height);

            canvas.toBlob(blob => {
                if (!blob) return reject();

                const fixedFile = new File([blob], "qr.jpg", { type: "image/jpeg" });
                resolve(fixedFile);
            }, "image/jpeg", 0.9);
        };

        reader.onerror = reject;
        reader.readAsDataURL(file);
    });
}

/////////////////////////////////////////End Mobile Scane/////////////////////////////////////////////////////////



////////////////////////// Auto Scan Logic End ////////////////////////////////////

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
                        <span class="badge bg-secondary p-2">
                            Not Entered
                        </span>
                    `;
                } else if (v.securityCheckStatus == 1 && v.meeting_status == 0) {
                    statusBadge = `
                        <span class="badge bg-primary warning text-lite p-2">
                             Inside <br>
                ${v.purpose} Not Yet Completed <br>
                            In: ${v.check_in_time ?? '-'} <br>
                        </span>
                    `;
                } 
                else if (v.securityCheckStatus == 1 && v.meeting_status == 1){
                      statusBadge = `
                        <span class="badge bg-warning text-dark p-2">
                             Inside <br>
                               ${v.purpose} Completed <br>
                            In: ${v.check_in_time ?? '-'} <br>
                        </span>
                    `;
                }else {
                    statusBadge = `
                        <span class="badge bg-success p-2" >
                            Completed <br>
                            In: ${v.check_in_time ?? '-'} <br>
                            Out: ${v.check_out_time ?? '-'} <br>
                          
                        </span>
                    `;
                }

                let validityBadge = "";
                if (v.validity == 1) {
                     validityBadge = `<i class="bi bi-check-circle text-success" style="font-size: 20px; font-weight: bold;"></i>`;
                } 
                else {
                   validityBadge = `<i class="bi bi-x-circle text-danger " style="font-size: 20px; font-weight: bold;"></i>`;
                }

                tbody.append(`
                    <tr onclick="openVisitorPopup('${v.v_code}')">
                        <td>${v.visit_date}</td>
                        <td>${v.company}</td>
                        <td>${v.department_name}</td>
                        <td>${v.referred_by_name}</td>
                        <td>${v.created_by_name}</td>
                        <td>${v.visitor_name}</td>
                        <td>${v.visitor_phone}</td>
                        <td>${v.purpose}</td>
                        <td>${v.check_in_by ? v.check_in_by : '--'}</td>   
                        <td>${validityBadge}</td>
                        <td>${statusBadge}</td>
                    </tr>
                `);
            });
        }
    });
}


function resetFilters() {
    $("#filterCompany").val('');
    $("#filterDepartment").val('');
    $("#filterSecurity").val('');
    $("#requestcode").val('');
    $("#f_v_code").val('');
    loadAuthorizedVisitors();
}

function exportTable() {
    let rows = [];
      
     $("#authorizedVisitorTablehead tr").each(function () {
        let cols = [];
        $(this).find("th").each(function () {
            cols.push($(this).text().trim());
        });
        if(cols.length > 0) rows.push(cols.join(","));
    });

    $("#authorizedVisitorTable tr").each(function () {
        let cols = [];
        $(this).find("td").each(function () {
            cols.push($(this).text().trim());
        });
        if(cols.length > 0) rows.push(cols.join(","));
    });

    let csvContent = "data:text/csv;charset=utf-8, " 
                     + rows.join("\n");
    // console.log(csvContent);
    let a = document.createElement("a");
    a.href = encodeURI(csvContent);
    a.download = "authorized_visitors.csv";
    a.click();
}

$('#f_v_code').on('keypress', function (e) {
    if (e.which === 13) { // Enter key
        e.preventDefault();

        let v_code = $(this).val().trim();
        if (v_code === '') {
            alert('Please enter V-Code');
            return;
        }
        openVisitorPopup(v_code);
    }
});


function openVisitorPopup(v_code){

    $.ajax({
        url: "<?= base_url('/get-visitor-details') ?>",
        type: "POST",
        data: { v_code: v_code },
        dataType: "json",
        success: function (d) {
             //console.log(d)
        if(d.status == 'success'){
                    // HEADER FIELDS
                    $("#h_code").text(d.data.header_code);
                    $("#h_requested_by").text(d.data.created_by_name);
                    $("#referred_by").text(d.data.referred_by_name ?? "-");
                    $("#h_company").text(d.data.company);
                    $("#h_department").text(d.data.department_name);
                    $("#h_count").text(d.data.total_visitors);
                    $("#h_email").text(d.data.visitor_email);
                    $("#h_purpose").text(d.data.purpose);
                    $("#h_date").text(d.data.visit_date + " " + d.data.visit_time);
                    $("#h_description").text(d.data.description);
                    $("#v_name").text(d.data.visitor_name);
                    $("#v_phone").text(d.data.visitor_phone);
                    $("#v_email").text(d.data.visitor_email);
                    $("#v_vehicle_no").text(d.data.vehicle_no);
                    $("#v_vehicle_type").text(d.data.vehicle_type);
                    $("#v_visit_date").text(d.data.visit_date);
                    $("#v_visit_time").text(d.data.visit_time);
                    $("#v_code").text(d.data.v_code);

                    // console.log(d.data.v_phopto_path);
                    window.BASE_URL = "<?= base_url() ?>";
                    if (d.data.v_phopto_path && d.data.v_phopto_path !== '') {
                        const imgPath =
                        window.BASE_URL +
                        'public/uploads/visitor_photos/' +
                        d.data.v_phopto_path;
                    $('#visitorPhotoPreview').attr('src', imgPath);
                    $('.camera-upload').hide();

                    } else {

                        $('#visitorPhotoPreview').attr(
                            'src',
                            window.BASE_URL + 'public/dist/User_Profile.png'
                        );

                        $('.camera-upload').show();
                    }

                    let statusTrackerData ="";
                        statusTrackerData = `
                        <div class="status-tracker-horizontal"
                            style="--progress: ${
                                d.data.securityCheckStatus >= 2 ? '100%' :
                                d.data.meeting_status >= 1 ? '75%' :
                                d.data.securityCheckStatus >= 1 ? '50%' :
                                d.data.status >= 'approved' ? '25%' : '0%'
                            };">

                            <div class="step ${d.data.status >= 'approved' ? 'active' : ''}">
                                <span class="circle">
                                    <i class="fa-solid fa-file-circle-check"></i>
                                </span>
                                <span class="label">Request Approved</span>
                            </div>

                            <div class="step ${d.data.securityCheckStatus >= 1 ? 'active' : ''}">
                                <span class="circle">
                                    <i class="fa-solid fa-right-to-bracket"></i>
                                </span>
                                <span class="label">Check In</span>
                            </div>

                            <div class="step ${d.data.meeting_status >= 1 ? 'active' : ''}">
                                <span class="circle">
                                    <i class="fa-solid fa-people-arrows"></i>
                                </span>
                                <span class="label">Session Complete</span>
                            </div>

                            <div class="step ${d.data.securityCheckStatus >= 2 ? 'active' : ''}">
                                <span class="circle">
                                    <i class="fa-solid fa-right-from-bracket"></i>
                                </span>
                                <span class="label">Check Out</span>
                            </div>

                        </div>`;

                    $("#statusTraker").html(statusTrackerData);

                let actionHTML = "";

                if (d.data.securityCheckStatus == 0) {
                    // NOT ENTERED → Allow Entry
                    actionHTML = `
                        <button class="btn btn-success btn-sm" onclick="processSecurity('${d.data.v_code}')">
                            <i class="bi bi-door-open"></i> Allow Entry
                        </button>
                    `;
                }
                else if (d.data.securityCheckStatus == 1) {
                    // INSIDE → Mark Exit
                    actionHTML = `
                        <button class="btn btn-warning btn-sm" onclick="processSecurity('${d.data.v_code}')" >
                            <i class="bi bi-box-arrow-right"></i> Mark Exit
                        </button>
                    `;
                }
                else {
                    // COMPLETED → No buttons
                    actionHTML = `<span class="badge bg-success"><i class="bi bi-check-circle"></i> Completed</span>`;
                }

                $("#actionBtns").html(actionHTML);
                            // Open Modal
                            $("#visitorModal").modal("show");
                
                }else{

                 Swal.fire("Error", d.message, "error");
                }
            }
        });
}



function uploadVisitorPhoto(input) {

    if (!input.files || !input.files[0]) return;

    const file = input.files[0];

    if (!file.type.startsWith('image/')) {
        Swal.fire("Invalid File", "Please select an image", "warning");
        return;
    }

    //  Hide camera icon
    $('.camera-upload').fadeOut(300);

    //  Show loader
    $('.photo-loader').fadeIn(200);

    //  Preview instantly
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('visitorPhotoPreview').src = e.target.result;
    };
    reader.readAsDataURL(file);

    //  Prepare upload
    const formData = new FormData();
    formData.append('photo', file);
    formData.append('v_code', document.getElementById('v_code').innerText);

    fetch("<?= base_url('visitor/uploadPhoto') ?>", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(res => {

        //  Hide loader
        $('.photo-loader').fadeOut(200);

        if (res.status === 'success') {

            $('#visitorPhotoPreview').attr('src', res.path);

            // Hide camera permanently after success
            $('.camera-upload').fadeOut(300);

        } else {

            //  Restore camera on error
            $('.camera-upload').fadeIn(300);

            Swal.fire("Error", res.message, "error");
        }
    })
    .catch(() => {

        //  Hide loader & restore camera
        $('.photo-loader').fadeOut(200);
        $('.camera-upload').fadeIn(300);

        Swal.fire("Error", "Upload failed", "error");
    });
}

</script>

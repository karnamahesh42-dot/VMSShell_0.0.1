<?= $this->include('/dashboard/layouts/sidebar') ?>
<?= $this->include('/dashboard/layouts/navbar') ?>

<main class="main-content" id="mainContent">
    <div class="container-fluid">

        <div class="row d-flex justify-content-center">
            <div class="col-md-11">
                <div class="card card-primary">
                    <div class="card-header py-2">
                        <h5 class="m-0">Visitor Request</h5>
                    </div>

                    <form id="visitorForm" enctype="multipart/form-data">
                        <div class="card-body">

                            <!-- Visit Info -->
                            <h5 class="text-primary font-weight-bold">Visit Information</h5>
                            <div class="row">

                                <div class="col-md-3 mb-2">
                                    <label class="form-label">Purpose</label>
                                    <select name="purpose" class="form-control select2" id="purpose" onchange="purposeEvent()" required >
                                        <option value="">-- Select Purpose --</option>
                                        <?php foreach ($purposes as $p): ?>
                                            <option value="<?= esc($p['purpose_name']) ?>"
                                                <?= (old('purpose') == $p['purpose_name']) ? 'selected' : '' ?>>
                                                <?= esc($p['purpose_name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                                  
                                <div class="col-md-3 mb-2">
                                    <label class="form-label">Referred By</label>
                                        
                                        <?php if($_SESSION['role_id'] == 5){?>
                                            <select name="referred_by" class="form-select" required title="Select Referred By">
                                                        <option value="<?= session()->get('user_id'); ?>">
                                                        <?= session()->get('name'); ?>
                                                        </option>
                                            </select>  

                                         <?php } else{ ?>                                    

                                            <select name="referred_by" class="form-select" required title="Select Referred By">
                                                <!-- <option value="">--Select Admin --</option> -->
                                                <?php if (!empty($admins)) : ?>
                                                    <?php foreach ($admins as $admin) : ?>
                                                        <option value="<?= $admin['id']; ?>">
                                                            <?= $admin['name']; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </select>   
                                        <?php }  ?>
                                    </div>
                                        
                                    <div class="col-md-3 mb-2">
                                        <label class="form-label">Date of Visit</label>
                                        <input type="date" name="visit_date" class="form-control" required>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        <label class="form-label">Time of Visit</label>
                                        <input type="time" name="visit_time" class="form-control" required>
                                    </div>  
                                </div>
                            
                                    <!-- Recce Details Start -->
                                    <div class="row" id="recceData" style="display:none">
                                        <h5 class="text-primary font-weight-bold m-2">Recce Details</h5>
                                        <div class="col-md-3 mb-2">
                                            <label class="form-label">Type of Recce</label>
                                            <select class="form-control" name="recce_type" id="recce_type">
                                                <option value="">-Select Recce Type-</option>
                                                <?php foreach ($recceTypes as $recce): ?>
                                                    <option value="<?= esc($recce['category_name']) ?>">
                                                        <?= esc($recce['category_name']) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <div class="col-md-3 mb-2">
                                            <label class="form-label">Company / Production</label>
                                            <input type="text" 
                                                name="company" 
                                                class="form-control" 
                                                placeholder="Enter Production / Company Name">
                                        </div>

                                        <div class="col-md-3 mb-2">
                                            <label class="form-label">Art Director / Director</label>
                                            <input type="text" 
                                                name="art_director" 
                                                class="form-control" 
                                                placeholder="Enter Art Director / Director Name">
                                        </div>

                                        <div class="col-md-3 mb-2">
                                            <label class="form-label">Tentative Shooting Date</label>
                                            <input type="date" 
                                                name="shooting_date" 
                                                class="form-control" 
                                                placeholder="Select Tentative Shooting Date">
                                        </div>

                                        <div class="col-md-3 mb-2">
                                            <label class="form-label">Contact Person</label>
                                            <input type="text" 
                                                name="contact_person" 
                                                class="form-control" 
                                                placeholder="Enter Contact Person Name">
                                        </div>

                                        <div class="col-md-3 mb-2">
                                            <label class="form-label">Email</label>
                                            <input type="email" 
                                                name="contact_person_email" 
                                                class="form-control" 
                                                placeholder="Enter Contact Person Email">
                                        </div>

                                         <div class="col-md-3 mb-2">
                                            <label class="form-label">Mobile No</label>
                                            <input type="phone" 
                                                name="contact_person_phone" 
                                                class="form-control" 
                                                placeholder="Enter Contact Person Mobile No">
                                        </div>
                                    </div>
                            <!-- Recce Details End  -->

                            <!-- Vendor Details Start -->
                                                
                            <div class="row" id="vendorData" style="display:none">

                                <h5 class="text-primary font-weight-bold m-2">Vendor Details</h5>

                                <div class="col-md-3 mb-2">
                                    <label class="form-label">Vendor Category</label>
                                    <select name="vendor_category" id="vendor_category" class="form-control" >
                                        <option value="">-- Select Vendor Category --</option>
                                        <?php foreach ($vendorTypes as $recce): ?>
                                            <option value="<?= esc($recce['category_name']) ?>"><?= esc($recce['category_name']) ?></option>
                                        <?php endforeach; ?>            
                                    </select>
                                </div>
                        
                                <div class="col-md-3 mb-2">
                                    <label class="form-label">Vendor Status</label>
                                    <select name="vendor_status" class="form-control" >
                                        <option value="">-- Select Vendor Status --</option>
                                        <option value="New">New</option>
                                        <option value="Existing">Existing</option>
                                    </select>
                                </div>

                                <div class="col-md-3 mb-2">
                                    <label class="form-label">Company Name</label>
                                    <input type="text"
                                        name="vendor_company"
                                        class="form-control"
                                        placeholder="Enter Company Name">
                                </div>

                                <div class="col-md-3 mb-2">
                                    <label class="form-label">Location</label>
                                    <input type="text"
                                        name="vendor_location"
                                        class="form-control"
                                        placeholder="Enter Vendor Location">
                                </div>
                            
                                <div class="col-md-3 mb-2">
                                    <label class="form-label">Contact Person</label>
                                    <input type="text"
                                        name="vendor_contact_name"
                                        class="form-control"
                                        placeholder="Enter Contact Person Name">
                                </div>
                         
                                <div class="col-md-3 mb-2">
                                    <label class="form-label">Email</label>
                                    <input type="email"
                                        name="vendor_email"
                                        class="form-control"
                                        placeholder="Enter Email Address">
                                </div>

                                <div class="col-md-3 mb-2">
                                    <label class="form-label">Mobile No</label>
                                    <input type="tel"
                                        name="vendor_mobile"
                                        class="form-control"
                                        placeholder="Enter Mobile Number"
                                        pattern="[0-9]{10}">
                                </div>
                            </div>

                            <!--Vendor Details End  -->

                            <!-- Visitor Details -->
                            <h5 class="text-primary font-weight-bold">Visitor Details</h5>
                            <div class="row">

                                <div class="col-md-3 mb-2">
                                    <label class="form-label">Visitor Name</label>
                                    <input type="text" name="visitor_name" id="visitorName"
                                           class="form-control" placeholder="Enter visitor full name" required>
                                </div>

                                <div class="col-md-3 mb-2">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="visitor_email" class="form-control"
                                           placeholder="Enter email address" required>
                                </div>

                                <div class="col-md-3 mb-2">
                                    <label class="form-label">Phone</label>
                                    <input type="text" name="visitor_phone" id="phone"
                                           class="form-control" maxlength="10"
                                           placeholder="Enter phone number" required>
                                </div>

                                <div class="col-md-3 mb-2">
                                    <label class="form-label">ID Proof Type</label>
                                    <select name="proof_id_type" class="form-control" required>
                                        <option value="">-- Select ID Type --</option>
                                        <option>Aadhar Card</option>
                                        <option>PAN Card</option>
                                        <option>Voter ID</option>
                                        <option>Passport</option>
                                        <option>Driving License</option>
                                        <option>Employee / Student ID</option>
                                        <option>Other</option>
                                    </select>
                                </div>

                                <div class="col-md-3 mb-2">
                                    <label class="form-label">ID Number</label>
                                    <input type="text" name="proof_id_number" id="idNumber"
                                           class="form-control" placeholder="Enter ID card number" required>
                                </div>

                                 <div class="col-md-9 mb-2">
                                    <label class="form-label">Description</label>
                                    <textarea name="description" id="description" class="form-control" rows="2" placeholder="Enter visit purpose details (optional)"></textarea>
                                </div>
                            </div>

                        <!-- Vehicle Details -->
                        <h5 class="text-primary font-weight-bold">Vehicle Details & Attachments </h5>                       
                        <div class="row">

                                <div class="col-md-3 mb-2">
                                    <label class="form-label">Vehicle Number</label>
                                    <input type="text" name="vehicle_no" id="vehicleNo"
                                           class="form-control" placeholder="Enter vehicle number (optional)">
                                </div>

                                <div class="col-md-3 mb-2">
                                    <label class="form-label">Vehicle Type</label>
                                    <select name="vehicle_type" class="form-control">
                                        <option value="">-- Select Vehicle Type --</option>
                                        <option>Bike</option>
                                        <option>Car</option>
                                        <option>Van</option>
                                        <option>Bus</option>
                                        <option>Auto</option>
                                        <option>Truck</option>
                                    </select>
                                </div>
                        
                                <div class="col-md-3 mb-2">
                                    <label class="form-label">Vehicle ID Proof</label>
                                    <input type="file" name="vehicle_id_proof" class="form-control">
                                </div>

                                <div class="col-md-3 mb-2">
                                    <label class="form-label">Visitor ID Proof</label>
                                    <input type="file" name="visitor_id_proof" class="form-control">
                                </div>
                          </div>
                            <input type="hidden" name="host_user_id" value="<?= $_SESSION['user_id']; ?>">
                        </div>

                        <div class="card-footer py-2">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="<?= base_url('visitorequestlist') ?>"
                               class="btn btn-danger float-right">Back</a>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
</main>

<?= $this->include('/dashboard/layouts/footer') ?>


<!-- =============== VALIDATION + AJAX SUBMIT JS =============== -->
<script>

// Phone Number Validation (only digits + 10 length)
$("#phone").on("input", function () {
    this.value = this.value.replace(/[^0-9]/g, "").slice(0, 10);
});

// Visitor Name Camel Case
$("#visitorName").on("input", function () {
    let val = this.value.toLowerCase().replace(/\b\w/g, c => c.toUpperCase());
    this.value = val;
});

// Visitor Name Camel Case
$("#description").on("input", function () {
    let val = this.value.toLowerCase().replace(/\b\w/g, c => c.toUpperCase());
    this.value = val;
});

// ID number uppercase
$("#idNumber").on("input", function () {
    this.value = this.value.toUpperCase();
});

// Vehicle number uppercase
$("#vehicleNo").on("input", function () {
    this.value = this.value.toUpperCase();
});


// // FORM SUBMIT
// $("#visitorForm").submit(function(e){
//     e.preventDefault();

//     // Phone check
//     let phone = $("#phone").val();
//     if(phone.length !== 10){
//         Swal.fire({
//             icon: "error",
//             title: "Phone number must be 10 digits",
//             timer: 1500,
//             showConfirmButton: false
//         });
//         return;
//     }

//     let formData = new FormData(this);

//     $.ajax({
//         url: "<?= base_url('/visitorequest/create')?>",
//         type: "POST",
//         data: formData,
//         dataType: "json",
//         contentType: false,
//         processData: false,
//         cache: false,

//         success: function(res){
//             if(res.status === "success"){
//                 $("#visitorForm")[0].reset();

//                 Swal.fire({
//                     icon: "success",
//                     title: "Visitor Saved Successfully",
//                     timer: 1200,
//                     showConfirmButton: false
//                 });

//                 // setTimeout(() => location.reload(), 800);

//                 if(res.submit_type === 'admin'){
//                     sendMail(res.head_id); 
//                 }
//             }
//         },

//         error: function(){
//             Swal.fire({
//                 icon: 'error',
//                 title: 'Something went wrong!',
//                 timer: 1200,
//                 showConfirmButton: false
//             });
//         }
//     });
// });


let isSubmitting = false;

$("#visitorForm").submit(function(e){
    e.preventDefault();

    if (!validateForm()) return; // validation 

    if (isSubmitting) {
        return false; // block second submit
    }

    isSubmitting = true; // lock submit

    let $btn = $("#visitorForm button[type=submit]");
    $btn.prop("disabled", true).text("Submitting...");

    let formData = new FormData(this);

    $.ajax({
        url: "<?= base_url('/visitorequest/create')?>",
        type: "POST",
        data: formData,
        dataType: "json",
        contentType: false,
        processData: false,
        cache: false,

        success: function(res){
            if(res.status === "success"){
                $("#visitorForm")[0].reset();

                Swal.fire({
                    icon: "success",
                    title: "Visitor Saved Successfully",
                    timer: 1200,
                    showConfirmButton: false
                });

                if(res.submit_type === 'admin'){
                    sendMail(res.head_id);
                }
            }
        },

        error: function(){
            Swal.fire({
                icon: 'error',
                title: 'Something went wrong!',
                timer: 1200,
                showConfirmButton: false
            });
        },

        complete: function(){
            isSubmitting = false;     // unlock
            $btn.prop("disabled", false).text("Submit");
        }
    });
});



function validateForm() {

    let purpose    = $('#purpose').val();
    let recceType  = $('#recce_type').val();
    let vendorType = $('#vendor_category').val();
    let phone      = $('#phone').val().trim();

    // Purpose-based validation
    const rules = {
        Recce:  { field: '#recce_type',  msg: 'Recce Type is mandatory when Purpose is Recce' },
        Vendor: { field: '#vendor_category', msg: 'Vendor Type is mandatory when Purpose is Vendor' }
    };

    if (rules[purpose]) {
        let value = $(rules[purpose].field).val();
        if (!value) {
            Swal.fire({
                icon: 'error',
                title: 'Missing Information',
                text: rules[purpose].msg,
                confirmButtonColor: '#3085d6'
            });
            return false;
        }
    }

    // Phone validation (10 digits, numbers only)
    if (!/^\d{10}$/.test(phone)) {
        Swal.fire({
            icon: "error",
            title: "Invalid Phone Number",
            text: "Phone number must be exactly 10 digits",
            timer: 1500,
            showConfirmButton: false
        });
        return false;
    }

    return true;
}


// // Send Mail
// function sendMail(postData) {
//     $.ajax({
//         url: "<?= base_url('/send-email') ?>",
//         type: "POST",
//         data: postData,
//         dataType: "json",
//         success: function (mailRes) {
//             console.log("Mail Sent:", mailRes);
//         }
//     });
// }

    function sendMail(head_id) {
        $.ajax({
        url: "<?= base_url('/send-email') ?>",
        type: "POST",
        data: { head_id: head_id },   // single variable
        success: function(res) {
        console.log(res);
        }
        });
    }



    function purposeEvent() {
        let purpose = $('#purpose').val();
        if (purpose === "Recce") {
         $('#recceData').show();   // show section
        }else{
          $('#recceData').hide();   // show section
        }

        if (purpose === "Vendor") {
         $('#vendorData').show();   // show section
        }else{
          $('#vendorData').hide();   // show section
        }
    }


// function sendMail(maildata) {
//     $.ajax({
//         url: "<?= base_url('/send-email') ?>",
//         type: "POST",
//         data:{ mail_data : maildata },
//         dataType: "json",
//         success: function (mailRes) {
//             console.log(mailRes);
//         },
//         error: function () {
//             console.log("Email sending failed");
//         }
//     });
// }

 
$(document).ready(function () {

    $('.select2').select2({
        width: '100%',
        allowClear: false
    });
});

</script>

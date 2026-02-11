<?= $this->include('/dashboard/layouts/sidebar') ?>
<?= $this->include('/dashboard/layouts/navbar') ?>
<style>
   .star-rating {
    font-size: 50px;
    cursor: pointer;
    user-select: none;
}

.star-rating span {
    color: #ccc;
    transition: 0.2s;
}

/* active stars only */
.star-rating span.active {
    color: #ffbf00;
}
</style>
<main class="main-content" id="mainContent">
<div class="container-fluid">

    <!-- =========================
        FEEDBACK LIST TABLE
    ========================== -->
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">

        <h5 class="mb-0">
            <i class="fa fa-comments mr-2"></i> Feedback Management
        </h5>

      <button class="btn btn-warning"
        data-bs-toggle="modal"
        data-bs-target="#feedbackModal">
        New Feedback
        </button>


    </div>
        <div class="card-body table-responsive">

            <table class="table table-bordered table-striped" id="feedbackTable">
                <thead class="bg-light">
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Department</th>
                    <th>Type</th>
                    <th>Module</th>
                    <th>Rating</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
                </thead>

                <tbody>
                <?php foreach($feedbacks as $f): ?>
                    <tr>
                        <td><?= $f['feedback_id'] ?></td>
                        <td><?= esc($f['user_name']) ?></td>
                        <td><?= esc($f['department_name']) ?></td>
                        <td><?= esc($f['feedback_type']) ?></td>
                        <td><?= esc($f['module_name']) ?></td>
                        <td><?= $f['rating'] ?> ⭐</td>
                        <td>
                            <span><?= $f['status'] ?></span>
                        </td>
                        <td><?= date('d-M-Y', strtotime($f['created_at'])) ?></td>
                        <td>
                        <button class="btn btn-sm btn-info viewBtn"
                            data-id="<?= $f['feedback_id'] ?>"
                            data-user="<?= esc($f['user_name']) ?>"
                            data-dept="<?= esc($f['department_name']) ?>"
                            data-type="<?= esc($f['feedback_type']) ?>"
                            data-module="<?= esc($f['module_name']) ?>"
                            data-rating="<?= $f['rating'] ?>"
                            data-comments="<?= esc($f['comments']) ?>"
                            data-suggestion="<?= esc($f['suggestion']) ?>"
                            data-status="<?= esc($f['status']) ?>"
                            data-contact="<?= esc($f['contact_required']) ?>"
                            data-date="<?= date('d-M-Y H:i', strtotime($f['created_at'])) ?>"
                            data-file="<?= esc($f['attachment_path']) ?>">
                            View
                        </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </div>



<!-- ===================================================
        FEEDBACK MODAL (CREATE + VIEW)
=================================================== -->
<div class="modal fade" id="feedbackModal">
<div class="modal-dialog modal-lg">
<div class="modal-content">

<form id="feedbackForm" enctype="multipart/form-data" >

    <!-- HEADER -->
    <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="modalTitle">Submit Feedback</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
    </div>

    <div class="modal-body">

        <div class="row">

            <!-- Type -->
            <div class="col-md-6 mb-2">
                <label>Type</label>
                <select name="feedback_type" id="feedback_type" class="form-control" required>
                    <option value="">Select</option>
                     <option>Appreciation</option>
                    <option>Suggestion</option>
                    <option>Feature Request</option>
                    <option>Issue</option>
                    
                </select>
            </div>

            <!-- Module -->
            <div class="col-md-6 mb-2">
                <label>Module</label>
                <select name="module_name" id="module_name" class="form-control" required>
                    <option>General</option>
                    <option>Visitor Request</option>
                    <option>Approval</option>
                    <option>Security Entry</option>
                </select>
            </div>

            <!-- Rating -->
            <!-- <div class="col-md-6 mb-2">
                <label>Rating</label>
                <select name="rating" id="rating" class="form-control" required>
                    <option value="5">⭐⭐⭐⭐⭐</option>
                    <option value="4">⭐⭐⭐⭐</option>
                    <option value="3">⭐⭐⭐</option>
                    <option value="2">⭐⭐</option>
                    <option value="1">⭐</option>
                </select>
            </div> -->
            <!-- Rating -->
<div class="col-md-6 mb-2">
    <label>Rating</label>
    <input type="hidden" name="rating" id="rating" required>

    <div class="star-rating">
        <span data-value="1">★</span>
        <span data-value="2">★</span>
        <span data-value="3">★</span>
        <span data-value="4">★</span>
        <span data-value="5">★</span>
    </div>
</div>


            <!-- Comments -->
            <div class="col-md-12 mb-2">
                <label>Comments</label>
                <textarea name="comments" id="comments" class="form-control" required></textarea>
            </div>

            <!-- Suggestion -->
            <div class="col-md-12 mb-2">
                <label>Suggestion</label>
                <textarea name="suggestion" id="suggestion" class="form-control"></textarea>
            </div>

            <!-- Attachment -->
            <div class="col-md-6 mb-2">
                <label>Attachment</label>
                <input type="file" name="attachment" id="attachment" class="form-control">
                <div id="filePreview" class="mt-1 small text-primary"></div>
            </div>

            <!-- Contact -->
            <div class="col-md-6 d-flex align-items-center">
                <input type="checkbox" name="contact_required" id="contact_required" value="Y">
                &nbsp; Contact me
            </div>

        </div>

    </div>

    <!-- FOOTER -->
    <div class="modal-footer">
       <button type="submit" class="btn btn-primary" id="submitBtn">Submit</button>

        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
    </div>

</form>

</div>
</div>
</div>


</div>
</main>

<?= $this->include('/dashboard/layouts/footer') ?>

<script>
/* =====================================
   NEW FEEDBACK MODE
===================================== */
$(document).on("click", "#openFeedback, .newFeedbackBtn", function(){

    $("#modalTitle").text("Submit Feedback");

    // reset form
    $("#feedbackForm")[0].reset();

    // enable inputs
    $("#feedbackForm :input").prop("disabled", false);

    // clear rating hidden value
    $("#rating").val("");

    // ⭐ CLEAR STAR UI (IMPORTANT)
    $(".star-rating span").removeClass("active");

    // clear attachment preview
    $("#filePreview").html("");

    // show attachment upload again
    $("#attachment").show();

    // show submit button
    $("#submitBtn").show();

    // Bootstrap 5 show
    let modal = new bootstrap.Modal(document.getElementById('feedbackModal'));
    modal.show();
});

/* =====================================
   VIEW MODE (reuse same modal)
===================================== */
$(document).on("click", ".viewBtn", function(){

    $("#modalTitle").text("View Feedback");

    $("#feedback_type").val($(this).data("type"));
    $("#module_name").val($(this).data("module"));
    $("#rating").val($(this).data("rating"));
    $("#comments").val($(this).data("comments"));
    $("#suggestion").val($(this).data("suggestion"));


    if($(this).data("contact") === 'Y'){
        $("#contact_required").prop("checked", true);
    }

    let file = $(this).data("file");
    let rating = $(this).data("rating");

    if(file){
        let fileUrl = "<?= base_url() ?>/" + file;
        $("#filePreview").html(`
            <div class="photo-wrapper mb-2">
                <img src="${fileUrl}" 
                    alt="Attachment"
                    class="img-fluid zoomable"
                    style="max-height:150px;cursor:pointer;">
            </div>
        `);
    }
    else{
        $("#filePreview").html('');
    }

    
    if(rating){
    $("#rating").val(rating);
        $(".star-rating span").each(function () {
            if ($(this).data("value") <= rating) {
                $(this).addClass("active");
            } else {
                $(this).removeClass("active");
            }
        });
    }
        

    // disable fields
    $("#feedbackForm :input").prop("disabled", false);
    // hide submit button
    $("#submitBtn").hide();
    $("#attachment").hide();
                    
    // Bootstrap 5 show
    let modal = new bootstrap.Modal(document.getElementById('feedbackModal'));
    modal.show();
});

$("#feedbackForm").on("submit", function (e) {

    e.preventDefault();

    let formData = new FormData(this);

    // prevent double click
    $("#submitBtn")
        .prop("disabled", true)
        .text("Saving...");

    $.ajax({
        url: "<?= base_url('feedback/save') ?>",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        dataType: "json",

        success: function (res) {

            if (res.status === "success") {

                Swal.fire({
                    icon: "success",
                    title: "Thanks for your feedback!",
                    text: "We really appreciate your input.",
                    timer: 1200,
                    showConfirmButton: false
                });

                $("#feedbackModal").modal('hide');

                setTimeout(() => location.reload(), 1000);

            } else {
                Swal.fire("Error", res.message, "error");
            }
        },

        complete: function () {
            // enable again
            $("#submitBtn")
                .prop("disabled", false)
                .text("Submit");
        }
    });
});

// ⭐ STAR RATING CLICK
$(".star-rating span").on("mouseenter", function () {

    let val = $(this).data("value");

    $(".star-rating span").each(function () {
        $(this).toggleClass("active", $(this).data("value") <= val);
    });

}).on("mouseleave", function () {

    let selected = $("#rating").val() || 0;

    $(".star-rating span").each(function () {
        $(this).toggleClass("active", $(this).data("value") <= selected);
    });

}).on("click", function () {

    let val = $(this).data("value");

    $("#rating").val(val);

    $(".star-rating span").each(function () {
        $(this).toggleClass("active", $(this).data("value") <= val);
    });

});

</script>

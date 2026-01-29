<?= $this->include('/dashboard/layouts/sidebar') ?>
<?= $this->include('/dashboard/layouts/navbar') ?>
<style>
.list-group-item.active {
    background-color: #0d6efd !important;
    color: #fff !important;
}

.list-group-item.active a {
    color: #fff !important;
    font-weight: 600 !important;
}
</style>

<main class="main-content" id="mainContent">
    <div class="container-fluid">

        <div class="row d-flex justify-content-center">
            <div class="col-md-10">

                <div class="card card-primary">
                    <div class="card-header">
                        <h5 class="mb-0">User Manuals</h5>
                    </div>

                    <div class="card-body">

                        <!-- Tabs -->
                        <ul class="nav nav-tabs mb-3" id="manualTabs" role="tablist">
                            <li class="nav-item">
                                <button class="nav-link active"
                                        id="videos-tab"
                                        data-bs-toggle="tab"
                                        data-bs-target="#videos"
                                        type="button"
                                        role="tab">
                                    🎥 Videos
                                </button>
                            </li>

                            <li class="nav-item">
                                <button class="nav-link"
                                        id="documents-tab"
                                        data-bs-toggle="tab"
                                        data-bs-target="#documents"
                                        type="button"
                                        role="tab">
                                    📄 Documents
                                </button>
                            </li>
                        </ul>

                        <!-- Tab Content -->
                        <div class="tab-content">

                            <!-- 🎥 Videos Tab -->
                            <div class="tab-pane fade show active" id="videos" role="tabpanel">
                                <h6 class="mb-3">Access360 Training Videos</h6>

                                <div class="card">
                                    <div class="card-body p-2">

                                    <div class="row">
                                        <div class="col-md-8 p-2">
                                        <video id="sopVideo" width="100%" height="100%" controls>
                                            <source id="sopVideoSource"
                                            src="<?= base_url('/public/uploads/sop/Mark_Exit_by_Security_Person.mp4') ?>"
                                            type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>

                                        </div>
                                        <div class="col-md-4 p-2">
                                            <h5 class="text-primary font-weight-bold">Training Videos Play List</h5>
                                            <ul class="list-group">
                                                <li class="list-group-item d-flex justify-content-between align-items-center" onclick="playVideo('/public/uploads/sop/Visitor_Request.mp4')">
                                                    <a href="#"
                                                    class="text-primary">
                                                        Create Visitor Requast
                                                    </a>
                                                </li>

                                                <li class="list-group-item d-flex justify-content-between align-items-center"  onclick="playVideo('/public/uploads/sop/Admin_Approval.mp4')">
                                                    <a href="#"
                                                    class="text-primary">
                                                      HOD Review & Approval
                                                    </a>
                                                </li>

                                                <li class="list-group-item d-flex justify-content-between align-items-center" onclick="playVideo('/public/uploads/sop/Guest_Received_Mail.mp4')">
                                                    <a href="#"
                                                    class="text-primary">
                                                      Gate Pass Received by Visitor
                                                    </a>
                                                </li>


                                                <li class="list-group-item d-flex justify-content-between align-items-center" onclick="playVideo('')">
                                                    <a href="#"
                                                    class="text-primary">
                                                      Security Marks Allowed Entry
                                                    </a>
                                                </li>

                                                <li class="list-group-item d-flex justify-content-between align-items-center" onclick="playVideo('/public/uploads/sop/Meeting_Completion_Confirmation_by_HOD.mp4')">
                                                    <a href="#"
                                                    class="text-primary">
                                                      Meeting Completion Confirmation by HOD
                                                    </a>
                                                </li>

                                                 <li class="list-group-item d-flex justify-content-between align-items-center" onclick="playVideo('/public/uploads/sop/Mark_Exit_by_Security_Person.mp4')">
                                                    <a href="#"
                                                    class="text-primary">
                                                      Security Marks Allowed Exit
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Documents Tab -->
                            <div class="tab-pane fade" id="documents" role="tabpanel">
                                <h6 class="mb-3">Access360 SOP Documents</h6>

                                <ul class="list-group">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        User SOP Document
                                        <a href="<?= base_url('/public/uploads/sop/endUser_usermanual.pdf') ?>"
                                           target="_blank"
                                           class="btn btn-sm btn-primary">
                                            View
                                        </a>
                                    </li>

                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Security SOP Document
                                        <a href="<?= base_url('/public/uploads/sop/securirty_usermanual.pdf') ?>"
                                           target="_blank"
                                           class="btn btn-sm btn-primary">
                                            View
                                        </a>
                                    </li>
                                </ul>
                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </div>

    </div>
</main>

<?= $this->include('/dashboard/layouts/footer') ?>
<script>
 
function playVideo(srcVal) {

if(srcVal == ""){
    alert('Video Not Yet Uploaded')
    return;
}
    const video = document.getElementById('sopVideo');
    const source = document.getElementById('sopVideoSource');

    source.src = "<?= base_url() ?>" + srcVal; // CI base_url
    video.load();   // reload new video
    video.play();  // auto play
    
    document.querySelectorAll('.list-group-item').forEach(li => {
        li.classList.remove('active');
    });
    event.currentTarget.classList.add('active');

}


</script>
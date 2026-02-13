
<!-- // works for ANY current/future image with class="zoomable" -->
<div id="imageZoomModal" class="zoom-modal">
    <span class="zoom-close">&times;</span>
    <img id="zoomedImage" class="zoom-img">
</div>
<!-- // works for ANY current/future image with class="zoomable" -->

<!-- Footer -->
<footer class="footer" id="footer" >
  <strong> ©2026 <a href="https://adminlte.io" class="text-decoration-none">Ushakiron Movies Private Limited. &nbsp;</a></strong>All rights reserved.
</footer>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
   
   function contactSupport() {

    Swal.fire({
        title: "Contact Support",
        icon: "info",
        width: 540,
        confirmButtonText: "Close",
        confirmButtonColor: "#3085d6",

        html: `
<div class="container-fluid text-start" style="font-size:14px;line-height:1.6">

    <p class="mb-3">
        For any assistance regarding <b>Access360</b>, please contact our support team below.
    </p>

    <div class="row g-2">

        <!-- Support Card 1 -->
        <div class="col-12 col-md-6">
            <div class="card shadow-sm h-100 border-0">
                <div class="card-body">

                    <h6 class="fw-bold text-primary mb-3">
                         <i class="fa fa-user me-2"></i> Srinivas
                    </h6>

                    <p class="mb-1">
               
                     <a href="mailto:srinivas.a@ramjifilmcity.com">
                        srinivas.a@ramjifilmcity.com</a>
                    </p>

                    <p class="mb-1">
                        <i class="fa fa-mobile-alt text-success me-2"></i>
                         <a href="tel:9347364990">9347364990</a>
                    </p>

                    <p class="mb-0">
                       <i class="fa fa-phone text-dark me-2"></i>
                         Ext: <b>8906</b>
                    </p>

                </div>
            </div>
        </div>


        <!-- Support Card 2 -->
        <div class="col-12 col-md-6">
            <div class="card shadow-sm h-100 border-0">
                <div class="card-body">

                    <h6 class="fw-bold text-primary mb-3">
                          <i class="fa fa-user me-2"></i>  Mahesh
                    </h6>

                    <p class="mb-1">
                        <a href="mailto:developers@ramojifilmcity.com">
                        developers@ramojifilmcity.com</a>
                    </p>

                    <p class="mb-1">
                      <i class="fa fa-mobile-alt text-success me-2"></i>    
                    <a href="tel:8919146333">8919146333</a>
                    </p>

                    <p class="mb-0">
                          <i class="fa fa-phone text-dark me-2"></i>
                           Ext: <b>8846</b>
                    </p>

                </div>
            </div>
        </div>

    </div>

    <hr class="my-3">

    <!-- Feedback box -->
    <div class="alert alert-success small mb-0">
      <i class="fa fa-comments me-2"></i>
        <b> Feedback & Requests</b><br>
        You can also share your issues, suggestions, or feature requests using the 
        <b>Feedback</b> option inside the application.  
        This helps us track and resolve your requests faster.
    </div>

</div>
`

    });

}



document.addEventListener('DOMContentLoaded', function () {

    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const mobileToggle = document.getElementById('mobileSidebarToggle');
    const collapseBtn = document.getElementById('sidebarCollapse');
    const mainContent = document.getElementById('mainContent');
    const topbar = document.getElementById('topbar');
    const footer = document.getElementById('footer');

    const mobileQuery = window.matchMedia('(max-width: 800px)');

    function applyResponsiveLayout() {
        if (mobileQuery.matches) {
            // Mobile / Tablet
            sidebar.classList.add('closed');
            mainContent.classList.add('expanded');
            topbar.classList.add('collapsed');
            footer.classList.add('expanded');
            overlay?.classList.remove('active');
            document.body.classList.remove('sidebar-open');
        } else {
            // Desktop
            sidebar.classList.remove('closed');
            mainContent.classList.remove('expanded');
            topbar.classList.remove('collapsed');
            footer.classList.remove('expanded');
            overlay?.classList.remove('active');
            document.body.classList.remove('sidebar-open');
        }
    }

    // Initial check (after layout settles)
    setTimeout(applyResponsiveLayout, 100);

    // Listen for real breakpoint changes
    mobileQuery.addEventListener('change', applyResponsiveLayout);

    // Toggle sidebar (mobile)
    mobileToggle?.addEventListener('click', () => {
        sidebar.classList.toggle('closed');
        mainContent.classList.toggle('expanded');
        topbar.classList.toggle('collapsed');
        footer.classList.toggle('expanded');

        if (!sidebar.classList.contains('closed') && mobileQuery.matches) {
            overlay?.classList.add('active');
            document.body.classList.add('sidebar-open');
        } else {
            overlay?.classList.remove('active');
            document.body.classList.remove('sidebar-open');
        }
    });

    // Overlay click
    overlay?.addEventListener('click', () => {
        sidebar.classList.add('closed');
        mainContent.classList.add('expanded');
        topbar.classList.add('collapsed');
        footer.classList.add('expanded');
        overlay.classList.remove('active');
        document.body.classList.remove('sidebar-open');
    });

    // Desktop collapse
    collapseBtn?.addEventListener('click', () => {
        sidebar.classList.toggle('closed');
        mainContent.classList.toggle('expanded');
        topbar.classList.toggle('collapsed');
        footer.classList.toggle('expanded');
    });

});

// works for ANY current/future image with class="zoomable"

$(document).on('click', '.zoomable', function () {

    let imgSrc = $(this).attr('src');

    $('#zoomedImage').attr('src', imgSrc);
    $('#imageZoomModal').fadeIn();
});

$(document).on('click', '.zoom-close, #imageZoomModal', function (e) {
    // prevent closing when clicking image itself
    if ($(e.target).is('#zoomedImage')) return;
    $('#imageZoomModal').fadeOut();
});
//Image preview in scann Visitor Popup and request management Popup End 
</script>
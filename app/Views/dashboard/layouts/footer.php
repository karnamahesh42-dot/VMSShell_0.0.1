
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
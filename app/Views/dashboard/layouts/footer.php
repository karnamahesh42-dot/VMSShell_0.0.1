
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
const sidebar = document.getElementById('sidebar');
const overlay = document.getElementById('overlay');
const mobileToggle = document.getElementById('mobileSidebarToggle');
const collapseBtn = document.getElementById('sidebarCollapse');
const mainContent = document.getElementById('mainContent');
const topbar = document.getElementById('topbar');
const footer = document.getElementById('footer');

document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    const topbar = document.getElementById('topbar');
    const footer = document.getElementById('footer');
    const mobileToggle = document.getElementById('mobileSidebarToggle');

    function initMobileView() {
        if (window.innerWidth <= 425) {
            sidebar.classList.add('closed');
            mainContent.classList.add('expanded');
            topbar.classList.add('collapsed');
            footer.classList.add('expanded');
            document.body.classList.remove('sidebar-open'); // important
        }
    }

    // Run on page load
    initMobileView();

    // Run on resize
    window.addEventListener('resize', initMobileView);

    // Toggle sidebar
    mobileToggle?.addEventListener('click', function () {

        sidebar.classList.toggle('closed');
        mainContent.classList.toggle('expanded');
        topbar.classList.toggle('collapsed');
        footer.classList.toggle('expanded');

        if (!sidebar.classList.contains('closed') && window.innerWidth <= 768) {
            document.body.classList.add('sidebar-open');
        } else {
            document.body.classList.remove('sidebar-open');
        }

    });

});


document.addEventListener('DOMContentLoaded', function () {
    const fullScreenBtn = document.getElementById('fullScreenBtn');
    fullScreenBtn?.addEventListener('click', function () {
        // Desktop only
        if (window.innerWidth <= 425) return;
        if (!document.fullscreenElement) {
            document.documentElement.requestFullscreen().catch(err => {
                console.error('Fullscreen error:', err);
            });
        } else {
            document.exitFullscreen();
        }
    });
});


// document.addEventListener('DOMContentLoaded', function () {
//     const fullScreenBtn = document.getElementById('fullScreenBtn');
//     // Restore fullscreen on reload
//     if (
//         localStorage.getItem('isFullscreen') === 'true' &&
//         window.innerWidth > 425
//     ) {
//         document.documentElement.requestFullscreen().catch(() => {});
//     }
//     fullScreenBtn?.addEventListener('click', function () {
//         // Desktop only
//         if (window.innerWidth <= 425) return;
//         if (!document.fullscreenElement) {
//             document.documentElement.requestFullscreen()
//                 .then(() => {
//                     localStorage.setItem('isFullscreen', 'true');
//                 })
//                 .catch(err => console.error('Fullscreen error:', err));
//         } else {
//             document.exitFullscreen()
//                 .then(() => {
//                     localStorage.setItem('isFullscreen', 'false');
//                 });
//         }
//     });

//     // Sync state if user exits fullscreen manually (ESC)
//     document.addEventListener('fullscreenchange', () => {
//         localStorage.setItem(
//             'isFullscreen',
//             document.fullscreenElement ? 'true' : 'false'
//         );
//     });
// });


overlay?.addEventListener('click', () => {
  sidebar.classList.remove('open');
  overlay.classList.remove('active');
});

// Desktop collapse
collapseBtn?.addEventListener('click', () => {
  sidebar.classList.toggle('closed');
  mainContent.classList.toggle('expanded');
  topbar.classList.toggle('collapsed');
  footer.classList.toggle('expanded');
});

</script>
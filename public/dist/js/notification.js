
$(document).ready(function () {
    // fetch count only on page load (unread count)
    checkNotification(false);
});

// open notifications when bell clicked
$(document).on('click', '#notificationBell', function(){
    checkNotification(true);
});

// show all notifications when button clicked
$(document).on('click', '#showAllNotificationsBtn', function(e){
    e.preventDefault();
    e.stopPropagation();
    Swal.close();  // Close the current popup
    setTimeout(function(){
        showAllNotifications();  // Open the all notifications popup
    }, 300);
});

function checkNotification(showModal = true){

                    $.ajax({
                            url: "notification/getUnread",
                            type: "GET",
                            dataType: "json",
                            success: function(res){
                                
                                // update badge count every call
                                if(res.length > 0){
                                    $("#notificationCount").text(res.length).show();
                                    $("#notificationBell").addClass('text-warning');
                                } else {
                                    $("#notificationCount").hide();
                                    $("#notificationBell").removeClass('text-warning');
                                }

                                // if only updating count, exit
                                if (!showModal) return;

                                // show latest notifications modal
                                displayLatestNotifications(res);

                            }
                        });
                }

function displayLatestNotifications(res){
    if(res.length > 0){
        // Display unread notifications
        let message = '';
        generateNotificationHTML(res, message, function(htmlContent){
            Swal.fire({
                title: `<div style="color: #0ea5e9; font-size: 24px; font-weight: bold;"><i class="fas fa-inbox" style="margin-right: 10px; color: #0ea5e9;"></i>Latest Notifications</div>`,
                html: `
                    <div style="text-align: left; max-height: 500px; overflow-y: auto;">
                        <div style="background: #e0f4ff; padding: 12px; border-radius: 8px; margin-bottom: 15px; text-align: center; color: #0ea5e9; font-size: 14px; font-weight: bold; border-left: 4px solid #0ea5e9;">
                            <i class="fas fa-star"></i> <strong>${res.length}</strong> new notification${res.length > 1 ? 's' : ''}
                        </div>
                        ${htmlContent}
                        <button id="showAllNotificationsBtn" class="btn btn-primary" style="width: 100%; margin-top: 15px; background-color: #0ea5e9; border: none; color: white; font-weight: bold; padding: 10px;">
                            <i class="fas fa-list"></i> Show All Notifications
                        </button>
                    </div>
                `,
                icon: "success",
                showCloseButton: true,
                closeButtonAriaLabel: 'Close',
                confirmButtonText: "<i class='fas fa-times'></i> Close",
                confirmButtonColor: "#0ea5e9",
                width: '700px',
                padding: '20px',
                background: "#ffffff",
                allowOutsideClick: false,
                didOpen: (modal) => {
                    modal.classList.add('notification-modal');
                    // auto mark as read when modal opens
                    $.post("notification/markRead", function(){
                        $("#notificationCount").hide();
                        $("#notificationBell").removeClass('text-warning');
                    });
                },
                customClass: {
                    popup: 'notification-popup'
                }
            }).then((result) => {
                if(result.isConfirmed){
                    // ensure badge is cleared when close is clicked
                    $("#notificationCount").hide();
                    $("#notificationBell").removeClass('text-warning');
                }
            });
        });
    } else {
        // No unread notifications
        Swal.fire({
            title: `<div style="color: #0ea5e9; font-size: 18px; font-weight: bold;"><i class="fas fa-inbox" style="margin-right: 10px; color: #0ea5e9;"></i>Latest Notifications</div>`,
            html: `
                <div style="text-align: center; padding: 40px 20px;">
                    <i class="fas fa-bell-slash" style="font-size: 48px; color: #0ea5e9; margin-bottom: 15px;"></i>
                    <p style="font-size: 18px; color: #333; margin: 15px 0;">No latest notifications currently</p>
                    <p style="font-size: 14px; color: #666; margin-bottom: 20px;">All caught up! Check back later or view all notifications</p>
                    <button id="showAllNotificationsBtn" class="btn btn-primary" style="background-color: #0ea5e9; border: none; color: white; font-weight: bold; padding: 10px 20px; border-radius: 4px; cursor: pointer;">
                        <i class="fas fa-list"></i> Show All Notifications
                    </button>
                </div>
            `,
            icon: "info",
            confirmButtonText: "<i class='fas fa-times'></i> Close",
            confirmButtonColor: "#0ea5e9",
            width: '700px',
            padding: '20px',
            background: "#ffffff",
            allowOutsideClick: false,
            customClass: {
                popup: 'notification-popup'
            }
        });
    }
}

function showAllNotifications(){
    $.ajax({
        url: "notification/getAll",
        type: "GET",
        dataType: "json",
        success: function(res){
           
            console.log(res);

            if(res.length > 0){
                let message = '';
                generateNotificationHTML(res, message, function(htmlContent){
                    Swal.fire({
                        title: `<div style="color: #0ea5e9; font-size: 24px; font-weight: bold;"><i class="fas fa-list" style="margin-right: 10px; color: #0ea5e9;"></i>All Notifications</div>`,
                        html: `
                            <div style="text-align: left; max-height: 500px; overflow-y: auto; padding: 20px;">
                                <div style="background: #e0f4ff; padding: 12px; border-radius: 8px; margin-bottom: 15px; text-align: center; color: #0ea5e9; font-size: 14px; font-weight: bold; border-left: 4px solid #0ea5e9;">
                                    <i class="fas fa-inbox"></i> Total <strong>${res.length}</strong> notification${res.length > 1 ? 's' : ''}
                                </div>
                                ${htmlContent}
                            </div>
                        `,
                        icon: "success",
                        showCloseButton: true,
                        closeButtonAriaLabel: 'Close',
                        confirmButtonText: "<i class='fas fa-times'></i> Close",
                        confirmButtonColor: "#0ea5e9",
                        width: '700px',
                        padding: '20px',
                        background: "#ffffff",
                        allowOutsideClick: false,
                        customClass: {
                            popup: 'notification-popup'
                        }
                    });
                });
            } else {
                Swal.fire({
                    title: 'No Notifications',
                    text: 'You have no notifications yet',
                    icon: 'info',
                    confirmButtonColor: '#1a5f3f'
                });
            }
        }
    });
}

function generateNotificationHTML(notifications, message, callback){

                                    let typeIcon = {
                                        'alert': 'fa-exclamation-triangle',
                                        'info': 'fa-info-circle',
                                        'success': 'fa-check-circle',
                                        'warning': 'fa-bolt',
                                        'error': 'fa-times-circle',
                                        'update': 'fa-sync',
                                        'New Feature': 'fa-star',
                                        'Module Extension': 'fa-puzzle-piece',
                                        'System Update': 'fa-cog',
                                        'Bug Fix': 'fa-bug',
                                        'Visitor Alert': 'fa-user-check',
                                        'Security Alert': 'fa-shield-alt',
                                        'Admin Announcement': 'fa-bullhorn',
                                        'Reminder': 'fa-bell',
                                        'Urgent Notice': 'fa-exclamation-circle'
                                    };

                                    let typeLabel = {
                                        'alert': 'ALERT',
                                        'info': 'INFO',
                                        'success': 'SUCCESS',
                                        'warning': 'WARNING',
                                        'error': 'ERROR',
                                        'update': 'UPDATE',
                                        'New Feature': 'NEW FEATURE',
                                        'Module Extension': 'MODULE EXTENSION',
                                        'System Update': 'SYSTEM UPDATE',
                                        'Bug Fix': 'BUG FIX',
                                        'Visitor Alert': 'VISITOR ALERT',
                                        'Security Alert': 'SECURITY ALERT',
                                        'Admin Announcement': 'ADMIN ANNOUNCEMENT',
                                        'Reminder': 'REMINDER',
                                        'Urgent Notice': 'URGENT NOTICE'
                                    };

                                    let iconColor = {
                                        'alert': '#ffc107',
                                        'info': '#2196f3',
                                        'success': '#28a745',
                                        'warning': '#ff6b6b',
                                        'error': '#dc3545',
                                        'update': '#2196f3',
                                        'New Feature': '#77eb87',
                                        'Module Extension': '#8b5cf6',
                                        'System Update': '#6366f1',
                                        'Bug Fix': '#ff6b6b',
                                        'Visitor Alert': '#f59e0b',
                                        'Security Alert': '#dc3545',
                                        'Admin Announcement': '#9c27b0',
                                        'Reminder': '#ffc107',
                                        'Urgent Notice': '#dc3545'
                                    };

                                    let bgColor = {
                                        'alert': '#fffdf5',
                                        'info': '#f0f7ff',
                                        'success': '#f7fcf3',
                                        'warning': '#fff5f5',
                                        'error': '#fff5f5',
                                        'update': '#faf2ff',
                                        'New Feature': '#f7fbff',
                                        'Module Extension': '#faf5ff',
                                        'System Update': '#f2f5ff',
                                        'Bug Fix': '#fff5f5',
                                        'Visitor Alert': '#fffdf2',
                                        'Security Alert': '#fff5f5',
                                        'Admin Announcement': '#faf5ff',
                                        'Reminder': '#fffcea',
                                        'Urgent Notice': '#fff5f5'
                                    };

                                    let headerBgColor = {
                                        'alert': '#0ea5e9',
                                        'info': '#0ea5e9',
                                        'success': '#0ea5e9',
                                        'warning': '#0ea5e9',
                                        'error': '#0ea5e9',
                                        'update': '#0ea5e9',
                                        'New Feature': '#07b91f',
                                        'Module Extension': '#0ea5e9',
                                        'System Update': '#0ea5e9',
                                        'Bug Fix': '#0ea5e9',
                                        'Visitor Alert': '#0ea5e9',
                                        'Security Alert': '#0ea5e9',
                                        'Admin Announcement': '#0ea5e9',
                                        'Reminder': '#0ea5e9',
                                        'Urgent Notice': '#0ea5e9'
                                    };

                                    let textColor = {
                                        'alert': '#856404',
                                        'info': '#01579b',
                                        'success': '#1b5e20',
                                        'warning': '#7f0000',
                                        'error': '#7f0000',
                                        'update': '#4a148c',
                                        'New Feature': '#137007',
                                        'Module Extension': '#4a148c',
                                        'System Update': '#1e293b',
                                        'Bug Fix': '#7f0000',
                                        'Visitor Alert': '#744210',
                                        'Security Alert': '#7f0000',
                                        'Admin Announcement': '#581c87',
                                        'Reminder': '#744210',
                                        'Urgent Notice': '#7f0000'
                                    };

                                    notifications.forEach(function(n, index){
                                        let icon = typeIcon[n.type] || 'fa-bell';
                                        let label = typeLabel[n.type] || 'NOTIFICATION';
                                        let color = iconColor[n.type] || '#2196f3';
                                        let bg = bgColor[n.type] || '#e3f2fd';
                                        let headerBg = headerBgColor[n.type];
                                        let textCol = textColor[n.type] || '#01579b';

                                        message += `
                                            <div style="background-color:${bg}; border: 3px solid ${color}; border-radius: 8px; margin-bottom: 15px; overflow: hidden; text-align: left; box-shadow: 0 4px 8px rgba(0,0,0,0.15);">
                                                <div style="background-color:${color}; color: white; padding: 10px; display: flex; align-items: center; justify-content: space-between; gap: 15px;">
                                                    <div style="display: flex; align-items: center; gap: 12px; flex: 1;">
                                                        <i class="fas ${icon}" style="font-size: 20px;"></i>
                                                        <div>
                                                           
                                                            <div style="font-weight: bold; font-size: 14px;">${label}</div>
                                                        </div>
                                                    </div>
                                                    <span style="font-size: 12px; background: rgba(255,255,255,0.3); padding: 5px 12px; border-radius: 12px; white-space: nowrap; font-weight: bold;">
                                                        ${index + 1} of ${notifications.length}
                                                    </span>
                                                </div>
                                                <div style="padding: 15px;">
                                                       <div style="text-align:right; color: ${textCol}; font-size: 12px; font-style: italic;">
                                                        <i class="fas fa-clock"></i> ${new Date(n.created_at).toLocaleString('en-US', { year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' })}
                                                    </div>

                                                    <strong style="font-size: 16px; color: ${textCol}; display: block; margin-bottom: 8px; margin-top: 8px;">${n.title}</strong>
                                                    <p style="margin: 0 0 12px 0; color: ${textCol}; font-size: 14px; line-height: 1.6;">
                                                        ${n.message.replace(/\r\n/g, '<br>').replace(/\n/g, '<br>')}
                                                    </p>
                                                 
                                                    ${n.attachment ? `
                                                        <div style="margin-top: 12px; padding-top: 12px; border-top: 1px solid ${color}; background: rgba(0,0,0,0.02); padding: 10px; border-radius: 4px;">
                                                            <a href="${n.attachment}" target="_blank" style="display: inline-flex; align-items: center; gap: 8px; background: ${color}; color: white; padding: 8px 12px; border-radius: 4px; text-decoration: none; font-size: 12px; font-weight: bold; transition: opacity 0.3s;">
                                                                <i class="fas fa-paperclip"></i>
                                                                <span>View Attachment</span>
                                                                <i class="fas fa-external-link-alt" style="font-size: 10px;"></i>
                                                            </a>
                                                        </div>
                                                    ` : ''}
                                                </div>
                                            </div>
                                        `;
                                    });

                                    callback(message);
                                }

               
/* ===================================================
   CLICK RIPPLE & PARTICLE BURST EFFECT
=================================================== */
(function () {
    // Particle colors — feel free to customize
    const particleColors = [
        '#4e79ff', '#ffae42', '#34c759',
        '#ff5b5b', '#7f67ff', '#00bcd4',
        '#0ea5e9', '#f59e0b', '#10b981'
    ];

    document.addEventListener('click', function (e) {
        spawnParticles(e.clientX, e.clientY);
    });

    function spawnParticles(x, y) {
        const count = 8;
        for (let i = 0; i < count; i++) {
            const el = document.createElement('div');
            el.classList.add('click-particle');

            // Random direction
            const angle  = (360 / count) * i + Math.random() * 20 - 10;
            const dist   = 28 + Math.random() * 22;
            const rad    = angle * (Math.PI / 180);
            const px     = Math.cos(rad) * dist;
            const py     = Math.sin(rad) * dist;

            // Random color
            const color  = particleColors[Math.floor(Math.random() * particleColors.length)];

            el.style.left            = x + 'px';
            el.style.top             = y + 'px';
            el.style.background      = color;
            el.style.setProperty('--px', px + 'px');
            el.style.setProperty('--py', py + 'px');
            el.style.animationDelay  = (Math.random() * 0.08) + 's';

            document.body.appendChild(el);
            el.addEventListener('animationend', () => el.remove());
        }
    }
})();


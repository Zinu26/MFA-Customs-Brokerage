<style>
    .notification-window {
        position: absolute;
        top: 80px;
        right: 120px;
        z-index: 1;
        background-color: white;
        border: 1px solid #ccc;
        padding: 10px;
        display: none;
    }

    .notification-window h3 {
        margin-top: 0;
    }

    .notification-window ul {
        list-style: none;
        margin: 0;
        padding: 100% 200px;
    }

    .notification-window li {
        margin-bottom: 10px;
    }

    .notification-window button {
        margin-top: 10px;
    }
</style>

<button type="button" id="notification-toggle" class="btn btn-primary position-relative">
    <i class="fas fa-bell"></i>
    <span id="notification-badge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
        99+
    </span>
</button>

<div id="notification-window" class="notification-window">
    <h3>Notifications</h3>
    <ul>
        <li></li>
    </ul>
</div>

{{-- Notification --}}
<script>
    // Get references to the notification toggle button, badge, and window
    const notificationToggle = document.getElementById('notification-toggle');
    const notificationBadge = document.getElementById('notification-badge');
    const notificationWindow = document.getElementById('notification-window');

    // Add a click event listener to the toggle button
    notificationToggle.addEventListener('click', function() {
        // Toggle the notification window's display style
        if (notificationWindow.style.display === 'block') {
            notificationWindow.style.display = 'none';
        } else {
            notificationWindow.style.display = 'block';
        }
    });

    // Add a click event listener to the close button
    const notificationClose = document.getElementById('notification-close');
    notificationClose.addEventListener('click', function() {
        // Hide the notification window
        notificationWindow.style.display = 'none';
    });

    // Update the badge count when the page loads
    notificationBadge.innerHTML = '3';
</script>

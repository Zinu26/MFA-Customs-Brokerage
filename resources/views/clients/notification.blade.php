<head>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .notification-window {
            position: absolute;
            top: 80px;
            right: 120px;
            z-index: 1;
            background-color: rgb(17, 40, 104);
            color: #ccc;
            border: 1px solid #ccc;
            padding: 10px;
            display: none;
            max-height: 500px;
            overflow-y: auto;
            scrollbar-width: none;
            /* Hide scrollbar for Firefox */
            -ms-overflow-style: none;
            /* Hide scrollbar for IE and Edge */
        }

        .notification-window::-webkit-scrollbar {
            /* Hide scrollbar for Chrome, Safari, and Opera */
            display: none;
        }

        .notification-window h3 {
            margin-top: 0;
        }

        .notification-window ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .notification-window li {
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            cursor: pointer;
        }

        .notification-window li:hover {
            background-color: #f8f8f8;
            color: black;
        }

        .notification-window li .notification-message {
            font-size: 16px;
            margin-bottom: 5px;
        }

        .notification-window li .notification-details {
            font-size: 12px;
            color: #666;
        }

        .notification-window button {
            margin-top: 10px;
        }

        @media (max-width: 1080px) {
            .notification-window {
                top: 90px;
                right: 20px;
            }

            .notification-window li {
                padding: 8px;
            }

            .notification-window li .notification-message {
                font-size: 14px;
            }

            .notification-window li .notification-details {
                font-size: 10px;
            }

            .notification-window button {
                margin-top: 5px;
            }
        }
    </style>
</head>

<button type="button" id="notification-toggle" class="btn btn-primary position-relative">
    <i class="fas fa-bell"></i>
    {{-- <span id="notification-badge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"> --}}
    {{-- display read_at null value count --}}
    {{-- {{ \App\Models\Notification::where('read_at', null)->where('notifiable_id', \Illuminate\Support\Facades\Auth::user()->id)->count() }}
    </span> --}}
</button>

<div id="notification-window" class="notification-window">
    <h3>Notifications</h3>
    <ul>
        @foreach ($notifications as $notification)
            <li class="notification-card {{ $notification->id === $latestNotification->id ? 'latest-notification' : '' }}"
                data-notification="{{ json_encode($notification) }}" data-notification-id="{{ $notification->id }}"
                data-bs-toggle="modal" data-bs-target="#viewModal">
                <div class="notification-message">
                    Shipment #{{ $notification->data['shipment_id'] }}: {{ $notification->data['message'] }}
                </div>
                <div class="notification-details">
                    @if ($notification->created_at->isToday())
                        Today, {{ $notification->created_at->format('h:i A') }}
                    @elseif ($notification->created_at->isYesterday())
                        Yesterday, {{ $notification->created_at->format('h:i A') }}
                    @else
                        {{ $notification->created_at->diffForHumans() }}
                    @endif
                </div>
            </li>
        @endforeach
    </ul>
</div>

<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="viewModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #29924c;">
                <h5 class="modal-title" id="notification-modal-label"></h5>
            </div>
            <div class="modal-body">
                <p id="notification-modal-body"></p>
            </div>
            {{-- <div class="modal-footer">
                <button type="button" class="btn btn-success mark-as-read-btn" data-bs-dismiss="modal">Mark as
                    Read</button>
            </div> --}}
        </div>
    </div>
</div>

<script>
    // Get references to the notification toggle button, badge, and window
    const notificationToggle = document.getElementById('notification-toggle');
    const notificationBadge = document.getElementById('notification-badge');
    const notificationWindow = document.getElementById('notification-window');

    // Get references to the modal elements
    const notificationModal = document.getElementById('notification-modal');
    const notificationModalTitle = document.getElementById('notification-modal-label');
    const notificationModalBody = document.getElementById('notification-modal-body');
    const notificationModalClose = document.getElementById('notification-close');


    // Add a click event listener to the toggle button
    notificationToggle.addEventListener('click', function() {
        // Toggle the notification window's display style
        if (notificationWindow.style.display === 'block') {
            notificationWindow.style.display = 'none';
        } else {
            notificationWindow.style.display = 'block';
        }
    });

    // Add a click event listener to the document
    document.addEventListener('click', function(event) {
        // Check if the clicked element is not part of the notification window
        if (!notificationWindow.contains(event.target) && event.target !== notificationToggle && event
            .target !== notificationBadge && notificationWindow.style.display === 'block') {
            // Hide the notification window
            notificationWindow.style.display = 'none';
        }

    });


    const notificationCards = document.querySelectorAll('.notification-card');
    notificationCards.forEach(function(card) {
        card.addEventListener('click', function() {
            // Get the notification data from the data attribute
            const notificationData = JSON.parse(card.dataset.notification);

            // Format the changes field in a readable way
            const changes = JSON.parse(notificationData.data.changes);
            const formattedChanges = JSON.stringify(changes, null, 2).replace(/,\n/g, '\n').replace(
                /"/g, '');


            // Set the title and body of the modal
            notificationModalTitle.textContent =
                `Shipment #${notificationData.data.shipment_id} | ${notificationData.data.message}`;
            notificationModalBody.innerHTML =
                `<p>Changes:</p><pre>${formattedChanges}</pre>`;

            // Show the modal
            const modal = new bootstrap.Modal(document.getElementById(`viewModal`));
            modal.show();
        });
    });
</script>
<script>
    var markAsReadBtns = document.getElementsByClassName('mark-as-read-btn');
    for (var i = 0; i < markAsReadBtns.length; i++) {
        markAsReadBtns[i].addEventListener('click', function() {
            var notificationId = this.closest('.notification-card').dataset.notificationId;
            markNotificationAsRead(notificationId);
            closeModal();
        });
    }

    function markNotificationAsRead(notificationId) {
        // Send an AJAX request to the server
        axios.post('/notifications/' + notificationId + '/mark-as-read')
            .then(function(response) {
                // Handle success response
                console.log(response.data);
            })
            .catch(function(error) {
                // Handle error response
                console.log(error);
            });
    }

    function closeModal() {
        var modal = document.getElementById('viewModal');
        var bootstrapModal = new bootstrap.Modal(modal);
        bootstrapModal.hide();
    }
</script>

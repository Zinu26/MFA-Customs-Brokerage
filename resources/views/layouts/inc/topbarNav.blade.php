<link rel="stylesheet" href="/css/topNav.css" />

<body class="p-0 m-0 border-0 bd-example">

    <nav class="navbar navbar-expand-lg bg-body-tertiary" style="height: 70px;">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><img src="/images/topnav_logo.png"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('landing') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about') }}">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('service') }}">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">Contact Us</a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Log in <i class="fa fa-user-circle"
                                    aria-hidden="true"></i></a>
                        </li>
                    @endauth
                </ul>
                <form class="d-flex" role="search" action="{{ route('search') }}" method="GET">
                    <input class="form-control me-2" type="text" name="bl_number" placeholder="Track Now"
                        aria-label="Search">
                    <button class="btn btn-outline-success" type="submit"><i class="fa fa-search"></i></button>
                </form>
            </div>
        </div>
    </nav>

    <div class="modal" id="search-modal" tabindex="-1" role="dialog" aria-labelledby="search-modal-label"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="search-modal-label">Search Result</h5>
                </div>
                <div class="modal-body">
                    <p id="search-result"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</body>
<!-- Include jQuery library -->

<script>
    $(function() {
        $('form[action="{{ route('search') }}"]').on('submit', function(e) {
            e.preventDefault();
            $.get($(this).attr('action'), $(this).serialize())
                .done(function(response) {
                    if ('bl_number' in response) {
                        $('#search-result').html(
                            '<p><strong>BL Number</strong>: ' + response.bl_number + '</p>' +
                            '<p><strong>Entry Number</strong>: ' + response.entry_number +
                            '</p>' +
                            '<p><strong>Port of Dispatch</strong>: ' + response.port_of_origin +
                            '</p>' +
                            '<p><strong>Arrival</strong>: ' + response.arrival + '</p>' +
                            '<p><strong>Process Start Date</strong>: ' + response.process_started +
                            '</p>' +
                            '<p><strong>Process End Date</strong>: ' + response.process_finished +
                            '</p>' +
                            '<p><strong>Predicted Delivery Date</strong>: ' + response.predicted_delivery_date +
                            '</p>' +
                            '<p><strong>Actual Delivery Date</strong>: ' + response.delivered_date +
                            '</p>' +
                            '<p><strong>DO Status</strong>: ' + response.do_status + '</p>' +
                            '<p><strong>Billing Status</strong>: ' + response.billing_status +
                            '</p>' +
                            '<p><strong>Shipment Status</strong>: ' + response.shipment_status +
                            '</p>'
                        );
                    } else if ('message' in response) {
                        $('#search-result').text(response.message);
                    }
                    $('#search-modal').modal('show');
                });
        });
    });
</script>

<link rel="stylesheet" href="/css/topNav.css" />


<nav>
    <div class="nav-bar">
        <i class="fa fa-bars sidebarOpen"></i>
        <span class="logo"><a href="#"><img src="/images/topnav_logo.png"></a></span>
        <div class="menu">
            <div class="logo-toggle">
                <span class="logo"><a href="#"><img src="/images/topnav_logo.png"></a></span>
                <i class="fa fa-xmark sidebarClose"></i>
            </div>
            <ul class="nav-links">
                <li><a aria-current="page" href="./">Home</a></li>
                <li><a href="{{ route('about') }}">About Us </a></li>
                <li><a href="{{ route('service') }}">Services </a></li>
                <li><a href="{{ route('contact') }}"> Contact Us </a></li>
                @auth
                    <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                @else
                    <li><a href="{{ route('login') }}">Log in <i class="fa fa-user-circle" aria-hidden="true"></i></a></li>
                @endauth
                <li class="search">
                    <form action="{{ route('search') }}" method="GET">
                        @csrf
                        <input type="text" name="bl_number" placeholder="Track Now">
                        <button type="submit"><i class="fa fa-search"></i></button>
                    </form>
                </li>
            </ul>
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


<!-- Include jQuery library -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
                            '<p><strong>Arrival</strong>: ' + response.arrival + '</p>' +
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

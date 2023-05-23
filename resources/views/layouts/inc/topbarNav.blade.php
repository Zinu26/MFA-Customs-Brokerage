<link rel="stylesheet" href="/css/topNav.css" />
<style>
    body {
        height: 100vh;
    }
    nav{
        position: absolute;
    }
    .nav-item .nav-link{
        color:white;
    }

    .nav-link:hover {
        background-color: rgb(33, 100, 54);
        border-radius: 10px;
    }

    @media screen and (max-width: 1080px) {
        nav {
            position: absolute;
            width: 100%;
        }
        .container-fluid {
            width: 100%;
            height: 80px;
            z-index: 99999;
            text-align: center;
            background: black;
        }
        .navbar-brand,.navbar-toggler,.navbar-collapse{
            margin-top: -75px;
        }
        .nav-item, form{
            background-color: black;
            padding-bottom: 10px;
        }
        form{
            padding: 30px;
        }
        .nav-item .nav-link{
            color: white;
        }
        .modal {
            z-index: 9999;
        }
        #search-modal.modal {
            top: 80px; /* Adjust this value as needed */
        }
    }
</style>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
<link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
</script>
<body class="p-0 m-0 border-0 bd-example">

    <nav class="navbar navbar-expand-lg bg-dark" style="height: 70px;">
        <div class="container-fluid" style="text-align: center; width: 100%; height: 80px; z-index: 99999; background: black;">
            <a class="navbar-brand" href="#"><img src="/images/topnav_logo.png"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span><i class="fa fa-bars fa-lg" style="color: white;"></i></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-0 mb-md-0">
                    <li class="nav-item" style="background-color: black; padding-bottom: 10px;">
                        <a class="nav-link text-white" href="{{ route('landing') }}">Home</a>
                    </li>
                    <li class="nav-item" style="background-color: black; padding-bottom: 10px;">
                        <a class="nav-link text-white" href="{{ route('about') }}">About Us</a>
                    </li>
                    <li class="nav-item" style="background-color: black; padding-bottom: 10px;">
                        <a class="nav-link text-white" href="{{ route('service') }}">Services</a>
                    </li>
                    <li class="nav-item" style="background-color: black; padding-bottom: 10px;">
                        <a class="nav-link text-white" href="{{ route('contact') }}">Contact Us</a>
                    </li>
                    @auth
                        @if (Auth::user()->type == 'admin')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                        @elseif(Auth::user()->type == 'employee')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('employee.dashboard') }}">Dashboard</a>
                            </li>
                        @elseif(Auth::user()->type == 'consignee')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('client.dashboard') }}">Dashboard</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item" style="background-color: black; padding-bottom: 10px;">
                            <a class="nav-link text-white" href="{{ route('login') }}">Log in <i class="fa fa-user-circle"
                                    aria-hidden="true"></i></a>
                        </li>
                    @endauth
                </ul>
                <form  style="background-color: black; padding-bottom: 10px;" class="d-flex" role="search" action="{{ route('search') }}" method="GET">
                    <input class="form-control me-2" type="text" name="bl_number" placeholder="Track Now"
                        aria-label="Search">
                    <button class="btn btn-outline-success" type="submit"><i class="fa fa-search"></i></button>
                </form>
            </div>
        </div>
    </nav>

    <div class="modal" id="search-modal" tabindex="-1" role="dialog" aria-labelledby="search-modal-label"
        aria-hidden="true" style="top: 100px;">
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
                    $('#navbarSupportedContent').collapse('hide'); // Hide the navigation collapse
                });
        });
    });
</script>

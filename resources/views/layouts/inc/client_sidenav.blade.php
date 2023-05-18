@include('layouts.inc.header')
<link rel="stylesheet" href="/css/sideNav.css" />

<body>
    <nav class="main-menu">
        <ul>
            <li><img src="/images/sidenav_logo.png" class="icon"></li>
            <li><img src="/images/logo_1.png" class="logo"></li>
            <li>
                <a href="{{ route('client.dashboard') }}">
                    <i class="fa fa-dashboard fa-2x"></i>
                    <span class="nav-text">
                        Dashboard
                    </span>
                </a>
            </li>
            <li>
                <a href="{{ route('consignee_open_shipment') }}">
                    <i class="fa fa-truck fa-2x"></i>
                    <span class="nav-text">
                        Shipments
                    </span>
                </a>
            </li>
        </ul>

        <ul class="logout">
            <li>
                <a href="{{ route('logout_client') }}">
                    <i class="fa fa-power-off fa-2x"></i>
                    <span class="nav-text">
                        Logout
                    </span>
                </a>
            </li>
        </ul>
    </nav>
</body>

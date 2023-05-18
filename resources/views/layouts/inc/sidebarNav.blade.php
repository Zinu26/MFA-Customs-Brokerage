@include('layouts.inc.header')
<link rel="stylesheet" href="/css/sideNav.css" />

<body>
    <nav class="main-menu">
        <ul>
            <li><img src="/images/sidenav_logo.png" class="icon"></li>
            <li><img src="/images/logo_1.png" class="logo"></li>
            <li>
                <a
                    href=" @if (Auth::user()->type == 'admin') {{ route('admin.dashboard') }} @elseif (Auth::user()->type == 'employee'){{ route('employee.dashboard') }} @endif">
                    <i class="fa fa-dashboard fa-2x"></i>
                    <span class="nav-text">
                        Dashboard
                    </span>
                </a>
            </li>
            @if (Auth::user()->type == 'admin')
                <li>
                    <a href="{{ route('admin_list') }}">
                        <i class="fa fa-user-tie fa-2x"></i>
                        <span class="nav-text">
                            Admin
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('employee_list') }}">
                        <i class="fa fa-address-card fa-2x"></i>
                        <span class="nav-text">
                            Employees
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('client_list') }}">
                        <i class="fa fa-users fa-2x"></i>
                        <span class="nav-text">
                            Clients
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('shipments') }}">
                        <i class="fa fa-truck fa-2x"></i>
                        <span class="nav-text">
                            Shipments
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.feedback') }}">
                        <i class="fa fa-envelope fa-2x"></i>
                        <span class="nav-text">
                            Feedbacks
                        </span>
                    </a>
                </li>
            @endif
            @if (Auth::user()->type == 'employee')
                <li>
                    <a href="{{ route('client_list.employee') }}">
                        <i class="fa fa-users fa-2x"></i>
                        <span class="nav-text">
                            Clients
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('shipments.employee') }}">
                        <i class="fa fa-truck fa-2x"></i>
                        <span class="nav-text">
                            Shipments
                        </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('employee.feedback') }}">
                        <i class="fa fa-envelope fa-2x"></i>
                        <span class="nav-text">
                            Feedbacks
                        </span>
                    </a>
                </li>
            @endif
        </ul>

        <ul class="logout">
            <li>
                <a href="{{ route('logout') }}">
                    <i class="fa fa-power-off fa-2x"></i>
                    <span class="nav-text">
                        Logout
                    </span>
                </a>
            </li>
        </ul>
    </nav>
</body>

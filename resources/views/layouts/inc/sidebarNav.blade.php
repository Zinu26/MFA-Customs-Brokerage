@include('layouts.inc.header')
<link rel="stylesheet" href="/css/sideNav.css" />

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<div class="sidebar">
    <div class="top">
        <div class="logo">
            <img src="/images/sidenav_logo.png" alt="" class="logo">
        </div>
        <i class="fa fa-bars" id="btn"></i>
    </div>
    <ul>
        <li><img src="/images/logo_1.png" alt="" class="icon"></li>
        <li><a href="{{ route('admin.dashboard') }}"><i class="fas fa-dashboard"></i><span
                    class="nav-item"> Dashboard</a><span class="tooltip">Dashboard</span></li>
        @if (Auth::user()->type == 'admin')
            <li><a href="{{ route('admin_list') }}"><i class="fas fa-user-tie"></i><span class="nav-item">Admin</a><span
                    class="tooltip"> Admin</span></li>
            <li><a href="{{ route('employee_list') }}"><i class="fas fa-address-card"></i><span
                        class="nav-item"> Employees</a><span class="tooltip">Employees</span></li>
            <li><a href="{{ route('client_list') }}"><i class="fas fa-users"></i><span class="nav-item">Clients</a><span
                    class="tooltip"> Clients</span></li>
            <li><a href="{{ route('shipments') }}"><i class="fas fa-truck"></i><span
                        class="nav-item"> Shipments</span></a><span class="tooltip"> Shipments</span></li>
            <li><a href="{{route('admin.feedback')}}"><i class="fas fa-envelope"></i><span class="nav-item">Feedbacks</span></a><span
                    class="tooltip"> Feedbacks</span></li>
        @endif
        @if (Auth::user()->type == 'employee')
            <li><a href="{{ route('client_list.employee') }}"><i class="fas fa-users"></i><span class="nav-item"> Clients</a><span
                    class="tooltip">Clients</span></li>
            <li><a href="{{ route('shipments.employee') }}"><i class="fas fa-truck"></i><span
                        class="nav-item">Shipments</span></a><span class="tooltip"> Shipments</span></li>
            <li><a href="{{route('employee.feedback')}}"><i class="fas fa-envelope"></i><span class="nav-item"> Feedbacks</span></a><span
                    class="tooltip">Feedbacks</span></li>
        @endif
        <li><a href="{{ route('logout') }}" class="logout"><i class="fas fa-power-off"></i><span
                    class="nav-item"> Logout</span></a></li>

    </ul>
</div>

<script>
    let btn = document.querySelector('#btn')
    let sidebar = document.querySelector('.sidebar')

    btn.onclick = function() {
        sidebar.classList.toggle('active');
    };
</script>

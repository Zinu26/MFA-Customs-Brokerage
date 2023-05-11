@include('layouts.inc.header')
<link rel="stylesheet" href="/css/sideNav.css" />

<div class="sidebar">
    <div class="top">
        <div class="logo">
            <img src="/images/sidenav_logo.png" alt="" class="logo">
        </div>
        <i class="fa fa-bars" id="btn"></i>
    </div>
    <ul>
        <li><img src="/images/logo_1.png" alt="" class="icon"></li>
        <li><a href="{{route('admin.dashboard')}}"><i class="fas fa-dashboard"></i><span class="nav-item">Dashboard</a><span class="tooltip">Dashboard</span></li>
        @if(Auth::user()->type == 0)
            <li><a href="{{route('admin_list')}}"><i class="fas fa-user-tie"></i><span class="nav-item">Admin</a><span class="tooltip">Admin</span></li>
            <li><a href="{{route('employee_list')}}"><i class="fas fa-address-card"></i><span class="nav-item">Employees</a><span class="tooltip">Employees</span></li>
        @endif
            <li><a href="{{route('client_list')}}"><i class="fas fa-users"></i><span class="nav-item">Clients</a><span class="tooltip">Clients</span></li>
            <li><a href="{{route('shipments')}}"><i class="fas fa-truck"></i><span class="nav-item">Shipments</span></a><span class="tooltip">Shipments</span></li>
            <li><a href=""><i class="fas fa-envelope"></i><span class="nav-item">Feedbacks</span></a><span class="tooltip">Feedbacks</span></li>
            <li><a href="{{route('logout')}}" class="logout"><i class="fas fa-power-off"></i><span class="nav-item">Logout</span></a></li>

    </ul>
</div>

<script>
    let btn = document.querySelector('#btn')
    let sidebar = document.querySelector('.sidebar')

    btn.onclick = function () {
        sidebar.classList.toggle('active');
    };
</script>

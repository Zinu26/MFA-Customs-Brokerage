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

        <li><a href="{{route('client.dashboard')}}"><i class="fas fa-dashboard"></i><span class="nav-item">Dashboard</span></a><span
                class="tooltip">Dashboard</span></li>
        <li><a href="{{route('consignee_open_shipment')}}"><i class="fas fa-truck"></i><span class="nav-item">Shipments</span></a><span
                class="tooltip">Shipments</span></li>
        <li><a href=""><i class="fas fa-bell"></i><span class="nav-item">Notifications</span></a><span
                class="tooltip">Notifications</span></li>
        <li><a href="{{ route('logout_client') }}" class="logout"><i class="fas fa-power-off"></i><span
                    class="nav-item">Logout</span></a></li>

    </ul>
</div>

<script>
    let btn = document.querySelector('#btn')
    let sidebar = document.querySelector('.sidebar')

    btn.onclick = function() {
        sidebar.classList.toggle('active');
    };
</script>

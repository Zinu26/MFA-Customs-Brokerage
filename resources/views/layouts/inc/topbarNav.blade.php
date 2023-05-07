<link rel="stylesheet" href="/css/style.css" />
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
                <li><a href="{{route('about')}}">About Us </a></li>
                <li><a href="{{route('service')}}">Our Services </a></li>
                <li><a href="{{route('contact')}}"> Contact Us </a></li>
                <li><a href="{{route('login')}}">Log in<i class="fa fa-user-circle" aria-hidden="true"></i></a></li>
            </ul>
        </div>

    </div>
</nav>

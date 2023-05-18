<div class="mobile-main-header">
    <div class="mb-1 navbar navbar-expand-lg  nav nav-item  navbar-nav-right responsive-navbar navbar-dark  ">
        <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
            
            <div class="dropdown main-profile-menu">
                <a class="d-flex" href="#">
                    <span class="main-img-user" ><img alt="avatar" src="{{ asset('assets/img/users/1.jpg') }}"></span>
                </a>
                <div class="dropdown-menu">
                    <div class="header-navheading">
                        <h6 class="main-notification-title">{{ auth()->user()->name }}</h6>
                        <p class="main-notification-text">Admin</p>
                    </div>
                    <a class="dropdown-item border-top" href="{{ asset('admin/settings/index') }}">
                        <i class="fe fe-user"></i> My Profile
                    </a>
                    <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fe fe-power"></i> Sign Out
                    </a>
                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        
        </div>
    </div>
</div>
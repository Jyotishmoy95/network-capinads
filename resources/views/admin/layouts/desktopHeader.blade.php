<div class="main-header side-header sticky">
    <div class="container-fluid">
        <div class="main-header-left">
            <a class="main-header-menu-icon" href="#" id="mainSidebarToggle"><span></span></a>
        </div>
        <div class="main-header-center">
            <div class="responsive-logo">
                <a href="{{ asset('admin/dashboard') }}"><img src="{{ asset('logo.png') }}" style="width:150px;" class="mobile-logo" alt="logo"></a>
                <a href="{{ asset('admin/dashboard') }}"><img src="{{ asset('logo.png') }}" class="mobile-logo-dark" alt="logo"></a>
            </div>
        </div>
        <div class="main-header-right">

            <button class="navbar-toggler navresponsive-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-4" aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
				<i class="fe fe-more-vertical header-icons navbar-toggler-icon"></i>
			</button>

            <div class="dropdown d-md-flex">
                <a class="nav-link icon full-screen-link" href="#">
                    <i class="fe fe-maximize fullscreen-button fullscreen header-icons"></i>
                    <i class="fe fe-minimize fullscreen-button exit-fullscreen header-icons"></i>
                </a>
            </div>
            <!-- <div class="dropdown main-header-notification">
                <a class="nav-link icon" href="#">
                    <i class="fe fe-bell header-icons"></i>
                    <span class="badge badge-danger nav-link-badge">4</span>
                </a>
                <div class="dropdown-menu">
                    <div class="header-navheading">
                        <p class="main-notification-text">You have 1 unread notification<span class="badge badge-pill badge-primary ml-3">View all</span></p>
                    </div>
                    <div class="main-notification-list">
                        <div class="media new">
                            <div class="main-img-user online"><img alt="avatar" src="assets/img/users/5.jpg"></div>
                            <div class="media-body">
                                <p>Congratulate <strong>Olivia James</strong> for New template start</p><span>Oct 15 12:32pm</span>
                            </div>
                        </div>
                        <div class="media">
                            <div class="main-img-user"><img alt="avatar" src="assets/img/users/2.jpg"></div>
                            <div class="media-body">
                                <p><strong>Joshua Gray</strong> New Message Received</p><span>Oct 13 02:56am</span>
                            </div>
                        </div>
                        <div class="media">
                            <div class="main-img-user online"><img alt="avatar" src="assets/img/users/3.jpg"></div>
                            <div class="media-body">
                                <p><strong>Elizabeth Lewis</strong> added new schedule realease</p><span>Oct 12 10:40pm</span>
                            </div>
                        </div>
                    </div>
                    <div class="dropdown-footer">
                        <a href="#">View All Notifications</a>
                    </div>
                </div>
            </div> -->
            <div class="dropdown main-profile-menu">
                <a class="d-flex" href="#">
                    <span class="main-img-user" ><img alt="avatar" src="{{ asset('assets/img/blank-user.webp') }}"></span>
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
<!-- Sidemenu -->
<div class="main-sidebar main-sidebar-sticky side-menu">
    <div class="sidemenu-logo">
        <a class="main-logo" href="index.html">
            <img src="{{ asset('logo.png') }}" class="header-brand-img desktop-logo" alt="logo">
            <img src="{{ asset('logo.png') }}" class="header-brand-img icon-logo" alt="logo">
            <img src="{{ asset('logo.png') }}" class="header-brand-img desktop-logo theme-logo" alt="logo">
            <img src="{{ asset('logo.png') }}" class="header-brand-img icon-logo theme-logo" alt="logo">
        </a>
    </div>
    <div class="main-sidebar-body">
        <ul class="nav">
            <li class="nav-header"><span class="nav-label">Dashboard</span></li>
            <li class="nav-item {{ request()->is('member/dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ asset('member/dashboard') }}"><span class="shape1"></span><span class="shape2"></span><i class="ti-home sidemenu-icon"></i><span class="sidemenu-label">Dashboard</span></a>
            </li>
            <li class="nav-item {{ request()->is('member/view-ads/*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ asset('member/view-ads/index') }}"><span class="shape1"></span><span class="shape2"></span><i class="ti-video-camera sidemenu-icon"></i><span class="sidemenu-label">View Ads</span></a>
            </li>
            <li class="nav-header"><span class="nav-label">Fund Requests</span></li>
            <li class="nav-item {{ request()->is('member/fund-request/*') ? 'active show' : '' }}">
                <a class="nav-link with-sub" href="#"><span class="shape1"></span><span class="shape2"></span><i class="ti-download sidemenu-icon"></i><span class="sidemenu-label">Fund Requests</span><i class="angle fe fe-chevron-right"></i></a>
                <ul class="nav-sub">
                    <li class="nav-sub-item {{ request()->is('member/fund-request/new') ? 'active' : '' }}">
                        <a class="nav-sub-link" href="{{ asset('member/fund-request/new') }}">New Request</a>
                    </li>
                    <li class="nav-sub-item {{ request()->is('member/fund-request/list') ? 'active' : '' }}">
                        <a class="nav-sub-link" href="{{ asset('member/fund-request/list') }}">Fund Request List</a>
                    </li>
                </ul>
            </li>
            <!-- <li class="nav-item {{ request()->is('member/epins/*') ? 'active show' : '' }}">
                <a class="nav-link with-sub" href="#"><span class="shape1"></span><span class="shape2"></span><i class="ti-key sidemenu-icon"></i><span class="sidemenu-label">E-Pins</span><i class="angle fe fe-chevron-right"></i></a>
                <ul class="nav-sub">
                    <li class="nav-sub-item {{ request()->is('member/epins/available') ? 'active' : '' }}">
                        <a class="nav-sub-link" href="{{ asset('member/epins/available') }}">Available E-Pins</a>
                    </li>
                    <li class="nav-sub-item {{ request()->is('member/epins/applied') ? 'active' : '' }}">
                        <a class="nav-sub-link" href="{{ asset('member/epins/applied') }}">Applied E-Pins</a>
                    </li>
                </ul>
            </li> -->
            <li class="nav-header"><span class="nav-label">Membership</span></li>
            <li class="nav-item">
                <a class="nav-link" href="{{ asset('member/register/'.auth()->user()->member_id) }}" target="_blank"><span class="shape1"></span><span class="shape2"></span><i class="ti-user sidemenu-icon"></i><span class="sidemenu-label">New Membership</span></a>
            </li>
            <li class="nav-item {{ request()->is('member/activations/*') ? 'active show' : '' }}">
                <a class="nav-link with-sub" href="#"><span class="shape1"></span><span class="shape2"></span><i class="ti-check-box sidemenu-icon"></i><span class="sidemenu-label">Activations</span><i class="angle fe fe-chevron-right"></i></a>
                <ul class="nav-sub">
                    <li class="nav-sub-item {{ request()->is('member/activations/new') ? 'active' : '' }}">
                        <a class="nav-sub-link" href="{{ asset('member/activations/new') }}">New Activation</a>
                    </li>
                    <li class="nav-sub-item {{ request()->is('member/activations/report') ? 'active' : '' }}">
                        <a class="nav-sub-link" href="{{ asset('member/activations/report') }}">Activation Report</a>
                    </li>
                </ul>
            </li>

            <li class="nav-header"><span class="nav-label">Network</span></li>
            <li class="nav-item {{ request()->is('member/network/*') ? 'active show' : '' }}">
                <a class="nav-link with-sub" href="#"><span class="shape1"></span><span class="shape2"></span><i class="ti-rss sidemenu-icon"></i><span class="sidemenu-label">Network</span><i class="angle fe fe-chevron-right"></i></a>
                <ul class="nav-sub">
                    <li class="nav-sub-item {{ request()->is('member/network/referrals') ? 'active' : '' }}">
                        <a class="nav-sub-link" href="{{ asset('member/network/referrals') }}">Direct Referrals</a>
                    </li>
                    <li class="nav-sub-item {{ request()->is('member/network/downline-team') ? 'active' : '' }}">
                        <a class="nav-sub-link" href="{{ asset('member/network/downline-team') }}">Downline Team</a>
                    </li>
                </ul>
            </li>

            <li class="nav-header"><span class="nav-label">Earnings & Withdrawals</span></li>
            <li class="nav-item {{ request()->is('member/reports/wallet') ? 'active' : '' }}">
                <a class="nav-link" href="{{ asset('member/reports/wallet') }}"><span class="shape1"></span><span class="shape2"></span><i class="ti-wallet sidemenu-icon"></i><span class="sidemenu-label">Wallet Report</span></a>
            </li>
            <li class="nav-item {{ request()->is('member/reports/incentives') ? 'active' : '' }}">
                <a class="nav-link" href="{{ asset('member/reports/incentives') }}"><span class="shape1"></span><span class="shape2"></span><i class="ti-credit-card sidemenu-icon"></i><span class="sidemenu-label">Incentive Report</span></a>
            </li>
            <li class="nav-item {{ request()->is('member/withdrawals') ? 'active' : '' }}">
                <a class="nav-link" href="{{ asset('member/withdrawals') }}"><span class="shape1"></span><span class="shape2"></span><i class="ti-export sidemenu-icon"></i><span class="sidemenu-label">Withdrawals</span></a>
            </li>
            
            <li class="nav-header"><span class="nav-label">Settings</span></li>
            <li class="nav-item {{ request()->is('member/settings/*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ asset('member/settings/index') }}"><span class="shape1"></span><span class="shape2"></span><i class="ti-settings sidemenu-icon"></i><span class="sidemenu-label">Settings</span></a>
            </li>
        </ul>
    </div>
</div>
<!-- End Sidemenu -->
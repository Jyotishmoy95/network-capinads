<!-- Sidemenu -->
<div class="main-sidebar main-sidebar-sticky side-menu">
    <div class="sidemenu-logo">
        <a class="main-logo" href="{{ asset('admin/dashboard') }}">
            <img src="{{ asset('logo.png') }}" class="header-brand-img desktop-logo" alt="logo">
            <img src="{{ asset('logo.png') }}" class="header-brand-img icon-logo" alt="logo">
            <img src="{{ asset('logo.png') }}" class="header-brand-img desktop-logo theme-logo" alt="logo">
            <img src="{{ asset('logo.png') }}" class="header-brand-img icon-logo theme-logo" alt="logo">
        </a>
    </div>
    <div class="main-sidebar-body">
        <ul class="nav">
            <li class="nav-header"><span class="nav-label">Dashboard</span></li>
            <li class="nav-item {{ request()->segment(2) == 'dashboard' ? 'active' : '' }}">
                <a class="nav-link" href="{{ asset('admin/dashboard') }}"><span class="shape1"></span><span class="shape2"></span><i class="ti-home sidemenu-icon"></i><span class="sidemenu-label">Dashboard</span></a>
            </li>
            <li class="nav-item {{ request()->is('admin/ad-details/*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ asset('admin/ad-details/index') }}"><span class="shape1"></span><span class="shape2"></span><i class="ti-video-camera sidemenu-icon"></i><span class="sidemenu-label">Ad Details</span></a>
            </li>

            <li class="nav-item {{ request()->is('admin/packages/*') ? 'active show' : '' }}">
                <a class="nav-link with-sub" href="#"><span class="shape1"></span><span class="shape2"></span><i class="ti-gift sidemenu-icon"></i><span class="sidemenu-label">Packages</span><i class="angle fe fe-chevron-right"></i></a>
                <ul class="nav-sub">
                    <li class="nav-sub-item {{ request()->is('admin/packages/create') ? 'active' : '' }}">
                        <a class="nav-sub-link" href="{{ asset('admin/packages/create') }}">Create New Package</a>
                    </li>
                    <li class="nav-sub-item {{ request()->is('admin/packages/list') ? 'active' : '' }}">
                        <a class="nav-sub-link" href="{{ asset('admin/packages/list') }}">Packages List</a>
                    </li>
                </ul>
            </li>

            <li class="nav-header"><span class="nav-label">Fund Transfer / Requests</span></li>
            <li class="nav-item {{ request()->is('admin/fund-transfer/*') ? 'active show' : '' }}">
                <a class="nav-link with-sub" href="#"><span class="shape1"></span><span class="shape2"></span><i class="ti-share sidemenu-icon"></i><span class="sidemenu-label">Fund Transfer</span><i class="angle fe fe-chevron-right"></i></a>
                <ul class="nav-sub">
                    <li class="nav-sub-item {{ request()->is('admin/fund-transfer/new') ? 'active' : '' }}">
                        <a class="nav-sub-link" href="{{ asset('admin/fund-transfer/new') }}">New Fund Transfer</a>
                    </li>
                    <li class="nav-sub-item {{ request()->is('admin/fund-transfer/list') ? 'active' : '' }}">
                        <a class="nav-sub-link" href="{{ asset('admin/fund-transfer/list') }}">Fund Transfer List</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item {{ request()->is('admin/fund-requests/*') ? 'active show' : '' }}">
                <a class="nav-link with-sub" href="#"><span class="shape1"></span><span class="shape2"></span><i class="ti-download sidemenu-icon"></i><span class="sidemenu-label">Fund Requests</span><i class="angle fe fe-chevron-right"></i></a>
                <ul class="nav-sub">
                    <li class="nav-sub-item {{ request()->is('admin/fund-requests/pending') ? 'active' : '' }}">
                        <a class="nav-sub-link" href="{{ asset('admin/fund-requests/pending') }}">Pending Fund requests</a>
                    </li>
                    <li class="nav-sub-item {{ request()->is('admin/fund-requests/approved') ? 'active' : '' }}">
                        <a class="nav-sub-link" href="{{ asset('admin/fund-requests/approved') }}">Approved Fund requests</a>
                    </li>
                    <li class="nav-sub-item {{ request()->is('admin/fund-requests/rejected') ? 'active' : '' }}">
                        <a class="nav-sub-link" href="{{ asset('admin/fund-requests/rejected') }}">Rejected Fund requests</a>
                    </li>
                </ul>
            </li>

            <li class="nav-header"><span class="nav-label">Membership</span></li>
            <li class="nav-item">
                <a class="nav-link" href="{{ asset('member/register/CAP1001') }}" target="_blank"><span class="shape1"></span><span class="shape2"></span><i class="ti-user sidemenu-icon"></i><span class="sidemenu-label">New Membership</span></a>
            </li>
            <li class="nav-item {{ request()->is('admin/activations/*') ? 'active show' : '' }}">
                <a class="nav-link with-sub" href="#"><span class="shape1"></span><span class="shape2"></span><i class="ti-check-box sidemenu-icon"></i><span class="sidemenu-label">Activations</span><i class="angle fe fe-chevron-right"></i></a>
                <ul class="nav-sub">
                    <li class="nav-sub-item {{ request()->is('admin/activations/new') ? 'active' : '' }}">
                        <a class="nav-sub-link" href="{{ asset('admin/activations/new') }}">New Activation</a>
                    </li>
                    <li class="nav-sub-item {{ request()->is('admin/activations/report') ? 'active' : '' }}">
                        <a class="nav-sub-link" href="{{ asset('admin/activations/report') }}">Activation Report</a>
                    </li>
                </ul>
            </li>
            <!-- <li class="nav-item">
                <a class="nav-link with-sub" href="#"><span class="shape1"></span><span class="shape2"></span><i class="ti-thumb-up sidemenu-icon"></i><span class="sidemenu-label">Re-topups</span><i class="angle fe fe-chevron-right"></i></a>
                <ul class="nav-sub">
                    <li class="nav-sub-item">
                        <a class="nav-sub-link" href="{{ asset('admin/re-topups/new') }}">New Re-topup</a>
                    </li>
                    <li class="nav-sub-item">
                        <a class="nav-sub-link" href="{{ asset('admin/re-topups/report') }}">Re-topup Report</a>
                    </li>
                </ul>
            </li> -->

            <li class="nav-header"><span class="nav-label">Network & Team</span></li>
            <li class="nav-item {{ request()->is('admin/members/*') ? 'active show' : '' }}">
                <a class="nav-link with-sub" href="#"><span class="shape1"></span><span class="shape2"></span><i class="ti-id-badge sidemenu-icon"></i><span class="sidemenu-label">Team</span><i class="angle fe fe-chevron-right"></i></a>
                <ul class="nav-sub">
                    <li class="nav-sub-item {{ request()->is('admin/members/index') ? 'active' : '' }}">
                        <a class="nav-sub-link" href="{{ asset('admin/members/index') }}">All Members</a>
                    </li>
                    <li class="nav-sub-item {{ request()->is('admin/members/working') ? 'active' : '' }}">
                        <a class="nav-sub-link" href="{{ asset('admin/members/working') }}">Working IDs</a>
                    </li>
                    <li class="nav-sub-item {{ request()->is('admin/members/non-working') ? 'active' : '' }}">
                        <a class="nav-sub-link" href="{{ asset('admin/members/non-working') }}">Non Working IDs</a>
                    </li>
                    <!-- <li class="nav-sub-item {{ request()->is('admin/members/blocked') ? 'active' : '' }}">
                        <a class="nav-sub-link" href="{{ asset('admin/members/blocked') }}">Blocked IDs</a>
                    </li> -->
                </ul>
            </li>
            <li class="nav-item {{ request()->is('admin/network/*') ? 'active show' : '' }}">
                <a class="nav-link with-sub" href="#"><span class="shape1"></span><span class="shape2"></span><i class="ti-rss sidemenu-icon"></i><span class="sidemenu-label">Network</span><i class="angle fe fe-chevron-right"></i></a>
                <ul class="nav-sub">
                    <li class="nav-sub-item {{ request()->is('admin/network/referrals') ? 'active' : '' }}">
                        <a class="nav-sub-link" href="{{ asset('admin/network/referrals') }}">Direct Referrals</a>
                    </li>
                    <li class="nav-sub-item {{ request()->is('admin/network/downline-team') ? 'active' : '' }}">
                        <a class="nav-sub-link" href="{{ asset('admin/network/downline-team') }}">Downline Team</a>
                    </li>
                </ul>
            </li>

            <li class="nav-header"><span class="nav-label">Earnings & Wallets</span></li>
            <li class="nav-item {{ request()->is('admin/reports/earnings') || request()->is('admin/reports/incentives') ? 'active show' : '' }}">
                <a class="nav-link with-sub" href="#"><span class="shape1"></span><span class="shape2"></span><i class="ti-money sidemenu-icon"></i><span class="sidemenu-label">Earnings</span><i class="angle fe fe-chevron-right"></i></a>
                <ul class="nav-sub">
                    <li class="nav-sub-item {{ request()->is('admin/reports/earnings') ? 'active' : '' }}">
                        <a class="nav-sub-link" href="{{ asset('admin/reports/earnings') }}">Total Earnings</a>
                    </li>
                    <li class="nav-sub-item {{ request()->is('admin/reports/incentives') ? 'active' : '' }}">
                        <a class="nav-sub-link" href="{{ asset('admin/reports/incentives') }}">Incentives</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item {{ request()->is('admin/reports/account') || request()->is('admin/reports/wallet') ? 'active show' : '' }}">
                <a class="nav-link with-sub" href="#"><span class="shape1"></span><span class="shape2"></span><i class="ti-wallet sidemenu-icon"></i><span class="sidemenu-label">Wallet Details</span><i class="angle fe fe-chevron-right"></i></a>
                <ul class="nav-sub">
                    <li class="nav-sub-item {{ request()->is('admin/reports/wallet') ? 'active' : '' }}">
                        <a class="nav-sub-link" href="{{ asset('admin/reports/wallet') }}">Wallet Balance</a>
                    </li>
                    <li class="nav-sub-item {{ request()->is('admin/reports/account') ? 'active' : '' }}">
                        <a class="nav-sub-link" href="{{ asset('admin/reports/account') }}">Account Report</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item {{ request()->is('admin/reports/withdrawals') ? 'active' : '' }}">
                <a class="nav-link" href="{{ asset('admin/reports/withdrawals') }}"><span class="shape1"></span><span class="shape2"></span><i class="ti-export sidemenu-icon"></i><span class="sidemenu-label">Withdrawal Report</span></a>
            </li>
            
            <li class="nav-header"><span class="nav-label">Settings</span></li>
            <li class="nav-item {{ request()->is('admin/settings/*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ asset('admin/settings/index') }}"><span class="shape1"></span><span class="shape2"></span><i class="ti-settings sidemenu-icon"></i><span class="sidemenu-label">Settings</span></a>
            </li>
            <li class="nav-item {{ request()->is('admin/news/*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ asset('admin/news/index') }}"><span class="shape1"></span><span class="shape2"></span><i class="ti-announcement sidemenu-icon"></i><span class="sidemenu-label">News & Notifications</span></a>
            </li>
            <li class="nav-item {{ request()->is('admin/downloads/*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ asset('admin/downloads/index') }}"><span class="shape1"></span><span class="shape2"></span><i class="ti-files sidemenu-icon"></i><span class="sidemenu-label">Promotional Files</span></a>
            </li>
        </ul>
    </div>
</div>
<!-- End Sidemenu -->
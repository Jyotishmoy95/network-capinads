@extends('admin.layouts.master')

@section('title', 'Settings')

@section('page-css')
    <!-- Internal DataTables css-->
	<link href="{{ asset('assets/plugins/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('assets/plugins/datatable/responsivebootstrap4.min.css') }}" rel="stylesheet" />
@endsection

@section('content')

    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h2 class="main-content-title tx-24 mg-b-5">Settings</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ asset('/admin/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Settings</li>
            </ol>
        </div>
    </div>
    <!-- End Page Header -->

    <!-- Row -->
    <div class="row row-sm">
        <div class="col-xl-3 col-lg-12 col-md-12">
            <div class="card custom-card">
                <!-- <div class="card-header">
                    <h3 class="main-content-label">My Account</h3>
                </div> -->
                <div class="card-body text-center item-user">
                    <div class="profile-pic">
                        <div class="profile-pic-img">
                            <span class="bg-success dots" data-toggle="tooltip" data-placement="top" title="online"></span>
                            <img src="{{ asset('assets/img/blank-user.webp') }}" width="200" class="rounded-circle" alt="user">
                        </div>
                        <a href="#" class="text-dark"><h5 class="mt-3 mb-0 font-weight-semibold">{{ auth()->user()->name }}</h5></a>
                    </div>
                </div>
                <ul class="item1-links nav nav-tabs  mb-0">
                    <li class="nav-item">
                        <a data-target="#profile" class="nav-link active" data-toggle="tab" role="tablist"><i class="ti-user icon1"></i> My Profile</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a data-target="#welcome" class="nav-link" data-toggle="tab" role="tablist"><i class="ti-gift icon1"></i> Welcome Letter</a>
                    </li> -->
                    <li class="nav-item">
                        <a data-target="#block-modules" class="nav-link" data-toggle="tab" role="tablist"><i class="ti-lock icon1"></i> Block Modules</a>
                    </li>
                    <li class="nav-item">
                        <a data-target="#withdraw" class="nav-link" data-toggle="tab" role="tablist"><i class="ti-wallet icon1"></i> Withdraw & Deduction Settings</a>
                    </li>
                    <li class="nav-item">
                        <a data-target="#ad-setting" class="nav-link" data-toggle="tab" role="tablist"><i class="ti-video-camera icon1"></i> Ad Income Settings</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="col-xl-9 col-lg-12 col-md-12">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="tab-content" id="myTabContent">
                        @include('admin.pages.settings.partials.profile')
                        
                        <!-- @include('admin.pages.settings.partials.welcome-letter') -->

                        @include('admin.pages.settings.partials.block-modules')

                        @include('admin.pages.settings.partials.withdraw-deduction')

                        @include('admin.pages.settings.partials.ad-settings')

                        <div class="tab-pane fade" id="profile" role="tabpanel">
                            <div class="d-flex align-items-start pb-3 border-bottom"> <img src="assets/img/users/1.jpg" class="img rounded-circle avatar-xl" alt="">
                                <div class="pl-sm-4 pl-2" id="img-section"> <b>Profile Photo</b>
                                    <p class="mb-1">Accepted file type .png. Less than 1MB</p> <button class="btn button border btn-sm"><b>Upload</b></button>
                                </div>
                            </div>
                            <div class="py-2">
                                <div class="row py-2">
                                    <div class="col-md-6"> <label id="firstname">First Name</label> <input type="text" class="form-control" placeholder="Steve"> </div>
                                    <div class="col-md-6 pt-md-0 pt-3"> <label id="last-name">Last Name</label> <input type="text" class="form-control" placeholder="Smith"> </div>
                                </div>
                                <div class="row py-2">
                                    <div class="col-md-6"> <label id="emailid">Email Address</label> <input type="text" class="form-control" placeholder="steve_@email.com"> </div>
                                    <div class="col-md-6 pt-md-0 pt-3"> <label id="phoneno">Phone Number</label> <input type="tel" class="form-control" placeholder="+1 213-548-6015"> </div>
                                </div>
                                <div class="row py-2">
                                    <div class="col-md-6">
                                        <label for="country">Country</label>
                                        <select name="country" id="country" class="select2-no-search">
                                            <option value="india" selected>India</option>
                                            <option value="usa">USA</option>
                                            <option value="uk">UK</option>
                                            <option value="uae">UAE</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 pt-md-0 pt-3" id="lang"> <label for="language">Language</label>
                                        <div class="arrow">
                                            <select name="language" id="language" class="select2-no-search">
                                                <option value="english" selected>English</option>
                                                <option value="english_us">English (United States)</option>
                                                <option value="enguk">English UK</option>
                                                <option value="arab">Arabic</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- End Row -->

@endsection

@section('page-js')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>   
    @include('admin.pages.settings.js.profile')
    @include('admin.pages.settings.js.welcome_letter')
    @include('admin.pages.settings.js.block_modules')
    @include('admin.pages.settings.js.withdraw_deduction')
    @include('admin.pages.settings.js.ad_settings')
@endsection
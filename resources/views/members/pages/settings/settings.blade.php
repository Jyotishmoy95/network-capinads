@extends('members.layouts.master')

@section('title', 'Settings')

@section('page-css')
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
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
                            <img src="{{ asset('uploads/profile-pictures/'.auth()->user()->photo) }}" id="user-profile-img" width="200" class="rounded-circle" alt="user">
                        </div>
                        <a href="#" class="text-dark"><h5 class="mt-3 mb-0 font-weight-semibold">{{ auth()->user()->full_name }}</h5></a>
                        <p class="text-muted mb-0 mt-2">{{ auth()->user()->member_id }}</p>
                    </div>
                </div>
                <ul class="item1-links nav nav-tabs  mb-0">
                    <li class="nav-item">
                        <a data-target="#profile" class="nav-link" data-toggle="tab" role="tablist"><i class="ti-user icon1"></i> My Profile</a>
                    </li>
                    <li class="nav-item">
                        <a data-target="#welcome" class="nav-link" data-toggle="tab" role="tablist"><i class="ti-gift icon1"></i> Bank Details</a>
                    </li>
                    <li class="nav-item">
                        <a data-target="#documents" class="nav-link" data-toggle="tab" role="tablist"><i class="ti-files icon1"></i> Verification Documents</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="col-xl-9 col-lg-12 col-md-12">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="tab-content" id="myTabContent">
                        @include('members.pages.settings.partials.profile')
                        @include('members.pages.settings.partials.bankDetails')
                        @include('members.pages.settings.partials.documents')
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- End Row -->
@endsection

@section('page-js')
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>   
    @include('members.pages.settings.js.profile')
    @include('members.pages.settings.js.bankDetails')
    @include('members.pages.settings.js.documents')

    <script>
        $(document).ready(function(){


            $('.select2').select2({
                width: '100%'
            });

            //make tab active based on url partial
            const url = window.location.href;
            const tab = url.split('#');
            const target_tab = tab[1] ? tab[1] : 'profile';
            //make required tab active
            $(`[data-target="#${target_tab}"]`).addClass('active');
            //remove active class from other tabs
            $('.tab-pane').removeClass('active');
            //show required tab content
            $(`#${target_tab}`).addClass('active');
        })
    </script>

@endsection
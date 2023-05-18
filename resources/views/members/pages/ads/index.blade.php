@extends('members.layouts.master')

@section('title', 'View Ads')

@section('page-css')
    <style>
        .light-br{
            border-right: 1px solid #ccc;
        }

        @media (max-width: 568px) {
            .display-3{
                font-size: 4rem;
            }

            h3.mt-4{
                font-size: 1rem;
            }
        }

    </style>
@endsection

@section('content')

    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h2 class="main-content-title tx-24 mg-b-5">View Ads</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ asset('/member/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">View Ads</li>
            </ol>
        </div>
    </div>
    <!-- End Page Header -->

    <!-- Row -->
    <div class="row row-sm">
        <div class="col-md-8 offset-md-2">

            @if($remaining_ads > 0)

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6 light-br">
                            <div class="text-center">
                                <h1 class="display-3">{{ $total_ads }}</h1>
                                <h3 class="mt-4">Total Ads</h3>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center">
                                <h1 class="display-3">{{ $remaining_ads }}</h1>
                                <h3 class="mt-4">Remaining Ads</h3>
                            </div>
                        </div>
                        <div class="col-12">
                            <hr/>
                        </div>
                        <div class="col-md-4 offset-md-4">
                            <a href="{{ asset('member/view-ads/show/'.$ads_to_view[0]) }}" class="btn btn-block btn-primary my-2 text-white @if(!auth()->user()->documents || auth()->user()->hirarchy->activation_amount <= 0) disabled @endif">View Ad</a>
                        </div>
                    </div>
                </div>
            </div>

            @else

            <div class="card alert-message">
                <div class="card-body">
                    <div class="text-center text-white">
                        <svg class="alert-icons" enable-background="new 0 0 512 512" version="1.1" viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
                                <path d="m491.38 157.66c-13.15-30.297-31.856-57.697-55.598-81.439s-51.142-42.448-81.439-55.598c-31.529-13.686-64.615-20.625-98.338-20.625s-66.809 6.939-98.338 20.625c-30.297 13.15-57.697 31.856-81.439 55.598s-42.448 51.142-55.598 81.439c-13.686 31.529-20.625 64.615-20.625 98.338s6.939 66.809 20.625 98.338c13.149 30.297 31.855 57.697 55.598 81.439 23.742 23.742 51.142 42.448 81.439 55.598 31.529 13.686 64.615 20.625 98.338 20.625s66.809-6.939 98.338-20.625c30.297-13.15 57.697-31.856 81.439-55.598s42.448-51.142 55.598-81.439c13.686-31.529 20.625-64.615 20.625-98.338s-6.939-66.809-20.625-98.338zm-235.38 334.34c-127.92 0-236-108.08-236-236s108.08-236 236-236 236 108.08 236 236-108.08 236-236 236z"/>
                                <path d="m451.98 173.8c-10.87-25.256-26.363-48.044-46.049-67.729-19.686-19.686-42.473-35.179-67.729-46.049-26.249-11.298-53.904-17.026-82.197-17.026-38.462 0-78.555 13.134-115.94 37.981-4.6 3.057-5.851 9.264-2.794 13.863 3.057 4.6 9.264 5.85 13.863 2.794 34.1-22.66 70.365-34.638 104.88-34.638 104.62 0 193 88.383 193 193s-88.383 193-193 193-193-88.383-193-193c0-34.504 11.975-70.771 34.629-104.88 3.056-4.601 1.804-10.807-2.796-13.863-4.602-3.056-10.807-1.803-13.863 2.797-24.84 37.397-37.97 77.489-37.97 115.94 0 28.293 5.728 55.948 17.025 82.196 10.87 25.256 26.363 48.044 46.049 67.729 19.686 19.687 42.473 35.179 67.73 46.05 26.248 11.297 53.903 17.025 82.196 17.025s55.948-5.728 82.196-17.025c25.256-10.87 48.044-26.363 67.729-46.049 19.686-19.686 35.179-42.473 46.049-67.729 11.298-26.249 17.026-53.904 17.026-82.197s-5.728-55.948-17.025-82.196z"/>
                                <path d="m115 105c-5.52 0-10 4.48-10 10s4.48 10 10 10 10-4.48 10-10-4.48-10-10-10z"/>
                                <path d="m374.28 177.72c-7.557-7.557-17.6-11.719-28.281-11.719s-20.724 4.162-28.281 11.719l-91.719 91.719-31.719-31.719c-7.557-7.557-17.6-11.719-28.281-11.719s-20.724 4.162-28.278 11.716c-7.559 7.553-11.722 17.597-11.722 28.284s4.163 20.731 11.719 28.281l60 60c7.557 7.557 17.601 11.719 28.281 11.719s20.724-4.162 28.281-11.719l120-120c7.559-7.553 11.722-17.597 11.722-28.284s-4.163-20.731-11.719-28.281zm-14.142 42.42-120 120c-3.78 3.779-8.801 5.861-14.139 5.861s-10.359-2.082-14.139-5.861l-60.003-60.003c-3.777-3.775-5.858-8.795-5.858-14.136s2.081-10.361 5.861-14.139c3.78-3.779 8.801-5.861 14.139-5.861s10.359 2.082 14.139 5.861l45.861 45.861 105.86-105.86c3.78-3.779 8.801-5.861 14.139-5.861s10.359 2.082 14.142 5.864c3.777 3.775 5.858 8.795 5.858 14.136s-2.081 10.361-5.861 14.139z"/>
                        </svg>
                        <h3 class="mt-4 mb-3">Congrats</h3>
                        <p class="tx-18 text-white-50">You have viewed all available ads.</p>
                        <a href="{{ asset('member/dashboard') }}" class="btn btn-success">Back to Home</a>
                    </div>
                </div>
            </div>

            @endif

        </div>
    </div>
    <!-- End Row -->

@endsection

@section('page-js')

@endsection
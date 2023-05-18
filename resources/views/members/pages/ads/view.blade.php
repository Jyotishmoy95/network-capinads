@extends('members.layouts.master')

@section('title', 'View Ad : '.$ad->title)

@section('page-css')
    
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
        <div class="col-md-8">
            <div class="card custom-card">
                <div class="card-body">

                    @if($ad->ad_type == 'url' && $ad->youtube_id)
                        <div>
                            <iframe width="100%" height="500" src="https://www.youtube.com/embed/{{ $ad->youtube_id }}" title="{{ $ad->title }}" frameborder="0" allow="accelerometer; clipboard-write; encrypted-media; gyroscope;" allowfullscreen></iframe>
                        </div>
                    @elseif($ad->ad_type == 'image')
                        <div class="text-center">
                            <img src="{{ asset('/uploads/ads/'.$ad->image) }}" style="width: 300px; margin: 0 auto" alt="{{ $ad->title }}">
                        </div>
                    @else
                        <div class="text-center">
                            <a href="#" id="link-ad" data-href="{{ $ad->url }}" class="btn btn-primary">{{ $ad->title }}</a>
                            <hr>
                            <div><span class="text-dark"><i class="mdi mdi-alert-circle-outline"></i> Please click on the above button.</span></div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card custom-card">
                <div class="card-header border-bottom-0 custom-card-header">
                    <h6 class="main-content-label mb-0">Ad Info</h6>
                </div>
                <div class="card-body">
                    <div style="font-size: 1.2rem"><strong>Title: </strong> {{ $ad->title }}</div>
                    @if(($ad->ad_type == 'url' && $ad->youtube_id) || $ad->ad_type == 'image')
                        <hr/>
                        <div class="text-center">
                            <h1 class="display-3" id="countdown">10</h1>
                            <h3 class="mt-3 ad-text">Timer</h3>
                        </div>
                        <p class="text-danger text-center">
                            <span class="text-danger">* N.B:</span> If you leave or reload the page before the timer ends, you will not be eligible for the payout.
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- End Row -->

@endsection

@section('page-js')
    <script>
        $(document).ready(function(){
            // get inner html from countdown element and count-down to zero
            let count = $('#countdown').html()
            let ad_type = '{{ $ad->ad_type }}'
            let is_video = '{{ $ad->youtube_id }}'
            let isAlreadyViewed = '{{ $isAlreadyViewed }}'

            if(isAlreadyViewed == '1'){
                window.location.href = "{{ asset('/member/view-ads/index') }}";
            }

            if((ad_type == 'url' && is_video) || ad_type == 'image'){
                let interval = setInterval(function(){
                    count--;
                    $('#countdown').html(count);
                    if(count <= 0){
                        clearInterval(interval);
                        viewComplete(); //call view complete action
                    }
                }, 1000);
            }

            //view complete action
            function viewComplete(){
                // make a post ajax request to update the viewed ad
                $.ajax({
                    url: "{{ route('member.view-ads.view-complete') }}",
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: '{{ $ad->id }}'
                    },
                    success: function(data){
                        if(data.success){
                            window.location.href = "{{ asset('/member/view-ads/index') }}";
                        }else{

                        }
                    }, 
                    error: function(xhr, textStatus, errorThrown) { 
                        
                    }
                });
            }

            // click on the link ad button
            $(document).on('click', '#link-ad', function(e){
                e.preventDefault();
                //open link in new tab
                window.open($(this).data('href'), '_blank');
                viewComplete(); //call view complete action
            });

        });
    </script>
@endsection
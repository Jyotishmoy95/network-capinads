@extends('admin.layouts.master')

@section('title', 'Edit Ad')

@section('page-css')
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <style>
        img.ad-image{
            display: block !important;
        }
    </style>
@endsection

@section('content')

    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h2 class="main-content-title tx-24 mg-b-5">Edit Ad</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ asset('/admin/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Ad Details</li>
            </ol>
        </div>
        <div class="d-flex">
            <div class="justify-content-center">
                <a href="{{ asset('/admin/ad-details/index') }}" class="btn btn-primary my-2 btn-icon-text">
                    <i class="fe fe-arrow-left-circle mr-2"></i> Back to Ad Details
                </a>
            </div>
        </div>
    </div>
    <!-- End Page Header -->

    <!-- Row -->
    <div class="row row-sm">
        <div class="col-lg-6 offset-md-3">
            <div class="card custom-card">
                <div class="card-header border-bottom-0 custom-card-header">
                    <h6 class="main-content-label mb-0">Edit Ad</h6>
                </div>
                <div class="card-body">

                    <form id="edit-ad">
                        @csrf
                        <div class="form-group">
                            <label for="ad_title">Ad Title</label>
                            <input type="text" name="ad_title" id="input-ad_title" class="form-control" placeholder="Enter Ad Title" required value="{{ $ad->title }}">
                            <div class="invalid-feedback error" id="ad_title-error"></div>
                        </div>
                        
                        <div class="form-group">
                            <label for="ad_type">Ad Type</label>
                            <select name="ad_type" id="input-ad_type" class="form-control select2" required>
                                <option value="">Select Ad Type</option>
                                <option @if($ad->ad_type == 'url') selected @endif value="url">Link</option>
                                <option @if($ad->ad_type == 'image') selected @endif value="image">Image</option>
                            </select>
                            <div class="invalid-feedback error" id="ad_type-error"></div>
                        </div>
                        
                        <div class="form-group" id="ad-url" style="display:none">
                            <label for="ad_url">Link</label>
                            <input type="url" name="ad_url" id="input-ad_url" class="form-control" value="{{ $ad->url }}" placeholder="Enter Link">
                            <div class="invalid-feedback error" id="ad_url-error"></div>
                        </div>

                        @if($ad->image)
                            <div>
                                <img src="{{ asset('uploads/ads/'.$ad->image) }}" class="mb-2 img-thumbnail" style="width: 200px" />
                            </div>
                        @endif

                        <div class="form-group" id="ad-image" style="display:none">
                            <label for="ad_image">Image</label>
                            <input type="file" name="ad_image" id="input-ad_image" class="form-control">
                            <div class="invalid-feedback error" id="ad_image-error"></div>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" id="submit-btn" class="btn btn-primary btn-block">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('page-js')
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function(){

            $('.select2').select2({
                width: '100%'
            });

            showHideFields()

            $("#input-ad_type").on('change', function(event){
                let ad_type = $(this).val();

                if(ad_type == 'url'){
                    $("#ad-url").show();
                    $("#ad-image").hide();
                }else if(ad_type == 'image'){
                    $("#ad-url").hide();
                    $("#ad-image").show();
                }else{
                    $("#ad-url").hide();
                    $("#ad-image").hide();
                }

            });

            function showHideFields(){
                let ad_type = $("#input-ad_type").val();
                if(ad_type == 'url'){
                    $("#ad-url").show();
                    $("#ad-image").hide();
                }else if(ad_type == 'image'){
                    $("#ad-url").hide();
                    $("#ad-image").show();
                }else{
                    $("#ad-url").hide();
                    $("#ad-image").hide();
                }
            }

            /* Submit Create E-Pins Form */
            $('#edit-ad').on('submit', function(event){
                event.preventDefault();

                $('#submit-btn').html(`<span aria-hidden="true" class="spinner-border spinner-border-sm" role="status"></span> Loading...`);
                $('#submit-btn').attr('disabled', 'disabled');
                $(".form-group>div.error").html("");
                $(".form-group>input.form-control").removeClass("is-invalid");

                $.ajax({
                    url:"{{ route('admin.ad-details.update', $ad->id) }}",
                    method:"POST",
                    data:new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success:function(data)
                    {
                        Swal.fire({
                            text: 'Ad successfully updated',
                            icon: 'success',
                            timer: 1500,
                            showConfirmButton: false,
                        }).then(() => {
                            if($("#input-ad_type").val() == 'image'){
                                window.location.reload();
                            }
                        }); 
                        $('#submit-btn').html('Update');
                        $('#submit-btn').removeAttr('disabled');
                        $(".form-group>div.error").html("");
                        $(".form-group>input.form-control").removeClass("is-invalid");

                        //window.location.href = "";

                    },
                    error: function(xhr, textStatus, errorThrown) { 
                        let data = xhr.responseJSON;
                        Object.keys(data.errors).forEach(key => {

                            let error = data.errors[key];
                            let arr_err = key.split('.');   

                            if(arr_err[1]){
                                $(`#input-${arr_err[0]}-${arr_err[1]}`).addClass('is-invalid');
                                $(`#${arr_err[0]}-${arr_err[1]}-error`).html(error);
                            }else{
                                $(`#input-${key}`).addClass("is-invalid");
                                $(`#${key}-error`).html(data.errors[key]);
                            }
                        });
                        $('#submit-btn').html('Update');
                        $('#submit-btn').removeAttr('disabled');
                    }  
                });  
            });

        });
    </script>

@endsection
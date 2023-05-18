@extends('admin.layouts.master')

@section('title', 'Edit Profile')

@section('page-css')
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection

@section('content')

    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h2 class="main-content-title tx-24 mg-b-5">Edit Profile</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ asset('/admin/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Team</li>
            </ol>
        </div>
    </div>
    <!-- End Page Header -->

    <!-- Row -->
    <div class="row row-sm">
        <div class="col-lg-6 offset-md-3">
            <div class="card custom-card">
                <div class="card-header border-bottom-0 custom-card-header">
                    <h6 class="main-content-label mb-0">Edit Profile</h6>
                </div>
                <div class="card-body">
                    <form id="activate-member">
                        @csrf
                        <div class="form-group">
                            <label for="fname">First Name</label>
                            <input type="text" name="fname" id="input-fname" value="{{  }}" class="form-control" placeholder="Enter First Name" required>
                            <div class="invalid-feedback error" id="fname-error"></div>
                        </div>
                        <div class="form-group">
                            <label for="lname">Last Name</label>
                            <input type="text" name="lname" id="input-lname" class="form-control" placeholder="Enter last Name" required>
                            <div class="invalid-feedback error" id="lname-error"></div>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="input-email" class="form-control" placeholder="Enter Email" required>
                            <div class="invalid-feedback error" id="email-error"></div>
                        </div>
                        <div class="form-group">
                            <label for="mobile">Mobile</label>
                            <input type="number" name="mobile" id="input-mobile" class="form-control" placeholder="Enter Mobile" required>
                            <div class="invalid-feedback error" id="mobile-error"></div>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="text" name="password" id="input-password" class="form-control" placeholder="Enter Password" required>
                            <div class="invalid-feedback error" id="password-error"></div>
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="text" name="password_confirmation" id="input-password_confirmation" class="form-control" placeholder="Confirm Password" required>
                            <div class="invalid-feedback error" id="password_confirmation-error"></div>
                        </div>
                        <input type="hidden" name="member_id" value="{{ $member->id }}" />
                        <div class="form-group">
                            <button type="submit" id="submit-btn" class="btn btn-primary btn-block" disabled>Activate</button>
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

            /* Submit Create E-Pins Form */
            $('#activate-member').on('submit', function(event){
                event.preventDefault();
                $('#submit-btn').html(`<span aria-hidden="true" class="spinner-border spinner-border-sm" role="status"></span> Loading...`);
                $('#submit-btn').attr('disabled', 'disabled');
                $(".form-group>div.error").html("");
                $(".form-group>input.form-control").removeClass("is-invalid");
                $.ajax({
                    url:"{{ route('admin.activations.activate') }}",
                    method:"POST",
                    data:new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success:function(data)
                    {
                        Swal.fire({
                            text: data.message,
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false,
                        });
                        $('#submit-btn').html('Activate');
                        $('#submit-btn').removeAttr('disabled');
                        $('#activate-member')[0].reset();
                        $(".form-group>div.error").html("");
                        $(".form-group>input.form-control").removeClass("is-invalid");

                        //window.location.href = "";

                    },
                    error: function(xhr, textStatus, errorThrown) { 
                        let data = xhr.responseJSON;
                        Object.keys(data.errors).forEach(key => {
                            console.log(`#${key}-error`)
                            $(`#input-${key}`).addClass("is-invalid");
                            $(`#${key}-error`).html(data.errors[key]);
                        });
                        $('#submit-btn').html('Activate');
                        $('#submit-btn').removeAttr('disabled');
                    }  
                });  
            });

        });
    </script>
    @include('includes.member-info-js')
@endsection
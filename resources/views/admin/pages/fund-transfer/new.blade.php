@extends('admin.layouts.master')

@section('title', 'New Fund Transfer')

@section('page-css')
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection

@section('content')

    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h2 class="main-content-title tx-24 mg-b-5">New Fund Transfer</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ asset('/admin/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Fund Transfer</li>
            </ol>
        </div>
    </div>
    <!-- End Page Header -->

    <!-- Row -->
    <div class="row row-sm">
        <div class="col-lg-6 offset-md-3">
            <div class="card custom-card">
                <div class="card-header border-bottom-0 custom-card-header">
                    <h6 class="main-content-label mb-0">New Fund Transfer</h6>
                </div>
                <div class="card-body">
                    <form id="fund-transfer">
                        @csrf
                        <div class="form-group">
                            <label for="member_id">Username</label>
                            @include('includes.member-info-html')
                        </div>
                        <div class="form-group">
                            <label for="amount">Enter Amount</label>
                            <input type="number" min="1" name="amount" id="input-amount" class="form-control" placeholder="Enter Amount" required>
                            <div class="invalid-feedback error" id="amount-error"></div>
                        </div>
                        <div class="form-group">
                            <button type="submit" id="submit-btn" class="btn btn-primary btn-block" disabled>Transfer</button>
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
            $('#fund-transfer').on('submit', function(event){
                event.preventDefault();
                $('#submit-btn').html(`<span aria-hidden="true" class="spinner-border spinner-border-sm" role="status"></span> Loading...`);
                $('#submit-btn').attr('disabled', 'disabled');
                $(".form-group>div.error").html("");
                $(".form-group>input.form-control").removeClass("is-invalid");
                $.ajax({
                    url:"{{ route('admin.fund-transfer.new') }}",
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
                        $('#fund-transfer')[0].reset();
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
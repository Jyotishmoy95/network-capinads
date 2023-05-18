@extends('admin.layouts.master')

@section('title', 'Create New Package')

@section('page-css')
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection

@section('content')

    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h2 class="main-content-title tx-24 mg-b-5">Create New Package</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ asset('/admin/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Packages</li>
            </ol>
        </div>
        <div class="d-flex">
            <div class="justify-content-center">
                <a href="{{ asset('/admin/packages/list') }}" class="btn btn-primary my-2 btn-icon-text">
                    <i class="fe fe-arrow-left-circle mr-2"></i> Back to Packages List
                </a>
            </div>
        </div>
    </div>
    <!-- End Page Header -->

    <!-- Row -->
    <div class="row row-sm">
        <div class="col-md-10 offset-md-1">
            <div class="card custom-card">
                <div class="card-header border-bottom-0 custom-card-header">
                    <h6 class="main-content-label mb-0">Create New Package</h6>
                </div>
                <div class="card-body">
                    <form id="create-package">
                        @csrf
                        <div class="form-group">
                            <label for="package_name">Package Name</label>
                            <input type="text" name="package_name" id="input-package_name" class="form-control" placeholder="Enter Package Name" required>
                            <div class="invalid-feedback error" id="package_name-error"></div>
                        </div>
                        <div class="form-group">
                            <label for="amount">Package Amount</label>
                            <input type="number" name="amount" id="input-amount" step="1" class="form-control" placeholder="Enter Package Amount" required>
                            <div class="invalid-feedback error" id="amount-error"></div>
                        </div>

                        <div class="form-group">
                            <label for="self_ad_income">Self Ad Income</label>
                            <input type="number" name="self_ad_income" id="input-self_ad_income" step="0.01" class="form-control" placeholder="Enter Self Ad Income" required>
                            <div class="invalid-feedback error" id="self_ad_income-error"></div>
                        </div>

                        <div class="form-group">
                            <label for="level_type">Level Type</label>
                            <select name="level_type" id="input-level_type" class="form-control select2" required>
                                <option value="">Select Level Type</option>
                                <option value="flat">Flat</option>
                                <option value="percent">Percentage</option>
                            </select>
                            <div class="invalid-feedback error" id="level_type-error"></div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-2">
                                <label for="">Package Incomes</label>
                                @for($i=0; $i<$levels; $i++)
                                    <div class="row">
                                        <div class="col-12 mb-2 form-group">
                                            <input type="number" min="0" id="input-levels-{{ $i }}" name="levels[]" placeholder="Package Level {{ $i+1 }} income" class="form-control" required>
                                            <div class="invalid-feedback error" id="levels-{{ $i }}-error"></div>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                            <div class="col-md-4 mb-2">
                                <label for="">Ads View Incomes</label>
                                @for($i=0; $i<$ad_levels; $i++)
                                    <div class="row">
                                        <div class="col-12 mb-2 form-group">
                                            <input type="number" step="0.01" id="input-ad_levels-{{ $i }}" name="ad_levels[]" placeholder="Ad Level {{ $i+1 }} income" class="form-control" required>
                                            <div class="invalid-feedback error" id="ad_levels-{{ $i }}-error"></div>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                            <div class="col-md-4 mb-2">
                                <label for="">Direct Referrals</label>
                                @for($i=0; $i<$levels; $i++)
                                    <div class="row">
                                        <div class="col-12 mb-2 form-group">
                                            <input type="number" min="0" id="input-referrals-{{ $i }}" name="referrals[]" placeholder="Direct Referrals Level {{ $i+1 }}" class="form-control" required>
                                            <div class="invalid-feedback error" id="referrals-{{ $i }}-error"></div>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        </div>

                        <!-- <div class="form-group">
                            <label for="roi_type">ROI Type</label>
                            <select name="roi_type" id="roi_type" class="form-control select2" required>
                                <option value="">Select ROI Type</option>
                                <option value="flat">Flat</option>
                                <option value="percent">Percentage</option>
                            </select>
                            <div class="invalid-feedback error" id="roi_type-error"></div>
                        </div>
                        <div class="form-group">
                            <label for="roi_value">ROI Value</label>
                            <input type="number" name="roi_value" id="roi_value" step="0.01" class="form-control" placeholder="Enter ROI Value" required>
                            <div class="invalid-feedback error" id="roi_value-error"></div>
                        </div>
                        <div class="form-group">
                            <label for="roi_days">ROI Days</label>
                            <input type="number" name="roi_days" id="roi_days" step="1" class="form-control" placeholder="Enter ROI Value" required>
                            <div class="invalid-feedback error" id="roi_days-error"></div>
                        </div>
                        <div class="form-group">
                            <label for="binary_type">Binary Type</label>
                            <select name="binary_type" id="binary_type" class="form-control select2" required>
                                <option value="">Select Binary Type</option>
                                <option value="flat">Flat</option>
                                <option value="percent">Percentage</option>
                            </select>
                            <div class="invalid-feedback error" id="binary_type-error"></div>
                        </div>
                        <div class="form-group">
                            <label for="binary_value">Binary Value</label>
                            <input type="number" name="binary_value" id="binary_value" step="0.01" class="form-control" placeholder="Enter Binary Value" required>
                            <div class="invalid-feedback error" id="binary_value-error"></div>
                        </div> -->

                        <div class="form-group">
                            <button type="submit" id="submit-btn" class="btn btn-primary btn-block">Create</button>
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
            $('#create-package').on('submit', function(event){
                event.preventDefault();

                $('#submit-btn').html(`<span aria-hidden="true" class="spinner-border spinner-border-sm" role="status"></span> Loading...`);
                $('#submit-btn').attr('disabled', 'disabled');
                $(".form-group>div.error").html("");
                $(".form-group>input.form-control").removeClass("is-invalid");

                $.ajax({
                    url:"{{ route('admin.packages.create') }}",
                    method:"POST",
                    data:new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success:function(data)
                    {
                        Swal.fire({
                            text: 'New package successfully created',
                            icon: 'success',
                            timer: 1500,
                            showConfirmButton: true,
                        }).then(() => {
                            window.location.href = "{{ asset('admin/packages/list') }}";
                        });

                        $('#submit-btn').html('Create');
                        $('#submit-btn').removeAttr('disabled');
                        $('#create-package')[0].reset();
                        $(".form-group>div.error").html("");
                        $(".form-group>input.form-control").removeClass("is-invalid");
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
                        $('#submit-btn').html('Create');
                        $('#submit-btn').removeAttr('disabled');
                    }  
                });  
            });

        });
    </script>

@endsection
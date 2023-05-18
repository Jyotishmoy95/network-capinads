@extends('members.layouts.master')

@section('title', 'New Withdraw')

@section('page-css')
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection

@section('content')

    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h2 class="main-content-title tx-24 mg-b-5">New Withdraw</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ asset('/member/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Earnings & Withdrawals</li>
            </ol>
        </div>
        <div class="d-flex">
            <div class="justify-content-center">
                <a href="{{ asset('member/withdrawals/') }}" class="btn btn-primary my-2 btn-icon-text">
                    <i class="fe fe-file-text mr-2"></i> Withdraw List
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
                    <h6 class="main-content-label mb-0">New Withdraw</h6>
                </div>
                <div class="card-body">
                    <form id="new-withdraw">
                        @csrf
                        <div class="main-contact-info-body border mb-3 p-0">
                            <div class="bg-dark text-white p-3 {{ $bank_details ? '' : 'text-center' }}">
                                Bank Details
                            </div>
                            @if($bank_details)
                                <div class="media-list pl-3 pr-3">
                                    <div class="media mb-0">
                                        <div class="media-body">
                                            <div>
                                                <label>Bank Name</label> <span class="tx-medium">{{ $bank_details->bank_name }}</span>
                                            </div>
                                            <div>
                                                <label>Account Name</label> <span class="tx-medium">{{ $bank_details->account_name }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="media mb-0">
                                        <div class="media-body">
                                            <div>
                                                <label>Account Number</label> <span class="tx-medium">{{ $bank_details->account_number }}</span>
                                            </div>
                                            <div>
                                                <label>IFSC Code</label> <span class="tx-medium">{{ $bank_details->ifsc_code }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="text-danger text-center p-3">
                                    You have not updated your bank details. Please update it in your profile.
                                    <a href="{{ asset('member/settings/index#welcome') }}" class="btn btn-primary mt-3">Update Bank Details</a>
                                </div>
                            @endif
                            
                        </div>
                        <div class="form-group">
                            <label for="amount">Enter Amount</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">{{ env('CURRENCY_SYMBOL') }}</span>
                                </div>
                                <input aria-label="Amount" name="amount" id="input-amount" required class="form-control" type="number" step="0.01" placeholder="Enter Amount">
                                <div class="input-group-append">
                                    <span class="input-group-text">Available Balance: {{ env('CURRENCY_SYMBOL').$available_balance }}</span>
                                </div>
                            </div>
                            <div class="text-danger error" id="amount-error"></div>
                            
                        </div>
                        <div class="form-group">
                            <button type="submit" id="submit-btn" class="btn btn-primary btn-block" @if(!$bank_details) disabled @endif>Widthdraw</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Row -->

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
            $('#new-withdraw').on('submit', function(event){
                event.preventDefault();
                $('#submit-btn').html(`<span aria-hidden="true" class="spinner-border spinner-border-sm" role="status"></span> Loading...`);
                $('#submit-btn').attr('disabled', 'disabled');
                $(".form-group>div.error").html("");
                $(".form-group>input.form-control").removeClass("is-invalid");
                $.ajax({
                    url:"{{ route('member.withdrawals.new') }}",
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
                        }).then(function() {
                            window.location.href = "{{ asset('member/withdrawals') }}";
                        });

                    },
                    error: function(xhr, textStatus, errorThrown) { 
                        let data = xhr.responseJSON;
                        Object.keys(data.errors).forEach(key => {
                            console.log(`#${key}-error`)
                            $(`#input-${key}`).addClass("is-invalid");
                            $(`#${key}-error`).html(data.errors[key]);
                        });
                        $('#submit-btn').html('Withdraw');
                        $('#submit-btn').removeAttr('disabled');
                    }  
                });  
            });

        });
    </script>
    @include('includes.member-info-js')
@endsection
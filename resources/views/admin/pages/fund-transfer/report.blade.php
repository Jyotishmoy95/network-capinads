@extends('admin.layouts.master')

@section('title', 'Fund Transfer Report')

@section('page-css')
    <!-- Internal DataTables css-->
	<link href="{{ asset('assets/plugins/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('assets/plugins/datatable/responsivebootstrap4.min.css') }}" rel="stylesheet" />
@endsection

@section('content')

    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h2 class="main-content-title tx-24 mg-b-5">Fund Transfer Report</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ asset('/admin/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Fund Transfer</li>
            </ol>
        </div>
    </div>
    <!-- End Page Header -->

    <!-- Row -->
    <div class="row row-sm">
        <div class="col-12">
            <div class="card custom-card">
                <div class="card-body">
                    <div>
                        <h6 class="main-content-label mb-1">Fund Transfer Report</h6>
                    </div>

                    <div class="search-div">
                        <hr>
                        <div class="row  mt-3">
                            <div class="col-md-3 mb-3">
                                <div>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fe fe-calendar lh--9 op-6"></i>
                                            </div>
                                        </div>
                                        <input class="form-control fc-datepicker" id="sdate" autocomplete="off" placeholder="Start Date" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fe fe-calendar lh--9 op-6"></i>
                                            </div>
                                        </div>
                                        <input class="form-control fc-datepicker" id="edate" autocomplete="off" placeholder="End Date" type="text">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <input type="text" id="username" class="form-control" placeholder="Username">
                            </div>
                            <div class="col-md-3 mb-3">
                                <button class="btn btn-block btn-primary" id="search-btn">Search</button>
                            </div>
                            <div class="col-12">
                                <div class="alert alert-danger" id="search-error" style="display: none;"></div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive mt-4 ">
                        <table id="dataTable" class="table w-100 border-t0 text-nowrap text-nowrap table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Username</th>
                                    <th>Full name</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Row -->

@endsection

@section('page-js')
    <!-- Internal Data Table js -->
    <script src="{{ asset('assets/plugins/datatable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/dataTables.responsive.min.js') }}"></script>
    <!-- Internal Jquery-Ui js-->
	<script src="{{ asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <script>
        $(document).ready(function(){

            $('.fc-datepicker').datepicker({
                dateFormat: 'yy/mm/dd',
                enableOnReadonly: true,
                todayHighlight: true,
                autoclose:true,
                orientation: 'bottom',
                maxDate: new Date()
            });

            document.querySelector("#search-btn").addEventListener("click", function(){

                let username = document.querySelector("#username").value;
                let sdate = document.querySelector("#sdate").value;
                let edate = document.querySelector("#edate").value;

                if(sdate !== '' && edate === ""){
                    document.querySelector("#search-error").style.display = "block";
                    document.querySelector("#search-error").innerHTML = "Please select an end date";
                }else if(sdate > edate){
                    document.querySelector("#search-error").style.display = "block";
                    document.querySelector("#search-error").innerHTML = "Start date cannot be greater than end date";
                }else{
                    document.querySelector("#search-error").style.display = "none";
                    $('#dataTable').DataTable().ajax.reload();
                }

            });

            $("#dataTable").DataTable({
                language:{
                    searchPlaceholder:"Search...",
                    sSearch:"",
                    lengthMenu:"_MENU_ items/page"
                },
                pageLength: 100,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.fund-transfer.list') }}",
                    type: 'post',
                    data: function (data) {
                        data._token = "{{ csrf_token() }}";
                        data.sdate = $('#sdate').val();
                        data.edate = $('#edate').val();
                        data.username = $('#username').val();
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false},
                    {data: 'date', name: 'date'},
                    {data: 'member_id', name: 'member_id'},
                    {data: 'member.full_name', name: 'member.full_name'},
                    {data: 'net', name: 'net'},
                ]
            })
        });
    </script>
@endsection
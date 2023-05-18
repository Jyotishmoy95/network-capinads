@extends('admin.layouts.master')

@section('title', 'Rejected Fund Requests')

@section('page-css')
    <!-- Internal DataTables css-->
	<link href="{{ asset('assets/plugins/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('assets/plugins/datatable/responsivebootstrap4.min.css') }}" rel="stylesheet" />
@endsection

@section('content')

    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h2 class="main-content-title tx-24 mg-b-5">Rejected Fund Requests</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ asset('/admin/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Fund Requests</li>
            </ol>
        </div>
    </div>
    <!-- End Page Header -->

    <!-- Row -->
    <div class="row row-sm">
        <div class="col-12">
            <div class="card custom-card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <h6 class="main-content-label mb-1">Rejected Fund Requests</h6>
                        </div>
                        <div class="col-6 d-flex flex-row-reverse">
                            <button class="btn btn-danger my-2 btn-icon-text delete-pins" style="opacity:0" id="delete-btn" onclick="bulkDeletePins()">
                                <i class="fe fe-trash-2 mr-2"></i> Delete
                            </button>
                        </div>
                    </div>
                    <div class="table-responsive mt-4 ">
                        <table id="dataTable" class="table w-100 border-t0 text-nowrap text-nowrap table-bordered text-center">
                            <thead>
                                <tr>
                                    <th> #</th>
                                    <th>Date</th>
                                    <th>Member ID</th>
                                    <th>Full Name</th>
                                    <th>Transaction ID</th>
                                    <th>Amount</th>
                                    <th>Receipt</th>
                                    <th>Remarks</th>
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
    <!-- <script src="https://cdn.datatables.net/buttons/2.1.0/js/dataTables.buttons.min.js"></script> -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function(){

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
                    url: "{{ route('admin.fund-requests.list') }}",
                    type: 'post',
                    data: function (data) {
                        data._token = "{{ csrf_token() }}";
                        data.status = 'rejected';
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false},
                    {data: 'date', name: 'date'},
                    {data: 'member_id', name: 'member_id'},
                    {data: 'member.full_name', name: 'member.full_name'},
                    {data: 'transaction_id', name: 'transaction_id'},
                    {data: 'amount', name: 'amount'},
                    {data: 'receipt', name: 'receipt', searchable:false},
                    {data: 'remarks', name: 'remarks'},
                ]
            })
        });
    </script>
@endsection
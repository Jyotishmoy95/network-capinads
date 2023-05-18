@extends('admin.layouts.master')

@section('title', 'Working Members')

@section('page-css')
    <!-- Internal DataTables css-->
	<link href="{{ asset('assets/plugins/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('assets/plugins/datatable/responsivebootstrap4.min.css') }}" rel="stylesheet" />
@endsection

@section('content')

    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h2 class="main-content-title tx-24 mg-b-5">Working Members</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ asset('/admin/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Team</li>
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
                        <h6 class="main-content-label mb-1">Working Members</h6>
                    </div>
                    <div class="table-responsive mt-4 ">
                        <table id="dataTable" class="table w-100 border-t0 text-nowrap text-nowrap table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Join Date</th>
                                    <th>Activation Date</th>
                                    <th>Username</th>
                                    <th>Full Name</th>
                                    <th>Referred By</th>
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
                    url: "{{ route('admin.members.working') }}",
                    type: 'post',
                    data: function (data) {
                        data._token = "{{ csrf_token() }}";
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'activation_time', name: 'activation_time'},
                    {data: 'member_id', name: 'member_id'},
                    {data: 'member.full_name', name: 'member.full_name'},
                    {data: 'sponsor_id', name: 'sponsor_id'},
                    {
                      data: 'activation_amount', name: 'activation_amount'
                    }
                ]
            })
        });
    </script>
@endsection
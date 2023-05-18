@extends('admin.layouts.master')

@section('title', 'Packages List')

@section('page-css')
    <!-- Internal DataTables css-->
	<link href="{{ asset('assets/plugins/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('assets/plugins/datatable/responsivebootstrap4.min.css') }}" rel="stylesheet" />
@endsection

@section('content')

    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h2 class="main-content-title tx-24 mg-b-5">Packages List</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ asset('/admin/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Packages</li>
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
                        <h6 class="main-content-label mb-1">Packages List</h6>
                    </div>
                    <div class="table-responsive mt-4 ">
                        <table id="dataTable" class="table w-100 border-t0 text-nowrap text-nowrap table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Created At</th>
                                    <th>Package Name</th>
                                    <th>Package Amount</th>
                                    <th>Status</th>
                                    <th>Action</th>
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

            $(document).on('change', '.toggle-status', function(){
                var id = $(this).data("id");
                $.ajax({
                    url: "{{ route('admin.packages.updateStatus') }}",
                    type: "GET",
                    data:  { id },
                    success:function(data)
                    {
                        $('#dataTable').DataTable().ajax.reload();
                    },
                    error: function(xhr, textStatus, errorThrown) { 
                        let data = xhr.responseJSON;
                        Swal.fire({
                            text: 'Something went wrong! Please try again.',
                            icon: 'error',
                            showConfirmButton: true,
                        });
                    }                   
                });
            });

            $("#dataTable").DataTable({
                language:{
                    searchPlaceholder:"Search...",
                    sSearch:"",
                    lengthMenu:"_MENU_ items/page"
                },
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.packages.list') }}",
                    type: 'post',
                    data: function (data) {
                        data._token = "{{ csrf_token() }}";
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'package_name', name: 'package_name'},
                    {data: 'amount', name: 'amount'},
                    {data: 'toggle', name: 'toggle', orderable: false, searchable: false},
                    {
                        data: 'action', 
                        name: 'action', 
                        orderable: true, 
                        searchable: true
                    },
                ]
            })
        });
    </script>
@endsection
@extends('admin.layouts.master')

@section('title', 'Create New Download')

@section('page-css')
    
@endsection

@section('content')

    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h2 class="main-content-title tx-24 mg-b-5">Create New Download</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ asset('/admin/dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Promotional Files</li>
            </ol>
        </div>
        <div class="d-flex">
            <div class="justify-content-center">
                <a href="{{ asset('/admin/downloads/index') }}" class="btn btn-primary my-2 btn-icon-text">
                    <i class="fe fe-arrow-left-circle mr-2"></i> Back to Downloads List
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
                    <h6 class="main-content-label mb-0">Create New Download</h6>
                </div>
                <div class="card-body">
                    <form id="create-download">
                        @csrf
                        <div class="form-group">
                            <label for="title">Download Title</label>
                            <input type="text" name="title" id="input-title" class="form-control" placeholder="Enter News Title" required>
                            <div class="invalid-feedback error" id="title-error"></div>
                        </div>

                        <div class="form-group">
                            <label for="file">File</label>
                            <input type="file" class="form-control" name="file" id="input-file" required>
                            <div class="invalid-feedback error" id="file-error"></div>
                        </div>
                        
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
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function(){

            /* Submit Create E-Pins Form */
            $('#create-download').on('submit', function(event){
                event.preventDefault();

                $('#submit-btn').html(`<span aria-hidden="true" class="spinner-border spinner-border-sm" role="status"></span> Loading...`);
                $('#submit-btn').attr('disabled', 'disabled');
                $(".form-group>div.error").html("");
                $(".form-group>input.form-control").removeClass("is-invalid");

                $.ajax({
                    url:"{{ route('admin.downloads.store') }}",
                    method:"POST",
                    data:new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success:function(data)
                    {
                        Swal.fire({
                            text: 'New download successfully created',
                            icon: 'success',
                            timer: 1500,
                            showConfirmButton: false,
                        });
                        $('#submit-btn').html('Create');
                        $('#submit-btn').removeAttr('disabled');
                        $('#create-download')[0].reset();
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
                        $('#submit-btn').html('Create');
                        $('#submit-btn').removeAttr('disabled');
                    }  
                });  
            });

        });
    </script>

@endsection
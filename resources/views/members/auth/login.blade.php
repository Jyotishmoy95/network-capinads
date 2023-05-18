
<!DOCTYPE html>
	
    @php
      $configData = Helper::applClasses();
    @endphp
    
    <html lang="en">
        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
        <head>
    
            <meta charset="utf-8">
            <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
            <meta name="author" content="Codechroma MLM Software Solutions">
            <!-- Favicon -->
            <link rel="icon" href="{{ asset('assets/img/brand/favicon.png') }}" type="image/x-icon"/>
    
            <!-- Title -->
            <title>Login - {{ env('APP_NAME') }}</title>
    
            <!-- Bootstrap css-->
            <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet"/>
    
            <!-- Icons css-->
            <link href="{{ asset('assets/plugins/web-fonts/icons.css') }}" rel="stylesheet"/>
            <link href="{{ asset('assets/plugins/web-fonts/font-awesome/font-awesome.min.css') }}" rel="stylesheet">
            <link href="{{ asset('assets/plugins/web-fonts/plugin.css') }}" rel="stylesheet"/>
    
            <!-- Style css-->
            <link href="{{ asset('assets/css/style/style.css') }}" rel="stylesheet">
            <link href="{{ asset('assets/css/skins.css') }}" rel="stylesheet">
            <link href="{{ asset('assets/css/dark-style.css') }}" rel="stylesheet">
            <link href="{{ asset('assets/css/colors/default.css') }}" rel="stylesheet">
    
            <!-- Color css-->
            <link id="theme" rel="stylesheet" type="text/css" media="all" href="{{ asset('assets/css/colors/'.$configData['memberPanelColor'].'.css') }}">
    
        </head>
    
        <body class="main-body leftmenu {{ $configData['theme'] == 'dark' ? 'dark-theme' : '' }}">
    
            <!-- Loader -->
            @include('components.loader')
            <!-- End Loader -->
    
            <!-- Page -->
            <div class="page main-signin-wrapper">
    
                <!-- Row -->
                <div class="row signpages text-center">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="row row-sm">
                                <div class="col-lg-6 col-xl-5 d-none d-lg-block text-center bg-primary details">
                                    <div class="mt-5 pt-4 p-2 pos-absolute">
                                        <h3 class="text-white mb-3">{{ env('APP_NAME') }}</h3>
                                        <div class="clearfix"></div>
                                        <img src="{{ asset('assets/img/svgs/user.svg') }}" class="ht-100 mb-0" alt="user">
                                        <h5 class="mt-4 text-white">Create Your Account</h5>
                                        <span class="tx-white-6 tx-13 mb-5 mt-xl-0">Signup to create, discover and connect with the {{ env('APP_NAME') }} community</span>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-xl-7 col-xs-12 col-sm-12 login_form ">
                                    <div class="container-fluid">
                                        <div class="row row-sm">
                                            <div class="card-body mt-2 mb-2">
                                                <img src="{{ asset('assets/img/brand/logo.png') }}" class=" d-lg-none header-brand-img text-left float-left mb-4" alt="logo">
                                                <div class="clearfix"></div>
                                                <form id="login-form">
                                                    <h5 class="text-left mb-2">Signin to Your Account</h5>
                                                    <p class="mb-4 text-muted tx-13 ml-0 text-left">Signin to create, discover and connect with the {{ env('APP_NAME') }} community</p>
                                                    <div class="form-group text-left">
                                                        <label>Username</label>
                                                        <input class="form-control" required placeholder="Enter username" id="input-username" name="username" type="text">
                                                        <div class="invalid-feedback error" id="username-error"></div>
                                                    </div>
                                                    <div class="form-group text-left">
                                                        <label>Password</label>
                                                        <input class="form-control" id="input-password" name="password" required placeholder="Enter your password" type="password">
                                                        <div class="invalid-feedback error" id="password-error"></div>
                                                    </div>
                                                    <button type="submit" id="submit-btn" class="btn ripple btn-main-primary btn-block">Sign In</button>
                                                </form>
                                                <div class="text-left mt-5 ml-0">
                                                    <!-- <div class="mb-1"><a href="#">Forgot password?</a></div> -->
                                                    <div>Don't have an account? <a href="{{ asset('/member/register') }}">Register Here</a></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Row -->
    
            </div>
            <!-- End Page -->
    
            <!-- Jquery js-->
            <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    
            <!-- Bootstrap js-->
            <script src="{{ asset('assets/plugins/bootstrap/js/popper.min.js') }}"></script>
            <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
            
            <!-- Custom js -->
            <script src="{{ asset('assets/js/custom.js') }}"></script>

            <script>

                $(document).ready(function(){

                    /* Submit Sign Up Form */
                    $('#login-form').on('submit', function(event){
                        event.preventDefault();
                        $('#submit-btn').html(`<span aria-hidden="true" class="spinner-border spinner-border-sm" role="status"></span> Loading...`);
                        $(".form-group>div.error").html("");
                        $(".form-group>input.form-control").removeClass("is-invalid");
                        $.ajax({
                            url:"{{ route('member.login') }}",
                            method:"POST",
                            data:new FormData(this),
                            contentType: false,
                            cache: false,
                            processData: false,
                            success:function(data)
                            {
                                // swal("Done!", "New member succesfully added!", "success");
                                // $('#submit-btn').html('Submit');
                                // $('#login-form')[0].reset();
                                // $(".form-group>div.error").html("");
                                // $(".form-group>input.form-control").removeClass("is-invalid");

                                window.location.href = "/member/dashboard";

                            },
                            error: function(xhr, textStatus, errorThrown) { 
                                let data = xhr.responseJSON;
                                Object.keys(data.errors).forEach(key => {
                                    console.log(`#${key}-error`)
                                    $(`#input-${key}`).addClass("is-invalid");
                                    $(`#${key}-error`).html(data.errors[key]);
                                });
                                $('#submit-btn').html('Submit');
                            }  
                        });  
                    });

                });

            </script>
            
        </body>
    
    </html>
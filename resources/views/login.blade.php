<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>POREVAK ADMIN PANEL</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{url('images/favicon.png')}}">
    <link href="{{url('css/style.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{url('vendor/sweetalert2/dist/sweetalert2.min.css')}}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
</head>

<body class="h-100">
<div class="authincation h-100">
    <div class="container h-100">
        <div class="row justify-content-center h-100 align-items-center">
            <div class="col-md-6">
                <div class="authincation-content">
                    <div class="row no-gutters">
                        <div class="col-xl-12">
                            <div class="auth-form">
                                <div class="text-center mb-3">
                                    <a href="#"><img src="{{url('images/logo-white.png')}}" alt=""></a>
                                </div>
                                <form class="form" id="login-form" name="login-form" action="{{route('admin-login-post')}}" method="post" enctype="multipart/form-data">
                                    {{csrf_field()}}
                                    <div class="form-group">
                                        <label class="mb-1 text-white"><strong>E-posta</strong></label>
                                        <input type="text" id="email" name="email"  class="form-control" value="">
                                        <span id="email_error" style="height: 30px">&nbsp;</span>
                                    </div>
                                    <div class="form-group">
                                        <label class="mb-1 text-white"><strong>Şifre</strong></label>
                                        <input type="password" t id="password" type="password" class="form-control" name="password" value="">
                                        <span id="password_error" style="height: 30px">&nbsp;</span>
                                    </div>
                                    <div class="form-row d-flex justify-content-between mt-4 mb-2">
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox ml-1 text-white">
                                                <input type="checkbox" class="custom-control-input" id="remember_me" name="remember_me" value="13">
                                                <label class="custom-control-label" for="basic_checkbox_1">Beni hatırla</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <a class="text-white" href="#">Şifremi Unuttum?</a>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn bg-white text-primary btn-block">Giriş yap</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!--**********************************
    Scripts
***********************************-->
<!-- Required vendors -->
<script src="{{url('vendor/global/global.min.js')}}"></script>
<script src="{{url('js/custom.min.js')}}"></script>
<script src="{{url('js/deznav-init.js')}}"></script>
<script src="{{url('vendor/sweetalert2/dist/sweetalert2.min.js')}}"></script>
<script src="{{url('js/save.js')}}"></script>
</body>
<script>
    function validateEmail(email) {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    }

    $('#login-form').submit(function (e) {
        e.preventDefault();
        var error = false;

        if ($('#email').val() == '' )   {
            $('#email_error').html('<span style="color: white;top:-20px">{{__('errors.this_field_is_required')}}</span>');
            error = true;
        }else{

            if(!validateEmail($('#email').val())){
                $('#email').val('');
                $('#email_error').html('<span style="color: white">{{__('errors.invalid_email')}}</span>');
                error = true;
            }else{
                $('#email_error').html('');
            }
        }

        if ($('#password').val() == '' )   {
            $('#password_error').html('<span style="color: white">{{__('errors.this_field_is_required')}}</span>');
            error = true;
        }else{
            $('#password_error').html('');
        }

        if(error){
            return false;
        }
        var formData = new FormData(this);
        save(formData,'{{route('admin-login-post')}}','','');
    });
</script>
</html>
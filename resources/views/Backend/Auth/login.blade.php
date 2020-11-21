<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <!-- <meta http-equiv="Content-Security-Policy" content="block-all-mixed-content"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>WebShop</title>

    <!-- Custom fonts for this template-->
    <link href="{{env('PUBLIC_PATH')}}/backend/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{env('PUBLIC_PATH')}}/backend/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="{{env('PUBLIC_PATH')}}/backend/css/custom_style.css" rel="stylesheet">

</head>

<body class="bg-gradient-success">

<div class="container">
    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-xl-6 col-lg-12 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="p-5">
                                <div class="text-center">
                                    <h5 class="signinwelcome">Welcome,please sign in</h5>
                                    <!-- <h6 style="color:black;margin-bottom: 16px; font-weight: 700; font-size:14px;">Welcome,please sign in</h6> -->
                                    {!! Session::has('message') ? Session::get('message') : '' !!}
                                </div>
                                <form class="user" method="post" action="{{route('admin.login.submit')}}">
                                    {{@csrf_field()}}
                                    <div class="form-group">
                                        <input type="email" name="email" class="form-control form-control-user" value="{{Request::old('email')}}" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address...">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password">
                                        <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response" />
                                        <p class="forgotpassword"><a href="#">Forgot your password?</a></p>
                                    </div>

                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox small">
                                            <input name="remember" type="checkbox" class="custom-control-input" id="customCheck">
                                            <label class="custom-control-label" for="customCheck">Remember Me</label>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-info btn-user btn-block">
                                        Login
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

<!-- Bootstrap core JavaScript-->
<script src="{{env('PUBLIC_PATH')}}/backend/vendor/jquery/jquery.min.js"></script>
<script src="{{env('PUBLIC_PATH')}}/backend/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="https://www.google.com/recaptcha/api.js?render={{env('GOOGLE_RECAPTCHA_SITE_KEY')}}"></script>
<script src="{{env('PUBLIC_PATH')}}/backend/vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="{{env('PUBLIC_PATH')}}/backend/js/sb-admin-2.min.js"></script>
</body>
</html>

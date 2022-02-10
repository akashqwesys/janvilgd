<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/png" sizes="32x32" href="/assets/images/favicon-icon.png">

    <link rel="stylesheet" type="text/css" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.1.1/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/responsive.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/custom.css">
    <link rel="stylesheet" href="/admin_assets/toast/jquery.toast.css">
    <style type="text/css">
        .errTxt {
            color: red;
            text-align: center;
            font-size: 0.9em;
        }
        .input-icon-cs {
            position: absolute;
            top: 10px;
            left: 12px;
            bottom: 0;
        }
        .err-margin {
            margin-top: 0.5rem;
            margin-bottom: 1.5rem;
        }
    </style>
</head>

<body>
    <div class="overlay cs-loader">
      <div class="overlay__inner">
        <div class="overlay__content"><img src='/assets/images/Janvi_Akashs_Logo_Loader_2.gif'></div>
      </div>
    </div>
    <div class="content-wrapper">
        <section class="login-section">
            <div class="login-bg">
                <img src="/assets/images/PSNM.gif" alt="PSNM">
            </div>
            <div class="login-container">
                <div class="login-header">
                    <a href="/"><img src="/assets/images/logo.png" class="img-fluid" alt="logo"></a>
                </div>
                <div class="login-box">
                    <div class="login-form-content">
                        <h4 class="title">Login</h4><br>
                        @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                        @endif
                        <form class="login-form bv-form" method="POST" action="/customer/login" id="loginForm">
                            @csrf
                            <div>
                                <div class="form-group">
                                    <span class="input-icon-cs"> <i class="far fa-envelope text-muted"></i> </span>
                                    <input type="email" name="email" class="form-control" placeholder="Email Address" id="email" autocomplete="off">
                                </div>
                                <div class="errTxt err-margin"></div>
                            </div>
                            <div>
                                <div class="form-group">
                                    <span class="input-icon-cs"> <i class="fas fa-unlock text-muted"></i> </span>
                                    <input type="password" name="password" class="form-control" placeholder="Password" id="password" autocomplete="off">
                                </div>
                                <div class="errTxt err-margin"></div>
                            </div>
                            {{-- <p>By continuing, I agree to the <a href="/terms-conditions">Terms of Use</a> & <a
                                    href="/privacy-policy">Privacy Policy</a></p> --}}
                            <button type="submit" id="login_btn" class="btn btn-primary">LOGIN</button>
                        </form>
                        <div class="text-center mt-3">
                            <p class="">Have trouble logging in? <a href="/customer/forgot-password">Forgot Password</a></p>
                            <p>New User? <a href="/customer/signup">Register</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script src="/assets/js/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/additional-methods.min.js"></script>
    <script src="/assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.1.1/js/all.min.js"></script>
    <script src="/admin_assets/toast/jquery.toast.js"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function( xhr ) {
                $( ".cs-loader" ).show();
            }
        });
        $("#loginForm").validate({
            errorClass: 'red-error',
            errorElement: 'div',
            rules: {
                email: {required: true, email: true},
                password: {required: true}
            },
            messages: {
                email: {
                    required: "Please enter your email address",
                    email: "Your email address must be in the format of name@domain.com"
                },
                password: {required: "Please enter password"}
            },
            errorPlacement: function(error, element) {
                error.appendTo( element.parent().nextAll("div.errTxt") );
            },
            submitHandler: function(form) {
                // do other things for a valid form
                form.submit();
            }
        });
    </script>
</body>
</html>

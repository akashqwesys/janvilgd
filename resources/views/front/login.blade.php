<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/png" sizes="32x32" href="/{{ check_host() }}assets/images/favicon-icon.png">

    <link rel="stylesheet" type="text/css" href="/{{ check_host() }}assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/{{ check_host() }}assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="/{{ check_host() }}assets/css/responsive.css">
    <link rel="stylesheet" type="text/css" href="/{{ check_host() }}assets/css/custom.css">
    <link rel="stylesheet" href="{{ asset(check_host().'admin_assets/toast/jquery.toast.css') }}">
</head>

<body>
    <div class="overlay cs-loader">
      <div class="overlay__inner">
        <div class="overlay__content"><span class="spinner"></span></div>
      </div>
    </div>
    <div class="content-wrapper">
        <section class="login-section">
            <div class="login-bg">
                <img src="/{{ check_host() }}assets/images/PSNM.gif" alt="PSNM">
            </div>
            <div class="login-container">
                <div class="login-header">
                    <a href="index.php"><img src="/{{ check_host() }}assets/images/logo.png" class="img-fluid" alt="logo"></a>
                </div>
                <div class="login-box">
                    <div class="login-form-content">
                        <h4 class="title">Login / Signup with</h4><br>
                        <form class="login-form bv-form" method="POST">
                            {{-- @csrf --}}
                            <div class="form-group">
                                <img src="/{{ check_host() }}assets/images/alt-phone.svg" alt="icn" class="img-fluid input-icon">
                                <input type="text" name="mobile" class="form-control" id="mobile" placeholder="Mobile Number" autocomplete="off">
                            </div>
                            <p class="or"><span>And / Or</span></p>
                            <div class="form-group">
                                <img src="/{{ check_host() }}assets/images/envelop.svg" alt="icn" class="img-fluid input-icon">
                                <input type="email" name="email" class="form-control" placeholder="Email Address" id="email" autocomplete="off">
                            </div>
                            <p>By continuing, I agree to the <a href="/customer/terms-condition">Terms of Use</a> & <a
                                    href="/customer/privacy-policy">Privacy Policy</a></p>
                            <button type="submit" id="login_btn" class="btn btn-primary">Continue</button>
                            <p class="mb-0">Have trouble logging in? <a href="Javascript:;">Get Help</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script src="/{{ check_host() }}assets/js/jquery-3.6.0.min.js"></script>
    <script src="/{{ check_host() }}assets/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset(check_host().'admin_assets/toast/jquery.toast.js') }}"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function( xhr ) {
                $( ".cs-loader" ).show();
            }
        });
        $(document).on('click', '#login_btn', function (e) {
            $('.cs-loader').show();
            e.preventDefault();
            $.ajax({
                type: "post",
                url: "login",
                data: {
                    'email': $('#email').val(),
                    'mobile': $('#mobile').val()
                },
                cache: false,
                dataType: "json",
                success: function (response) {
                    $('.cs-loader').hide();
                    if (response.success == 1) {
                        $.toast({
                            heading: 'Success',
                            text: response.message,
                            icon: 'success',
                            position: 'top-right'
                        });
                        setTimeout(() => {
                            window.location = response.url;
                        }, 2000);
                    }
                    /* if (response.success == 2) {
                        window.location = response.url + '?mobile=' + $('#mobile').val() + '&email=' + $('#email').val();
                    } */
                    else {
                        $.toast({
                            heading: 'Error',
                            text: response.message,
                            icon: 'error',
                            position: 'top-right'
                        });
                    }
                },
                failure: function (response) {
                    $.toast({
                        heading: 'Error',
                        text: 'Oops, something went wrong...!',
                        icon: 'error',
                        position: 'top-right'
                    });
                }
            });
        });
    </script>
</body>
</html>

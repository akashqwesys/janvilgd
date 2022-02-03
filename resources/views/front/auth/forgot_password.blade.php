<!DOCTYPE html>
<html>
<head>
    <title>Forgot | Reset Password</title>
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
        .otp-verify-block, .reset-block  {
            display: none;
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
                        <h6 class="title mb-3">Forgot Password</h6>
                        @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                        @endif
                        <div class="login-form bv-form" method="POST" id="forgotForm">
                            <div class="forgot-block mb-4">
                                <div>
                                    <div class="form-group">
                                        <span class="input-icon-cs"> <i class="far fa-envelope text-muted"></i> </span>
                                        <input type="email" name="email" class="form-control" placeholder="Email Address" id="email" autocomplete="off">
                                    </div>
                                    <div class="errTxt errTxt-1 err-margin"></div>
                                </div>
                                <button id="forgot-btn" class="btn btn-primary">Continue</button>
                            </div>
                            <div class="otp-verify-block mb-4">
                                <hr>
                                <h6 class="title mb-3">Verify OTP</h6>
                                <div>
                                    <div class="form-group">
                                        <span class="input-icon-cs"> <i class="fas fa-unlock text-muted"></i> </span>
                                        <input type="text" name="otp" class="form-control" placeholder="OTP" id="otp" autocomplete="off" maxlength="4">
                                    </div>
                                    <div class="errTxt errTxt-2 err-margin"></div>
                                    <p class="reset-time text-center">
                                        <a href="javascript:void(0);" id="resendOTP" class="resend-otp">Resend OTP</a>
                                        in <span id="time">01:00</span>
                                    </p>
                                    <button id="verify-otp-btn" class="btn btn-primary">Continue</button>
                                </div>
                            </div>
                            <div class="reset-block">
                                <hr>
                                <h6 class="title mb-3">Reset Password</h6>
                                <div>
                                    <div class="form-group">
                                        <span class="input-icon-cs"> <i class="fas fa-unlock text-muted"></i> </span>
                                        <input type="password" name="password" class="form-control" placeholder="New Password" id="password" autocomplete="off">
                                    </div>
                                    <div class="errTxt errTxt-3 err-margin"></div>
                                </div>
                                <div>
                                    <div class="form-group">
                                        <span class="input-icon-cs"> <i class="fas fa-unlock text-muted"></i> </span>
                                        <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" id="confirm_password" autocomplete="off">
                                    </div>
                                    <div class="errTxt errTxt-4 err-margin"></div>
                                </div>
                                <button id="reset-btn" class="btn btn-primary">Continue</button>
                            </div>
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
        function startTimer(duration, display) {
            var timer = duration, minutes, seconds;
            var setInterval_ID = setInterval(function () {
                minutes = parseInt(timer / 60, 10);
                seconds = parseInt(timer % 60, 10);

                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;

                display.textContent = minutes + ':' + seconds;

                if (--timer < 0) {
                    // uncomment below line for infinite loop
                    // timer = duration;
                    clearInterval(setInterval_ID);
                    $('.reset-time a').attr('id', 'resendOTP');
                }
            }, 1000);
        }
        function countDown() {
            $('.reset-time a').attr('id', '');
            var fiveMinutes = 60 * 1,
                display = document.querySelector('#time');
            startTimer(fiveMinutes, display);
        };
        $( document ).ready(function() {
            $("#email").keydown(function() {
                var key = event.keyCode || event.charCode;
                if( key == 13 ) {
                    $('#forgot-btn').trigger('click');
                }
            });
            $("#otp").keydown(function() {
                var key = event.keyCode || event.charCode;
                if( key == 13 ) {
                    $('#verify-otp-btn').trigger('click');
                }
            });
            $("#confirm_password").keydown(function() {
                var key = event.keyCode || event.charCode;
                if( key == 13 ) {
                    $('#reset-btn').trigger('click');
                }
            });
        });
        $(document).on('click', '#forgot-btn', function() {
            if ($('#email').val() == '') {
                $('.errTxt-1').text('Please enter email address ');
                return false;
            }
            else {
                if ($('#email').val() != '' && !$('#email').val().match(/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/)) {
                    $('.errTxt-1').text('Please enter valid email address');
                    return false;
                }
                $('.errTxt-1').text('');
            }
            $('.cs-loader').show();
            $.ajax({
                type: "post",
                url: "/customer/forgot-password",
                data: { 'email': $('#email').val() },
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
                        $('#forgot-btn').remove();
                        countDown();
                        $('.otp-verify-block').slideDown();
                    }
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
                    $('.cs-loader').hide();
                    $.toast({
                        heading: 'Error',
                        text: 'Oops, something went wrong...!',
                        icon: 'error',
                        position: 'top-right'
                    });
                }
            });
        });
        $(document).on('click', '#verify-otp-btn', function() {
            if ($('#otp').val().length != 4) {
                $('.errTxt-2').text('Please enter 4 digits OTP');
                return false;
            }
            $('.errTxt-2').text('');
            $('.cs-loader').show();
            $.ajax({
                type: "post",
                url: "/customer/reset-password",
                data: { 'step': 1, 'email': $('#email').val(), 'otp': $('#otp').val() },
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
                        $('.otp-verify-block').slideUp().remove();
                        $('#email').attr('readonly', true);
                        $('.reset-block').slideDown();
                    }
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
                    $('.cs-loader').hide();
                    $.toast({
                        heading: 'Error',
                        text: 'Oops, something went wrong...!',
                        icon: 'error',
                        position: 'top-right'
                    });
                }
            });
        });
        $(document).on('click', '#reset-btn', function() {
            if ($('#password').val().length < 6 || $('#password').val().length > 15) {
                $('.errTxt-3').text('Please enter password');
                return false;
            }
            $('.errTxt-3').text('');
            if ($('#confirm_password').val().length < 6 || $('#confirm_password').val().length > 15) {
                $('.errTxt-4').text('Please enter confirm password');
                return false;
            }
            $('.errTxt-4').text('');
            $('.cs-loader').show();
            $.ajax({
                type: "post",
                url: "/customer/reset-password",
                data: {
                    'step': 2,
                    'email': $('#email').val(),
                    'password': $('#password').val(),
                    'confirm_password': $('#confirm_password').val()
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
                        $('#reset-btn').remove();
                        setTimeout(() => {
                            location.href = '/customer/login';
                        }, 2000);
                    }
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
                    $('.cs-loader').hide();
                    $.toast({
                        heading: 'Error',
                        text: 'Oops, something went wrong...!',
                        icon: 'error',
                        position: 'top-right'
                    });
                }
            });
        });
        $(document).on('click', '#resendOTP', function() {
            $('.cs-loader').show();
            $.ajax({
                type: "post",
                url: "/customer/resendOTP",
                data: { 'email': $('#email').val() },
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
                        countDown();
                    }
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
                    $('.cs-loader').hide();
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

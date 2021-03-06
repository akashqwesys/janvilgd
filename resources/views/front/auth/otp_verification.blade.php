<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>OTP Verification</title>
    <link rel="icon" type="image/png" sizes="32x32" href="/{{ check_host() }}assets/images/favicon-icon.png">

    <link rel="stylesheet" type="text/css" href="/{{ check_host() }}assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/{{ check_host() }}assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="/{{ check_host() }}assets/css/custom.css">
    <link rel="stylesheet" href="{{ asset(check_host().'admin_assets/toast/jquery.toast.css') }}">
    <style type="text/css">
    .otp-box {
        padding: 50px;
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
                <img src="/{{ check_host() }}assets/images/PSNM.gif" alt="PSNM">
            </div>
            <div class="login-container">
                <div class="login-header">
                    <img src="/{{ check_host() }}assets/images/logo.png" class="img-fluid" alt="logo">
                </div>
                <div class="login-box otp-box">
                    <div class="login-form-content text-center">
                        <h2 class="title">Verify With OTP</h2>
                        <p class="mb-0">Sent to {{ decrypt($request->token, false) }}</p>
                        <form class="otp-form bv-form">
                            <div class="d-flex flex-row otp-list">
                                <input type="text" class="form-control" id="no-1" autofocus onfocus="this.select();" maxlength="1" minlength="1">
                                <input type="text" class="form-control" id="no-2" onfocus="this.select();" maxlength="1" minlength="1">
                                <input type="text" class="form-control" id="no-3" onfocus="this.select();" maxlength="1" minlength="1">
                                <input type="text" class="form-control" id="no-4" onfocus="this.select();" maxlength="1" minlength="1">
                            </div>
                        </form>
                        <p class="reset-time">
                            <button class="btn btn-dark" disabled>Resend OTP</button><br>
                            <span id="time">01:00</span>
                        </p>
                        <p class="mb-0">Have trouble logging in? <a href="Javascript:;">Get Help</a></p>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- site-footer -->
    <script src="/{{ check_host() }}assets/js/jquery-3.6.0.min.js"></script>
    <script src="/{{ check_host() }}assets/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset(check_host().'admin_assets/toast/jquery.toast.js') }}"></script>
    <script type="text/javascript">
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
                    $('.reset-time button').prop('id', 'resendOTP').attr('disabled', false);
                }
            }, 1000);
        }
        function countDown() {
            $('.reset-time button').prop('id', '').attr('disabled', true);
            var fiveMinutes = 60 * 1,
                display = document.querySelector('#time');
            startTimer(fiveMinutes, display);
        };
        countDown();

        $(document).on('keyup', '#no-1', function() {
            if ($(this).val() ) {
                $('#no-2').focus();
            }
        });
        $(document).on('keyup', '#no-2', function() {
            if ($(this).val() ) {
                $('#no-3').focus();
            }
        });
        $(document).on('keyup', '#no-3', function() {
            if ($(this).val() ) {
                $('#no-4').focus();
            }
        });
        $("#no-1").bind("paste", function(e){
            var pastedData = e.originalEvent.clipboardData.getData('text');
            if (isNaN(pastedData) || pastedData.length != 4) {
                $.toast({
                    heading: 'Error',
                    text: 'Not a valid 4 digits OTP',
                    icon: 'error',
                    position: 'top-right'
                });
                return false;
            } else {
                var digits = (""+pastedData).split("");
                $('#no-2').val(digits[1]);
                $('#no-3').val(digits[2]);
                $('#no-4').val(digits[3]);
                setTimeout(() => {
                    $(this).val(digits[0]);
                    verify_otp(pastedData);
                }, 20);
            }
        } );
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function( xhr ) {
                $( ".cs-loader" ).show();
            }
        });
        $(document).on('keyup', '#no-4', function() {
            var otp = $('#no-1').val() + $('#no-2').val() + $('#no-3').val() + $('#no-4').val();
            if ($(this).val() && otp.length == 4) {
                verify_otp(otp);
            }
        });
        function verify_otp(otp) {
            if ($('#no-4').val()) {
                $.ajax({
                    type: "post",
                    url: "/customer/verify",
                    data: { 'otp': otp, 'token': '{{ $request->token }}' },
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
                            $("#no-1").focus();
                            $(".otp-list input").val('');
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
                        $("#no-1").focus();
                        $(".otp-list input").val('');
                    }
                });
            }
         }

        $(document).on('click', '#resendOTP', function() {
            $('.cs-loader').show();
            $.ajax({
                type: "post",
                url: "/customer/resendOTP",
                data: { 'token': '{{ $request->token }}' },
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
                        $(".otp-list input").val('');
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
    $( document ).ready(function() {
        $(".otp-list input").keyup(function(){
		    var key = event.keyCode || event.charCode;
            if( key == 8 || key == 46 ){
                $(this).prev("input[type='text']").focus();
            }
	    })
    });
    </script>

</body>
</html>

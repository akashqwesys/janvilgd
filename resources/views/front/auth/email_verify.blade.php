<!DOCTYPE html>
<html>
<head>
    <title>Email Verification</title>
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
        .msg-block {
            background-color: #ffffff;
            position: relative;
            padding: 3rem;
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
        <section class="signup-section">
            <div class="login-bg">
                <img src="/assets/images/PSNM.gif" alt="PSNM">
            </div>
            <div class="container">
                <div class="row">
                    <div class="col col-12 col-md-10 col-lg-7 m-auto">
                        <div class="form-header text-center">
                            <a href="/"><img src="/assets/images/logo.png" alt="logo" class="img-fluid"></a>
                        </div>
                        <div class="msg-block">
                            <p class="title">Thank you for registering with Janvi LGD Private Limited.</p>
                            <p>Your account requires approval. You will be notified via email when your account is approved.</p>
                            <p>In case of urgency please contact <a href="mailto:support@janvilgd.com">support@janvilgd.com</a> or whatsapp <a href="tel:+919714405421">+919714405421</a>.</p>
                            <div class="mt-4 text-center"><a href="/" class="btn btn-primary">Back to Home</a></div>
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
    </script>
</body>
</html>

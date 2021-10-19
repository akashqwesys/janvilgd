<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <base href="../../../">
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="{{ asset(check_host().'admin_assets/assets/images/favicon.png') }}">
    <!-- Page Title  -->
    <title>Error 404 | DashLite Admin Template</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="{{ asset(check_host().'admin_assets/assets/css/dashlite.css?ver=1.9.2') }}">
    <link id="skin-default" rel="stylesheet" href="{{ asset(check_host().'admin_assets/assets/css/theme.css?ver=1.9.2') }}">
    <style>
        .wide-xs {
            max-width: 100% !important;
        }
        
    </style>
</head>

<body class="nk-body bg-white npc-default pg-error">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- wrap @s -->
            <div class="nk-wrap nk-wrap-nosidebar">
                <!-- content @s -->
                <div class="nk-content ">
                    <div class="nk-block nk-block-middle wide-xs mx-auto">
                        <div class="nk-block-content nk-error-ld text-center">
                            <h1 class="nk-error-head">Access Denied..!</h1>
                            <h3 class="nk-error-title">You are not able to access this module</h3>
                            <!--<p class="nk-error-text">We are very sorry for inconvenience. It looks like you’re try to access a page that either has been deleted or never existed.</p>-->
                            <a href="{{url('dashboard')}}" class="btn btn-lg btn-primary mt-2">Back To Dashboard</a>
                            <a href="{{url('logout')}}" class="btn btn-lg btn-primary mt-2">Logout</a>
                        </div>
                    </div><!-- .nk-block -->
                </div>
                <!-- wrap @e -->
            </div>
            <!-- content @e -->
        </div>
        <!-- main @e -->
    </div>
    <!-- app-root @e -->
    <!-- JavaScript -->
    <script src="{{ asset(check_host().'admin_assets/assets/js/bundle.js?ver=1.9.2') }}"></script>
    <script src="{{ asset(check_host().'admin_assets/assets/js/scripts.js?ver=1.9.2') }}"></script>
    <link rel="stylesheet" href="{{ asset(check_host().'admin_assets/toast/jquery.toast.css') }}">
    <script src="{{ asset(check_host().'admin_assets/toast/jquery.toast.js') }}"></script>
     <?php
        if (!isset($_SESSION['message'])) {
            $_SESSION['message'] = '';
        }
        ?>
        <script type="text/javascript">
$(document).ready(function () {
    if (<?php
        if (!empty(session()->get('error'))) {
            echo session()->get('error');
        } else {
            echo 0;
        }
        ?> === 1)
    {
        $.toast({
            heading: 'Error',
            text: '<?php echo session()->get('message') ?>',
            icon: 'error',
            position: 'top-right'
        });
<?php session(['error' => 0]); ?>
    }
    if (<?php
if (!empty(session()->get('success'))) {
    echo session()->get('success');
} else {
    echo 0;
}
?> === 1)
    {
        $.toast({
            heading: 'Success',
            text: '<?php echo session()->get('message') ?>',
            icon: 'success',
            position: 'top-right'
        });
<?php session(['success' => 0]); ?>
    }
});
        </script>
</html>
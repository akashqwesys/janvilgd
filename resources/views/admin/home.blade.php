<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <base href="../../../">
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="{{ asset(check_host().'admin_assets/images/favicon.png')}}">
    <!-- Page Title  -->
    <title><?php echo $data['title']; ?></title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="{{ asset(check_host().'admin_assets/assets/css/dashlite.css?ver=1.9.2') }}">
    <link id="skin-default" rel="stylesheet" href="{{ asset(check_host().'admin_assets/assets/css/theme.css?ver=1.9.2') }}">
</head>

<body class="nk-body bg-white npc-default pg-auth">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- wrap @s -->
            <div class="nk-wrap nk-wrap-nosidebar">
                <!-- content @s -->
                <div class="nk-content ">
                    <div class="nk-block nk-block-middle nk-auth-body  wide-xs">
<!--                        <div class="brand-logo pb-4 text-center">
                            <a href="html/index.html" class="logo-link">
                                <img class="logo-light logo-img logo-img-lg" src="{{ asset(check_host().'admin_assets/images/logo.png')}}" srcset="{{ asset(check_host().'admin_assets/images/logo2x.png 2x')}}" alt="logo">
                                <img class="logo-dark logo-img logo-img-lg" src="{{ asset(check_host().'admin_assets/images/logo-dark.png')}}" srcset="{{ asset(check_host().'admin_assets/images/logo-dark2x.png 2x')}}" alt="logo-dark">
                            </a>
                        </div>-->
                        <div class="card">
                            <div class="card-inner card-inner-lg">
                                <div class="nk-block-head">
                                    <div class="nk-block-head-content">
                                        <center><h4 class="nk-block-title">Home</h4>
                                        <div class="nk-block-des">
                                            <p>Home page of janvi</p>
                                        </div></center>
                                    </div>
                                </div>                                                                                           
                            </div>
                        </div>
                    </div>                    
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

</html>
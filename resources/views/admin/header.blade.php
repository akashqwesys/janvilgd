<!DOCTYPE html>
<html lang="zxx" class="js">
<head>
    <base href="../">
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="{{ asset(check_host().'admin_assets/images/favicon.png') }}">
    <!-- Page Title  -->
    <title><?php echo $data['title']; ?></title>
    <!-- StyleSheets  -->
    <link href="{{ asset(check_host().'admin_assets/assets/css/dashlite.css?ver=1.9.2') }}" rel="stylesheet">
    <!--<link href="{{ asset(check_host().'admin_assets/assets/css/dashlite.css') }}" rel="stylesheet">-->
    <link href="{{ asset(check_host().'admin_assets/assets/css/theme.css?ver=1.9.2') }}" rel="stylesheet">
    <style>
        .removeimg {
            width:100px;
            height:100px;
            position:relative;
        }
        .removeimg img {
            max-width:100%;
            max-height:100%;
            border-radius: 5px;
        }
        .removeimg span {
            border-radius: 50px;
            display:block;
            width:15px;
            height:15px;
            padding: 0;
            line-height: 50px;
            position:absolute;
            top:-4px;
            right:-4px;
            overflow:hidden;
        }
        .d-none{
            display: none !important;
        }
        .overlay {
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            position: absolute;
            background: #6e6e6e38;
            z-index: 1111;
            display: none;
        }
        .notification-dropdown {
            display: none;
        }
        .notification-dropdown a {
            padding: 9px;
            border-radius: 50%;
        }
        .notification-box {
            /* position: fixed; */
            z-index: 99;
            top: 30px;
            right: 30px;
            width: 15px;
            height: 15px;
            text-align: center;
        }
        .notification-bell {
            animation: bell 1s 1s both infinite;
        }
        .notification-bell * {
            display: block;
            margin: 0 auto;
            background-color: #fff;
            box-shadow: 0px 0px 10px #fff;
        }
        .bell-top {
            width: 3px;
            height: 3px;
            border-radius: 3px 3px 0 0;
        }
        .bell-middle {
            width: 10px;
            height: 10px;
            margin-top: 0px;
            border-radius: 12.5px 12.5px 0 0;
        }
        .bell-bottom {
            position: relative;
            z-index: 0;
            width: 12px;
            height: 1px;
        }
        .bell-bottom::before,
        .bell-bottom::after {
            content: '';
            position: absolute;
            top: -4px;
        }
        .bell-bottom::before {
            left: 1px;
            border-bottom: 4px solid #fff;
            border-right: 0 solid transparent;
            border-left: 4px solid transparent;
        }
        .bell-bottom::after {
            right: 1px;
            border-bottom: 4px solid #fff;
            border-right: 4px solid transparent;
            border-left: 0 solid transparent;
        }
        .bell-rad {
            width: 3px;
            height: 2px;
            margin-top: 1px;
            border-radius: 0 0 4px 4px;
            animation: rad 1s 2s both infinite;
        }
        .notification-count {
            position: absolute;
            z-index: 1;
            top: 7px;
            right: 14px;
            width: 8px;
            height: 8px;
            line-height: 30px;
            font-size: 12px;
            border-radius: 50%;
            background-color: #ff4927;
            color: #fff;
            animation: zoom 1s 1s both infinite;
        }
        @keyframes bell {
            0% { transform: rotate(0); }
            10% { transform: rotate(30deg); }
            20% { transform: rotate(0); }
            80% { transform: rotate(0); }
            90% { transform: rotate(-30deg); }
            100% { transform: rotate(0); }
        }
        @keyframes rad {
            0% { transform: translateX(0); }
            10% { transform: translateX(6px); }
            20% { transform: translateX(0); }
            80% { transform: translateX(0); }
            90% { transform: translateX(-6px); }
            100% { transform: translateX(0); }
        }
        @keyframes zoom {
            0% { opacity: 0; transform: scale(0); }
            10% { opacity: 1; transform: scale(1); }
            50% { opacity: 1; }
            51% { opacity: 0; }
            100% { opacity: 0; }
        }
    </style>
    @yield('css')
</head>
    <body class="nk-body bg-lighter npc-default has-sidebar ">
        <div class="nk-app-root">
            <!-- main @s -->
            <div class="nk-main ">
                <!-- sidebar @s -->
                <div class="nk-sidebar nk-sidebar-fixed is-light is-compact" data-content="sidebarMenu">
                    <div class="nk-sidebar-element nk-sidebar-head">
                        <div class="nk-sidebar-brand">
                            <a href="html/index.html" class="logo-link nk-sidebar-logo">
                                <img class="logo-light logo-img" src="{{ asset(check_host().'admin_assets/images/logo.png') }}" srcset="{{ asset(check_host().'admin_assets/images/logo2x.png 2x') }}" alt="logo">
                                <img class="logo-dark logo-img" src="{{ asset(check_host().'admin_assets/images/logo-dark.png') }}" srcset="{{ asset(check_host().'admin_assets/images/logo-dark2x.png 2x') }}" alt="logo-dark">
                                <img class="logo-small logo-img logo-img-small" src="{{ asset(check_host().'admin_assets/images/logo-small.png') }}" srcset="{{ asset(check_host().'admin_assets/images/logo-small2x.png 2x') }}" alt="logo-small">
                            </a>
                        </div>
                        <div class="nk-menu-trigger mr-n2">
                            <a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu"><em class="icon ni ni-arrow-left"></em></a>
                            <a href="#" class="nk-nav-compact nk-quick-nav-icon d-xl-inline-flex compact-active-" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
                        </div>
                    </div><!-- .nk-sidebar-element -->
                    <div class="nk-sidebar-element">
                        <div class="nk-sidebar-content">
                            <div class="nk-sidebar-menu" data-simplebar>
                                <ul class="nk-menu">

                                    @foreach (session()->get('menu') as $m)
                                    <li class="nk-menu-heading">
                                        <h6 class="overline-title text-primary-alt">{{ $m['name'] }}</h6>
                                    </li><!-- .nk-menu-item -->
                                    @foreach ($m['sub'] as $m1)
                                    <li class="nk-menu-item {{ isset($m1['sub']) ? 'has-sub' : '' }}">
                                        <a href="{{ $m1['slug'] ? '/admin/' . $m1['slug'] : '#' }}" class="nk-menu-link {{ isset($m1['sub']) ? 'nk-menu-toggle' : '' }}">
                                            <span class="nk-menu-icon"><em class="icon ni {{ $m1['icon'] }}"></em></span>
                                            <span class="nk-menu-text">{{ $m1['name'] }}</span>
                                        </a>
                                        @if (isset($m1['sub']))
                                        <ul class="nk-menu-sub">
                                        {{-- @php
                                        usort($m1['sub'], function($a, $b) {
                                            return $a['sort_order'] <=> $b['sort_order'];
                                        });
                                        @endphp --}}
                                        @foreach ($m1['sub'] as $m2)
                                            <li class="nk-menu-item">
                                                {{-- @if ($m2['name'] == 'Orders')
                                                <a href="#" class="nk-menu-link nk-menu-toggle"><span class="nk-menu-text">{{ $m2['name'] }}</span></a>
                                                <ul class="nk-menu-sub">
                                                    <li class="nk-menu-item">
                                                        <a href="/admin/orders?filter=PENDING" class="nk-menu-link"><span class="nk-menu-text"> PENDING</span></a>
                                                    </li>
                                                    <li class="nk-menu-item">
                                                        <a href="/admin/orders?filter=PAID" class="nk-menu-link"><span class="nk-menu-text"> PAID</span></a>
                                                    </li>
                                                    <li class="nk-menu-item">
                                                        <a href="/admin/orders?filter=UNPAID" class="nk-menu-link"><span class="nk-menu-text"> UNPAID</span></a>
                                                    </li>
                                                    <li class="nk-menu-item">
                                                        <a href="/admin/orders?filter=CANCELLED" class="nk-menu-link"><span class="nk-menu-text"> CANCELLED</span></a>
                                                    </li>
                                                </ul>
                                                @else --}}
                                                    <a href="{{ $m2['slug'] ? '/admin/' . $m2['slug'] : '#' }}" class="nk-menu-link {{ isset($m2['sub']) ? 'nk-menu-toggle' : '' }}"><span class="nk-menu-text">{{ $m2['name'] }}</span></a>
                                                    @if (isset($m2['sub']))
                                                    <ul class="nk-menu-sub">
                                                        @foreach ($m2['sub'] as $m3)
                                                        <li class="nk-menu-item">
                                                            <a href="/admin/{{ $m3['slug'] }}" class="nk-menu-link"><span class="nk-menu-text">{{ $m3['name'] }}</span></a>
                                                        </li>
                                                        @endforeach
                                                    </ul>
                                                    @endif
                                                {{-- @endif --}}
                                            </li>
                                            @endforeach
                                        </ul>
                                        @endif
                                    </li>
                                    @endforeach
                                    @endforeach

                                    @if (session()->get('user_email') == 'akash@qweysys.com')
                                    <li class="nk-menu-heading">
                                        <a href="/admin/project-setup">
                                            <h6 class="overline-title text-primary-alt" id="project-setup-link"> Project Setup</h6>
                                        </a>
                                    </li>
                                    <li class="nk-menu-heading">
                                        <a href="/admin/truncate-elastic">
                                            <h6 class="overline-title text-primary-alt" id="truncate-elastic-link"> Truncate Elastic Diamonds</h6>
                                        </a>
                                    </li>
                                    <li class="nk-menu-heading">
                                        <a href="/admin/truncate-diamonds">
                                            <h6 class="overline-title text-primary-alt" id="truncate-diamonds-link"> Truncate PG Diamonds</h6>
                                        </a>
                                    </li>
                                    <li class="nk-menu-heading">
                                        <a href="/admin/truncate-orders">
                                            <h6 class="overline-title text-primary-alt" id="truncate-orders-link"> Truncate Orders</h6>
                                        </a>
                                    </li><!-- .nk-menu-item -->
                                    @endif
                                </ul><!-- .nk-menu -->
                            </div><!-- .nk-sidebar-menu -->
                        </div><!-- .nk-sidebar-content -->
                    </div><!-- .nk-sidebar-element -->
                </div>
                <!-- sidebar @e -->
                <!-- wrap @s -->
                <div class="nk-wrap ">
                    <!-- main header @s -->
                    <div class="nk-header nk-header-fixed is-light">
                        <div class="container-fluid">
                            <div class="nk-header-wrap">
                                <div class="nk-menu-trigger d-xl-none ml-n1">
                                    <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
                                </div>
                                <div class="nk-header-brand d-xl-none">
                                    <a href="html/index.html" class="logo-link">
                                        <img class="logo-light logo-img" src="{{ asset(check_host().'admin_assets/images/logo.png') }}" srcset="{{ asset(check_host().'admin_assets/images/logo2x.png 2x') }}" alt="logo">
                                        <img class="logo-dark logo-img" src="{{ asset(check_host().'admin_assets/images/logo-dark.png') }}" srcset="{{ asset(check_host().'admin_assets/images/logo-dark2x.png 2x') }}" alt="logo-dark">
                                    </a>
                                </div><!-- .nk-header-brand -->
                                <div class="nk-header-tools">
                                    <ul class="nk-quick-nav">
                                        <li class="dropdown notification-dropdown">
                                            <a href="#" class="dropdown-toggle bg-warning" data-toggle="dropdown">
                                                {{-- <div class="icon-status icon-status-info"><em class="icon ni ni-bell"></em></div> --}}
                                                <div class="notification-box">
                                                    <span class="notification-count"></span>
                                                    <div class="notification-bell">
                                                    <span class="bell-top"></span>
                                                    <span class="bell-middle"></span>
                                                    <span class="bell-bottom"></span>
                                                    <span class="bell-rad"></span>
                                                    </div>
                                                </div>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-xl dropdown-menu-right">
                                                <div class="dropdown-head">
                                                    <span class="sub-title nk-dropdown-title">Notification</span>
                                                    <a href="#" class="push-noti-read">Mark as Read</a>
                                                </div>
                                                <div class="dropdown-body">
                                                    <div class="nk-notification">
                                                        <div class="nk-notification-item dropdown-inner">
                                                            <div class="nk-notification-icon">
                                                                <em class="icon icon-circle bg-warning-dim ni ni-curve-down-right"></em>
                                                            </div>
                                                            <div class="nk-notification-content">
                                                                <div class="nk-notification-text push-noti-text"></div>
                                                                <div class="nk-notification-time push-noti-time"></div>
                                                            </div>
                                                        </div>
                                                    </div><!-- .nk-notification -->
                                                </div><!-- .nk-dropdown-body -->
                                                {{-- <div class="dropdown-foot center">
                                                    <a href="#">View All</a>
                                                </div> --}}
                                            </div>
                                        </li>
                                        <li class="dropdown user-dropdown">
                                            <a href="#" class="dropdown-toggle mr-n1" data-toggle="dropdown">
                                                <div class="user-toggle">
                                                    <div class="user-avatar sm">
                                                        <em class="icon ni ni-user-alt"></em>
                                                    </div>
                                                </div>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                                                <div class="dropdown-inner">
                                                    <ul class="link-list">
                                                        <li><a href="{{route('logout')}}"><em class="icon ni ni-signout"></em><span>Sign out</span></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div><!-- .nk-header-wrap -->
                        </div><!-- .container-fliud -->
                    </div>
                    <!-- main header @e -->
                    @yield('content')

                    <!-- footer @s -->
                    <div class="nk-footer">
                        <div class="container-fluid">
                            <div class="nk-footer-wrap">
                                <div class="nk-footer-copyright"> &copy; 2021 Janvi LGD Pvt Ltd.
                                </div>
                                <div class="nk-footer-links">
                                    <ul class="nav nav-sm">
                                        <li class="nav-item"><a class="nav-link" href="#">Terms</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#">Privacy</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#">Help</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- footer @e -->
                </div>
                <!-- wrap @e -->
            </div>
            <!-- main @e -->
        </div>
        <!-- app-root @e -->
        <!-- JavaScript -->
        <script src="{{ asset(check_host().'admin_assets/assets/js/bundle.js?ver=1.9.2') }}"></script>
        <script src="{{ asset(check_host().'admin_assets/assets/js/scripts.js?ver=1.9.2') }}"></script>
        {{-- <script src="{{ asset(check_host().'admin_assets/js/charts/gd-default.js') }}"></script> --}}

        <link rel="stylesheet" href="{{ asset(check_host().'admin_assets/assets/css/editors/summernote.css')}}">
        <script type="text/javascript" nonce='S51U26wMQz' src="{{ asset(check_host().'admin_assets/assets/js/libs/editors/summernote.js')}}"></script>
        <?php // include 'admin_assets/assets/js/editors.php'; ?>

        <script src="{{ asset(check_host().'admin_assets/assets/js/charts/chart-ecommerce.js?ver=1.9.2') }}"></script>
        <link rel="stylesheet" href="{{ asset(check_host().'admin_assets/toast/jquery.toast.css') }}">
        <script src="{{ asset(check_host().'admin_assets/toast/jquery.toast.js') }}"></script>
        @yield('script')
        @include('admin.designation.designation_list_js')
        @include('admin.blogs.list_js')
        @include('admin.categories.list_js')
        @include('admin.customerType.list_js')
        @include('admin.discount.list_js')
        @include('admin.events.list_js')
        @include('admin.informativePages.list_js')
        @include('admin.labourCharges.list_js')
        @include('admin.paymentModes.list_js')
        @include('admin.settings.list_js')
        @include('admin.transport.list_js')
        @include('admin.modules.list_js')
        @include('admin.userActivity.list_js')
        @include('admin.country.list_js')
        @include('admin.state.list_js')
        @include('admin.city.list_js')
        @include('admin.userRoles.list_js')
        @include('admin.users.list_js')
        @include('admin.customers.list_js')
        @include('admin.deliveryCharges.list_js')
        @include('admin.taxes.list_js')
        @include('admin.sliders.list_js')
        @include('admin.attributeGroups.list_js')
        @include('admin.attributes.list_js')
        @include('admin.diamonds.list_js')
        @include('admin.rapaport.list_js')
        @include('admin.orders.list_js')
        @include('admin.commonjs')

        <?php
        if (!isset($_SESSION['message'])) {
            $_SESSION['message'] = '';
        }
        ?>
        @if (session()->get('user-type') == 'MASTER_ADMIN')
        <script type="module">
            // Import the functions you need from the SDKs you need
            import { initializeApp } from "https://www.gstatic.com/firebasejs/9.6.6/firebase-app.js";
            import { getMessaging, getToken, onMessage } from "https://www.gstatic.com/firebasejs/9.6.6/firebase-messaging.js";
            import { getAnalytics, isSupported } from "https://www.gstatic.com/firebasejs/9.6.6/firebase-analytics.js";
            // TODO: Add SDKs for Firebase products that you want to use
            // https://firebase.google.com/docs/web/setup#available-libraries

            // Your web app's Firebase configuration
            // For Firebase JS SDK v7.20.0 and later, measurementId is optional
            const firebaseConfig = {
                apiKey: "AIzaSyAPzNIRChBF70ycP9RMi0SYDquRWG1LTOw",
                authDomain: "janvi-lgd.firebaseapp.com",
                projectId: "janvi-lgd",
                storageBucket: "janvi-lgd.appspot.com",
                messagingSenderId: "152003953916",
                appId: "1:152003953916:web:1b15b4d05e7e12c1070379",
                measurementId: "G-L74PSGLSF4"
            };

            // Initialize Firebase
            const firebaseApp = initializeApp(firebaseConfig);
            const messaging = getMessaging(firebaseApp);
            const analytics = getAnalytics(firebaseApp);

		    if (window.location.href.search('dashboard') !== -1)

                const serviceWorkerRegistration = await navigator.serviceWorker.register(
                    '/firebase-messaging-sw.js', {
                        type: 'module'
                    });
                    // .then(reg => {
                    //     console.log(`Service Worker Registration (Scope: ${reg.scope})`);
                    // });
                if (!('Notification' in window && navigator.serviceWorker)) {
                    $.toast({
                        heading: 'Error',
                        text: 'Desktop Notification is not supported in this browser',
                        icon: 'error',
                        position: 'top-right'
                    });
                } else {
                    (async () => {
                        function initFirebaseMessagingRegistration() {
                            getToken(messaging, {
                                vapidKey: "BMHATKTzrOf7LF1PXuBfN3nb8LYeeErQwLBSDqfFEbxoiI__wcAYNk3I3xHh0cDhGa7wB32kohEJiYjbOP4O2Po",
                                serviceWorkerRegistration: serviceWorkerRegistration
                            })
                            .then(function(token) {
                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    }
                                });

                                $.ajax({
                                    url: '/admin/save-device-token',
                                    type: 'POST',
                                    data: {
                                        token: token
                                    },
                                    dataType: 'JSON',
                                    success: function (response) {
                                        // console.log('Token saved successfully.');
                                    },
                                    error: function (err) {
                                        console.log('User Chat Token Error '+ err);
                                    },
                                });

                            }).catch(function (err) {
                                console.log('User Chat Token Error '+ err);
                            });
                        }

                        let granted = false;
                        if (Notification.permission === "granted") {
                            granted = true;
                        } else if (Notification.permission !== "denied") {
                            let noti_permission = await Notification.requestPermission();
                            granted = noti_permission === 'granted' ? true : false;
                        }
                        if (granted) {
                            initFirebaseMessagingRegistration();
                        } else {
                            $.toast({
                                heading: 'Information',
                                text: 'Please give access to show notifications',
                                icon: 'info',
                                position: 'top-right'
                            });
                        }

                    })();
                }

            }

            onMessage(messaging, function (payload) {
                // console.log('Message received. ', payload);
                $('.push-noti-text').text(payload.notification.body);
                $('.push-noti-time').text(JSON.parse(payload.data['gcm.notification.data']).time);
                $('.notification-dropdown').slideDown();
                const noteTitle = payload.notification.title;
                const noteOptions = {
                    body: payload.notification.body,
                    icon: payload.notification.icon,
                };
                new Notification(noteTitle, noteOptions);
            });

            $(document).on('click', '.push-noti-read', function () {
                $('.push-noti-text, .push-noti-time').text('');
                $('.notification-dropdown').slideUp();
            });

            /* $(document).ready( (event) => {
                setTimeout(() => {
                    $.ajax({
                        url: '/admin/test-noti/Hello/How are you',
                        type: 'GET',
                        dataType: 'JSON',
                    });
                }, 1000);
            }); */
        </script>
        @endif
        <script type="text/javascript">

            $(document).on('click', '#project-setup-link, #truncate-elastic-link, #truncate-diamonds-link, #truncate-orders-link', function() {
                if (!confirm('Are you sure, you want to execute this command?')) {
                    return false;
                }
            });
            function showloader(){
                $("#append_loader").css("display","block");
                return true;
            }
            $(document).ready(function () {

                if (<?php
                if (!empty(session()->get('request_check'))) {
                    echo session()->get('request_check');
                } else {
                    echo 0;
                }
                ?> === 1)
                {
                    $.ajax({
                        type: "POST",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        url: "{{ route('rapaport.updatePrice') }}"
                        });
                        <?php session(['request_check' => 0]); ?>
                    }

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
    </body>
</html>
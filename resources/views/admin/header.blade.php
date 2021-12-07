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
        </style>

        @yield('css')
    </head>
    <body class="nk-body bg-lighter npc-default has-sidebar ">
        <div class="nk-app-root">
            <!-- main @s -->
            <div class="nk-main ">
                <!-- sidebar @s -->
                <div class="nk-sidebar nk-sidebar-fixed is-light " data-content="sidebarMenu">
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
                            <a href="#" class="nk-nav-compact nk-quick-nav-icon d-none d-xl-inline-flex" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
                        </div>
                    </div><!-- .nk-sidebar-element -->
                    <div class="nk-sidebar-element">
                        <div class="nk-sidebar-content">
                            <div class="nk-sidebar-menu" data-simplebar>
                                <ul class="nk-menu">

                                <?php
                                    if (session('user-type') == "MASTER_ADMIN") {
                                        ?>
                                                    <li class="nk-menu-heading">
                                            <h6 class="overline-title text-primary-alt">Diamonds</h6>
                                        </li><!-- .nk-menu-item -->
                                       <li class="nk-menu-item has-sub">
                                                                            <a href="#" class="nk-menu-link nk-menu-toggle">
                                                                                <span class="nk-menu-icon"><em class="icon ni nni ni-centos"></em></span>
                                                                                <span class="nk-menu-text">Diamonds</span>
                                                                            </a>
                                                                            <ul class="nk-menu-sub">
                                                                                <?php if (!empty(session('categories'))) {
                                                                                    foreach (session('categories') as $cat_row) {
                                                                                        ?>
                                                                                <li class="nk-menu-item">
                                                                                    <a href="/<?php echo 'admin/diamonds/list/'.$cat_row->category_id; ?>" class="nk-menu-link"><span class="nk-menu-text"><?php echo $cat_row->name; ?></span></a>
                                                                                </li>
                                                                                <?php

                                                                                    }
                                                                                } ?>
                                                                            </ul>
                                                                        </li>
                                        <?php
                                    }
                                    ?>

                                    <?php
                                    if (!empty(session('menu'))) {
                                        foreach (session('menu') as $session_row) {
                                            ?>

                                            <li class="nk-menu-heading">
                                                <h6 class="overline-title text-primary-alt"><?php echo $session_row->name; ?></h6>
                                            </li><!-- .nk-menu-item -->

                                            <?php
                                            if (!empty($session_row->submenu)) {
                                                foreach ($session_row->submenu as $submenu) {
                                                    ?>
                                                    <li class="nk-menu-item">
                                                        <a href="/<?php echo 'admin/' . $submenu->slug; ?>" class="nk-menu-link">
                                                            <span class="nk-menu-icon"><em class="icon ni <?php echo $submenu->icon; ?>"></em></span>
                                                            <span class="nk-menu-text"><?php echo $submenu->name; ?></span>
                                                        </a>
                                                    </li><!-- .nk-menu-item -->
                                                    <?php
                                                }
                                            }
                                        }
                                    }
                                    ?>
                                    <?php
                                    if (session('user-type') == "MASTER_ADMIN") {
                                        ?>
                                        <li class="nk-menu-heading">
                                            <h6 class="overline-title text-primary-alt">Modules</h6>
                                        </li><!-- .nk-menu-item -->
                                        <li class="nk-menu-item">
                                            <a href="{{url('admin/modules')}}" class="nk-menu-link">
                                                <span class="nk-menu-icon"><em class="icon ni ni-menu"></em></span>
                                                <span class="nk-menu-text">Modules</span>
                                            </a>
                                        </li><!-- .nk-menu-item -->
                                        <?php
                                    }
                                    ?>

                                        <li class="nk-menu-heading">
                                            <a href="/project-setup"><h6 class="overline-title text-primary-alt">Project Setup</h6></a>
                                        </li><!-- .nk-menu-item -->
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
                                <div class="nk-header-search ml-3 ml-xl-0">
                                    <em class="icon ni ni-search"></em>
                                    <input type="text" class="form-control border-transparent form-focus-none" placeholder="Search anything">
                                </div><!-- .nk-header-news -->
                                <div class="nk-header-tools">
                                    <ul class="nk-quick-nav">
                                        <li class="dropdown chats-dropdown hide-mb-xs">
                                            <a href="#" class="dropdown-toggle nk-quick-nav-icon" data-toggle="dropdown">
                                                <div class="icon-status icon-status-na"><em class="icon ni ni-comments"></em></div>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-xl dropdown-menu-right">
                                                <div class="dropdown-head">
                                                    <span class="sub-title nk-dropdown-title">Recent Chats</span>
                                                    <a href="#">Setting</a>
                                                </div>
                                                <div class="dropdown-body">
                                                    <ul class="chat-list">
                                                        <li class="chat-item">
                                                            <a class="chat-link" href="html/apps-chats.html">
                                                                <div class="chat-media user-avatar">
                                                                    <span>IH</span>
                                                                    <span class="status dot dot-lg dot-gray"></span>
                                                                </div>
                                                                <div class="chat-info">
                                                                    <div class="chat-from">
                                                                        <div class="name">Iliash Hossain</div>
                                                                        <span class="time">Now</span>
                                                                    </div>
                                                                    <div class="chat-context">
                                                                        <div class="text">You: Please confrim if you got my last messages.</div>
                                                                        <div class="status delivered">
                                                                            <em class="icon ni ni-check-circle-fill"></em>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </li><!-- .chat-item -->
                                                        <li class="chat-item is-unread">
                                                            <a class="chat-link" href="html/apps-chats.html">
                                                                <div class="chat-media user-avatar bg-pink">
                                                                    <span>AB</span>
                                                                    <span class="status dot dot-lg dot-success"></span>
                                                                </div>
                                                                <div class="chat-info">
                                                                    <div class="chat-from">
                                                                        <div class="name">Abu Bin Ishtiyak</div>
                                                                        <span class="time">4:49 AM</span>
                                                                    </div>
                                                                    <div class="chat-context">
                                                                        <div class="text">Hi, I am Ishtiyak, can you help me with this problem ?</div>
                                                                        <div class="status unread">
                                                                            <em class="icon ni ni-bullet-fill"></em>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </li><!-- .chat-item -->
                                                        <li class="chat-item">
                                                            <a class="chat-link" href="html/apps-chats.html">
                                                                <div class="chat-media user-avatar">
                                                                    <img src="{{ asset(check_host().'admin_assets/images/avatar/b-sm.jpg') }}" alt="">
                                                                </div>
                                                                <div class="chat-info">
                                                                    <div class="chat-from">
                                                                        <div class="name">George Philips</div>
                                                                        <span class="time">6 Apr</span>
                                                                    </div>
                                                                    <div class="chat-context">
                                                                        <div class="text">Have you seens the claim from Rose?</div>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </li><!-- .chat-item -->
                                                        <li class="chat-item">
                                                            <a class="chat-link" href="html/apps-chats.html">
                                                                <div class="chat-media user-avatar user-avatar-multiple">
                                                                    <div class="user-avatar">
                                                                        <img src="{{ asset(check_host().'admin_assets/images/avatar/c-sm.jpg') }}" alt="">
                                                                    </div>
                                                                    <div class="user-avatar">
                                                                        <span>AB</span>
                                                                    </div>
                                                                </div>
                                                                <div class="chat-info">
                                                                    <div class="chat-from">
                                                                        <div class="name">Softnio Group</div>
                                                                        <span class="time">27 Mar</span>
                                                                    </div>
                                                                    <div class="chat-context">
                                                                        <div class="text">You: I just bought a new computer but i am having some problem</div>
                                                                        <div class="status sent">
                                                                            <em class="icon ni ni-check-circle"></em>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </li><!-- .chat-item -->
                                                        <li class="chat-item">
                                                            <a class="chat-link" href="html/apps-chats.html">
                                                                <div class="chat-media user-avatar">
                                                                    <img src="{{ asset(check_host().'admin_assets/images/avatar/a-sm.jpg') }}" alt="">
                                                                    <span class="status dot dot-lg dot-success"></span>
                                                                </div>
                                                                <div class="chat-info">
                                                                    <div class="chat-from">
                                                                        <div class="name">Larry Hughes</div>
                                                                        <span class="time">3 Apr</span>
                                                                    </div>
                                                                    <div class="chat-context">
                                                                        <div class="text">Hi Frank! How is you doing?</div>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </li><!-- .chat-item -->
                                                        <li class="chat-item">
                                                            <a class="chat-link" href="html/apps-chats.html">
                                                                <div class="chat-media user-avatar bg-purple">
                                                                    <span>TW</span>
                                                                </div>
                                                                <div class="chat-info">
                                                                    <div class="chat-from">
                                                                        <div class="name">Tammy Wilson</div>
                                                                        <span class="time">27 Mar</span>
                                                                    </div>
                                                                    <div class="chat-context">
                                                                        <div class="text">You: I just bought a new computer but i am having some problem</div>
                                                                        <div class="status sent">
                                                                            <em class="icon ni ni-check-circle"></em>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </li><!-- .chat-item -->
                                                    </ul><!-- .chat-list -->
                                                </div><!-- .nk-dropdown-body -->
                                                <div class="dropdown-foot center">
                                                    <a href="html/apps-chats.html">View All</a>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="dropdown notification-dropdown">
                                            <a href="#" class="dropdown-toggle nk-quick-nav-icon" data-toggle="dropdown">
                                                <div class="icon-status icon-status-info"><em class="icon ni ni-bell"></em></div>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-xl dropdown-menu-right">
                                                <div class="dropdown-head">
                                                    <span class="sub-title nk-dropdown-title">Notifications</span>
                                                    <a href="#">Mark All as Read</a>
                                                </div>
                                                <div class="dropdown-body">
                                                    <div class="nk-notification">
                                                        <div class="nk-notification-item dropdown-inner">
                                                            <div class="nk-notification-icon">
                                                                <em class="icon icon-circle bg-warning-dim ni ni-curve-down-right"></em>
                                                            </div>
                                                            <div class="nk-notification-content">
                                                                <div class="nk-notification-text">You have requested to <span>Widthdrawl</span></div>
                                                                <div class="nk-notification-time">2 hrs ago</div>
                                                            </div>
                                                        </div>
                                                        <div class="nk-notification-item dropdown-inner">
                                                            <div class="nk-notification-icon">
                                                                <em class="icon icon-circle bg-success-dim ni ni-curve-down-left"></em>
                                                            </div>
                                                            <div class="nk-notification-content">
                                                                <div class="nk-notification-text">Your <span>Deposit Order</span> is placed</div>
                                                                <div class="nk-notification-time">2 hrs ago</div>
                                                            </div>
                                                        </div>
                                                        <div class="nk-notification-item dropdown-inner">
                                                            <div class="nk-notification-icon">
                                                                <em class="icon icon-circle bg-warning-dim ni ni-curve-down-right"></em>
                                                            </div>
                                                            <div class="nk-notification-content">
                                                                <div class="nk-notification-text">You have requested to <span>Widthdrawl</span></div>
                                                                <div class="nk-notification-time">2 hrs ago</div>
                                                            </div>
                                                        </div>
                                                        <div class="nk-notification-item dropdown-inner">
                                                            <div class="nk-notification-icon">
                                                                <em class="icon icon-circle bg-success-dim ni ni-curve-down-left"></em>
                                                            </div>
                                                            <div class="nk-notification-content">
                                                                <div class="nk-notification-text">Your <span>Deposit Order</span> is placed</div>
                                                                <div class="nk-notification-time">2 hrs ago</div>
                                                            </div>
                                                        </div>
                                                        <div class="nk-notification-item dropdown-inner">
                                                            <div class="nk-notification-icon">
                                                                <em class="icon icon-circle bg-warning-dim ni ni-curve-down-right"></em>
                                                            </div>
                                                            <div class="nk-notification-content">
                                                                <div class="nk-notification-text">You have requested to <span>Widthdrawl</span></div>
                                                                <div class="nk-notification-time">2 hrs ago</div>
                                                            </div>
                                                        </div>
                                                        <div class="nk-notification-item dropdown-inner">
                                                            <div class="nk-notification-icon">
                                                                <em class="icon icon-circle bg-success-dim ni ni-curve-down-left"></em>
                                                            </div>
                                                            <div class="nk-notification-content">
                                                                <div class="nk-notification-text">Your <span>Deposit Order</span> is placed</div>
                                                                <div class="nk-notification-time">2 hrs ago</div>
                                                            </div>
                                                        </div>
                                                    </div><!-- .nk-notification -->
                                                </div><!-- .nk-dropdown-body -->
                                                <div class="dropdown-foot center">
                                                    <a href="#">View All</a>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="dropdown user-dropdown">
                                            <a href="#" class="dropdown-toggle mr-n1" data-toggle="dropdown">
                                                <div class="user-toggle">
                                                    <div class="user-avatar sm">
                                                        <em class="icon ni ni-user-alt"></em>
                                                    </div>
                                                    <div class="user-info d-none d-xl-block">
                                                        <div class="user-status user-status-unverified">Unverified</div>
                                                        <div class="user-name dropdown-indicator">Akash Shah</div>
                                                    </div>
                                                </div>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                                                <div class="dropdown-inner user-card-wrap bg-lighter d-none d-md-block">
                                                    <div class="user-card">
                                                        <div class="user-avatar">
                                                            <span>AS</span>
                                                        </div>
                                                        <div class="user-info">
                                                            <span class="lead-text">Akash Shah</span>
                                                            <span class="sub-text">akash@qwesys.com</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="dropdown-inner">
                                                    <ul class="link-list">
                                                        <li><a href="html/user-profile-regular.html"><em class="icon ni ni-user-alt"></em><span>View Profile</span></a></li>
                                                        <li><a href="html/user-profile-setting.html"><em class="icon ni ni-setting-alt"></em><span>Account Setting</span></a></li>
                                                        <li><a href="html/user-profile-activity.html"><em class="icon ni ni-activity-alt"></em><span>Login Activity</span></a></li>
                                                    </ul>
                                                </div>
                                                <div class="dropdown-inner">
                                                    <ul class="link-list">
                                                        <li><a href="admin/logout"><em class="icon ni ni-signout"></em><span>Sign out</span></a></li>
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
        <script type="text/javascript">
            $(document).ready(function () {
                $('a[href$="#finish"]').attr("class", "submit_customers");
                $('a[href$="#finish"]').addClass("d-none");
                $('a[href$="#finish"]').parent('li').append('<button calss="submit_btn">submit</button>');

                $(document).on('click', '.submit_btn', function () {
                    $('.submit_btn').get(0).submit();
                });

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
                        // success: function (res) {
                            // }
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
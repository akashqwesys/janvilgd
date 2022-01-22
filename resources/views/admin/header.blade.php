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
                                    <li class="nk-menu-item">
                                        <a href="/admin/dashboard/inventory" class="nk-menu-link">
                                            <span class="nk-menu-icon"><em class="icon ni ni-dashboard-fill"></em></span>
                                            <span class="nk-menu-text">Dashboard</span>
                                        </a>
                                    </li><!-- .nk-menu-item -->

                                    <li class="nk-menu-heading">
                                        <h6 class="overline-title text-primary-alt">Inventory</h6>
                                    </li><!-- .nk-menu-item -->
                                    <li class="nk-menu-item has-sub">
                                        <a href="#" class="nk-menu-link nk-menu-toggle">
                                            <span class="nk-menu-icon"><em class="icon ni ni-note-add"></em></span>
                                            <span class="nk-menu-text">Inventory</span>
                                        </a>
                                        <ul class="nk-menu-sub">
                                            <li class="nk-menu-item">
                                                <a href="#" class="nk-menu-link nk-menu-toggle"><span class="nk-menu-text">Diamonds</span></a>
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
                                            <li class="nk-menu-item">
                                                <a href="/admin/categories" class="nk-menu-link"><span class="nk-menu-text"> Categories</span></a>
                                            </li>
                                            <li class="nk-menu-item">
                                                <a href="#" class="nk-menu-link nk-menu-toggle"><span class="nk-menu-text">Attributes</span></a>
                                                <ul class="nk-menu-sub">
                                                    <li class="nk-menu-item">
                                                        <a href="/admin/attributes" class="nk-menu-link"><span class="nk-menu-text">Attributes</span></a>
                                                    </li>
                                                    <li class="nk-menu-item">
                                                        <a href="/admin/attribute-groups" class="nk-menu-link"><span class="nk-menu-text">Attributes Groups</span></a>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li class="nk-menu-item">
                                                <a href="/admin/rapaport" class="nk-menu-link"><span class="nk-menu-text"> Rapaport</span></a>
                                            </li>
                                            <li class="nk-menu-item">
                                                <a href="#" class="nk-menu-link nk-menu-toggle"><span class="nk-menu-text">Charges</span></a>
                                                <ul class="nk-menu-sub">
                                                    <li class="nk-menu-item">
                                                        <a href="/admin/labour-charges" class="nk-menu-link"><span class="nk-menu-text">Labour Charges</span></a>
                                                    </li>
                                                    <li class="nk-menu-item">
                                                        <a href="/admin/delivery-charges" class="nk-menu-link"><span class="nk-menu-text">Shipping/Delivery</span></a>
                                                    </li>
                                                    <li class="nk-menu-item">
                                                        <a href="/admin/discount" class="nk-menu-link"><span class="nk-menu-text">Discount</span></a>
                                                    </li>
                                                    <li class="nk-menu-item">
                                                        <a href="/admin/taxes" class="nk-menu-link"><span class="nk-menu-text">Tax</span></a>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li class="nk-menu-item">
                                                <a href="/admin/transport" class="nk-menu-link"><span class="nk-menu-text"> Transport</span></a>
                                            </li>
                                            <li class="nk-menu-item">
                                                <a href="/admin/payment-modes" class="nk-menu-link"><span class="nk-menu-text"> Payment Modes</span></a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="nk-menu-heading">
                                        <h6 class="overline-title text-primary-alt">Orders</h6>
                                    </li><!-- .nk-menu-item -->
                                    <li class="nk-menu-item has-sub">
                                        <a href="#" class="nk-menu-link nk-menu-toggle">
                                            <span class="nk-menu-icon"><em class="icon ni ni-report-profit"></em></span>
                                            <span class="nk-menu-text">Orders</span>
                                        </a>
                                        <ul class="nk-menu-sub">
                                            <li class="nk-menu-item">
                                                <a href="#" class="nk-menu-link nk-menu-toggle"><span class="nk-menu-text">Sold Diamonds</span></a>
                                                <ul class="nk-menu-sub">
                                                <?php if (!empty(session('categories'))) {
                                                    foreach (session('categories') as $cat_row) {
                                                        ?>
                                                        <li class="nk-menu-item">
                                                            <a href="/<?php echo 'admin/sold-diamonds/list/'.$cat_row->slug; ?>" class="nk-menu-link"><span class="nk-menu-text"><?php echo $cat_row->name; ?></span></a>
                                                        </li>
                                                        <?php
                                                    }
                                                } ?>
                                                </ul>
                                            </li>
                                            <li class="nk-menu-item">
                                                <a href="#" class="nk-menu-link nk-menu-toggle"><span class="nk-menu-text">Orders</span></a>
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
                                                    <li class="nk-menu-item">
                                                        <a href="/admin/orders?filter=OFFLINE" class="nk-menu-link"><span class="nk-menu-text"> OFFLINE</span></a>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="nk-menu-heading">
                                        <h6 class="overline-title text-primary-alt">Users</h6>
                                    </li><!-- .nk-menu-item -->
                                    <li class="nk-menu-item has-sub">
                                        <a href="#" class="nk-menu-link nk-menu-toggle">
                                            <span class="nk-menu-icon"><em class="icon ni ni-users"></em></span>
                                            <span class="nk-menu-text">Users</span>
                                        </a>
                                        <ul class="nk-menu-sub">
                                            <li class="nk-menu-item">
                                                <a href="/admin/customers" class="nk-menu-link"><span class="nk-menu-text"> Customers</span></a>
                                            </li>
                                            <li class="nk-menu-item">
                                                <a href="/admin/customer-activities" class="nk-menu-link"><span class="nk-menu-text"> Customers Activity</span></a>
                                            </li>
                                            <li class="nk-menu-item">
                                                <a href="/admin/customer-type" class="nk-menu-link"><span class="nk-menu-text"> Customers Type</span></a>
                                            </li>
                                            <li class="nk-menu-item">
                                                <a href="/admin/users" class="nk-menu-link"><span class="nk-menu-text"> Employees</span></a>
                                            </li>
                                            <li class="nk-menu-item">
                                                <a href="/admin/user-activity" class="nk-menu-link"><span class="nk-menu-text"> Employees Activity</span></a>
                                            </li>
                                            <li class="nk-menu-item">
                                                <a href="/admin/user-role" class="nk-menu-link"><span class="nk-menu-text"> Employees Role</span></a>
                                            </li>
                                            <li class="nk-menu-item">
                                                <a href="/admin/designation" class="nk-menu-link"><span class="nk-menu-text"> Designation</span></a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="nk-menu-heading">
                                        <h6 class="overline-title text-primary-alt">Address</h6>
                                    </li><!-- .nk-menu-item -->
                                    <li class="nk-menu-item has-sub">
                                        <a href="#" class="nk-menu-link nk-menu-toggle">
                                            <span class="nk-menu-icon"><em class="icon ni ni-map-pin"></em></span>
                                            <span class="nk-menu-text">Address</span>
                                        </a>
                                        <ul class="nk-menu-sub">
                                            <li class="nk-menu-item">
                                                <a href="/admin/country" class="nk-menu-link"><span class="nk-menu-text"> Countries</span></a>
                                            </li>
                                            <li class="nk-menu-item">
                                                <a href="/admin/state" class="nk-menu-link"><span class="nk-menu-text"> States</span></a>
                                            </li>
                                            <li class="nk-menu-item">
                                                <a href="/admin/city" class="nk-menu-link"><span class="nk-menu-text"> Cities</span></a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="nk-menu-heading">
                                        <h6 class="overline-title text-primary-alt">Web Modules</h6>
                                    </li><!-- .nk-menu-item -->
                                    <li class="nk-menu-item has-sub">
                                        <a href="#" class="nk-menu-link nk-menu-toggle">
                                            <span class="nk-menu-icon"><em class="icon ni ni-card-view"></em></span>
                                            <span class="nk-menu-text">Web Modules</span>
                                        </a>
                                        <ul class="nk-menu-sub">
                                            <li class="nk-menu-item">
                                                <a href="/admin/informative-pages" class="nk-menu-link"><span class="nk-menu-text"> Informative Pages</span></a>
                                            </li>
                                            <li class="nk-menu-item">
                                                <a href="/admin/sliders" class="nk-menu-link"><span class="nk-menu-text"> Sliders</span></a>
                                            </li>
                                            <li class="nk-menu-item">
                                                <a href="/admin/events" class="nk-menu-link"><span class="nk-menu-text"> Events</span></a>
                                            </li>
                                            <li class="nk-menu-item">
                                                <a href="/admin/blogs" class="nk-menu-link"><span class="nk-menu-text"> Blogs</span></a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="nk-menu-heading">
                                        <h6 class="overline-title text-primary-alt">Modules</h6>
                                    </li><!-- .nk-menu-item -->
                                    <li class="nk-menu-item">
                                        <a href="/admin/modules" class="nk-menu-link">
                                            <span class="nk-menu-icon"><em class="icon ni ni-list-round"></em></span>
                                            <span class="nk-menu-text">Modules</span>
                                        </a>
                                    </li>

                                    <li class="nk-menu-heading">
                                        <h6 class="overline-title text-primary-alt">Settings</h6>
                                    </li><!-- .nk-menu-item -->
                                    <li class="nk-menu-item">
                                        <a href="/admin/settings" class="nk-menu-link">
                                            <span class="nk-menu-icon"><em class="icon ni ni-setting"></em></span>
                                            <span class="nk-menu-text">Settings</span>
                                        </a>
                                    </li>
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
        <script type="text/javascript">
            $(document).on('click', '#project-setup-link, #truncate-elastic-link, #truncate-diamonds-link', function() {
                if (!confirm('Are you sure, you want to execute this command?')) {
                    return false;
                }
            });
            function showloader(){
                    $("#append_loader").css("display","block");
                    return true;
                }
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
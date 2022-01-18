@extends('admin.header')

@section('css')
<style type="text/css">
    span.title {
        font-size: 1.05rem;
        font-family: "DM Sans", sans-serif;
        font-weight: 700;
        line-height: 1.1;
        /* color: #364a63; */
    }
    .hv-effect:hover {
        background: #1f327f;
        color: #ffffff;
        transition: 0.5s;
        box-shadow: 0px 10px 30px 0px #616a8f;
    }
    .orders-revenue, .carats-revenue, .cancelled-revenue {
        height: 200px;
    }
    .user-action {
        color: #000000;
    }
    .nk-activity-action {
        margin-left: auto;
        color: #8094ae;
    }
    .a-head {
        display: flex;
        vertical-align: middle;
        align-items: center;
    }
    .a-head .icon.ni {
        font-size: 18px;
    }
</style>
@endsection
@section('content')
<!-- content @s -->
<div class="nk-content">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block card card-bordered">
                    <div class="row g-gs card-body">
                        <div class="col-md-2 col-lg-2 col-4">
                            <div class="">
                                <a class="a-head" href="/admin/dashboard/inventory">
                                    <em class="icon ni ni-money"></em>
                                    <span class="pl-1"><b>INVENTORY</b></span>
                                </a>
                            </div><!-- .card -->
                        </div><!-- .col -->
                        <div class="col-md-2 col-lg-2 col-4">
                            <div class="">
                                <a class="a-head" href="/admin/dashboard/sales">
                                    <em class="icon ni ni-sign-dollar"></em>
                                    <span class=""><b>SALES</b></span>
                                </a>
                            </div><!-- .card -->
                        </div><!-- .col -->
                        <div class="col-md-2 col-lg-2 col-4">
                            <div class="">
                                <a class="a-head" href="/admin/dashboard/accounts">
                                    <em class="icon ni ni-report-profit"></em>
                                    <span class="pl-1"><b>ACCOUNTS</b></span>
                                </a>
                            </div><!-- .card -->
                        </div><!-- .col -->
                    </div>
                </div>
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">Dashboard</h3>
                        </div><!-- .nk-block-head-content -->
                        <div class="nk-block-head-content">

                        </div><!-- .nk-block-head-content -->
                    </div><!-- .nk-block-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block">
                    <div class="row g-gs">
                        <div class="col-md-6 col-lg-4">
                            <div class="card card-bordered">
                                <a class="card-body hv-effect" href="/admin/orders?filter=yesterday">
                                    <span class="title">Today's Orders</span>
                                    <span class="title float-right">{{ $orders->today }}</span>
                                </a>
                            </div><!-- .card -->
                        </div><!-- .col -->
                        <div class="col-md-6 col-lg-4">
                            <div class="card card-bordered">
                                <a class="card-body hv-effect" href="/admin/orders?filter=7days">
                                    <span class="title">Last 7 Days Orders</span>
                                    <span class="title float-right">{{ $orders->last_7 }}</span>
                                </a>
                            </div><!-- .card -->
                        </div><!-- .col -->
                        <div class="col-md-6 col-lg-4">
                            <div class="card card-bordered">
                                <a class="card-body hv-effect" href="/admin/orders?filter=30days">
                                    <span class="title">Last 30 Days Orders</span>
                                    <span class="title float-right">{{ $orders->last_30 }}</span>
                                </a>
                            </div><!-- .card -->
                        </div><!-- .col -->
                        <div class="col-md-6 col-lg-4">
                            <div class="card card-bordered card-full">
                                <div class="card-inner-group">
                                    <div class="card-inner">
                                        <div class="card-title-group">
                                            <div class="card-title">
                                                <h6 class="title">Pending Orders ({{ count($pending_orders) }})</h6>
                                            </div>
                                            <div class="card-tools">
                                                <a href="/admin/orders?filter=PENDING" class="link">View All</a>
                                            </div>
                                        </div>
                                    </div>
                                    @if (count($pending_orders))
                                    @for ($i = 0; $i < (count($pending_orders) < 5 ? count($pending_orders) : 5); $i++)
                                    <div class="card-inner card-inner-md">
                                        <div class="user-card">
                                            <div class="user-avatar bg-primary-dim">
                                                <span>{{ $pending_orders[$i]->name[0] }}</span>
                                            </div>
                                            <div class="user-info">
                                                <span class="lead-text">{{ $pending_orders[$i]->name . ' (#' . $pending_orders[$i]->order_id . ')'}}</span>
                                                <span class="sub-text">{{ $pending_orders[$i]->email_id }}</span>
                                            </div>
                                            <div class="user-action">
                                                <small>${{ number_format(round($pending_orders[$i]->total_paid_amount, 2), 2, '.', ',') }}</small>
                                            </div>
                                        </div>
                                    </div>
                                    @endfor
                                    @endif
                                </div>
                            </div><!-- .card -->
                        </div><!-- .col -->
                        <div class="col-md-6 col-lg-4">
                            <div class="card card-bordered card-full">
                                <div class="card-inner-group">
                                    <div class="card-inner">
                                        <div class="card-title-group">
                                            <div class="card-title">
                                                <h6 class="title">Completed Orders ({{ count($completed_orders) }})</h6>
                                            </div>
                                            <div class="card-tools">
                                                <a href="/admin/orders?filter=COMPLETED" class="link">View All</a>
                                            </div>
                                        </div>
                                    </div>
                                    @if (count($completed_orders))
                                    @for ($i = 0; $i < (count($completed_orders) < 5 ? count($completed_orders) : 5); $i++)
                                    <div class="card-inner card-inner-md">
                                        <div class="user-card">
                                            <div class="user-avatar bg-primary-dim">
                                                <span>{{ $completed_orders[$i]->name[0] }}</span>
                                            </div>
                                            <div class="user-info">
                                                <span class="lead-text">{{ $completed_orders[$i]->name . ' (#' . $completed_orders[$i]->order_id . ')'}}</span>
                                                <span class="sub-text">{{ $completed_orders[$i]->email_id }}</span>
                                            </div>
                                            <div class="user-action">
                                                <small>${{ number_format(round($completed_orders[$i]->total_paid_amount, 2), 2, '.', ',') }}</small>
                                            </div>
                                        </div>
                                    </div>
                                    @endfor
                                    @endif
                                </div>
                            </div><!-- .card -->
                        </div><!-- .col -->
                        <div class="col-md-6 col-lg-4">
                            <div class="card card-bordered card-full">
                                <div class="card-inner-group">
                                    <div class="card-inner">
                                        <div class="card-title-group">
                                            <div class="card-title">
                                                <h6 class="title">Offline Orders ({{ count($offline_orders) }})</h6>
                                            </div>
                                            <div class="card-tools">
                                                <a href="/admin/orders?filter=OFFLINE" class="link">View All</a>
                                            </div>
                                        </div>
                                    </div>
                                    @if (count($offline_orders))
                                    @for ($i = 0; $i < (count($offline_orders) < 5 ? count($offline_orders) : 5); $i++)
                                    <div class="card-inner card-inner-md">
                                        <div class="user-card">
                                            <div class="user-avatar bg-primary-dim">
                                                <span>{{ $offline_orders[$i]->name[0] }}</span>
                                            </div>
                                            <div class="user-info">
                                                <span class="lead-text">{{ $offline_orders[$i]->name . ' (#' . $offline_orders[$i]->order_id . ')'}}</span>
                                                <span class="sub-text">{{ $offline_orders[$i]->email_id }}</span>
                                            </div>
                                            <div class="user-action">
                                                <small>${{ number_format(round($offline_orders[$i]->total_paid_amount, 2), 2, '.', ',') }}</small>
                                            </div>
                                        </div>
                                    </div>
                                    @endfor
                                    @endif
                                </div>
                            </div><!-- .card -->
                        </div><!-- .col -->
                        <div class="col-md-6 col-lg-4">
                            <div class="card card-bordered card-full">
                                <div class="card-inner-group">
                                    <div class="card-inner">
                                        <div class="card-title-group">
                                            <div class="card-title">
                                                <h6 class="title">
                                                   <a href="/admin/report-customers?customer_type=recent"> Recent Customers </a>
                                                </h6>
                                            </div>
                                            <div class="card-tools"> </div>
                                        </div>
                                    </div>
                                    @foreach ($recent_customers as $p)
                                    <div class="card-inner card-inner-md">
                                        <div class="user-card">
                                            <div class="user-avatar bg-primary-dim">
                                                <span>{{ $p[0]->name[0] }}</span>
                                            </div>
                                            <div class="user-info">
                                                <span class="lead-text">{{ $p[0]->name }}</span>
                                                <span class="sub-text">{{ $p[0]->email }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div><!-- .card -->
                        </div><!-- .col -->
                        <div class="col-md-6 col-lg-4">
                            <div class="card card-bordered card-full">
                                <div class="card-inner-group">
                                    <div class="card-inner">
                                        <div class="card-title-group">
                                            <div class="card-title">
                                                <h6 class="title">
                                                   <a href="/admin/report-customers?customer_type=top"> Top Customers </a>
                                                </h6>
                                            </div>
                                            <div class="card-tools"> </div>
                                        </div>
                                    </div>
                                    @foreach ($top_customers as $p)
                                    <div class="card-inner card-inner-md">
                                        <div class="user-card">
                                            <div class="user-avatar bg-primary-dim">
                                                <span>{{ $p->name[0] }}</span>
                                            </div>
                                            <div class="user-info">
                                                <span class="lead-text">{{ $p->name }}</span>
                                                <span class="sub-text">{{ $p->email_id }}</span>
                                            </div>
                                            <div class="user-action">
                                                <small>{{ $p->repeative }}</small>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div><!-- .card -->
                        </div><!-- .col -->
                        <div class="col-md-6 col-lg-4">
                            <div class="card card-bordered card-full">
                                <div class="card-inner-group">
                                    <div class="card-inner">
                                        <div class="card-title-group">
                                            <div class="card-title">
                                                <h6 class="title">
                                                   <a href="/admin/report-customers?customer_type=bottom"> Bottom Customers </a>
                                                </h6>
                                            </div>
                                            <div class="card-tools"> </div>
                                        </div>
                                    </div>
                                    @foreach ($bottom_customers as $p)
                                    <div class="card-inner card-inner-md">
                                        <div class="user-card">
                                            <div class="user-avatar bg-primary-dim">
                                                <span>{{ $p->name[0] }}</span>
                                            </div>
                                            <div class="user-info">
                                                <span class="lead-text">{{ $p->name }}</span>
                                                <span class="sub-text">{{ $p->email_id }}</span>
                                            </div>
                                            <div class="user-action">
                                                <small>{{ $p->repeative }}</small>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div><!-- .card -->
                        </div><!-- .col -->
                        <div class="col-md-12 col-lg-6">
                            <div class="card card-bordered card-full">
                                <div class="card-inner border-bottom">
                                    <div class="card-title-group">
                                        <div class="card-title">
                                            <h6 class="title">Customers Activities</h6>
                                        </div>
                                        <div class="card-tools">
                                            <a href="/admin/customer-activities" class="link">View All</a>
                                        </div>
                                    </div>
                                </div>
                                <ul class="nk-activity">
                                     @foreach ($customer_activity as $c)
                                    <li class="nk-activity-item">
                                        <div class="user-avatar bg-primary-dim">
                                            <span>{{ $c->subject[0] }}</span>
                                        </div>
                                        <div class="nk-activity-data">
                                            <div class="label">{{ $c->subject }}</div>
                                            <span class="time">{{ date('dS F Y, \a\t H:i A', strtotime($c->created_at)) }}</span>
                                        </div>
                                        <div class="nk-activity-action">
                                            <div class="label">{{ $c->device }}</div>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div><!-- .card -->
                        </div><!-- .col -->
                        <div class="col-md-12 col-lg-6">
                            <div class="card card-bordered card-full">
                                <div class="card-inner border-bottom">
                                    <div class="card-title-group">
                                        <div class="card-title">
                                            <h6 class="title">Employees Activities</h6>
                                        </div>
                                        <div class="card-tools">
                                            <a href="/admin/user-activity" class="link">View All</a>
                                        </div>
                                    </div>
                                </div>
                                <ul class="nk-activity">
                                    @foreach ($employee_activity as $e)
                                    <li class="nk-activity-item">
                                        <div class="user-avatar bg-primary-dim">
                                            <span>{{ $e->name[0] }}</span>
                                        </div>
                                        <div class="nk-activity-data">
                                            <div class="label">{{ $e->subject . ' by ' . $e->name}}</div>
                                            <span class="time">{{ date('dS F Y, \a\t H:i A', strtotime($e->date_added)) }}</span>
                                        </div>
                                        <div class="nk-activity-action">
                                            <div class="label">{{ $e->device }}</div>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div><!-- .card -->
                        </div><!-- .col -->
                        <div class="col-lg-4 col-md-6">
                            <div class="card card-bordered">
                                <div class="card-inner">
                                    <div class="card-title-group align-start mb-2">
                                        <div class="card-title">
                                            <h6 class="title">
                                                <a href="/admin/report-orders?order_type=total_orders" class="">Total Orders</a>
                                            </h6>
                                            <p>Total number of orders in last 6 months</p>
                                        </div>
                                    </div>
                                    <div class="align-end gy-3 gx-5 flex-wrap flex-md-nowrap flex-lg-wrap flex-xxl-nowrap">
                                        <div class="nk-sales-ck orders-revenue">
                                            <canvas class="orders-bar-chart" id="ordersRevenue"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- .card -->
                        </div><!-- .col -->
                        <div class="col-lg-4 col-md-6">
                            <div class="card card-bordered">
                                <div class="card-inner">
                                    <div class="card-title-group align-start mb-2">
                                        <div class="card-title">
                                            <h6 class="title">
                                                <a href="/admin/report-orders?order_type=total_carats" class="">Total Carats Sold</a>
                                            </h6>
                                            <p>Total diamond carats sold in last 6 months</p>
                                        </div>
                                    </div>
                                    <div class="align-end gy-3 gx-5 flex-wrap flex-md-nowrap flex-lg-wrap flex-xxl-nowrap">
                                        <div class="nk-sales-ck carats-revenue">
                                            <canvas class="carats-bar-chart" id="caratsRevenue"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- .card -->
                        </div><!-- .col -->
                        <div class="col-lg-4 col-md-6">
                            <div class="card card-bordered">
                                <div class="card-inner">
                                    <div class="card-title-group align-start mb-2">
                                        <div class="card-title">
                                            <h6 class="title">
                                                <a href="/admin/report-orders?order_type=cancelled_orders" class="">Total Cancelled Orders</a>
                                            </h6>
                                            <p>Total cancelled orders in last 6 months</p>
                                        </div>
                                    </div>
                                    <div class="align-end gy-3 gx-5 flex-wrap flex-md-nowrap flex-lg-wrap flex-xxl-nowrap">
                                        <div class="nk-sales-ck cancelled-revenue">
                                            <canvas class="cancelled-bar-chart" id="cancelledRevenue"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- .card -->
                        </div><!-- .col -->
                        <div class="col-md-6 col-lg-4">
                            <div class="card card-preview">
                                <div class="card-inner">
                                    <div class="card-title">
                                        <h6 class="title">
                                            <a href="/admin/report-diamonds?category=polish" class="">Polish Diamonds</a>
                                        </h6>
                                        <p>Import and Sales ratio of last 3 months</p>
                                    </div>
                                    <div class="nk-ck-sm">
                                        <canvas class="bar-chart-polish" id="barChartPolish"></canvas>
                                    </div>
                                </div>
                            </div><!-- .card -->
                        </div><!-- .col -->
                        <div class="col-md-6 col-lg-4">
                            <div class="card card-preview">
                                <div class="card-inner">
                                    <div class="card-title">
                                        <h6 class="title">
                                            <a href="/admin/report-diamonds?category=4p" class="">4P Diamonds</a>
                                        </h6>
                                        <p>Import and Sales ratio of last 3 months</p>
                                    </div>
                                    <div class="nk-ck-sm">
                                        <canvas class="bar-chart-4p" id="barChart4P"></canvas>
                                    </div>
                                </div>
                            </div><!-- .card -->
                        </div><!-- .col -->
                        <div class="col-md-6 col-lg-4">
                            <div class="card card-preview">
                                <div class="card-inner">
                                    <div class="card-title">
                                        <h6 class="title">
                                            <a href="/admin/report-diamonds?category=rough" class="">Rough Diamonds</a>
                                        </h6>
                                        <p>Import and Sales ratio of last 3 months</p>
                                    </div>
                                    <div class="nk-ck-sm">
                                        <canvas class="bar-chart-rough" id="barChartRough"></canvas>
                                    </div>
                                </div>
                            </div><!-- .card -->
                        </div><!-- .col -->
                        <div class="col-md-6 col-lg-4">
                            <div class="card card-bordered">
                                <a class="card-body hv-effect" href="/admin/orders?date_range_filter={{ date('Y-m-01', strtotime(date('Y-m-d'))) . ' - ' . date('Y-m-t', strtotime(date('Y-m-d')))}}">
                                    <span class="title">Monthly Revenue</span>
                                    <span class="title float-right">${{ number_format(round($orders->monthly_revenue, 2), 2, '.', ',') }}</span>
                                </a>
                            </div><!-- .card -->
                        </div><!-- .col -->
                        @php
                        if (date('m') >= 1 && date('m') <= 3) {
                            $q_start = date('Y-m-d', strtotime(date('Y') . '-01-01'));
                            $q_end = date('Y-m-d', strtotime(date('Y') . '-03-31'));
                        } else if (date('m') >= 4 && date('m') <= 6) {
                            $q_start = date('Y-m-d', strtotime(date('Y') . '-04-01'));
                            $q_end = date('Y-m-d', strtotime(date('Y') . '-06-31'));
                        } else if (date('m') >= 7 && date('m') <= 9) {
                            $q_start = date('Y-m-d', strtotime(date('Y') . '-07-01'));
                            $q_end = date('Y-m-d', strtotime(date('Y') . '-09-31'));
                        } else {
                            $q_start = date('Y-m-d', strtotime(date('Y') . '-010-01'));
                            $q_end = date('Y-m-d', strtotime(date('Y') . '-12-31'));
                        }
                        @endphp
                        <div class="col-md-6 col-lg-4">
                            <div class="card card-bordered">
                                <a class="card-body hv-effect" href="/admin/orders?date_range_filter={{ date('Y-m-01', strtotime($q_start)) . ' - ' . date('Y-m-t', strtotime($q_end))}}">
                                    <span class="title">Quarterly Revenue</span>
                                    <span class="title float-right">${{ number_format(round($orders->quaterly_revenue, 2), 2, '.', ',') }}</span>
                                </a>
                            </div><!-- .card -->
                        </div><!-- .col -->
                        <div class="col-md-6 col-lg-4">
                            <div class="card card-bordered">
                                <a class="card-body hv-effect" href="/admin/orders?date_range_filter={{ date('Y-m-01', strtotime($start_year)) . ' - ' . date('Y-m-t', strtotime($end_year))}}">
                                    <span class="title">Yearly Revenue</span>
                                    <span class="title float-right">${{ number_format(round($orders->yearly_revenue, 2), 2, '.', ',') }}</span>
                                </a>
                            </div><!-- .card -->
                        </div><!-- .col -->
                        <div class="col-md-6 col-lg-4">
                            <div class="card card-bordered card-full">
                                <div class="card-inner-group">
                                    <div class="card-inner">
                                        <div class="card-title-group">
                                            <div class="card-title">
                                                <h6 class="title">
                                                    {{-- <a href="/admin/orders?filter=polish&shape={{ ($trending_polish[0]->shape ?? '') . '&carat=' . ($trending_polish[0]->carat ?? '') . '&color=' . ($trending_polish[0]->color ?? '') . '&clarity=' . ($trending_polish[0]->clarity ?? '') . '&cut=' . ($trending_polish[0]->cut ?? '') }}"> Most Ordered Polish Diamonds</a> --}}
                                                     Most Ordered Polish Diamonds
                                                </h6>
                                            </div>
                                            <div class="card-tools"> </div>
                                        </div>
                                    </div>
                                    <div class="card-inner card-inner-md">
                                        <div class="user-card">
                                            <div class="user-info">
                                                <span class="lead-text">SHAPE</span>
                                            </div>
                                            <div class="user-action">
                                                <span class="lead-text">{{ $trending_polish[0]->shape ?? '-' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-inner card-inner-md">
                                        <div class="user-card">
                                            <div class="user-info">
                                                <span class="lead-text">CARAT</span>
                                            </div>
                                            <div class="user-action">
                                                <span class="lead-text">{{ $trending_polish[0]->carat ?? '-' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-inner card-inner-md">
                                        <div class="user-card">
                                            <div class="user-info">
                                                <span class="lead-text">COLOR</span>
                                            </div>
                                            <div class="user-action">
                                                <span class="lead-text">{{ $trending_polish[0]->color ?? '-' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-inner card-inner-md">
                                        <div class="user-card">
                                            <div class="user-info">
                                                <span class="lead-text">CLARITY</span>
                                            </div>
                                            <div class="user-action">
                                                <span class="lead-text">{{ $trending_polish[0]->clarity ?? '-' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-inner card-inner-md">
                                        <div class="user-card">
                                            <div class="user-info">
                                                <span class="lead-text">CUT</span>
                                            </div>
                                            <div class="user-action">
                                                <span class="lead-text">{{ $trending_polish[0]->cut ?? '-' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- .card -->
                        </div><!-- .col -->
                        <div class="col-md-6 col-lg-4">
                            <div class="card card-bordered card-full">
                                <div class="card-inner-group">
                                    <div class="card-inner">
                                        <div class="card-title-group">
                                            <div class="card-title">
                                                <h6 class="title">
                                                    Most Ordered 4P Diamonds
                                                </h6>
                                            </div>
                                            <div class="card-tools"> </div>
                                        </div>
                                    </div>
                                    <div class="card-inner card-inner-md">
                                        <div class="user-card">
                                            <div class="user-info">
                                                <span class="lead-text">SHAPE</span>
                                            </div>
                                            <div class="user-action">
                                                <span class="lead-text">{{ $trending_4p[0]->shape ?? '-' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-inner card-inner-md">
                                        <div class="user-card">
                                            <div class="user-info">
                                                <span class="lead-text">CARAT</span>
                                            </div>
                                            <div class="user-action">
                                                <span class="lead-text">{{ $trending_4p[0]->carat ?? '-' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-inner card-inner-md">
                                        <div class="user-card">
                                            <div class="user-info">
                                                <span class="lead-text">COLOR</span>
                                            </div>
                                            <div class="user-action">
                                                <span class="lead-text">{{ $trending_4p[0]->color ?? '-' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-inner card-inner-md">
                                        <div class="user-card">
                                            <div class="user-info">
                                                <span class="lead-text">CLARITY</span>
                                            </div>
                                            <div class="user-action">
                                                <span class="lead-text">{{ $trending_4p[0]->clarity ?? '-' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-inner card-inner-md">
                                        <div class="user-card">
                                            <div class="user-info">
                                                <span class="lead-text">CUT</span>
                                            </div>
                                            <div class="user-action">
                                                <span class="lead-text">{{ $trending_4p[0]->cut ?? '-' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- .card -->
                        </div><!-- .col -->
                        <div class="col-md-6 col-lg-4">
                            <div class="card card-bordered card-full">
                                <div class="card-inner-group">
                                    <div class="card-inner">
                                        <div class="card-title-group">
                                            <div class="card-title">
                                                <h6 class="title">
                                                    Most Ordered Rough Diamonds
                                                </h6>
                                            </div>
                                            <div class="card-tools"> </div>
                                        </div>
                                    </div>
                                    <div class="card-inner card-inner-md">
                                        <div class="user-card">
                                            <div class="user-info">
                                                <span class="lead-text">SHAPE</span>
                                            </div>
                                            <div class="user-action">
                                                <span class="lead-text">{{ $trending_rough[0]->shape ?? '-' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-inner card-inner-md">
                                        <div class="user-card">
                                            <div class="user-info">
                                                <span class="lead-text">CARAT</span>
                                            </div>
                                            <div class="user-action">
                                                <span class="lead-text">{{ $trending_rough[0]->carat ?? '-' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-inner card-inner-md">
                                        <div class="user-card">
                                            <div class="user-info">
                                                <span class="lead-text">COLOR</span>
                                            </div>
                                            <div class="user-action">
                                                <span class="lead-text">{{ $trending_rough[0]->color ?? '-' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-inner card-inner-md">
                                        <div class="user-card">
                                            <div class="user-info">
                                                <span class="lead-text">CLARITY</span>
                                            </div>
                                            <div class="user-action">
                                                <span class="lead-text">{{ $trending_rough[0]->clarity ?? '-' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- .card -->
                        </div><!-- .col -->
                        <div class="col-md-6 col-lg-4">
                            <div class="card card-bordered">
                                <div class="card-body" >
                                    <span class="title"><a href="/admin/orders?filter=polish">Polish Ratio</a></span>
                                    <table width="100%" class="mt-1 table">
                                        <thead>
                                            <tr>
                                                <th width="50%" class="text-center"><div>Views</div></th>
                                                <th width="50%" class="text-center"><div>Orders</div></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td style="border-right: 1px solid #dbdfea;" align="center"><div>{{ $vs_views[2]->views_cnt }}</div></td>
                                                <td align="center"><div class="text-right-">{{ $vs_orders->total_polish ?? 0 }}</div></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="card card-bordered">
                                <div class="card-body" >
                                    <span class="title"><a href="/admin/orders?filter=4p">4P Ratio</a></span>
                                    <table width="100%" class="mt-1 table">
                                        <thead>
                                            <tr>
                                                <th width="50%" class="text-center"><div>Views</div></th>
                                                <th width="50%" class="text-center"><div>Orders</div></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td style="border-right: 1px solid #dbdfea;" align="center"><div>{{ $vs_views[1]->views_cnt }}</div></td>
                                                <td align="center"><div class="text-right-">{{ $vs_orders->total_4p ?? 0 }}</div></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="card card-bordered">
                                <div class="card-body" >
                                    <span class="title"><a href="/admin/orders?filter=rough">Rough Ratio</a></span>
                                    <table width="100%" class="mt-1 table">
                                        <thead>
                                            <tr>
                                                <th width="50%" class="text-center"><div>Views</div></th>
                                                <th width="50%" class="text-center"><div>Orders</div></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td style="border-right: 1px solid #dbdfea;" align="center"><div>{{ $vs_views[0]->views_cnt }}</div></td>
                                                <td align="center"><div class="text-right-">{{ $vs_orders->total_rough ?? 0 }}</div></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div><!-- .card -->
                        </div><!-- .col -->
                        <div class="col-md-6 col-lg-4">
                            <div class="card card-bordered">
                                <div class="card-body hv-effect" >
                                    <span class="title">Average 4P Weight Loss</span>
                                    <span class="title float-right">{{ $weight_loss->av_weight_loss ? round($weight_loss->av_weight_loss / $weight_loss->cn_weight_loss, 2) : 0 }}%</span>
                                </div>
                            </div><!-- .card -->
                        </div><!-- .col -->
                    </div>
                </div><!-- .nk-block -->
            </div>
        </div>
    </div>
</div>
<!-- content @e -->
@endsection
@section('script')
<script>
    !function (NioApp, $) {
        function _ordersBarChart(selector, set_data) {
            var $selector = selector ? $(selector) : $('.orders-bar-chart');
            $selector.each(function () {
                var $self = $(this),
                _self_id = $self.attr('id'),
                _get_data = typeof set_data === 'undefined' ? eval(_self_id) : set_data,
                _d_legend = typeof _get_data.legend === 'undefined' ? false : _get_data.legend;

                var selectCanvas = document.getElementById(_self_id).getContext("2d");
                var chart_data = [];

                for (var i = 0; i < _get_data.datasets.length; i++) {
                    chart_data.push({
                        label: _get_data.datasets[i].label,
                        data: _get_data.datasets[i].data,
                        // Styles
                        backgroundColor: _get_data.datasets[i].color,
                        borderWidth: 2,
                        borderColor: 'transparent',
                        hoverBorderColor: 'transparent',
                        borderSkipped: 'bottom',
                        barPercentage: .7,
                        categoryPercentage: .7
                    });
                }

                var chart = new Chart(selectCanvas, {
                    type: 'bar',
                    data: {
                        labels: _get_data.labels,
                        datasets: chart_data
                    },
                    options: {
                        legend: {
                            display: _get_data.legend ? _get_data.legend : false,
                            labels: {
                                boxWidth: 30,
                                padding: 20,
                                fontColor: '#6783b8'
                            }
                        },
                        maintainAspectRatio: false,
                        tooltips: {
                            enabled: true,
                            rtl: NioApp.State.isRTL,
                            callbacks: {
                                title: function title(tooltipItem, data) {
                                    return false;
                                },
                                label: function label(tooltipItem, data) {
                                    return data['labels'][tooltipItem['index']] + ' ' + data.datasets[tooltipItem.datasetIndex]['data'][tooltipItem['index']];
                                }
                            },
                            backgroundColor: '#eff6ff',
                            titleFontSize: 11,
                            titleFontColor: '#6783b8',
                            titleMarginBottom: 4,
                            bodyFontColor: '#9eaecf',
                            bodyFontSize: 10,
                            bodySpacing: 3,
                            yPadding: 8,
                            xPadding: 8,
                            footerMarginTop: 0,
                            displayColors: false
                        },
                        scales: {
                            yAxes: [{
                                display: true,
                                stacked: _get_data.stacked ? _get_data.stacked : false,
                                ticks: {
                                    beginAtZero: true
                                }
                            }],
                            xAxes: [{
                                display: true,
                                stacked: _get_data.stacked ? _get_data.stacked : false,
                                ticks: {
                                    reverse: NioApp.State.isRTL
                                }
                            }]
                        }
                    }
                });
            });
        } // init chart

        function _caratsBarChart(selector, set_data) {
            var $selector = selector ? $(selector) : $('.carats-bar-chart');
            $selector.each(function () {
                var $self = $(this),
                _self_id = $self.attr('id'),
                _get_data = typeof set_data === 'undefined' ? eval(_self_id) : set_data,
                _d_legend = typeof _get_data.legend === 'undefined' ? false : _get_data.legend;

                var selectCanvas = document.getElementById(_self_id).getContext("2d");
                var chart_data = [];

                for (var i = 0; i < _get_data.datasets.length; i++) {
                    chart_data.push({
                        label: _get_data.datasets[i].label,
                        data: _get_data.datasets[i].data,
                        // Styles
                        backgroundColor: _get_data.datasets[i].color,
                        borderWidth: 2,
                        borderColor: 'transparent',
                        hoverBorderColor: 'transparent',
                        borderSkipped: 'bottom',
                        barPercentage: .7,
                        categoryPercentage: .7
                    });
                }

                var chart = new Chart(selectCanvas, {
                    type: 'bar',
                    data: {
                        labels: _get_data.labels,
                        datasets: chart_data
                    },
                    options: {
                        legend: {
                            display: _get_data.legend ? _get_data.legend : false,
                            labels: {
                                boxWidth: 30,
                                padding: 20,
                                fontColor: '#6783b8'
                            }
                        },
                        maintainAspectRatio: false,
                        tooltips: {
                            enabled: true,
                            rtl: NioApp.State.isRTL,
                            callbacks: {
                                title: function title(tooltipItem, data) {
                                    return false;
                                },
                                label: function label(tooltipItem, data) {
                                    return data['labels'][tooltipItem['index']] + ' ' + data.datasets[tooltipItem.datasetIndex]['data'][tooltipItem['index']];
                                }
                            },
                            backgroundColor: '#eff6ff',
                            titleFontSize: 11,
                            titleFontColor: '#6783b8',
                            titleMarginBottom: 4,
                            bodyFontColor: '#9eaecf',
                            bodyFontSize: 10,
                            bodySpacing: 3,
                            yPadding: 8,
                            xPadding: 8,
                            footerMarginTop: 0,
                            displayColors: false
                        },
                        scales: {
                            yAxes: [{
                                display: true,
                                stacked: _get_data.stacked ? _get_data.stacked : false,
                                ticks: {
                                    beginAtZero: true
                                }
                            }],
                            xAxes: [{
                                display: true,
                                stacked: _get_data.stacked ? _get_data.stacked : false,
                                ticks: {
                                    reverse: NioApp.State.isRTL
                                }
                            }]
                        }
                    }
                });
            });
        } // init chart

        function _cancelledBarChart(selector, set_data) {
            var $selector = selector ? $(selector) : $('.cancelled-bar-chart');
            $selector.each(function () {
                var $self = $(this),
                _self_id = $self.attr('id'),
                _get_data = typeof set_data === 'undefined' ? eval(_self_id) : set_data,
                _d_legend = typeof _get_data.legend === 'undefined' ? false : _get_data.legend;

                var selectCanvas = document.getElementById(_self_id).getContext("2d");
                var chart_data = [];

                for (var i = 0; i < _get_data.datasets.length; i++) {
                    chart_data.push({
                        label: _get_data.datasets[i].label,
                        data: _get_data.datasets[i].data,
                        // Styles
                        backgroundColor: _get_data.datasets[i].color,
                        borderWidth: 2,
                        borderColor: 'transparent',
                        hoverBorderColor: 'transparent',
                        borderSkipped: 'bottom',
                        barPercentage: .7,
                        categoryPercentage: .7
                    });
                }

                var chart = new Chart(selectCanvas, {
                    type: 'bar',
                    data: {
                        labels: _get_data.labels,
                        datasets: chart_data
                    },
                    options: {
                        legend: {
                            display: _get_data.legend ? _get_data.legend : false,
                            labels: {
                                boxWidth: 30,
                                padding: 20,
                                fontColor: '#6783b8'
                            }
                        },
                        maintainAspectRatio: false,
                        tooltips: {
                            enabled: true,
                            rtl: NioApp.State.isRTL,
                            callbacks: {
                                title: function title(tooltipItem, data) {
                                    return false;
                                },
                                label: function label(tooltipItem, data) {
                                    return data['labels'][tooltipItem['index']] + ' ' + data.datasets[tooltipItem.datasetIndex]['data'][tooltipItem['index']];
                                }
                            },
                            backgroundColor: '#eff6ff',
                            titleFontSize: 11,
                            titleFontColor: '#6783b8',
                            titleMarginBottom: 4,
                            bodyFontColor: '#9eaecf',
                            bodyFontSize: 10,
                            bodySpacing: 3,
                            yPadding: 8,
                            xPadding: 8,
                            footerMarginTop: 0,
                            displayColors: false
                        },
                        scales: {
                            yAxes: [{
                                display: true,
                                stacked: _get_data.stacked ? _get_data.stacked : false,
                                ticks: {
                                    beginAtZero: true
                                }
                            }],
                            xAxes: [{
                                display: true,
                                stacked: _get_data.stacked ? _get_data.stacked : false,
                                ticks: {
                                    reverse: NioApp.State.isRTL
                                }
                            }]
                        }
                    }
                });
            });
        } // init chart

        function _barChartPolish(selector, set_data) {
            var $selector = selector ? $(selector) : $('.bar-chart-polish');
            $selector.each(function () {
                var $self = $(this),
                _self_id = $self.attr('id'),
                _get_data = typeof set_data === 'undefined' ? eval(_self_id) : set_data,
                _d_legend = typeof _get_data.legend === 'undefined' ? false : _get_data.legend;

                var selectCanvas = document.getElementById(_self_id).getContext("2d");
                var chart_data = [];

                for (var i = 0; i < _get_data.datasets.length; i++) {
                    chart_data.push({
                        label: _get_data.datasets[i].label,
                        data: _get_data.datasets[i].data,
                        // Styles
                        backgroundColor: _get_data.datasets[i].color,
                        borderWidth: 2,
                        borderColor: 'transparent',
                        hoverBorderColor: 'transparent',
                        borderSkipped: 'bottom',
                        barPercentage: .6,
                        categoryPercentage: .7
                    });
                }

                var chart = new Chart(selectCanvas, {
                    type: 'bar',
                    data: {
                        labels: _get_data.labels,
                        datasets: chart_data
                    },
                    options: {
                        legend: {
                            display: _get_data.legend ? _get_data.legend : false,
                            rtl: NioApp.State.isRTL,
                            labels: {
                                boxWidth: 30,
                                padding: 20,
                                fontColor: '#6783b8'
                            }
                        },
                        maintainAspectRatio: false,
                        tooltips: {
                            enabled: true,
                            rtl: NioApp.State.isRTL,
                            callbacks: {
                                title: function title(tooltipItem, data) {
                                    return data.datasets[tooltipItem[0].datasetIndex].label;
                                },
                                label: function label(tooltipItem, data) {
                                    return data.datasets[tooltipItem.datasetIndex]['data'][tooltipItem['index']] + ' ' + _get_data.dataUnit;
                                }
                            },
                            backgroundColor: '#eff6ff',
                            titleFontSize: 13,
                            titleFontColor: '#6783b8',
                            titleMarginBottom: 6,
                            bodyFontColor: '#9eaecf',
                            bodyFontSize: 12,
                            bodySpacing: 4,
                            yPadding: 10,
                            xPadding: 10,
                            footerMarginTop: 0,
                            displayColors: false
                        },
                        scales: {
                            yAxes: [{
                                display: true,
                                stacked: _get_data.stacked ? _get_data.stacked : false,
                                position: NioApp.State.isRTL ? "right" : "left",
                                ticks: {
                                    beginAtZero: true,
                                    fontSize: 12,
                                    fontColor: '#9eaecf',
                                    padding: 5
                                },
                                gridLines: {
                                    color: "#e5ecf8",
                                    tickMarkLength: 0,
                                    zeroLineColor: '#e5ecf8'
                                }
                            }],
                            xAxes: [{
                                display: true,
                                stacked: _get_data.stacked ? _get_data.stacked : false,
                                ticks: {
                                    fontSize: 12,
                                    fontColor: '#9eaecf',
                                    source: 'auto',
                                    padding: 5,
                                    reverse: NioApp.State.isRTL
                                },
                                gridLines: {
                                    color: "transparent",
                                    tickMarkLength: 10,
                                    zeroLineColor: 'transparent'
                                }
                            }]
                        }
                    }
                });
            });
        } // init bar chart

        function _barChart4P(selector, set_data) {
            var $selector = selector ? $(selector) : $('.bar-chart-4p');
            $selector.each(function () {
                var $self = $(this),
                _self_id = $self.attr('id'),
                _get_data = typeof set_data === 'undefined' ? eval(_self_id) : set_data,
                _d_legend = typeof _get_data.legend === 'undefined' ? false : _get_data.legend;

                var selectCanvas = document.getElementById(_self_id).getContext("2d");
                var chart_data = [];

                for (var i = 0; i < _get_data.datasets.length; i++) {
                    chart_data.push({
                        label: _get_data.datasets[i].label,
                        data: _get_data.datasets[i].data,
                        // Styles
                        backgroundColor: _get_data.datasets[i].color,
                        borderWidth: 2,
                        borderColor: 'transparent',
                        hoverBorderColor: 'transparent',
                        borderSkipped: 'bottom',
                        barPercentage: .6,
                        categoryPercentage: .7
                    });
                }

                var chart = new Chart(selectCanvas, {
                    type: 'bar',
                    data: {
                        labels: _get_data.labels,
                        datasets: chart_data
                    },
                    options: {
                        legend: {
                            display: _get_data.legend ? _get_data.legend : false,
                            rtl: NioApp.State.isRTL,
                            labels: {
                                boxWidth: 30,
                                padding: 20,
                                fontColor: '#6783b8'
                            }
                        },
                        maintainAspectRatio: false,
                        tooltips: {
                            enabled: true,
                            rtl: NioApp.State.isRTL,
                            callbacks: {
                                title: function title(tooltipItem, data) {
                                    return data.datasets[tooltipItem[0].datasetIndex].label;
                                },
                                label: function label(tooltipItem, data) {
                                    return data.datasets[tooltipItem.datasetIndex]['data'][tooltipItem['index']] + ' ' + _get_data.dataUnit;
                                }
                            },
                            backgroundColor: '#eff6ff',
                            titleFontSize: 13,
                            titleFontColor: '#6783b8',
                            titleMarginBottom: 6,
                            bodyFontColor: '#9eaecf',
                            bodyFontSize: 12,
                            bodySpacing: 4,
                            yPadding: 10,
                            xPadding: 10,
                            footerMarginTop: 0,
                            displayColors: false
                        },
                        scales: {
                            yAxes: [{
                                display: true,
                                stacked: _get_data.stacked ? _get_data.stacked : false,
                                position: NioApp.State.isRTL ? "right" : "left",
                                ticks: {
                                    beginAtZero: true,
                                    fontSize: 12,
                                    fontColor: '#9eaecf',
                                    padding: 5
                                },
                                gridLines: {
                                    color: "#e5ecf8",
                                    tickMarkLength: 0,
                                    zeroLineColor: '#e5ecf8'
                                }
                            }],
                            xAxes: [{
                                display: true,
                                stacked: _get_data.stacked ? _get_data.stacked : false,
                                ticks: {
                                    fontSize: 12,
                                    fontColor: '#9eaecf',
                                    source: 'auto',
                                    padding: 5,
                                    reverse: NioApp.State.isRTL
                                },
                                gridLines: {
                                    color: "transparent",
                                    tickMarkLength: 10,
                                    zeroLineColor: 'transparent'
                                }
                            }]
                        }
                    }
                });
            });
        } // init bar chart

        function _barChartRough(selector, set_data) {
            var $selector = selector ? $(selector) : $('.bar-chart-rough');
            $selector.each(function () {
                var $self = $(this),
                _self_id = $self.attr('id'),
                _get_data = typeof set_data === 'undefined' ? eval(_self_id) : set_data,
                _d_legend = typeof _get_data.legend === 'undefined' ? false : _get_data.legend;

                var selectCanvas = document.getElementById(_self_id).getContext("2d");
                var chart_data = [];

                for (var i = 0; i < _get_data.datasets.length; i++) {
                    chart_data.push({
                        label: _get_data.datasets[i].label,
                        data: _get_data.datasets[i].data,
                        // Styles
                        backgroundColor: _get_data.datasets[i].color,
                        borderWidth: 2,
                        borderColor: 'transparent',
                        hoverBorderColor: 'transparent',
                        borderSkipped: 'bottom',
                        barPercentage: .6,
                        categoryPercentage: .7
                    });
                }

                var chart = new Chart(selectCanvas, {
                    type: 'bar',
                    data: {
                        labels: _get_data.labels,
                        datasets: chart_data
                    },
                    options: {
                        legend: {
                            display: _get_data.legend ? _get_data.legend : false,
                            rtl: NioApp.State.isRTL,
                            labels: {
                                boxWidth: 30,
                                padding: 20,
                                fontColor: '#6783b8'
                            }
                        },
                        maintainAspectRatio: false,
                        tooltips: {
                            enabled: true,
                            rtl: NioApp.State.isRTL,
                            callbacks: {
                                title: function title(tooltipItem, data) {
                                    return data.datasets[tooltipItem[0].datasetIndex].label;
                                },
                                label: function label(tooltipItem, data) {
                                    return data.datasets[tooltipItem.datasetIndex]['data'][tooltipItem['index']] + ' ' + _get_data.dataUnit;
                                }
                            },
                            backgroundColor: '#eff6ff',
                            titleFontSize: 13,
                            titleFontColor: '#6783b8',
                            titleMarginBottom: 6,
                            bodyFontColor: '#9eaecf',
                            bodyFontSize: 12,
                            bodySpacing: 4,
                            yPadding: 10,
                            xPadding: 10,
                            footerMarginTop: 0,
                            displayColors: false
                        },
                        scales: {
                            yAxes: [{
                                display: true,
                                stacked: _get_data.stacked ? _get_data.stacked : false,
                                position: NioApp.State.isRTL ? "right" : "left",
                                ticks: {
                                    beginAtZero: true,
                                    fontSize: 12,
                                    fontColor: '#9eaecf',
                                    padding: 5
                                },
                                gridLines: {
                                    color: "#e5ecf8",
                                    tickMarkLength: 0,
                                    zeroLineColor: '#e5ecf8'
                                }
                            }],
                            xAxes: [{
                                display: true,
                                stacked: _get_data.stacked ? _get_data.stacked : false,
                                ticks: {
                                    fontSize: 12,
                                    fontColor: '#9eaecf',
                                    source: 'auto',
                                    padding: 5,
                                    reverse: NioApp.State.isRTL
                                },
                                gridLines: {
                                    color: "transparent",
                                    tickMarkLength: 10,
                                    zeroLineColor: 'transparent'
                                }
                            }]
                        }
                    }
                });
            });
        } // init bar chart

        NioApp.coms.docReady.push(function () {
            _ordersBarChart();
            _caratsBarChart();
            _cancelledBarChart();
            _barChartPolish();
            _barChart4P();
            _barChartRough();
        });
        function getMonthName(n) {
            const current = new Date();
            current.setDate(current.getDate() - (n * 30));
            return current.toLocaleString('default', { month: 'short' });
        }
        var ordersRevenue = {
            labels: [getMonthName(6), getMonthName(5), getMonthName(4), getMonthName(3), getMonthName(2), getMonthName(1)],
            dataUnit: '',
            stacked: true,
            datasets: [{
                label: "Total Orders",
                color: ["#e9ecff", "#e9ecff", "#e9ecff", "#e9ecff", "#e9ecff", "#6576ff"],
                data: [<?= $chart_orders->cur_month6 ?>, <?= $chart_orders->cur_month5 ?>, <?= $chart_orders->cur_month4 ?>, <?= $chart_orders->cur_month3 ?>, <?= $chart_orders->cur_month2 ?>, <?= $chart_orders->cur_month1 ?>]
            }]
        };
        var caratsRevenue = {
            labels: [getMonthName(6), getMonthName(5), getMonthName(4), getMonthName(3), getMonthName(2), getMonthName(1)],
            dataUnit: '',
            stacked: true,
            datasets: [{
                label: "Total Carats",
                color: ["#e9ecff", "#e9ecff", "#e9ecff", "#e9ecff", "#e9ecff", "#6576ff"],
                data: [<?= round($chart_carats->cur_month6, 2) ?>, <?= round($chart_carats->cur_month5, 2) ?>, <?= round($chart_carats->cur_month4, 2) ?>, <?= round($chart_carats->cur_month3, 2) ?>, <?= round($chart_carats->cur_month2, 2) ?>, <?= round($chart_carats->cur_month1, 2) ?>]
            }]
        };
        var cancelledRevenue = {
            labels: [getMonthName(6), getMonthName(5), getMonthName(4), getMonthName(3), getMonthName(2), getMonthName(1)],
            dataUnit: '',
            stacked: true,
            datasets: [{
                label: "Total Cancelled Orders",
                color: ["#e9ecff", "#e9ecff", "#e9ecff", "#e9ecff", "#e9ecff", "#6576ff"],
                data: [<?= $cancel_orders->cur_month6 ?>, <?= $cancel_orders->cur_month5 ?>, <?= $cancel_orders->cur_month4 ?>, <?= $cancel_orders->cur_month3 ?>, <?= $cancel_orders->cur_month2 ?>, <?= $cancel_orders->cur_month1 ?>]
            }]
        };
        var barChartPolish = {
            labels: [getMonthName(3), getMonthName(2), getMonthName(1)],
            dataUnit: '',
            datasets: [{
                label: "Added",
                color: "#9cabff",
                data: [<?= $import->cur_month3_pl ?>, <?= $import->cur_month2_pl ?>, <?= $import->cur_month1_pl ?>]
            }, {
                label: "Sold",
                color: "#f4aaa4",
                data: [<?= $export->cur_month3_pl ?>, <?= $export->cur_month2_pl ?>, <?= $export->cur_month1_pl ?>]
            }]
        };
        var barChart4P = {
            labels: [getMonthName(3), getMonthName(2), getMonthName(1)],
            dataUnit: '',
            datasets: [{
                label: "Added",
                color: "#9cabff",
                data: [<?= $import->cur_month3_4p ?>, <?= $import->cur_month2_4p ?>, <?= $import->cur_month1_4p ?>]
            }, {
                label: "Sold",
                color: "#f4aaa4",
                data: [<?= $export->cur_month3_4p ?>, <?= $export->cur_month2_4p ?>, <?= $export->cur_month1_4p ?>]
            }]
        };
        var barChartRough = {
            labels: [getMonthName(3), getMonthName(2), getMonthName(1)],
            dataUnit: '',
            datasets: [{
                label: "Added",
                color: "#9cabff",
                data: [<?= $import->cur_month3_rg ?>, <?= $import->cur_month2_rg ?>, <?= $import->cur_month1_rg ?>]
            }, {
                label: "Sold",
                color: "#f4aaa4",
                data: [<?= $export->cur_month3_rg ?>, <?= $export->cur_month2_rg ?>, <?= $export->cur_month1_rg ?>]
            }]
        };
    }(NioApp, jQuery);
</script>
@endsection

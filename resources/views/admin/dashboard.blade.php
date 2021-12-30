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
</style>
@endsection
@section('content')
<!-- content @s -->
<div class="nk-content">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
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
                                </div><!-- .card -->
                            </a>
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
                                                <h6 class="title">Pending Orders</h6>
                                            </div>
                                            <div class="card-tools">
                                                <a href="html/user-list-regular.html" class="link">View All</a>
                                            </div>
                                        </div>
                                    </div>
                                    @foreach ($pending_orders as $p)
                                    <div class="card-inner card-inner-md">
                                        <div class="user-card">
                                            <div class="user-avatar bg-primary-dim">
                                                <span>{{ $p->name[0] }}</span>
                                            </div>
                                            <div class="user-info">
                                                <span class="lead-text">{{ $p->name . ' (#' . $p->order_id . ')'}}</span>
                                                <span class="sub-text">{{ $p->email_id }}</span>
                                            </div>
                                            <div class="user-action">
                                                <small>${{ $p->total_paid_amount }}</small>
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
                                                <h6 class="title">Completed Orders</h6>
                                            </div>
                                            <div class="card-tools">
                                                <a href="html/user-list-regular.html" class="link">View All</a>
                                            </div>
                                        </div>
                                    </div>
                                    @foreach ($completed_orders as $p)
                                    <div class="card-inner card-inner-md">
                                        <div class="user-card">
                                            <div class="user-avatar bg-primary-dim">
                                                <span>{{ $p->name[0] }}</span>
                                            </div>
                                            <div class="user-info">
                                                <span class="lead-text">{{ $p->name . ' (#' . $p->order_id . ')'}}</span>
                                                <span class="sub-text">{{ $p->email_id }}</span>
                                            </div>
                                            <div class="user-action">
                                                <small>${{ $p->total_paid_amount }}</small>
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
                                                <h6 class="title">Offline Orders</h6>
                                            </div>
                                            <div class="card-tools">
                                                <a href="html/user-list-regular.html" class="link">View All</a>
                                            </div>
                                        </div>
                                    </div>
                                    @foreach ($offline_orders as $p)
                                    <div class="card-inner card-inner-md">
                                        <div class="user-card">
                                            <div class="user-avatar bg-primary-dim">
                                                <span>{{ $p->name[0] }}</span>
                                            </div>
                                            <div class="user-info">
                                                <span class="lead-text">{{ $p->name . ' (#' . $p->order_id . ')'}}</span>
                                                <span class="sub-text">{{ $p->email_id }}</span>
                                            </div>
                                            <div class="user-action">
                                                <small>${{ $p->total_paid_amount }}</small>
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
                                                <h6 class="title">Recent Customers</h6>
                                            </div>
                                            <div class="card-tools"> </div>
                                        </div>
                                    </div>
                                    @foreach ($recent_customers as $p)
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
                                                <small>${{ $p->total_paid_amount }}</small>
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
                                                <h6 class="title">Top Customers</h6>
                                            </div>
                                            <div class="card-tools"> </div>
                                        </div>
                                    </div>
                                    <div class="card-inner card-inner-md">
                                        <div class="user-card">
                                            <div class="user-avatar bg-primary-dim">
                                                <span>AB</span>
                                            </div>
                                            <div class="user-info">
                                                <span class="lead-text">Abu Bin Ishtiyak</span>
                                                <span class="sub-text">info@softnio.com</span>
                                            </div>
                                            <div class="user-action">
                                                <div class="drodown">
                                                    <a href="#" class="dropdown-toggle btn btn-icon btn-trigger mr-n1" data-toggle="dropdown" aria-expanded="false"><em class="icon ni ni-more-h"></em></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <ul class="link-list-opt no-bdr">
                                                            <li><a href="#"><em class="icon ni ni-setting"></em><span>Action Settings</span></a></li>
                                                            <li><a href="#"><em class="icon ni ni-notify"></em><span>Push Notification</span></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
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
                                                <h6 class="title">Bottom Customers</h6>
                                            </div>
                                            <div class="card-tools"> </div>
                                        </div>
                                    </div>
                                    <div class="card-inner card-inner-md">
                                        <div class="user-card">
                                            <div class="user-avatar bg-primary-dim">
                                                <span>AB</span>
                                            </div>
                                            <div class="user-info">
                                                <span class="lead-text">Abu Bin Ishtiyak</span>
                                                <span class="sub-text">info@softnio.com</span>
                                            </div>
                                            <div class="user-action">
                                                <div class="drodown">
                                                    <a href="#" class="dropdown-toggle btn btn-icon btn-trigger mr-n1" data-toggle="dropdown" aria-expanded="false"><em class="icon ni ni-more-h"></em></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <ul class="link-list-opt no-bdr">
                                                            <li><a href="#"><em class="icon ni ni-setting"></em><span>Action Settings</span></a></li>
                                                            <li><a href="#"><em class="icon ni ni-notify"></em><span>Push Notification</span></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                                            <a href="html/user-list-regular.html" class="link">View All</a>
                                        </div>
                                    </div>
                                </div>
                                <ul class="nk-activity">
                                    <li class="nk-activity-item">
                                        <div class="user-avatar bg-primary-dim">
                                            <span>AB</span>
                                        </div>
                                        <div class="nk-activity-data">
                                            <div class="label">Keith Jensen requested to Widthdrawl.</div>
                                            <span class="time">2 hours ago</span>
                                        </div>
                                    </li>
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
                                            <a href="html/user-list-regular.html" class="link">View All</a>
                                        </div>
                                    </div>
                                </div>
                                <ul class="nk-activity">
                                    <li class="nk-activity-item">
                                        <div class="user-avatar bg-primary-dim">
                                            <span>AB</span>
                                        </div>
                                        <div class="nk-activity-data">
                                            <div class="label">Keith Jensen requested to Widthdrawl.</div>
                                            <span class="time">2 hours ago</span>
                                        </div>
                                    </li>
                                </ul>
                            </div><!-- .card -->
                        </div><!-- .col -->
                        <div class="col-lg-4 col-md-6">
                            <div class="card card-bordered">
                                <div class="card-inner">
                                    <div class="card-title-group align-start mb-2">
                                        <div class="card-title">
                                            <h6 class="title">Total Orders</h6>
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
                                            <h6 class="title">Total Carats Sold</h6>
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
                                            <h6 class="title">Total Cancelled Orders</h6>
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
                                    <div class="card-head">
                                        <h6 class="title">Polish Diamonds</h6>
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
                                    <div class="card-head">
                                        <h6 class="title">4P Diamonds</h6>
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
                                    <div class="card-head">
                                        <h6 class="title">Rough Diamonds</h6>
                                    </div>
                                    <div class="nk-ck-sm">
                                        <canvas class="bar-chart-rough" id="barChartRough"></canvas>
                                    </div>
                                </div>
                            </div><!-- .card -->
                        </div><!-- .col -->
                        <div class="col-md-6 col-lg-4">
                            <div class="card card-bordered">
                                <div class="card-body hv-effect" >
                                    <span class="title">Monthly Revenue</span>
                                    <span class="title float-right">{{ $orders->monthly_revenue }}</span>
                                </div>
                            </div><!-- .card -->
                        </div><!-- .col -->
                        <div class="col-md-6 col-lg-4">
                            <div class="card card-bordered">
                                <div class="card-body hv-effect" >
                                    <span class="title">Quaterly Revenue</span>
                                    <span class="title float-right">{{ $orders->quaterly_revenue }}</span>
                                </div>
                            </div><!-- .card -->
                        </div><!-- .col -->
                        <div class="col-md-6 col-lg-4">
                            <div class="card card-bordered">
                                <div class="card-body hv-effect" >
                                    <span class="title">Yearly Revenue</span>
                                    <span class="title float-right">{{ $orders->yearly_revenue }}</span>
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
                                display: false,
                                stacked: _get_data.stacked ? _get_data.stacked : false,
                                ticks: {
                                    beginAtZero: false
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
                                display: false,
                                stacked: _get_data.stacked ? _get_data.stacked : false,
                                ticks: {
                                    beginAtZero: false
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
                                display: false,
                                stacked: _get_data.stacked ? _get_data.stacked : false,
                                ticks: {
                                    beginAtZero: false
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
                                display: false,
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
                                display: false,
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
                                display: false,
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
        var ordersRevenue = {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun"],
            dataUnit: '',
            stacked: true,
            datasets: [{
                label: "Total Orders",
                color: ["#e9ecff", "#e9ecff", "#e9ecff", "#e9ecff", "#e9ecff", "#6576ff"],
                data: [11000, 8000, 12500, 5500, 9500, 14299]
            }]
        };
        var caratsRevenue = {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun"],
            dataUnit: '',
            stacked: true,
            datasets: [{
                label: "Total Carats",
                color: ["#e9ecff", "#e9ecff", "#e9ecff", "#e9ecff", "#e9ecff", "#6576ff"],
                data: [11000, 8000, 12500, 5500, 9500, 14299]
            }]
        };
        var cancelledRevenue = {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun"],
            dataUnit: '',
            stacked: true,
            datasets: [{
                label: "Total Carats",
                color: ["#e9ecff", "#e9ecff", "#e9ecff", "#e9ecff", "#e9ecff", "#6576ff"],
                data: [11000, 8000, 12500, 5500, 9500, 14299]
            }]
        };
        var barChartPolish = {
            labels: ["Jan", "Feb", "Mar"],
            dataUnit: '',
            datasets: [{
                label: "Added",
                color: "#9cabff",
                data: [110, 80, 125]
            }, {
                label: "Sold",
                color: "#f4aaa4",
                data: [75, 50, 100]
            }]
        };
        var barChart4P = {
            labels: ["Jan", "Feb", "Mar"],
            dataUnit: '',
            datasets: [{
                label: "Added",
                color: "#9cabff",
                data: [110, 80, 125]
            }, {
                label: "Sold",
                color: "#f4aaa4",
                data: [75, 50, 100]
            }]
        };
        var barChartRough = {
            labels: ["Jan", "Feb", "Mar"],
            dataUnit: '',
            datasets: [{
                label: "Added",
                color: "#9cabff",
                data: [110, 80, 125]
            }, {
                label: "Sold",
                color: "#f4aaa4",
                data: [75, 50, 100]
            }]
        };
    }(NioApp, jQuery);
</script>
@endsection

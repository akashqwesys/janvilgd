@extends('admin.header')
@section('css')
<link href="/admin_assets/datatable/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
<link href="/admin_assets/datatable/dataTables.responsive.css" rel="stylesheet" type="text/css">
<link href="https://cdn.datatables.net/buttons/2.1.0/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<style>
    /* .date-range {
        width: 50%;
        display: inline-block;
    } */
    .ni-clock {
        font-size: 1.25rem;
    }
    .accordion-s3 .accordion-head {
        padding: 0 0 0 2.25rem;
    }
</style>
@endsection
@section('content')
<!-- content @s -->
@php
    if ($request->filter || $request->date_range_filter) {
        $ac1 = 'show';
        $collapse1 = '';
    } else {
        $ac1 = '';
        $collapse1 = 'collapsed';
    }
@endphp
<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="components-preview wide mx-auto">
                    <div class="nk-block nk-block-lg">
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <div class="toggle-wrap nk-block-tools-toggle">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <h4 class="nk-block-title">Orders list</h4>
                                        </div>
                                        <div class="col-md-5 text-center">
                                        </div>
                                        <div class="col-md-5 text-right">
                                            <button class="btn btn-primary mr-2" id="clear-filters"> Clear Filters</button>
                                            <a href="/admin/orders/create-invoice" class="btn btn-icon btn-primary mr-2">&nbsp;&nbsp; Create Invoice<em class="icon ni ni-plus"></em></a>
                                            <a href="{{route('orders.import_excel')}}" class="btn btn-icon btn-primary mr-2">&nbsp;&nbsp; Import Excel<em class="icon ni ni-plus"></em></a>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- .nk-block-head-content -->
                        </div>
                        <div class="card card-preview">
                            <div class="card-inner">
                                <div id="accordion-2" class="accordion accordion-s3">
                                    <div class="accordion-item">
                                        <a href="#" class="accordion-head {{ $collapse1 }}" data-toggle="collapse" data-target="#accordion-item-2-1">
                                            <h6 class="title">Select Filters</h6>
                                            <span class="accordion-icon"></span>
                                        </a>
                                        <div class="accordion-body collapse {{ $ac1 }}" id="accordion-item-2-1" data-parent="#accordion-2">
                                            <div class="accordion-inner pt-3">
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <div class="row">
                                                            <div class="col-md-4 m-auto">
                                                                <b>Select Date Range</b>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <!-- Date and time range -->
                                                                <div class="input-group form-group date-range">
                                                                    <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="ni ni-clock"></i></span>
                                                                    </div>
                                                                    <input type="text" class="form-control float-right" id="dateRange" placeholder="Select The Date Range" value="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <div class="row">
                                                            <div class="col-md-4 m-auto">
                                                                <b>Select Customer</b>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <select id="orderCustomers" class="form-control form-select" data-search="on" data-placeholder="--------- Select Customer ---------">
                                                                    <option value="" disabled="" selected=""> --------- Select Customer ---------</option>
                                                                    @foreach ($customers as $c)
                                                                    <option value="{{ $c->customer_id }}">{{ $c->name . ' (' . ($c->email ?? $c->mobile) . ')' }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <div class="row">
                                                            <div class="col-md-4 m-auto">
                                                                <b>Select Order Status</b>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <select id="orderStatus" class="form-control form-select" data-search="on" data-placeholder="--------- Select Order Status ---------">
                                                                    <option value="" disabled="" selected=""> --------- Select Order Status ---------</option>
                                                                    @foreach ($order_status as $o)
                                                                    <option value="{{ $o->name }}">{{ $o->name }}</option>
                                                                    @endforeach
                                                                    <option value="OFFLINE">OFFLINE</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <div class="row">
                                                            <div class="col-md-4 m-auto">
                                                                <b>Select Diamond Category</b>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <select id="d-category" class="form-control form-select" data-search="on" data-placeholder="------- Select Diamond Category -------">
                                                                    <option value="" disabled="" selected=""> ------- Select Diamond Category -------</option>
                                                                    <option value="3">POLISH</option>
                                                                    <option value="2">4P</option>
                                                                    <option value="1">ROUGH</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- .card-preview -->
                        <div class="card card-preview">
                            <div id='append_loader' class="overlay">
                                <div class='d-flex justify-content-center' style="padding-top: 10%;">
                                    <div class='spinner-border text-success' role='status'>
                                        <span class='sr-only'>Loading...</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-inner">
                                <table id="table" class="table dt-responsive nowrap">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>ID</th>
                                            <th>Customer</th>
                                            <th>Email</th>
                                            <th>Mobile No</th>
                                            {{-- <th>Payment</th> --}}
                                            <th>Transaction ID</th>
                                            <th>Placed on</th>
                                            <th>Status</th>
                                            <th>Amount</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div><!-- .card-preview -->
                    </div> <!-- nk-block -->
                </div><!-- .components-preview -->
            </div>
        </div>
    </div>
</div>
<!-- content @e -->
@endsection
@section('script')
<script src="/admin_assets/datatable/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="/admin_assets/datatable/dataTables.responsive.min.js" type="text/javascript" ></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.1.0/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript">
    var startDate = moment().subtract(7, 'days').format('YYYY-MM-DD');
    var endDate = moment().format('YYYY-MM-DD');
    var customer_id = null;
    var order_status = null;
    var category = null;
    var date_applied = false;
    var order_filter = '{{ $request["filter"] }}';
    var date_filter = '{{ $request["date_range_filter"] }}';
    if (date_filter) {
        startDate = date_filter.split(' - ')[0];
        endDate = date_filter.split(' - ')[1];
        setTimeout(() => {
            $('#dateRange').val(date_filter);
            $('#dateRange').trigger('apply.daterangepicker');
        }, 500);
    }
    if (order_filter == 'yesterday') {
        startDate = moment().subtract(1, 'days').format('YYYY-MM-DD');
        setTimeout(() => {
            $('#dateRange').trigger('apply.daterangepicker');
        }, 1000);
    } else if (order_filter == '30days') {
        startDate = moment().subtract(30, 'days').format('YYYY-MM-DD');
        setTimeout(() => {
            $('#dateRange').trigger('apply.daterangepicker');
        }, 1000);
    } else if (order_filter == '7days') {
        startDate = moment().subtract(7, 'days').format('YYYY-MM-DD');
        setTimeout(() => {
            $('#dateRange').trigger('apply.daterangepicker');
        }, 1000);
    } else if (['PENDING', 'PAID', 'UNPAID', 'OFFLINE', 'CANCELLED'].includes(order_filter)) {
        setTimeout(() => {
            $('#dateRange').val('');
            $('#orderStatus').val(order_filter).trigger('change');
        }, 1000);
    } else if (['polish', '4p', 'rough'].includes(order_filter)) {
        setTimeout(() => {
            $('#dateRange').val('');
            $('#d-category').val(order_filter == 'polish' ? 3 : (order_filter == '4p' ? 2 : 1)).trigger('change');
        }, 1000);
    }

    $('#dateRange').daterangepicker({
        minDate  : "2021-12-01",
        maxDate  : moment(),
        showDropdowns: true,
        autoUpdateInput: true,
        locale: {
            format: 'YYYY-MM-DD'
        },
        ranges   : {
            'Today'       : [moment(), moment()],
            'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month'  : [moment().startOf('month'), moment().endOf('month')],
            'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        alwaysShowCalendars: false,
        autoApply: false,
        startDate: startDate,
        endDate  : endDate,
    });
    $('#dateRange').on('apply.daterangepicker', function(ev, picker) {
        date_applied = true;
        startDate = (picker == undefined) ? $(this).val().substr(0,10) : picker.startDate.format('YYYY-MM-DD');
        endDate = (picker == undefined) ? $(this).val().substr(13,24) : picker.endDate.format('YYYY-MM-DD');
        // $('#dateRange').daterangepicker().autoUpdateInput = true;
        table.clear().draw();
    });
    $(document).on('change', '#orderCustomers', function(){
        customer_id = $(this).val();
        table.clear().draw();
    });
    $(document).on('change', '#orderStatus', function(){
        order_status = $(this).val();
        table.clear().draw();
    });
    $(document).on('change', '#d-category', function(){
        category = $(this).val();
        table.clear().draw();
    });
    $(document).on('click', '#clear-filters', function(){
        $('.accordion-head').attr('class', 'accordion-head collapsed');
        $('.accordion-body').attr('class', 'accordion-body collapse');
        startDate = endDate = customer_id = order_status = category = null;
        table.clear().draw();
    });
    $(document).on('click', '#refreshData', function(){
        $('#dateRange').trigger('apply.daterangepicker');
    });
</script>
@endsection
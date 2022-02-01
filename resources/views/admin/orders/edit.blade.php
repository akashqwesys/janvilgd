@extends('admin.header')
@section('css')
<link href="{{ asset(check_host().'admin_assets/datatable/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset(check_host().'admin_assets/datatable/dataTables.responsive.css')}}" rel="stylesheet" type="text/css">
@endsection
@section('content')
<div class="nk-content">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between- row">
                        <div class="col-md-2">
                            <h3 class="nk-block-title page-title" >View Order</h3>
                        </div>
                        <div class="col-md-5">
                            @if ($data['order_history'][0]->order_status_name == 'PENDING')
                            <div class="">
                                <button class="btn btn-success mr-3" id="acceptOrder" data-value="UNPAID">ACCEPT</button>
                                <button class="btn btn-danger" id="declineOrder" data-value="CANCELLED">DECLINE</button>
                            </div>
                            @endif
                        </div>
                        <div class="col-md-5 text-right">
                            <a style="float: right;" href="/admin/orders" class="btn btn-icon btn-primary">&nbsp;&nbsp;Back To List<em class="icon ni ni-plus"></em></a>
                        </div>
                    </div><!-- .nk-block-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block nk-block-lg">
                    <div class="card">
                        <div class="card-inner">

                            <h3 class="nk-block-title page-title" style="display: inline;">Update Address</h3>
                            <hr>

                            <form method="POST" action="{{route('orders.update')}}">
                                @csrf
                                <input type="hidden" name="id" value="{{ $data['result']->order_id }}">
                                <div class="row g-3 align-center">
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label class="form-label float-right" for="refCustomer_company_id_shipping">Shipping Address:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <select class="form-select form-control" id="refCustomer_company_id_shipping" name="refCustomer_company_id_shipping" required="" tabindex="-1" aria-hidden="true" data-search="on">
                                                    <option value="" disabled="" selected="">------ Select Shipping Address ------</option>
                                                    <?php if (!empty($data['address_list'])) {
                                                        foreach ($data['address_list'] as $row) {
                                                    ?>
                                                            <option value="{{ $row->customer_company_id }}" {{ set_selected($row->customer_company_id,$data['result']->refCustomer_company_id_shipping) }}>{{ $row->name }}, {{ $row->office_address }}, {{ $row->city_name }}, {{ $row->state_name }}, {{ $row->country_name }}-{{ $row->pincode }}</option>
                                                    <?php
                                                        }
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label class="form-label float-right" for="refCustomer_company_id_billing">Billing Address:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <select class="form-select form-control" id="refCustomer_company_id_billing" name="refCustomer_company_id_billing" required="" tabindex="-1" aria-hidden="true" data-search="on">
                                                    <option value="" disabled="" selected="">------ Select Billing Address ------</option>
                                                    <?php if (!empty($data['address_list'])) {
                                                        foreach ($data['address_list'] as $row) {
                                                    ?>
                                                            <option value="{{ $row->customer_company_id }}" {{ set_selected($row->customer_company_id,$data['result']->refCustomer_company_id_billing) }}>{{ $row->name }}, {{ $row->office_address }}, {{ $row->city_name }}, {{ $row->state_name }}, {{ $row->country_name }}-{{ $row->pincode }}</option>
                                                    <?php
                                                        }
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row g-3">
                                    <div class="col-sm-12 col-md-2 offset-md-2">
                                        <div class="form-group mt-2">
                                            <button type="submit" class="btn btn-lg btn-primary btn-block">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div><!-- card -->
                </div><!-- .nk-block -->
            </div>
            <br>
            <div class="nk-content-body">
                <div class="nk-block nk-block-lg">
                    <div class="card">
                        <div class="card-inner">
                            <h3 class="nk-block-title page-title" style="display: inline;">Order #{{$data['result']->order_id}}</h3>
                            <hr>
                            <table class="table dt-responsive nowrap table-bordered">
                                <thead>
                                    <tr>
                                        <th>Billing Address</th>
                                        <th>Shipping Address</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{$data['result']->billing_company_name}}<br>
                                            {{$data['result']->billing_company_office_address}},<br>
                                            {{$data['result']->billing_city_name}}, {{$data['result']->billing_state_name}}-{{$data['result']->billing_company_office_pincode}}, {{$data['result']->billing_country_name}}<br>
                                            Contact No: {{$data['result']->billing_company_office_no}}<br>
                                            Email: {{$data['result']->billing_company_office_email}}<br>
                                        </td>
                                        <td>{{$data['result']->shipping_company_name}}<br>
                                            {{$data['result']->shipping_company_office_address}},<br>
                                            {{$data['result']->shipping_city_name}}, {{$data['result']->shipping_state_name}}-{{$data['result']->shipping_company_office_pincode}}, {{$data['result']->shipping_country_name}}<br>
                                            Contact No: {{$data['result']->shipping_company_office_no}}<br>
                                            Email: {{$data['result']->shipping_company_office_email}}<br>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <br>
                            <table class="table dt-responsive nowrap table-bordered">
                                <thead>
                                    <tr>
                                        <th>Barcode</th>
                                        <th>Category</th>
                                        <th>Shape</th>
                                        <th>Carat</th>
                                        <th>Color</th>
                                        <th>Clarity</th>
                                        <th>Rapaport</th>
                                        <th>Discount</th>
                                        <th style="text-align: right;">Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data['diamonds'] as $d_row)
                                    <tr>
                                        <td>{{$d_row['barcode']}}</td>
                                        <td>{{$d_row['cat_name']}}</td>
                                        <td>{{ $d_row['attributes']['SHAPE'] }}</td>
                                        <td>{{$d_row['expected_polish_cts']}}</td>
                                        <td>{{ $d_row['attributes']['COLOR'] }}</td>
                                        <td>{{ $d_row['attributes']['CLARITY'] }}</td>
                                        <td>$ {{ number_format($d_row['rapaport_price'], 2, '.', ',') }}</td>
                                        <td>{{ number_format($d_row['discount'], 2) }}%</td>
                                        <td style="text-align: right;">$ {{ number_format($d_row['total'], 2, '.', ',') }}</td>
                                    </tr>
                                    @endforeach
                                    <tr style="background-color: lightgray;">
                                        <td colspan="9" style="text-align: right;">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" style="text-align: right;"><b>Subtotal</b></td>
                                        <td style="text-align: right;">$ {{number_format($data['result']->sub_total, 2, '.', ',')}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" style="text-align: right;"><b>Discount</b></td>
                                        <td style="text-align: right;">$ {{number_format($data['result']->discount_amount, 2, '.', ',')}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" style="text-align: right;"><b>Tax</b></td>
                                        <td style="text-align: right;">$ {{number_format($data['result']->tax_amount, 2, '.', ',')}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" style="text-align: right;"><b>Shipping Charge</b></td>
                                        <td style="text-align: right;">$ {{number_format($data['result']->delivery_charge_amount, 2, '.', ',')}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" style="text-align: right;">
                                            <b> <h6>Total</h6> </b>
                                        </td>
                                        <td style="text-align: right;">
                                            <b> <h6>$ {{number_format($data['result']->total_paid_amount, 2, '.', ',')}}</h6> </b>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div><!-- card -->
                </div><!-- .nk-block -->
            </div>
            <br>
            <div class="nk-content-body">
                <div class="nk-block nk-block-lg">
                    <div class="card">
                        <div class="card-inner">
                            <h3 class="nk-block-title page-title" style="display: inline;">History</h3>
                            <hr>
                            <table id="table" class="table dt-responsive nowrap table-bordered">
                                <thead>
                                    <tr>
                                        <th>Status</th>
                                        <th>Comment</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($data['order_history']))
                                    @foreach($data['order_history'] as $oh_row)
                                    <tr>
                                        <td>{{$oh_row->order_status_name}}</td>
                                        <td>{{$oh_row->comment}}</td>
                                        <td>{{date_time_formate($oh_row->date_added)}}</td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                            @if ($data['order_history'][0]->order_status_name != 'CANCELLED')
                            <h3 class="nk-block-title page-title mt-5" >Add Order History</h3>
                            <hr>
                            <form method="POST" action="{{route('orders.addOrderHistory')}}">
                                @csrf
                                <input type="hidden" name="id" value="{{ $data['result']->order_id }}">
                                <div class="row g-3 align-center">
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label class="form-label float-right" for="order_status_name">Order Status:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <select class="form-select form-control" id="order_status_name" name="order_status_name" required="" tabindex="-1" aria-hidden="true" data-search="on" data-placeholder="----- Select Order Status -----">
                                                    <option value="" disabled="" selected="">----- Select Order Status -----</option>
                                                    @foreach ($data['order_sts'] as $row)
                                                    <option value="{{ $row->name }}">{{ $row->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label class="form-label float-md-right" for="comment">Comment:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-10">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <textarea name="comment" class="form-control form-control-sm" id="cf-default-textarea" placeholder="Enter comment"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row g-3">
                                    <div class="col-sm-12 col-md-2 offset-md-2">
                                        <div class="form-group mt-2">
                                            <button type="submit" class="btn btn-lg btn-primary btn-block" id="updateOrder">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            @endif
                        </div>
                    </div><!-- card -->
                </div><!-- .nk-block -->
            </div>

        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    $(document).on('click', '#acceptOrder, #declineOrder', function() {
        $('#order_status_name').val($(this).attr('data-value')).trigger('change');
        $('#cf-default-textarea').val('<?= $data['admin_name'] ?>' + ' has ' + $(this).attr('data-value').toLowerCase() + ' order');
        setTimeout(() => {
            $('#updateOrder').trigger('click');
        }, 100);
    });
</script>
@endsection
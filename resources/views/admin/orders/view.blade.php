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
                <div class="nk-block nk-block-lg">
                    <div class="card">
                        <div class="card-inner">
                            <h3 class="nk-block-title page-title" style="display: inline;">Order #{{$data['result']->order_id}}</h3>
                            <a style="float: right;" href="/admin/orders" class="btn btn-icon btn-primary">&nbsp;&nbsp;Back To List<em class="icon ni ni-plus"></em></a>
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
                                        <th>Carat</th>
                                        <th>Shape</th>
                                        <th>Color</th>
                                        <th>Clarity</th>
                                        <th>Rapaport</th>
                                        <th>Discount</th>
                                        <th style="text-align: right;">Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['diamonds'] as $d_row)
                                    <tr>
                                        <td>{{$d_row['barcode']}}</td>
                                        <td>{{$d_row['cat_name']}}</td>
                                        <td>{{$d_row['expected_polish_cts']}}</td>
                                        <td>{{ $d_row['attributes']['SHAPE'] }}</td>
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
                                        <td style="text-align: right;">$ {{number_format($data['result']->sub_total * $data['result']->discount_amount / 100, 2, '.', ',')}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" style="text-align: right;"><b>Tax</b></td>
                                        <td style="text-align: right;">$ {{number_format($data['result']->sub_total * $data['result']->tax_amount / 100, 2, '.', ',')}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" style="text-align: right;"><b>Shipping Charge</b></td>
                                        <td style="text-align: right;">$ {{number_format($data['result']->delivery_charge_amount, 2, '.', ',')}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" style="text-align: right;"><b>
                                            <h6>Total</h6>
                                        </b></td>
                                        <td style="text-align: right;"><b>
                                            <h6>$ {{number_format(floatval($data['result']->total_paid_amount), 2, '.', ',')}}</h6>
                                        </b></td>
                                    </tr>

                                </tbody>
                            </table>
                            <br>
                            <table class="table dt-responsive nowrap table-bordered">
                                <tbody>
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
                        </div>
                    </div><!-- card -->
                </div><!-- .nk-block -->
            </div>

        </div>
    </div>
</div>
@endsection
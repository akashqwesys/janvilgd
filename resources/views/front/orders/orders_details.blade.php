@extends('front.layout_2')
@section('title', $title)
@section('css')
<style type="text/css">
    .img-cs {
        width: 200px;
    }
    .cs-card {
        box-shadow: 0px 1px 5px #c2c2c2;
    }
    .table {
        color: unset;
    }
    .account-tabs li a {
        display: block;
    }
</style>
@endsection

@section('content')
<div class="overlay cs-loader">
    <div class="overlay__inner">
    <div class="overlay__content"><span class="spinner"></span></div>
    </div>
</div>
<section class="profile-section">
    <div class="container">
        <div class="row mb-5">
            <div class="col col-12 col-sm-4 col-md-3 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="navbar-tabs account-tabs">
                        <ul class="list-unstyled mb-0">
                            <li class="tab-item"><a href="/customer/my-account" class="tab-link">Account</a></li>
                            <hr>
                            <li class="tab-item"><a href="/customer/my-profile" class="tab-link">Profile</a></li>
                            <hr>
                            <li class="tab-item"><a href="/customer/my-addresses" class="tab-link">Addresses</a></li>
                            <hr>
                            <li class="tab-item"><a href="/customer/my-orders" class="tab-link">Orders</a></li>
                        </ul>
                    </div>
                    </div>
                </div>
            </div>
            <div class="col col-12 col-sm-8 col-md-9 col-lg-9">
                <div class="card">
                    <div class="card-body">
                        <h4 class="text-primary" >Order #{{ $orders[0]->order_id }}</h4>
                        <hr>
                        <div class="order-info">
                            @if(!count($orders))
                            <div class="text-center">
                                <img src="/assets/images/dilevery-boy.png" alt="dilevery-boy.png" class="img-fluid mb-5">
                                <p>You haven't placed any order yet!<br><br>Order section is empty. After placing order, You can track them from here!</p>
                                <div class="edit-btn d-flex mt-5">
                                    <a href="/" class="btn btn-primary m-auto">Start Shopping</a>
                                </div>
                            </div>
                            @else
                            <div class="order-details">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="50%">Billing Address</th>
                                            <th width="50%">Shipping Address</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div>{{ $orders[0]->billing_company_name }}</div>
                                                <div>{{ $orders[0]->billing_company_office_address }}</div>
                                                <div>{{ $orders[0]->billing_city .' - '. $orders[0]->billing_company_office_pincode }}</div>
                                                <div>{{ $orders[0]->billing_state .', '. $orders[0]->billing_country }}</div>
                                                <div>Mo: {{ $orders[0]->billing_company_office_no }}</div>
                                                <div>Email: {{ $orders[0]->billing_company_office_email }}</div>
                                            </td>
                                            <td>
                                                <div>{{ $orders[0]->shipping_company_name }}</div>
                                                <div>{{ $orders[0]->shipping_company_office_address }}</div>
                                                <div>{{ $orders[0]->shipping_city .' - '. $orders[0]->shipping_company_office_pincode }}</div>
                                                <div>{{ $orders[0]->shipping_state .', '. $orders[0]->shipping_country }}</div>
                                                <div>Mo: {{ $orders[0]->shipping_company_office_no }}</div>
                                                <div>Email: {{ $orders[0]->shipping_company_office_email }}</div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <table class="table table-bordered">
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
                                        @foreach ($diamonds as $o)
                                        <tr>
                                            <td>{{ $o['barcode'] }}</td>
                                            <td>{{ $o['cat_name'] }}</td>
                                            <td>{{ $o['attributes']['SHAPE'] }}</td>
                                            <td>{{ $o['expected_polish_cts'] }}</td>
                                            <td>{{ $o['attributes']['COLOR'] }}</td>
                                            <td>{{ $o['attributes']['CLARITY'] }}</td>
                                            <td>${{ number_format($o['rapaport_price'], 2, '.', ',') }}</td>
                                            <td>{{ number_format($o['discount'], 2) }}%</td>
                                            <td style="text-align: right;">${{ number_format($o['total'], 2, '.', ',') }}</td>
                                        </tr>
                                        @endforeach
                                        <tr style="background-color: lightgray;">
                                            <td colspan="9" style="text-align: right;">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td colspan="8" style="text-align: right;"><b>Subtotal</b></td>
                                            <td style="text-align: right;">${{ number_format($orders[0]->sub_total, 2, '.', ',') }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="8" style="text-align: right;"><b>Discount</b></td>
                                            <td style="text-align: right;">${{ number_format($orders[0]->sub_total * $orders[0]->discount_amount / 100, 2, '.', ',') }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="8" style="text-align: right;"><b>Tax</b></td>
                                            <td style="text-align: right;">${{ number_format(($orders[0]->sub_total - ($orders[0]->sub_total * $orders[0]->discount_amount / 100)) * $orders[0]->tax_amount / 100, 2, '.', ',') }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="8" style="text-align: right;"><b>Shipping Charge</b></td>
                                            <td style="text-align: right;">${{ number_format($orders[0]->delivery_charge_amount, 2, '.', ',') }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="8" style="text-align: right;">
                                                <b> Total </b>
                                            </td>
                                            <td style="text-align: right;">
                                                <b> ${{ number_format($orders[0]->total_paid_amount, 2, '.', ',') }}</b>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="mt-4">
                                    <h5>Order Updates</h5>
                                    <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Status</th>
                                            <th>Comment</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($status))
                                            @foreach($status as $s)
                                                <tr>
                                                    <td>{{ $s->order_status_name }}</td>
                                                    <td>{{ $s->comment }}</td>
                                                    <td>{{ date('d-m-Y H:i:s', strtotime($s->date_added)) }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                        <tr>
                                            <td colspan="3">No updates yet</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('js')
<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
    },
    beforeSend: function (xhr) {
        $(".cs-loader").show();
    }
});
$(document).on('click', '.edit-btn', function () {

});
$("#exampleModal").on('hidden.bs.modal', function(){
    $('div.errTxt').html('');
});
</script>
@endsection
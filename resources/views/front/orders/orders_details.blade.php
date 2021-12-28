@extends('front.layout_2')
@section('title', $title)
@section('css')
<style type="text/css">
    .bd-right {
        border-right: 1px solid lightgray;
    }
    .bd-left {
        border-left: 1px solid lightgray;
    }
    .bd-top {
        border-top: 1px solid lightgray;
    }
    .bd-bottom {
        border-bottom: 1px solid lightgray;
    }
    hr {
        margin: 2rem 0;
    }
    .img-cs {
        width: 200px;
    }
    .cs-card {
        box-shadow: 0px 1px 5px #c2c2c2;
    }
    .table {
        color: unset;
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
        <div class="profile-content">
            <h2 class="title">Janvi LGD</h2>
            <div class="row main-box">
                <div class="col col-12 col-sm-12 col-md-3 col-lg-2">
                    <div class="navbar-tabs">
                        <ul class="list-unstyled mb-0">
                            <li class="tab-item"><a href="/customer/my-account" class="tab-link">Account</a></li>
                            <li class="tab-item"><a href="/customer/my-profile" class="tab-link">Profile</a></li>
                            <li class="tab-item"><a href="/customer/my-saved-cards" class="tab-link">Saved Cards</a></li>
                            <li class="tab-item"><a href="/customer/my-addresses" class="tab-link">Addresses</a></li>
                            <li class="tab-item"><a href="/customer/my-orders" class="tab-link">Orders</a></li>
                            {{-- <li class="tab-item"><a href="javascript:void(0);" class="tab-link">Orders Details</a></li> --}}
                        </ul>
                    </div>
                    <hr>
                </div>
                <div class="col col-12 col-sm-12 col-md-9 col-lg-10">
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
                        <div class="order-details p-4">
                            <h3 class="text-primary" >Order #{{ $orders[0]->order_id }}</h3>
                            <hr>
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
                                        <th>Carat</th>
                                        <th>Shape</th>
                                        <th>Color</th>
                                        <th>Clarity</th>
                                        <th style="text-align: right;">Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($diamonds as $o)
                                    <tr>
                                        <td>{{ $o['barcode'] }}</td>
                                        <td>{{ $o['expected_polish_cts'] }}</td>
                                        @foreach ( $o['attributes'] as $d_attr)
                                            <td>{{$d_attr}}</td>
                                        @endforeach
                                        <td style="text-align: right;">${{ $o['total'] }}</td>
                                    </tr>
                                    @endforeach
                                    <tr style="background-color: lightgray;">
                                        <td colspan="6" style="text-align: right;">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" style="text-align: right;"><b>Subtotal</b></td>
                                        <td style="text-align: right;">${{ number_format($orders[0]->sub_total, 2, '.', ',') }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" style="text-align: right;"><b>Discount</b></td>
                                        <td style="text-align: right;">${{ number_format($orders[0]->discount_amount, 2, '.', ',') }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" style="text-align: right;"><b>Tax</b></td>
                                        <td style="text-align: right;">${{ number_format($orders[0]->tax_amount, 2, '.', ',') }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" style="text-align: right;"><b>Shipping Charge</b></td>
                                        <td style="text-align: right;">${{ number_format($orders[0]->delivery_charge_amount, 2, '.', ',') }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" style="text-align: right;">
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
                                                <td>{{ $s->date_added }}</td>
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
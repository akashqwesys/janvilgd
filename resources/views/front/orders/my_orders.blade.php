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
                <div class="col col-12 col-sm-12 col-md-4 col-lg-3">
                    <div class="navbar-tabs">
                        <ul class="list-unstyled mb-0">
                            <li class="tab-item"><a href="/customer/my-account" class="tab-link">Account</a></li>
                            <li class="tab-item"><a href="/customer/my-profile" class="tab-link">Profile</a></li>
                            <li class="tab-item"><a href="/customer/my-saved-cards" class="tab-link">Saved Cards</a></li>
                            <li class="tab-item"><a href="/customer/my-addresses" class="tab-link">Addresses</a></li>
                            <li class="tab-item"><a href="javascript:void(0);" class="tab-link">Orders</a></li>
                            {{-- <li class="tab-item"><a href="/customer/order-details" class="tab-link">Orders Details</a></li> --}}
                        </ul>
                    </div>
                    <hr>
                </div>
                <div class="col col-12 col-sm-12 col-md-8 col-lg-9">
                    <div class="order-info">
                        @if (session('success'))
                        <div class="alert alert-success mt-3">
                            {{ session('message') }}
                        </div>
                        @elseif (session('error'))
                        <div class="alert alert-danger mt-3">
                            {{ session('message') }}
                        </div>
                        @endif
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
                            @foreach ($orders as $o)
                            <div>
                                <h3 class="mb-2"><i><a href="/customer/order-details/{{ $o->refTransaction_id }}/{{ $o->order_id }}">Order #: {{ $o->order_id }}</a></i></h3>
                                <div>Transaction ID: <b>{{ $o->refTransaction_id }}</b></div>
                                <div>Total Amount: <b>${{ $o->total_paid_amount }}</b></div>
                                <div class="">Payment Mode: <b>{{ $o->payment_mode_name }}</b></div>
                                <div class="">Order Status: <b>{{ $o->order_status_name }}</b></div>
                                <div class="mb-2">Order Date: <b>{{ date(' dS F Y, l', strtotime($o->created_at)) }}</b></div>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered-">
                                        <thead>
                                            <tr class="bg-dark text-primary">
                                                <th>Billing Address</th>
                                                <th>Shipping Address</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td width="50%">
                                                    <div>{{ $o->billing_company_name }}</div>
                                                    <div>{{ $o->billing_company_office_address }}</div>
                                                    <div>{{ $o->billing_city .' - '. $o->billing_company_office_pincode }}</div>
                                                    <div>{{ $o->billing_state .', '. $o->billing_country }}</div>
                                                    <div>Mo: {{ $o->billing_company_office_no }}</div>
                                                    <div>Email: {{ $o->billing_company_office_email }}</div>
                                                </td>
                                                <td width="50%">
                                                    <div>{{ $o->shipping_company_name }}</div>
                                                    <div>{{ $o->shipping_company_office_address }}</div>
                                                    <div>{{ $o->shipping_city .' - '. $o->shipping_company_office_pincode }}</div>
                                                    <div>{{ $o->shipping_state .', '. $o->shipping_country }}</div>
                                                    <div>Mo: {{ $o->shipping_company_office_no }}</div>
                                                    <div>Email: {{ $o->shipping_company_office_email }}</div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <hr>
                            </div>
                            @endforeach
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
</script>
@endsection
@extends('front.layout_2')
@section('title', $title)
@section('css')
<style type="text/css">
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
                            <li class="tab-item"><a href="javascript:void(0);" class="tab-link">Orders</a></li>
                        </ul>
                    </div>
                    </div>
                </div>
            </div>
            <div class="col col-12 col-sm-8 col-md-9 col-lg-9">
                <div class="card">
                    <div class="card-body">
                        <h4 class="mb-3">My Orders</h4>
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
                            <div class="order-details">
                                <div class="table-responsive">
                                    <table class="table table-striped- table-bordered">
                                        <thead>
                                            <tr class="bg-dark text-primary">
                                                <th width="20%" class="text-right">Order ID</th>
                                                <th width="20%" class="text-right">Transaction ID</th>
                                                <th width="20%" class="text-right">Total Amount</th>
                                                <th width="20%" class="text-right">Placed On</th>
                                                <th width="20%" class="text-right">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($orders))
                                            @foreach ($orders as $o)
                                            <tr>
                                                <td class="text-right">
                                                    <div>{{ $o[0]->order_id }}</div>
                                                </td>
                                                <td class="text-right">
                                                    <div>{{ $o[0]->refTransaction_id }}</div>
                                                </td>
                                                <td class="text-right">
                                                    <div>${{ number_format($o[0]->total_paid_amount, 2, '.', ',') }}</div>
                                                </td>
                                                <td class="text-right">
                                                    <div>{{ $o[0]->created_at }}</div>
                                                </td>
                                                <td class="text-right">
                                                    <a href="/customer/order-details/{{ $o[0]->refTransaction_id }}/{{ $o[0]->order_id }}">View Details</a>
                                                </td>
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr>
                                                <td colspan="5" align="center">No Orders Placed Yet</td>
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
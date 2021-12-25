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
                            <li class="tab-item"><a href="/customer/my-orders" class="tab-link">Orders</a></li>
                            <li class="tab-item"><a href="javascript:void(0);" class="tab-link">Orders Details</a></li>
                        </ul>
                    </div>
                    <hr>
                </div>
                <div class="col col-12 col-sm-12 col-md-8 col-lg-9">
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
                            @php $temp_id = 0; $hr = null; @endphp
                            @foreach ($orders as $o)
                            <div>
                                @php $hr = '<hr>'; @endphp
                                @if ($temp_id != $o->order_id)
                                    @php $temp_id = $o->order_id; $hr = null; @endphp
                                <h3 class="mb-3"><i>Order #: {{ $o->order_id }}</i></h3>
                                <div class="row mb-3">
                                    <div class="col col-md-6 col-lg-6 bd-right">
                                        <div class="mb-1 p-1 bd-bottom bd-top">Billing Address</div>
                                        <div>{{ $o->billing_company_name }}</div>
                                        <div>{{ $o->billing_company_office_address }}</div>
                                        <div>{{ $o->billing_city .' - '. $o->billing_company_office_pincode }}</div>
                                        <div>{{ $o->billing_state .', '. $o->billing_country }}</div>
                                        <div>Mo: {{ $o->billing_company_office_no }}</div>
                                        <div>Email: {{ $o->billing_company_office_email }}</div>
                                    </div>
                                    <div class="col col-md-6 col-lg-6 bd-left">
                                        <div class="mb-1 p-1 bd-bottom bd-top">Shipping Address</div>
                                        <div>{{ $o->shipping_company_name }}</div>
                                        <div>{{ $o->shipping_company_office_address }}</div>
                                        <div>{{ $o->shipping_city .' - '. $o->shipping_company_office_pincode }}</div>
                                        <div>{{ $o->shipping_state .', '. $o->shipping_country }}</div>
                                        <div>Mo: {{ $o->shipping_company_office_no }}</div>
                                        <div>Email: {{ $o->shipping_company_office_email }}</div>
                                    </div>
                                </div>
                                @endif

                                <div class="mb-3">
                                    {{-- <div class="col col-12 col-lg-4"> --}}
                                        <span class="order-prouct-image mb-3">
                                            <img src="{{ $o->images[0] }}" alt="product" class="img-cs">
                                        </span>
                                    {{-- </div>
                                    <div class="col col-12 col-lg-8"> --}}
                                        <div class="order-prouct-details d-inline-block mx-2">
                                            <h4 class="product-name">{{ $o->diamond_name }}</h4>
                                            <p>Barcode: {{ $o->barcode }}</p>
                                            <p class="product-price">${{ number_format(round($o->price, 2), 2, '.', ',') }}</p>
                                        </div>
                                    {{-- </div> --}}
                                </div>
                            </div>
                            {!! $hr !!}
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
    $('#customer_company_id').val($(this).attr('data-id'));
    $('#company_name').val($(this).attr('data-name'));
    $('#company_office_no').val($(this).attr('data-company_office_no'));
    $('#company_email').val($(this).attr('data-company_email'));
    $('#company_gst_pan').val($(this).attr('data-company_gst_pan'));
    $('#company_address').val($(this).attr('data-company_address'));
    $('#company_pincode').val($(this).attr('data-company_pincode'));
    $('#company_country').val($(this).attr('data-company_country')).trigger('change');
    setTimeout(() => {
        $('#company_state').val($(this).attr('data-company_state')).trigger('change');
    }, 1000);
    setTimeout(() => {
        $('#company_city').val($(this).attr('data-company_city'));
    }, 2000);
    $('#exampleModal').modal('show');
});
$("#exampleModal").on('hidden.bs.modal', function(){
    $('div.errTxt').html('');
});
</script>
@endsection
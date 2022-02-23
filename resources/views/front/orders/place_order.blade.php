@extends('front.layout_2')
@section('title', $title)
@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"/>
<style class="text/css">
@media (min-width: 992px) {
    .ps-lg-6 {
        padding-left: 8rem !important;
    }
}
@media (min-width: 768px) {
    .ps-md-6 {
        padding-left: 4rem;
    }
}
</style>
@endsection
@section('content')
<div class="overlay cs-loader">
    <div class="overlay__inner">
    <div class="overlay__content"><span class="spinner"></span></div>
    </div>
</div>
<section class="sub-header">
    <div class="container">
        <div class="section-content">
            <div>
                <h2 class="title bread-crumb-title">Payment</h2>
            </div>
        </div>
    </div>
</section>
<div class="cart-page">
    <div class="container">
        <div class="alert alert-info">
            Note: Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order will not be shipped until the funds have cleared in our account.
        </div>
        <div class="row">
            <div class="col col-12 col-md-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 col-12 ">
                                <div class="text-center">
                                    <h5>Payment Method</h5>
                                    <hr>
                                </div>
                                <h6><b>Direct Bank Transfer</b></h6>
                                <div>Make your payment directly into our bank....</div>
                            </div>
                            <div class="col-md-8 col-12 ">
                                <h5 class="text-center">Bank Details</h5>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6 col-12 ">
                                        <h6>  <b>USA</b>  </h6>
                                        <label> BANK NAME : JPMorgan Chase </label><br>
                                        <label> ACCOUNT NAME : JANVI LGD PRIVATE LIMITED </label><br>
                                        <label> ACCOUNT NUMBER : 8420108663 </label><br>
                                        <label> ROUTING NUMBER : 122333248 </label><br>
                                        <label> USA PAYMENT : WDBIU6S </label><br>
                                        <label> SHIFT CODE : CHASUS33XXX </label><br>
                                    </div>
                                    <div class="col-md-6 col-12 mb-2">
                                        <h6 class="mt-3">  <b>INDIA</b>  </h6>
                                        <label> BANK NAME : HDFC Bank </label><br>
                                        <label> ACCOUNT NAME : JANVI LGD PRIVATE LIMITED </label><br>
                                        <label> ACCOUNT NUMBER : 50200045669788 </label><br>
                                        <label> BRANCH NAME : Sachin </label><br>
                                        <label> IFSC CODE : HDFC0001706 </label><br>
                                        <label> SHIFT CODE : HDFCINBB </label><br>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="text-center">
                                <form method="post" action="/customer/save-order">
                                    @csrf
                                    <input type="hidden" name="token" value="{{ $tk }}">
                                    <button class="btn btn-primary" type="submit">CONFIRM ORDER</button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            {{-- <div class="col col-12 col-md-6">
                <div class="card mb-4">
                    <div class="card-body text-center">
                        <form method="post" action="/customer/save-order">
                            @csrf
                            <input type="hidden" name="token" value="{{ $tk }}">
                            <button class="btn btn-primary" type="submit">CONFIRM ORDER</button>
                        </form>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
</div>

@endsection
@section('js')
<script type="text/javascript">
</script>
@endsection
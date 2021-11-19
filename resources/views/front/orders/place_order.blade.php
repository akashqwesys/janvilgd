@extends('front.layout_2')
@section('title', $title)
@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"/>
<style class="text/css">

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
                <h2 class="title bread-crumb-title">Place Order</h2>
            </div>
        </div>
    </div>
</section>
<div class="cart-page">
    <div class="container">
        <div class="row">
            <div class="col col-12 col-md-6 m-auto">
                <div class="card mb-4">
                    <div class="card-body text-center">
                        <form method="post" action="/customer/save-order">
                            @csrf
                            <input type="hidden" name="token" value="{{ $tk }}">
                            <button class="btn btn-primary" type="submit">PLACE ORDER</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
<script type="text/javascript">
</script>
@endsection
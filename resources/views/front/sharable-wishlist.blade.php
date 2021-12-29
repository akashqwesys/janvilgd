@extends('front.layout_2')
@section('title', $title)
@section('css')
@endsection
@section('content')
<section class="sub-header">
    <div class="container">
        <div class="section-content">
            <div>
                <h2 class="title bread-crumb-title">Sharable Wishlist</h2>
            </div>
        </div>
    </div>
</section>
<!-- CART SECTION -->

<section class="cart-page mb-5">
    <div class="container">
        <div class="row">
            <div class="col col-12">
                <div class="d-sm-flex d-block align-items-center mb-4">
                    <h2 class="me-auto mb-3 mb-dm-0">Diamonds</h2>
                    <a href="javascript:;" class="btn btn-primary" id="add-all-to-wishlist">ADD ALL TO MY WISHLIST</a>
                    <input type="hidden" id="share_wishlist_id" value="{{$share_wishlist_id}}">
                </div>
            </div>
        </div>
        <div class="row">
            @if(!empty($response))
            @foreach($response as $r)
                <div class="col-md-3 col-6 mb-3" id="diamond_{{$r['_source']['diamond_id']}}">
                    <div class="card">
                        <div class="card-body- p-1 text-center">
                            <div class=" mb-2">
                                <a href="/customer/single-diamonds/{{$r['_source']['barcode']}}">
                                    <img src="{{ count($r['_source']['image']) ? $r['_source']['image'][0] : '/assets/images/No-Preview-Available.jpg' }}" alt="Diamond" class="w-100">
                                </a>
                            </div>
                            <h5>{{ $r['_source']['expected_polish_cts'] . ' CT ' .  $r['_source']['attributes']['SHAPE'] . ' DIAMOND' }}</h5>
                            <small class="">{{ $r['_source']['attributes']['COLOR'] . ' Color • ' .  $r['_source']['attributes']['CLARITY'] . ' Clarity' }}</small>
                            <div class="mt-2"><h5><b>${{ number_format($r['_source']['total'], 2, '.', ',') }} USD</b></h5></div>
                            <a href="javascript:void(0);" class="btn btn-primary w-100 add-to-cart">ADD TO CART</a>
                        </div>
                    </div>
                </div>
            @endforeach
            @endif
        </div>
    </div>
</section>
@endsection
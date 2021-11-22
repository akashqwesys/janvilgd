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
                    <a href="javascript:;" class="btn btn-primary" id="add-all-to-wishlist">Add all to my wishlist</a>
                    <input type="hidden" id="share_wishlist_id" value="{{$share_wishlist_id}}">
                </div>
            </div>
        </div>
        <div class="row">
            @if(!empty($response))
            @foreach($response as $row)
            <div class="col col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3" id="diamond_{{$row->diamond_id}}">
                <div class="card wish-card">
                    <div class="card-body">
                        <a class="close removeFromWishlist" href="Javascript:;" data-id="{{$row->diamond_id}}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="#ffffff" class="bi bi-x-lg" viewBox="0 0 16 16">
                                <path d="M1.293 1.293a1 1 0 0 1 1.414 0L8 6.586l5.293-5.293a1 1 0 1 1 1.414 1.414L9.414 8l5.293 5.293a1 1 0 0 1-1.414 1.414L8 9.414l-5.293 5.293a1 1 0 0 1-1.414-1.414L6.586 8 1.293 2.707a1 1 0 0 1 0-1.414z"/>
                            </svg>
                        </a>
                        <a href="/customer/single-diamonds/{{$row->barcode}}"><img class="img-fluid cart-product-img" src="{{ count($row->image) ? $row->image[0] : '/assets/images/No-Preview-Available.jpg' }}" alt="No-Preview-Available">  </a>
                        <h5>{{ substr($row->diamond_name, 0, strpos($row->diamond_name, '::'))}}</h5>
                        <p class="price">${{number_format(round($row->total, 2), 2, '.', ',')}}</p>
                        <a href="Javascript:;" class="btn btn-primary add-to-cart" data-id="{{$row->diamond_id}}">Add to cart</a>
                    </div>
                </div>
            </div>
            @endforeach
            @endif

        </div>
    </div>
</section>
@endsection
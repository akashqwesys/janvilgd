@extends('front.layout_2')
@section('title', $title)
@section('css')
@endsection
@section('content')
<section class="sub-header">
    <div class="container">
        <div class="section-content">
            <div>
                <h2 class="title bread-crumb-title">Sharable Cart</h2>
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
                    <a href="javascript:;" class="btn btn-primary" id="add-all-to-cart">Add all to my cart</a>
                    <input type="hidden" id="share_cart_id" value="{{$share_cart_id}}">
                </div>
            </div>
        </div>
        <div class="row">
            @php
                if(!empty($response)){
                    foreach($response as $row) {
            @endphp
            <div class="col col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3" id="diamond_{{$row->diamond_id}}">
                <div class="card wish-card">
                    <div class="card-body">
                        @php
                            $i=0;
                            $image=json_decode($row->image);
                                if(!empty($image)){
                                    foreach($image as $v) {
                                        if($i==0){
                        @endphp
                        <a href="/customer/single-diamonds/{{$row->barcode}}"><img class="img-fluid cart-product-img" style="height:200px;" src="/storage/other_images/{{ $v }}" alt="{{ $v }}">  </a>
                        @php
                                    }
                                    $i=$i+1;
                                }
                            }
                            @endphp
                            <h5>{{ substr($row->diamond_name, 0, strpos($row->diamond_name, '::'))}}</h5>
                            <p class="price">${{number_format(round($row->total, 2), 2, '.', ',')}}</p>
                            <a href="Javascript:;" class="btn btn-primary add-to-cart" data-id="{{$row->diamond_id}}">Add to cart</a>
                    </div>
                </div>
            </div>
            @php
                    }
                }
            @endphp

        </div>
    </div>
</section>
@endsection
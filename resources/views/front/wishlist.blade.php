@extends('front.layout_2')
@section('title', $title)
@section('css')

<script type="text/javascript">
 $(document).ready(function () {
     $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function( xhr ) {
            $( ".cs-loader" ).show();
        }
    });
    $(document).on('click', '#share-wishlist', function () {
        $.ajax({
            type: "POST",
            url: "{{ route('generate-share-wishlist-link') }}",
            success: function (res) {
                $('.cs-loader').hide();
                if (res.suceess==1) {
                    $("#watsapplink").val("https://api.whatsapp.com/send?text="+encodeURIComponent('<?php echo url("customer/sharable-wishlist/"); ?>/'+res.link_id));   
                    $("#copylink").val('<?php echo url("customer/sharable-wishlist/"); ?>/'+res.link_id);                    
                    $("#staticBackdrop").modal("show");
//                    navigator.clipboard.writeText('<?php //echo url("customer/sharable-wishlist/"); ?>/'+res.link_id);
//                    $.toast({
//                        heading: 'Success',
//                        text: "Link is copied",
//                        icon: 'success',
//                        position: 'top-right'
//                    });
                }else{
                    $.toast({
                        heading: 'Error',
                        text: "Your wishlist is empty link is not generated",
                        icon: 'error',
                        position: 'top-right'
                    });
                }
            }
        });
    });
 });
 </script>
@endsection
@section('content')
<section class="sub-header">
    <div class="container">
        <div class="section-content">
            <div>
                <h2 class="title bread-crumb-title">Wishlist</h2>
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
                    @if(!empty($response))
                    <a href="javascript:;" class="btn btn-primary" id="share-wishlist">Share your wishlist <i class="fa fa-share-alt"></i></a>
                    <input type="hidden" id="watsapplink" value="">
                    <input type="hidden" id="copylink" value="">
                    @endif
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
                        <a class="close removeFromWishlist" href="Javascript:;" data-id="{{$row->diamond_id}}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="#ffffff" class="bi bi-x-lg" viewBox="0 0 16 16">
                                <path d="M1.293 1.293a1 1 0 0 1 1.414 0L8 6.586l5.293-5.293a1 1 0 1 1 1.414 1.414L9.414 8l5.293 5.293a1 1 0 0 1-1.414 1.414L8 9.414l-5.293 5.293a1 1 0 0 1-1.414-1.414L6.586 8 1.293 2.707a1 1 0 0 1 0-1.414z"/>
                            </svg>
                        </a>
                        @php
                            $i=0;
                            $image=json_decode($row->image);
                                if(!empty($image)){
                                    foreach($image as $v) {
                                        if($i==0){
                        @endphp
                        <a href="/customer/single-diamonds/{{$row->diamond_id}}"><img class="img-fluid cart-product-img" style="height:200px;" src="{{ asset(check_host().'images') }}<?php echo '/' . $v; ?>" alt="{{ $v }}">  </a>
                        @php
                                    }
                                    $i=$i+1;
                                }
                            }
                            @endphp
                            <h5>{{ substr($row->diamond_name, 0, strpos($row->diamond_name, '::'))}}</h5>
                            <p class="price">${{$row->total}}</p>
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
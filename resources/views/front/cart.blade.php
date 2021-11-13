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
    $(document).on('click', '#share-cart', function () {
        $.ajax({
            type: "POST",
            url: "{{ route('generate-share-cart-link') }}",
            success: function (res) {
                $('.cs-loader').hide();
                if (res.suceess==1) {
                    $("#watsapplink").val("https://api.whatsapp.com/send?text="+encodeURIComponent('<?php echo url("customer/sharable-cart/"); ?>/'+res.link_id));
                    $("#copylink").val('<?php echo url("customer/sharable-cart/"); ?>/'+res.link_id);
                    $("#staticBackdrop").modal("show");
                }else{
                    $.toast({
                        heading: 'Error',
                        text: "Your cart is empty link is not generated",
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
                <h2 class="title bread-crumb-title">View Cart</h2>
            </div>
        </div>
    </div>
</section>
<div class="cart-page mb-5">
    <div class="container">
        <div class="row">
            <div class="d-flex align-items-center mb-5">

                @if(!empty($response))
                <h2 class="me-auto mb-0">Shopping Bag</h2>
                <a href="javascript:;" class="btn btn-primary" id="share-cart">Share your cart <i class="fa fa-share-alt"></i></a>
                <input type="hidden" id="watsapplink" value="">
                <input type="hidden" id="copylink" value="">
                @endif
            </div>
            <div class="col col-12 col-md-12 col-lg-8">
                <table class="cart-table">

                    @php
                    $total=0;
                    if(!empty($response)){
                    foreach($response as $k => $rv) {
                        if ($k == 'summary') {
                            continue;
                        }
                    @endphp
                    <tr id="diamond_{{$rv->diamond_id}}">
                        <td>
                            @php
                            $i=0;
                            $image=($rv->image);
                            if(!empty($image)){
                            foreach($image as $v) {
                            if($i==0){
                            @endphp

                            <a href="/customer/single-diamonds/{{$rv->barcode}}"><img class="img-fluid cart-product-img" src="{{ $v }}" alt="{{ $v }}">  </a>
                            @php
                            }
                            $i=$i+1;
                            }
                            }
                            @endphp
                            <a class="close removeFromCart" href="Javascript:;" data-id="{{$rv->diamond_id}}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="#ffffff" class="bi bi-x-lg" viewBox="0 0 16 16">
                                    <path d="M1.293 1.293a1 1 0 0 1 1.414 0L8 6.586l5.293-5.293a1 1 0 1 1 1.414 1.414L9.414 8l5.293 5.293a1 1 0 0 1-1.414 1.414L8 9.414l-5.293 5.293a1 1 0 0 1-1.414-1.414L6.586 8 1.293 2.707a1 1 0 0 1 0-1.414z"/>
                                </svg>
                            </a>
                        </td>
                        <td>
                            <h5>{{$rv->diamond_name}}</h5>
                            <h4 class="cart-price">${{$rv->total}}</h4>
                            <p><span class="me-2"><img src="{{ asset(check_host().'assets/images') }}/Star.svg" class="star-img img-fluid"></span>Only One Available</p>
                        </td>
                    </tr>
                    @php

                    $total=$total+$rv->total;
                    }
                    }
                    @endphp
                </table>
            </div>
            <div class="col col-12 col-md-12 col-lg-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="text-center mb-4">Order summary</h5>
                        <table class="table summary-table">
                            <tbody>
                                <tr>
                                    <td>Subtotal</td>
                                    <td id="sub-total-td">${{$response['summary']['subtotal']}}</td>
                                </tr>
                                <tr>
                                    <td>Discount</td>
                                    <td>{{ $response['summary']['discount'] }}</td>
                                </tr>
                                <tr>
                                    <td>Tax</td>
                                    <td>{{ $response['summary']['tax'] }}</td>
                                </tr>
                                <tr>
                                    <td>Additional Discount</td>
                                    <td>{{ $response['summary']['additional_discount'] }}</td>
                                </tr>
                                <tr>
                                    <td>Shipping charge</td>
                                    <td>{{ $response['summary']['shipping'] }}</td>
                                </tr>
                                <tr>
                                    <th>Total</th>
                                    <th id="final-total-th">${{$response['summary']['total']}}</td>
                                </tr>
                            </tbody>
                        </table>
                        <a href="/customer/checkout" class="btn btn-primary d-block">Checkout</a>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h5 class="text-center mb-4">Shipping Info</h5>
                        <p>Estimated ship date when ordered by 2 PM PT <span class="themecolor">Monday: Monday, October 18th</span></p>
                        <p>Contact us at 800.691.0952 to schedule Saturday delivery, hold at a FedEx location, or to inquire about available delivery options.</p>
                        <h5>Need Help?</h5>
                        <p class="themecolor">Chat now or call <a href="tel:8006910952">800.691.0952</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
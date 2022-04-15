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
                    $("#watsapplink").val("https://api.whatsapp.com/send?text="+encodeURIComponent(res.url));
                    $("#copylink").val(res.url);
                    $("#staticBackdrop").modal("show");
                }else{
                    $.toast({
                        heading: 'Error',
                        text: "Your cart is empty, link is not generated",
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
<div class="cart-page mb-5 mt-5">
    <div class="container">
        <div class="row">
            <div class="d-block d-sm-flex align-items-center mb-5">
                @if(!empty($response['diamonds']))
                <h2 class="me-auto mb-3 mb-sm-0">Shopping Bag</h2>
                <a href="javascript:;" class="btn btn-primary" id="share-cart">Share Your Cart <i class="fa fa-share-alt"></i></a>
                <input type="hidden" id="watsapplink" value="">
                <input type="hidden" id="copylink" value="">
                @endif
            </div>
            <?php
            $total=0;
            if(!empty($response['diamonds'])){
            ?>
            <div class="col col-12 col-md-8 col-lg-8 mb-4 mb-md-0">
                <div class="card p-4 cart-card">
                <?php
                    echo '<table class="cart-table">';

                    foreach($response['diamonds'] as $k => $rv) {
                        if ($k == 'summary') {
                            continue;
                        }
                    ?>
                    <tr id="diamond_{{$rv->diamond_id}}">
                        <td>
                            <a href="/customer/single-diamonds/{{$rv->barcode}}"><img class="img-fluid cart-product-img" src="{{ count($rv->image) ? '/storage/diamond_images/'.$rv->image[0] : '/assets/images/No-Preview-Available.jpg' }}" alt="No-Preview-Available">  </a>
                            <a class="close removeFromCart" href="Javascript:;" data-id="{{$rv->diamond_id}}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="#ffffff" class="bi bi-x-lg" viewBox="0 0 16 16">
                                    <path d="M1.293 1.293a1 1 0 0 1 1.414 0L8 6.586l5.293-5.293a1 1 0 1 1 1.414 1.414L9.414 8l5.293 5.293a1 1 0 0 1-1.414 1.414L8 9.414l-5.293 5.293a1 1 0 0 1-1.414-1.414L6.586 8 1.293 2.707a1 1 0 0 1 0-1.414z"/>
                                </svg>
                            </a>
                        </td>
                        <td>
                            <h5>{{ $rv->carat . ' CT ' . $rv->attributes['SHAPE'] . ' DIAMOND - ' . $rv->ct_name }}</h5>
                            <p class="">Stock No: {{ $rv->barcode }}</p>
                            <p class="">{{ $rv->attributes['COLOR'] . ' Color • ' . $rv->attributes['CLARITY'] . ' Clarity' }}</p>
                            <h4 class="cart-price pt-3">${{number_format(round($rv->total, 2), 2, '.', ',')}}</h4>
                            {{-- @if ($rv->available_pcs == 1)
                            <p><span class="me-2"><img src="{{ asset(check_host().'assets/images') }}/Star.svg" class="star-img img-fluid"></span>Only One Available</p> --}}
                            @if ($rv->available_pcs == 0)
                            <p class="text-danger"><b>This diamond is currently out of stock.</b></p>
                            @endif
                        </td>
                    </tr>
                    <?php
                    }
                    echo '</table>';
                    ?>
                </div>
            </div>

            <div class="col col-12 col-md-4 col-lg-4 order-summary-card">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="text-center mb-4">Order Summary</h5>
                        <table class="table summary-table">
                            <tbody>
                                <tr>
                                    <td>Subtotal</td>
                                    <td align="right" id="sub-total-td">${{ isset($response['summary']) ? $response['summary']['subtotal'] : 0 }}</td>
                                </tr>
                                <tr>
                                    <td>Discount</td>
                                    <td align="right" id="discount">${{ isset($response['summary']) ? $response['summary']['discount'] : 0 }}</td>
                                </tr>
                                @if (isset($response['summary']) && $response['summary']['additional_discount'] > 0)
                                <tr>
                                    <td>Additional Discount</td>
                                    <td align="right" id="additional_discount">${{ $response['summary']['additional_discount'] }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <td>Tax (Tentative)</td>
                                    <td align="right" id="tax">${{ isset($response['summary']) ? $response['summary']['tax'] : 0 }}</td>
                                </tr>
                                <tr>
                                    <td>Shipping charge</td>
                                    <td align="right" id="shipping">${{ isset($response['summary']) ? $response['summary']['shipping'] : 0 }}</td>
                                </tr>
                                <tr>
                                    <th>Total Amount</th>
                                    <th id="final-total-th"><div class="text-right">${{isset($response['summary']) ? $response['summary']['total'] : 0 }}</div></td>
                                </tr>
                            </tbody>
                        </table>
                        <a href="/customer/checkout" class="btn btn-primary d-block" id="checkout-link">Checkout</a>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h5 class="text-center mb-4">Order Timeline</h5>
                        <p><b>Loose Stones, Ready to Ship</b></p>
                        <p>Item(s) will ship to you within 1-2 business working days.</p>
                        <h6>Need Assistance?</h6>
                        <p class="">Chat with us via WhatsApp or Call <a href="tel:+1-9122456789">+1-9122456789</a> ( USA ) / <a href="tel:+91-9714405421">+91-9714405421</a> ( INDIA )</p>
                    </div>
                </div>
            </div>
            <?php
            } else {
            ?>
            <div class="col col-12 col-md-12 col-lg-12 card p-5 cart-card">
                <div class="text-center">
                    <h3>Your Cart is Empty...!</h3>
                    <h5>Enjoy Shopping</h5>
                    <img src="/assets/images/dilevery-boy.png" alt="dilevery-boy.png" class="img-fluid mb-5">
                </div>
            </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>
@endsection

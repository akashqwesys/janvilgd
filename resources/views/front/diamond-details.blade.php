@extends('front.layout_2')
@section('title', $title)
@section('css')
<link rel="stylesheet" href="/assets/owlcarousel/owl.carousel.min.css">
<link rel="stylesheet" href="/assets/owlcarousel/owl.theme.default.min.css">
<style>
    .p1r {
        padding: 0.8rem;
    }
    .h-100 {
        height: 100%;
    }
    .cs-loader-video {
        position: absolute;
    }
    .bg-lightgrey {
        background: #e2e2e2;
    }
    .detail-table td:nth-child(odd) {
        background: #e2e2e2;
        width: 16%;
    }
    .detail-table td:nth-child(even) {
        width: 17%;
    }
    .detail-table td {
        vertical-align: middle;
        height: 50px;
        /* font-size: smaller; */
    }
    .overflow-auto {
        overflow: auto;
    }
    .mini-table td {
        border: 1px solid;
        color: #000;
        /* font-size: smaller; */
    }
    .mini-table-2 td {
        border: none;
        color: #000;
        /* font-size: smaller; */
        padding: 0.25rem 0.25rem;
    }
    .mini-table-2  {
        border: 1px solid;
    }
    .mini-table-2 a {
        color : #272727;
    }
    .mini-table-2 a:hover {
        color : #D2AB66;
    }
    .product--details p {
        color: #000;
    }
    .img-cs {
        width: 20px;
    }
    .text-theme {
        color: #D2AB66;
    }
    @media (min-width: 1200px) {
        .w-85 {
            width: 95%;
        }
    }
    @media (min-width: 1400px) {
        .w-85 {
            width: 85%;
        }
    }
    .fs-small {
        font-size: smaller;
    }
    .fa-play-circle {
        cursor: pointer;
    }
</style>
@endsection
@section('content')
<div class="overlay cs-loader">
    <div class="overlay__inner">
    <div class="overlay__content"><img src='/assets/images/Janvi_Akashs_Logo_Loader_2.gif'></div>
    </div>
</div>
<section class="diamond-info-section" style="padding-top: 130px;">
    <div class="container">
        @if(!empty($response))
        @php
        $color='-';
        $cut='-';
        $size='-';
        $clarity='-';
        $certificate='';
        $certificate_url='';
        if(!empty($attributes)){

            foreach($attributes as $row){
                if(isset($row['COLOR'])){
                    $color=$row['COLOR'];
                }
                if(isset($row['SHAPE'])){
                    $shape=$row['SHAPE'];
                }
                if(isset($row['EXP POL SIZE'])){
                    $size=$row['EXP POL SIZE'];
                }
                if(isset($row['CUT'])){
                    $cut=$row['CUT'];
                }
                if(isset($row['CLARITY'])){
                    $clarity=$row['CLARITY'];
                }
                if(isset($row['CERTIFICATE'])){
                    $certificate=$row['CERTIFICATE'];
                }
                if(isset($row['CERTIFICATE URL'])){
                    $certificate_url=$row['CERTIFICATE URL'];
                }
                if(isset($row['LAB'])){
                    $lab=$row['LAB'];
                }
            }
        }
        @endphp
        <div class="diamond-carat main-box">

            <div class="row">
                <div class="col col-12 col-sm-12 col-md-6 col-lg-7">
                    <div class="product---slider">
                        <div class="product--slider" id="insert-loader">
                            @php
                            $i=0;
                            $image=($response['image']);
                            if(!empty($image)){
                                foreach(($response['image']) as $rv) {
                                    $i=$i+1;
                                    @endphp
                                    <div>
                                        <div class="item" data-hash="slide{{$i}}">
                                            <div class="carousel-slide-pic">
                                                <img src="/storage/diamond_images/{{ $rv }}" alt="{{ $rv }}">
                                            </div>
                                        </div>
                                    </div>
                                    @php
                                }
                            } else {
                                @endphp
                                <div>
                                    <div class="item" data-hash="slide2">
                                        <div class="carousel-slide-pic">
                                            <img src="/assets/images/No-Preview-Available.jpg" alt="No-Preview-Available">
                                        </div>
                                    </div>
                                </div>
                                @php
                            }
                            @endphp
                            @if($response['video_link'])
                            <div class="item" data-hash="slide{{ $i+1 }}">
                                <div class="carousel-slide-pic">
                                    <div class="slider-video">
                                        {{-- @if(strpos($response['video_link'], 'http') !== 0)
                                        <iframe width="100%" height="100%" src="http://{{ $response['video_link'] }}"></iframe>
                                        @else --}}
                                        <iframe width="100%" height="100%" src="" id="myframe"></iframe>
                                        <input id="iframe-src" type="hidden" value="/storage/diamond_videos/{{ $response['barcode'] . '/' . $response['barcode'] . '.html'}}">
                                        {{-- @endif --}}
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if ($certificate)
                            <div>
                                <div class="item" data-hash="slide{{ ++$i }}">
                                    <div class="carousel-slide-pic">
                                        <div class="align-items-center justify-content-center display-flex">
                                            <a href="{{ $certificate_url }}" target="_blank"> Click here to see certificate</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="product--slider-thumb">
                            @php
                            $i=0;
                            if(!empty($image)){
                                foreach(($response['image']) as $rv) {
                                    $i=$i+1;
                                    @endphp
                                    <div>
                                        <div class="thumb">
                                            <div class="thumb-pic">
                                                <img src="/storage/diamond_images/{{ $rv }}" alt="{{ $rv }}">
                                            </div>
                                        </div>
                                    </div>
                                    @php
                                }
                            } else {
                                @endphp
                                <div>
                                    <div class="thumb">
                                        <div class="thumb-pic">
                                            <img src="/assets/images/No-Preview-Available.jpg" alt="No-Preview-Available">
                                        </div>
                                    </div>
                                </div>
                                @php
                            }
                            @endphp
                            @if($response['video_link'])
                            <div>
                                <div class="thumb">
                                    <div class="thumb-pic">
                                        <i id="load-iframe" class="fa fa-play-circle" style="font-size: 70px"></i>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if ($certificate)
                            <div>
                                <div class="thumb">
                                    <div class="thumb-pic">
                                        {{-- <img src="{{ $certificate_url }}" alt="Certificate"> --}}
                                        <a href="javascript:void(0);"> Certificate</a>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col col-12 col-sm-12 col-md-6 col-lg-5">
                    <div class="product--details">
                        <h3 class="title mb-3">{{ $response['expected_polish_cts'] . ' CARAT ' . $response['attributes']['SHAPE'] }} Lab grown diamond</h3>
                        <div class="mb-4 mt-4">
                            <table class="table mini-table overflow-auto">
                                <tbody>
                                    <tr>
                                        <td colspan="2" align="center">
                                            <div class="text-uppercase" style="font-size: 17px;">
                                                Category: {{ ucwords(str_replace('-', ' ', $response['category'])) }}
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="50%">CARAT: {{ $response['expected_polish_cts'] }}</td>
                                        <td width="50%">COLOR: {{ $response['attributes']['COLOR'] }}</td>
                                    </tr>
                                    <tr>
                                        <td width="50%">CLARITY: {{ $response['attributes']['CLARITY'] }}</td>
                                        <td width="50%">CUT: {{ $response['attributes']['CUT'] ?? '-'}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <p class="price">${{number_format(round($response['total'], 2), 2, '.', ',')}} </p>
                        {{-- @if ($response['available_pcs'] == 1)
                        <p><span class="me-2"><img src="{{ asset(check_host().'assets/images') }}/Star.svg" class="img-fluid"></span>Only One Available</p>
                        @endif --}}
                        <div class="cart-buy-btn">
                            <button class="btn btn-primary add-to-cart" data-id="{{$response['diamond_id']}}">Add To Cart</button>
                            <button class="btn btn-primary" id="buy-now" data-id="{{$response['diamond_id']}}">Buy Now</button>
                            <a href="Javascript:;" class="btn like add-to-wishlist" data-id="{{$response['diamond_id']}}"><img src="{{ asset(check_host().'assets/images') }}/heart.svg" class="img-fluid"></a>
                        </div>
                        {{-- <div class="mail-phone">
                            <div class="mail me-auto d-flex align-items-center"><span><img src="{{ asset(check_host().'assets/images') }}/envelope.svg" class="img-fluid"></span><a href="mailto:">Emails Us</a></div>
                            <div class="phone d-flex align-items-center"><span><img src="{{ asset(check_host().'assets/images') }}/phone.svg" class="img-fluid"></span><a href="tel:">1234567890</a></div>
                        </div> --}}
                        <div class="help-box mb-4">
                            <table class="table mini-table-2 text-center overflow-auto">
                                <tbody>
                                    <tr>
                                        <td colspan="3" align="center">
                                            <div class="text-center p-2">
                                                NEED HELP?
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="34%"><span><img src="/assets/images/whatsapp_n.svg" class="img-cs"></span> &nbsp;WHATSAPP</td>
                                        <td width="33%"><span><img src="/assets/images/envelope.svg" class="img-cs"></span> &nbsp;EMAIL US</td>
                                        <td width="33%"><span><img src="/assets/images/phone.svg" class="" style="width: 16px;"></span> &nbsp;CALL</td>
                                    </tr>
                                    <tr>
                                        <td width="34%"><div class=""><a href="https://api.whatsapp.com/send?phone=1234567890" target="_blank"> +919714405421</a></div></td>
                                        <td width="33%"><div class=""><a href="mailto:sales@janvilgd.com">sales@janvilgd.com</a></div></td>
                                        <td width="33%"><div class=""><a href="tel+919714405421:">+91-9714405421</a></div></td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                        {{-- <div class="return-policy d-flex">
                            <img src="{{ asset(check_host().'assets/images') }}/delivery.svg" class="img-fluid me-2">
                            <p>Free Shipping, Free 30 Day Returns</p>
                        </div>
                        <div class="order-shiped d-flex align-items-baseline">
                            <img src="{{ asset(check_host().'assets/images') }}/book_calendar.svg" class="img-fluid me-2">
                            <p>Order loose diamond and your order ships by <br><span>{{ date(' dS F Y, l', strtotime(date('Y-m-d H:i:s') . ' + 15 days')) }}</span></p>
                        </div> --}}

                    </div>
                </div>
            </div>
            @if ($response['category'] == 'polish-diamonds')
            <div class="mt-5 overflow-auto">
                <table class="table detail-table table-responsive bg-white">
                    <tbody>
                        <tr>
                            <td>Stock No:</td>
                            <td>{{ $response['barcode'] }}</td>
                            <td>Depth:</td>
                            <td>{{ $response['attributes']['DEPTH PERCENT'] ?? '-'}}%</td>
                            <td>Rapaport Price/CT:</td>
                            <td>${{ number_format($response['rapaport_price'], 2, '.', ',') }}</td>
                        </tr>
                        <tr>
                            <td>Shape:</td>
                            <td>{{ $response['attributes']['SHAPE'] ?? '-'}}</td>
                            <td>Table:</td>
                            <td>{{ $response['attributes']['TABLE PERCENT'] ?? '-'}}%</td>
                            <td>Discount:</td>
                            <td>{{ $response['discount'] * 100 }}%</td>
                        </tr>
                        <tr>
                            <td>Carat:</td>
                            <td>{{ $response['expected_polish_cts'] }}</td>
                            <td>Girdle Condition:</td>
                            <td>{{ $response['attributes']['GRIDLE CONDITION'] ?? '-'}}</td>
                            <td>Price/CT:</td>
                            <td>${{ number_format($response['price_ct'], 2, '.', ',') }}</td>
                        </tr>
                        <tr>
                            <td>Color:</td>
                            <td>{{ $response['attributes']['COLOR'] ?? '-'}}</td>
                            <td>Culet:</td>
                            <td>{{ $response['attributes']['CULET SIZE'] ?? '-'}}</td>
                            <td>Price:</td>
                            <td>${{ number_format($response['total'], 2, '.', ',') }}</td>
                        </tr>
                        <tr>
                            <td>Clarity:</td>
                            <td>{{ $response['attributes']['CLARITY'] ?? '-'}}</td>
                            <td>Measurements:</td>
                            <td>{{ $response['attributes']['MEASUREMENTS'] ?? '-'}}</td>
                            <td rowspan="4">Comment:</td>
                            <td rowspan="4">{{ $response['attributes']['COMMENT'] ?? '-'}}</td>
                        </tr>
                        <tr>
                            <td>Cut Grade:</td>
                            <td>{{ $response['attributes']['CUT'] ?? '-'}}</td>
                            <td>Flourescence:</td>
                            <td>{{ $response['attributes']['FLOURESCENCE'] ?? 'None'}}</td>
                        </tr>
                        <tr>
                            <td>Polish:</td>
                            <td>{{ $response['attributes']['POLISH'] ?? '-'}}</td>
                            <td>Growth Type:</td>
                            <td>{{ $response['attributes']['GROWTH TYPE'] ?? '-'}}</td>
                        </tr>
                        <tr>
                            <td>Symmetry:</td>
                            <td>{{ $response['attributes']['SYMMETRY'] ?? '-'}}</td>
                            <td>Location:</td>
                            <td>{{ $response['attributes']['LOCATION'] ?? '-'}}</td>
                        </tr>
                    </tbody>
                </table>
                <div class="mt-3 bg-white p1r">
                    <div class="row">
                        <div class="col-md-4">
                            Certified By: {{ $response['attributes']['LAB'] ?? '-'}}
                        </div>
                        <div class="col-md-4">
                            Certificate No: {{ $response['attributes']['CERTIFICATE'] }}
                        </div>
                        <div class="col-md-4">
                            <span><img src="/assets/images/certificate.svg" style="height: 20px;"></span>
                            <a href="{{ $response['attributes']['CERTIFICATE URL'] ?? 'javascript:void(0);' }}" target="_blank">View Diamond Report</a>
                        </div>
                    </div>
                </div>
            </div>
            @elseif ($response['category'] == '4p-diamonds')
            <div class="mt-5 overflow-auto">
                <table class="table detail-table table-responsive bg-white">
                    <tbody>
                        <tr>
                            <td>Stock No:</td>
                            <td>{{ $response['barcode'] }}</td>
                            <td>4P Weight CTS:</td>
                            <td>{{ $response['makable_cts'] }}</td>
                            <td>Rapaport Price/CT:</td>
                            <td>${{ number_format($response['rapaport_price'], 2, '.', ',') }}</td>
                        </tr>
                        <tr>
                            <td>Shape:</td>
                            <td>{{ $response['attributes']['SHAPE'] ?? '-'}}</td>
                            <td>Exp Polish CTS:</td>
                            <td>{{ $response['expected_polish_cts'] }}</td>
                            <td>Discount:</td>
                            <td>{{ $response['discount'] * 100 }}%</td>
                        </tr>
                        <tr>
                            <td>Carat:</td>
                            <td>{{ $response['expected_polish_cts'] }}</td>
                            <td>Exp Polish Size:</td>
                            <td>{{ $response['attributes']['EXP POL SIZE'] ?? '-'}}</td>
                            @php
                                $labour_charge_4p = DB::table('labour_charges')->where('is_active', 1)->where('labour_charge_id', 1)->where('is_deleted', 0)->first();
                            @endphp
                            <td>Labour Charge/CT:</td>
                            <td>${{ number_format($labour_charge_4p->amount, 2, '.', ',') }}</td>
                        </tr>
                        <tr>
                            <td>Color:</td>
                            <td>{{ $response['attributes']['COLOR'] ?? '-'}}</td>
                            <td>HALF-CUT DIA:</td>
                            <td>{{ $response['attributes']['HALF-CUT DIA'] ?? '-'}}</td>
                            <td>Price/CT:</td>
                            <td>${{ number_format($response['price_ct'], 2, '.', ',') }}</td>
                        </tr>
                        <tr>
                            <td>Clarity:</td>
                            <td>{{ $response['attributes']['CLARITY'] ?? '-'}}</td>
                            <td>HALF-CUT HGT:</td>
                            <td>{{ $response['attributes']['HALF-CUT HGT'] ?? '-'}}</td>
                            <td>Price</td>
                            <td>${{ number_format($response['total'], 2, '.', ',') }}</td>
                        </tr>
                        <tr>
                            <td>Cut Grade:</td>
                            <td>{{ $response['attributes']['CUT'] ?? '-'}}</td>
                            <td>PO. DIAMETER:</td>
                            <td>{{ $response['attributes']['PO. DIAMETER'] ?? '-'}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            @else
            <div class="mt-5 overflow-auto">
                <table class="table detail-table table-responsive bg-white">
                    <tbody>
                        <tr>
                            <td>Stock No:</td>
                            <td>{{ $response['barcode'] }}</td>
                            <td>Rough Weight CTS:</td>
                            <td>{{ $response['makable_cts'] }}</td>
                        </tr>
                        <tr>
                            <td>Shape:</td>
                            <td>{{ $response['attributes']['SHAPE'] ?? '-'}}</td>
                            <td>Exp Polish CTS:</td>
                            <td>{{ $response['expected_polish_cts'] }}</td>
                        </tr>
                        <tr>
                            <td>Carat:</td>
                            <td>{{ $response['expected_polish_cts'] }}</td>
                            <td>Rapaport Price/CT:</td>
                            <td>${{ number_format($response['rapaport_price'], 2, '.', ',') }}</td>
                        </tr>
                        <tr>
                            <td>Color:</td>
                            <td>{{ $response['attributes']['COLOR'] ?? '-'}}</td>
                            <td>Discount:</td>
                            <td>{{ $response['discount'] * 100 }}%</td>
                        </tr>
                        <tr>
                            <td>Clarity:</td>
                            <td>{{ $response['attributes']['CLARITY'] ?? '-'}}</td>
                            @php
                                $labour_charge_rough = DB::table('labour_charges')->where('is_active', 1)->where('labour_charge_id', 2)->where('is_deleted', 0)->first();
                            @endphp
                            <td>Labour Charge (${{ $labour_charge_rough->amount }}/CT):</td>
                            <td>${{ number_format(($labour_charge_rough->amount * $response['makable_cts']), 2, '.', ',') }}</td>
                        </tr>
                        <tr>
                            <td>Location:</td>
                            <td>{{ $response['attributes']['LOCATION'] ?? '-'}}</td>
                            <td>Price/CT:</td>
                            <td>${{ number_format($response['price_ct'], 2, '.', ',') }}</td>
                        </tr>
                        <tr>
                            <td>Comment</td>
                            <td>{{ $response['attributes']['COMMENT'] ?? '-'}}</td>
                            <td>Price</td>
                            <td>${{ number_format($response['total'], 2, '.', ',') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            @endif
        </div>
        @endif

        @if (count($similar))
        <div class="similar-diamonds-box">
            <h4 class="mb-4">Similar Diamonds</h4>
            <div class="row">
                @php
                if (count($similar) > 4) {
                    echo '<div class="owl-carousel-1">';
                    $cols = '';
                } else {
                    $cols = 'col col-12 col-sm-6 col-md-3';
                }
                @endphp
                    @foreach ($similar as $r)
                    <div class="{{ $cols }} mb-3">
                        <div class="card">
                            <div class="card-body- p-1 text-center">
                                <div class=" mb-2">
                                    <a href="/customer/single-diamonds/{{$r['_source']['barcode']}}">
                                        <img src="{{ count($r['_source']['image']) ? '/storage/diamond_images/'.$r['_source']['image'][0] : '/assets/images/No-Preview-Available.jpg' }}" alt="Diamond" class="w-100">
                                    </a>
                                </div>
                                <h5>{{ $r['_source']['expected_polish_cts'] . ' CT ' .  $r['_source']['attributes']['SHAPE'] . ' DIAMOND' }}</h5>
                                <small class="">{{ $r['_source']['attributes']['COLOR'] . ' Color • ' .  $r['_source']['attributes']['CLARITY'] . ' Clarity' }}</small>
                                <div class="mt-2"><h5><b>${{ number_format($r['_source']['total'], 2, '.', ',') }} USD</b></h5></div>
                                <a href="/customer/single-diamonds/{{$r['_source']['barcode']}}" class="btn btn-primary w-100">VIEW DIAMOND</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @if (count($similar) > 4)
                </div>
                @endif
            </div>
        </div>
        @endif
        @if (count($recommended))
        <div class="recommended-diamonds-box">
            <h4 class="mb-4">Recommended Diamonds</h4>
            <div class="row">
                @php
                if (count($recommended) > 4) {
                    echo '<div class="owl-carousel-2">';
                    $cols = '';
                } else {
                    $cols = 'col col-12 col-sm-6 col-md-3';
                }
                @endphp
                    @foreach ($recommended as $r)
                    <div class="{{ $cols }} mb-3">
                        <div class="card">
                            <div class="card-body- p-1 text-center">
                                <div class="mb-2">
                                    <a href="/customer/single-diamonds/{{$r['_source']['barcode']}}">
                                        <img src="{{ count($r['_source']['image']) ? '/storage/diamond_images/'.$r['_source']['image'][0] : '/assets/images/No-Preview-Available.jpg' }}" alt="Diamond" class="w-100">
                                    </a>
                                </div>
                                <h5>{{ $r['_source']['expected_polish_cts'] . ' CT ' .  $r['_source']['attributes']['SHAPE'] . ' DIAMOND' }}</h5>
                                <small class="">{{ $r['_source']['attributes']['COLOR'] . ' Color • ' .  $r['_source']['attributes']['CLARITY'] . ' Clarity' }}</small>
                                <div class="mt-2"><h5><b>${{ number_format($r['_source']['total'], 2, '.', ',') }} USD</b></h5></div>
                                <a href="/customer/single-diamonds/{{$r['_source']['barcode']}}" class="btn btn-primary w-100">VIEW DIAMOND</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @if (count($recommended) > 4)
                </div>
                @endif
            </div>
        </div>
        @endif
    </section>
    @endsection
    @section('js')
    <script src="/assets/owlcarousel/owl.carousel.min.js"></script>
    <script type="text/javascript">
        var cnt_similar = @php echo count($similar); @endphp;
        if (cnt_similar > 4) {
            var owl_1 = $('.owl-carousel-1');
            owl_1.owlCarousel({
                items:4,
                loop:true,
                margin:25,
                autoplay:true,
                autoplayTimeout:3000,
                autoplayHoverPause:true
            });
        }
        var cnt_recommended = @php echo count($recommended); @endphp;
        if (cnt_recommended > 4) {
            var owl_2 = $('.owl-carousel-2');
            owl_2.owlCarousel({
                items:4,
                loop:true,
                margin:25,
                autoplay:true,
                autoplayTimeout:3000,
                autoplayHoverPause:true
            });
        }
        $(document).on('click', '.add-to-cart, #buy-now', function () {
			var self = $(this);
			var diamond_id = self.data('id');
			var data = {
				'diamond_id': diamond_id
			};
			$.ajax({
                beforeSend: function () {
                    $('.cs-loader').show();
                },
				type: "POST",
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				url: "{{ route('add-to-cart') }}",
				data: data,
                context: this,
				success: function (res) {
					if (res.suceess) {
                        if ($(this).attr('id') == 'buy-now') {
                            location.href = '/customer/cart';
                        } else {
                            $('.cs-loader').hide();
                            $.toast({
                                heading: 'Success',
                                text: 'Diamond added in cart.',
                                icon: 'success',
                                position: 'top-right'
                            });
                            $('#global_cart_count').attr('data-badge', parseInt($('#global_cart_count').attr('data-badge'))+1);
                        }
					}else{
						$.toast({
							heading: 'Error',
							text: res.message,
							icon: 'error',
							position: 'top-right'
						});
					}
				}
			});
		});
        $(document).on('click', '#load-iframe', function () {
            if ($('iframe').attr('src') == '') {
                $('.cs-loader-video').show();
                $('iframe').attr('src', $('#iframe-src').val());
            }
        });
        document.getElementById('myframe').onload = function() {
            $('.cs-loader-video').hide();
        };
        window.onload = function () {
            setTimeout(() => {
                $('#insert-loader').prepend('<div class="overlay cs-loader-video"> <div class="overlay__inner"> <div class="overlay__content"><img src="/assets/images/Janvi_Akashs_Logo_Loader_2.gif"></div> </div> </div>');
            }, 1000);
        }
    </script>
    @endsection

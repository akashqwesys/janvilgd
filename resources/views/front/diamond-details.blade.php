@extends('front.layout_2')
@section('title', $title)
@section('css')
@endsection
@section('content')
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
                if($row['ag_name']=="COLOR"){
                    $color=$row['at_name'];
                }
                if($row['ag_name']=="EXP POL SIZE"){
                    $size=$row['at_name'];
                }
                if($row['ag_name']=="CUT GRADE"){
                    $cut=$row['at_name'];
                }
                if($row['ag_name']=="CLARITY" || $row['ag_name']=="PURITY"){
                    $clarity=$row['at_name'];
                }
                if($row['ag_name']=="CERTIFICATE"){
                    $certificate=$row['at_name'];
                }
                if($row['ag_name']=="CERTIFICATE URL"){
                    $certificate_url=$row['at_name'];
                }
            }
        }
        @endphp
        <div class="diamond-carat main-box">

            <div class="row">
                <div class="col col-12 col-sm-12 col-md-6 col-lg-7">
                    <div class="product---slider">
                        <div class="product--slider">
                            @if($response['video_link'])
                            <div class="item" data-hash="slide1">
                                <div class="carousel-slide-pic">
                                    <div class="slider-video">
                                        @if(strpos($response['video_link'], 'http') !== 0)
                                            <iframe width="100%" height="100%" src="http://{{ $response['video_link'] }}"></iframe>
                                        @else
                                            <iframe width="100%" height="100%" src="{{ $response['video_link'] }}"></iframe>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endif
                            @php
                                $i=1;
                                $image=($response['image']);
                                if(!empty($image)){
                                    foreach(($response['image']) as $rv) {
                                    $i=$i+1;
                            @endphp
                                <div>
                                    <div class="item" data-hash="slide{{$i}}">
                                        <div class="carousel-slide-pic">
                                            <img src="{{ $rv }}" alt="{{ $rv }}">
                                        </div>
                                    </div>
                                </div>
                            @php
                                    }
                                }
                            @endphp
                            @if ($certificate)
                                <div>
                                    <div class="item" data-hash="slide{{ ++$i }}">
                                        <div class="carousel-slide-pic">
                                            <img src="{{ $certificate_url }}" alt="Certificate">
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="product--slider-thumb">
                            @if($response['video_link'])
                            <div>
                                <div class="thumb">
                                    <div class="thumb-pic">
                                        <i class="fa fa-play-circle" style="font-size: 70px"></i>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @php
                                $i=0;
                                if(!empty($image)){
                                    foreach(($response['image']) as $rv) {
                                    $i=$i+1;
                            @endphp
                                    <div>
                                        <div class="thumb">
                                            <div class="thumb-pic">
                                                <img src="{{ $rv }}" alt="{{ $rv }}">
                                            </div>
                                        </div>
                                    </div>
                            @php
                                    }
                                }
                            @endphp
                            @if ($certificate)
                                <div>
                                    <div class="thumb">
                                        <div class="thumb-pic">
                                            <img src="{{ $certificate_url }}" alt="Certificate">
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col col-12 col-sm-12 col-md-6 col-lg-5">
                    <div class="product--details">
                        <h3 class="title">{{$response['diamond_name']}}</h3>
                        <p>&nbsp;</p>
                        <!--<p>Ideal Cut • I Color • SI1 Clarity</p>-->
                        <p class="price">${{number_format(round($response['total'], 2), 2, '.', ',')}}</p>
                        <p><span class="me-2"><img src="{{ asset(check_host().'assets/images') }}/Star.svg" class="img-fluid"></span>Only One Available</p>
                        <div class="cart-buy-btn">
                            <button class="btn btn-primary add-to-cart" data-id="{{$response['diamond_id']}}">Add To Cart</button>
                            <a href="Javascript:;" class="btn btn-primary">Buy Now</a>
                            <a href="Javascript:;" class="btn like add-to-wishlist" data-id="{{$response['diamond_id']}}"><img src="{{ asset(check_host().'assets/images') }}/heart.svg" class="img-fluid"></a>
                        </div>
                        <div class="mail-phone">
                            <div class="mail me-auto d-flex align-items-center"><span><img src="{{ asset(check_host().'assets/images') }}/envelope.svg" class="img-fluid"></span><a href="mailto:">Emails Us</a></div>
                            <div class="phone d-flex align-items-center"><span><img src="{{ asset(check_host().'assets/images') }}/phone.svg" class="img-fluid"></span><a href="tel:">1234567890</a></div>
                        </div>
                        <div class="return-policy d-flex">
                            <img src="{{ asset(check_host().'assets/images') }}/delivery.svg" class="img-fluid me-2">
                            <p>Free Shipping, Free 30 Day Returns</p>
                        </div>
                        <div class="order-shiped d-flex align-items-baseline">
                            <img src="{{ asset(check_host().'assets/images') }}/book_calendar.svg" class="img-fluid me-2">
                            <p>Order loose diamond and your order ships by <br><span>Fri, Oct 15.</span></p>
                        </div>

                        <div class="product-details-collapse">
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item">
                                    <button class="accordion-button collapsed" id="headingOne" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Diamond Details</button>
                                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element.
                                        </div>
                                    </div>
                                </div>
                                @if ($certificate)
                                <div class="accordion-item">
                                    <button class="accordion-button collapsed" id="headingTwo" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Gia Certificate</button>
                                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <strong>Certificate No :</strong>{{$certificate}}<br>
                                            <strong>Certificate URL :</strong>{{$certificate_url}}
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <div class="four-diamond-content main-box">
            <h2 class="text-center"><img class="img-fluid title-diamond_img" src="{{ asset(check_host().'assets/images') }}/title-diamond.svg" alt=""> The Four C’s of Your Diamond</h2>
            <div class="row">
                <div class="col col-12 col-sm-12 col-md-6">
                    <div class="about-four_c">
                        <h6 class="title">Diamond Size: {{$response['carat']}} Ct</h6>
                        <p class="description">The carat is the unit of weight of a diamond. Carat is often confused with size even though it is actually a measure of weight. One carat equals 200 milligrams or 0.2 grams. The scale below illustrates the typical size relationship between diamonds of increasing carat weights. Remember that while the measurements below are typical, every diamond is unique.</p>
                        <div class="video-link d-flex align-items-center">
                            <img src="{{ asset(check_host().'assets/images') }}/viedo-recorder.svg" alt="video-link" class="img-fluid me-2">
                            <a href="Javascript:;">Watch video</a>
                        </div>
                        <div class="diamond-image">
                            <img src="{{ asset(check_host().'assets/images') }}/Hero-Carat-Weight.png" alt="diamond-fireframe" class="img-fluid">
                        </div>
                    </div>
                </div>
                <div class="col col-12 col-sm-12 col-md-6">
                    <div class="about-four_c">
                        <h6 class="title">Cut: {{ $response['category'] == 'rough-diamonds' ? 'As per your requirement' : $cut }}</h6>
                        <p class="description">The carat is the unit of weight of a diamond. Carat is often confused with size even though it is actually a measure of weight. One carat equals 200 milligrams or 0.2 grams. The scale below illustrates the typical size relationship between diamonds of increasing carat weights. Remember that while the measurements below are typical, every diamond is unique.</p>
                        <div class="video-link d-flex align-items-center">
                            <img src="{{ asset(check_host().'assets/images') }}/viedo-recorder.svg" alt="video-link" class="img-fluid me-2">
                            <a href="Javascript:;">Watch video</a>
                        </div>
                        <div class="diamond-image">
                            <img src="{{ asset(check_host().'assets/images') }}/most-expensive-diamond-cut-grades.png" alt="diamond-fireframe" class="img-fluid">
                        </div>
                    </div>
                </div>
                <div class="col col-12 col-sm-12 col-md-6">
                    <div class="about-four_c">
                        <h6 class="title">Color: {{$color}}</h6>
                        <p class="description">The carat is the unit of weight of a diamond. Carat is often confused with size even though it is actually a measure of weight. One carat equals 200 milligrams or 0.2 grams. The scale below illustrates the typical size relationship between diamonds of increasing carat weights. Remember that while the measurements below are typical, every diamond is unique.</p>
                        <div class="video-link d-flex align-items-center">
                            <img src="{{ asset(check_host().'assets/images') }}/viedo-recorder.svg" alt="video-link" class="img-fluid me-2">
                            <a href="Javascript:;">Watch video</a>
                        </div>
                        <div class="diamond-image">
                            <img src="{{ asset(check_host().'assets/images') }}/diamond_color_scale.jpg" alt="diamond-fireframe" class="img-fluid">
                        </div>
                    </div>
                </div>
                <div class="col col-12 col-sm-12 col-md-6">
                    <div class="about-four_c">
                        <h6 class="title">Clarity: {{$clarity}}</h6>
                        <p class="description">The carat is the unit of weight of a diamond. Carat is often confused with size even though it is actually a measure of weight. One carat equals 200 milligrams or 0.2 grams. The scale below illustrates the typical size relationship between diamonds of increasing carat weights. Remember that while the measurements below are typical, every diamond is unique.</p>
                        <div class="video-link d-flex align-items-center">
                            <img src="{{ asset(check_host().'assets/images') }}/viedo-recorder.svg" alt="video-link" class="img-fluid me-2">
                            <a href="Javascript:;">Watch video</a>
                        </div>
                        <div class="diamond-image">
                            <img src="{{ asset(check_host().'assets/images') }}/Diamond_Clarity.png" alt="diamond-fireframe" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="order-details-content main-box">
            <h2 class="text-center"><img class="img-fluid title-diamond_img" src="{{ asset(check_host().'assets/images') }}/title-diamond.svg" alt=""> Order Details</h2>
            <div class="row">
                <div class="col col-12 col-sm-12 col-md-6 mb-4 mb-md-0">
                    <div class="order-image text-center">
                        <img src="{{ asset(check_host().'assets/images') }}/order_product-img.png" alt="order-image" class="img-fluid">
                    </div>
                </div>
                <div class="col col-12 col-sm-12 col-md-6">
                    <div class="order-details">
                        <div class="accordion" id="accordionExample1">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Your order includes</button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample1">
                                    <div class="accordion-body">
                                        <strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Estimates ships by:
                                        <span>{{ date(' dS F Y, l', strtotime(date('Y-m-d H:i:s') . ' + 15 days')) }}</span></button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample1">
                                    <div class="accordion-body">
                                        <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingthree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsethree" aria-expanded="false" aria-controls="collapsethree">Payment</button>
                                </h2>
                                <div id="collapsethree" class="accordion-collapse collapse" aria-labelledby="headingthree" data-bs-parent="#accordionExample1">
                                    <div class="accordion-body">
                                        <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="compare-diamonds-content main-box">
                        <h2 class="title"><img class="img-fluid title-diamond_img" src="{{ asset(check_host().'assets/images') }}/title-diamond.svg" alt=""> Compare with Similar diamonds</h2>
                        <div class="compare-diamonds-table">
                                        <table class="table">
                                                        <thead>
                                                                        <tr>
                                                                                        <th scope="col" class="text-center"></th>
                                                                                        <th scope="col" class="text-center">Diamond-1</th>
                                                                                        <th scope="col" class="text-center">Diamond-2</th>
                                                                                        <th scope="col" class="text-center">Diamond-3</th>
                                                                                        <th scope="col" class="text-center">Diamond-4</th>
                                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                                        <tr>
                                                                                        <td scope="col"></td>
                                                                                        <td scope="col" class="text-center"><div class="diamond-image"><img src="{{ asset(check_host().'assets/images') }}/MRCYVCDV.png" class="img-fluid"></div></td>
                                                                                        <td scope="col" class="text-center"><div class="diamond-image"><img src="{{ asset(check_host().'assets/images') }}/MRCYVCDV.png" class="img-fluid"></div></td>
                                                                                        <td scope="col" class="text-center"><div class="diamond-image"><img src="{{ asset(check_host().'assets/images') }}/MRCYVCDV.png" class="img-fluid"></div></td>
                                                                                        <td scope="col" class="text-center"><div class="diamond-image"><img src="{{ asset(check_host().'assets/images') }}/MRCYVCDV.png" class="img-fluid"></div></td>
                                                                        </tr>
                                                                        <tr>
                                                                                        <td scope="col" class="text-center"><h6>Price</h6></td>
                                                                                        <td scope="col" class="text-center"><p>$500</p></td>
                                                                                        <td scope="col" class="text-center"><p>$500</p></td>
                                                                                        <td scope="col" class="text-center"><p>$500</p></td>
                                                                                        <td scope="col" class="text-center"><p>$500</p></td>
                                                                        </tr>
                                                                        <tr>
                                                                                        <td scope="col" class="text-center"><h6>Shape</h6></td>
                                                                                        <td scope="col" class="text-center"><p>Round</p></td>
                                                                                        <td scope="col" class="text-center"><p>Round</p></td>
                                                                                        <td scope="col" class="text-center"><p>Round</p></td>
                                                                                        <td scope="col" class="text-center"><p>Round</p></td>
                                                                        </tr>
                                                                        <tr>
                                                                                        <td scope="col" class="text-center"><h6>Cut</h6></td>
                                                                                        <td scope="col" class="text-center"><p>$500</p></td>
                                                                                        <td scope="col" class="text-center"><p>$500</p></td>
                                                                                        <td scope="col" class="text-center"><p>$500</p></td>
                                                                                        <td scope="col" class="text-center"><p>$500</p></td>
                                                                        </tr>
                                                                        <tr>
                                                                                        <td scope="col" class="text-center"><h6>Clarity</h6></td>
                                                                                        <td scope="col" class="text-center"><p>Round</p></td>
                                                                                        <td scope="col" class="text-center"><p>Round</p></td>
                                                                                        <td scope="col" class="text-center"><p>Round</p></td>
                                                                                        <td scope="col" class="text-center"><p>Round</p></td>
                                                                        </tr>
                                                                        <tr>
                                                                                        <td scope="col" class="text-center"><h6>Color</h6></td>
                                                                                        <td scope="col" class="text-center"><p>$500</p></td>
                                                                                        <td scope="col" class="text-center"><p>$500</p></td>
                                                                                        <td scope="col" class="text-center"><p>$500</p></td>
                                                                                        <td scope="col" class="text-center"><p>$500</p></td>
                                                                        </tr>
                                                                        <tr>
                                                                                        <td scope="col" class="text-center"><h6>Carat</h6></td>
                                                                                        <td scope="col" class="text-center"><p>Round</p></td>
                                                                                        <td scope="col" class="text-center"><p>Round</p></td>
                                                                                        <td scope="col" class="text-center"><p>Round</p></td>
                                                                                        <td scope="col" class="text-center"><p>Round</p></td>
                                                                        </tr>
                                                        </tbody>
                                        </table>
                        </div>
        </div> -->
    </div>
</section>
@endsection
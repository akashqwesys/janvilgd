@extends('front.layout_2')
@section('title', $title)
@section('css')
@endsection
@section('content')
<section class="diamond-info-section" style="padding-top: 130px;">
    <div class="container">
        <div class="diamond-carat main-box">
            <div class="row">
                <div class="col col-12 col-sm-12 col-md-6 col-lg-7">
                    <div class="product---slider">
                        <div class="product--slider">
                            @php
                            $i=0;
                            foreach(json_decode($response->image) as $rv) {
                            $i=$i+1;
                            @endphp
                            <div>
                                <div class="item" data-hash="slide{{$i}}">
                                    <div class="carousel-slide-pic">
                                        <img src="{{ asset(check_host().'images') }}<?php echo '/' . $rv; ?>" alt="{{ $rv }}">
                                    </div>
                                </div>
                            </div>  
                            @php
                            }
                            @endphp
                        </div>
                        <div class="product--slider-thumb">
                            @php
                            $i=0;
                            foreach(json_decode($response->image) as $rv) {
                            $i=$i+1;
                            @endphp
                            <div>
                                <div class="thumb">
                                    <div class="thumb-pic">
                                        <img src="{{ asset(check_host().'images') }}<?php echo '/' . $rv; ?>" alt="{{ $rv }}">
                                    </div>
                                </div>
                            </div>
                            @php
                            }
                            @endphp                        
                        </div>
                    </div>
                </div>
                <div class="col col-12 col-sm-12 col-md-6 col-lg-5">
                    <div class="product--details">
                        <h3 class="title">{{$response->diamond_name}}</h3>
                        <p>Ideal Cut • I Color • SI1 Clarity</p>
                        <p class="price">{{$response->total}}$</p>
                        <p><span class="me-2"><img src="{{ asset(check_host().'assets/images') }}/Star.svg" class="img-fluid"></span>Only One Available</p>
                        <div class="cart-buy-btn">
                            <button class="btn btn-primary add-to-cart" data-id="{{$response->diamond_id}}">Add To Cart</button>
                            <a href="Javascript:;" class="btn btn-primary">Buy Now</a>
                            <a href="Javascript:;" class="btn like"><img src="{{ asset(check_host().'assets/images') }}/heart.svg" class="img-fluid"></a>
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
                                <div class="accordion-item">
                                    <button class="accordion-button collapsed" id="headingTwo" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Gia Certificate</button>
                                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
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
        </div>
        <div class="four-diamond-content main-box">
            <h2 class="text-center"><img class="img-fluid title-diamond_img" src="{{ asset(check_host().'assets/images') }}/title-diamond.svg" alt=""> The Four C’s of Your Diamond</h2>
            <div class="row">
                <div class="col col-12 col-sm-12 col-md-6">
                    <div class="about-four_c">
                        <h6 class="title">Diamond Size: 0.50 Ct</h6>
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
                        <h6 class="title">Cut: Ideal</h6>
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
                        <h6 class="title">Color: J</h6>
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
                        <h6 class="title">Clarity: SI1</h6>
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
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Estimates ships by: <span>20 june, Friday</span></button>
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
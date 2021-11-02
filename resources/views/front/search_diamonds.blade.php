<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="og:type" content="website" />
	<meta name="twitter:card" content="photo" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }}</title>

	<link rel="icon" type="image/png" sizes="32x32" href="/assets/images/favicon-icon.png">

	<link rel="stylesheet" type="text/css" href="/assets/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/assets/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="/assets/css/slick.css">
	<link rel="stylesheet" type="text/css" href="/assets/css/rSlider.min.css">
    <link rel="stylesheet" href="{{ asset(check_host().'admin_assets/toast/jquery.toast.css') }}">
    <script src="/assets/js/rSlider.min.js"></script>
	<link rel="stylesheet" type="text/css" href="/assets/css/style.css">
    <script src="/assets/js/jquery-3.6.0.min.js"></script>
    <script type="text/javascript">
        $(document).on('click', '.diamond-shape .item img', function () {
            var group_id = $(this).attr('data-group_id');
            if ($(this).attr('data-selected') == 1) {
                $(this).css('border', '4px solid #00000000');
                $(this).attr('data-selected', 0);
            } else {
                $(this).css('border', '4px solid #D2AB66');
                $(this).attr('data-selected', 1);
            }
            var values = [];
            $('.diamond-shape .item img').each(function(index, element) {
                if ($(this).attr('data-selected') == 1) {
                    values.push({'attribute_id': $(this).attr('data-attribute_id'), 'name': $(this).attr('data-name')});
                }
            });
            getAttributeValues(values, [], group_id);
        });

        function getAttributeValues(values, array, group_id) {
            $('.cs-loader').show();
            var selected_values = [];
            if (values.length > 1) {
                var strArray = values.split(",");
            }
            if (group_id != 'price' && group_id != 'carat' && array.length !== 0) {
                var first_index = array.map(function (e) {
                    return e.name;
                }).indexOf(strArray[0]);
                var last_index = array.map(function (e) {
                    return e.name;
                }).indexOf(strArray[1]);
                for (let i = first_index; i <= last_index; i++) {
                    selected_values.push(array[i]);
                }
            } else if (array.length === 0) {
                selected_values = values;
            } else {
                selected_values = strArray;
            }
            // console.log(selected_values);

            $.ajax({
                type: "post",
                url: "/api/search-diamonds",
                data: {'attribute_values': selected_values, 'group_id': group_id, 'web': 'web'},
                // cache: false,
                dataType: "json",
                success: function (response) {
                    $('.cs-loader').hide();
                    if (response.success == 1) {
                        $.toast({
                            heading: 'Success',
                            text: response.message,
                            icon: 'success',
                            position: 'top-right'
                        });
                        // return false;
                        $('#result-table tbody').html(response.data);
                    }
                    else {
                        $.toast({
                            heading: 'Error',
                            text: response.message,
                            icon: 'error',
                            position: 'top-right'
                        });
                    }
                },
                failure: function (response) {
                    $('.cs-loader').hide();
                    $.toast({
                        heading: 'Error',
                        text: 'Oops, something went wrong...!',
                        icon: 'error',
                        position: 'top-right'
                    });
                }
            });
        }
        $(document).on('click', '#result-table .diamond-checkbox', function() {
            $(this).attr('checked', true);
            $('#compare-table tbody').append('<tr>'+$(this).closest('tr').html()+'</tr>');
            $(this).closest('tr').remove();
        });
        $(document).on('click', '#compare-table .diamond-checkbox', function() {
            $('#result-table tbody').append('<tr>'+$(this).closest('tr').html()+'</tr>');
            $(this).closest('tr').remove();
        });
    </script>
    <style>
        /* CSS for input range sliders */
        .range-sliders {
            width: 100%;
        }
        .rs-container .rs-pointer::after, .rs-container .rs-pointer::before {
            content: unset;
        }
        .rs-container .rs-pointer {
            background-color: #D2AB66;
            border-radius: 50%;
            height: 18px;
            width: 18px;
            border: none;
            box-shadow: unset;
        }
        .rs-container .rs-bg, .rs-container .rs-selected {
            height: 7px;
            background-color: #fff;
        }
        .rs-container .rs-selected {
            background-color: #D2AB66;
            border: 1px solid #D2AB66;
        }
        .rs-tooltip {
            border: none;
        }

        .diamond-shape .item img {
            border: 4px solid #00000000;
        }
    </style>
</head>
<body>


    <section class="diamond-cut-section">
        <div class="container">
            <div class="main-box"><h2 class="text-center"><img class="img-fluid title-diamond_img" src="/assets/images/title-diamond.svg" alt=""> Search for Princess Cut Diamonds</h2></div>
            <div class="diamond-cut-filter">
                <div class="filter-content">
                    <div class="row">
                        {!! $html !!}
                    <div class="filter-toggle">
                        {!! $none_fix !!}
                    </div>
                </div>
                <div class="filter-btn text-center">
                    <a href="#" class="btn btn-primary" id="filter-toggle">Filters <i class="fas fa-chevron-up ms-2"></i></a>
                    <a href="#" class="btn reset-btn"><i class="fas fa-times me-2"></i> Reset Filters</a>
                </div>
            </div>
            <div class="search-diamond-view">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="result-tab" data-bs-toggle="tab" data-bs-target="#results" type="button" role="tab" aria-controls="results" aria-selected="true">Results </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="recently-viwed-tab" data-bs-toggle="tab" data-bs-target="#recently-viwed" type="button" role="tab" aria-controls="recently-viwed" aria-selected="false">Recently Viewed </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="comparision-tab" data-bs-toggle="tab" data-bs-target="#comparision" type="button" role="tab" aria-controls="comparision" aria-selected="false">Comparision </button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="results" role="tabpanel" aria-labelledby="result-tab">
                        <div class="result-tab-content">
                            <div class="row">
                                <div class="col col-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="selected-diamonds">
                                        <div class="select-diamond">
                                            <div class="diamond-img">
                                                <img src="/assets/images/Opalescentwhitediamond.png" class="img-fluid">
                                            </div>
                                            <h6 class="diamond-name">0.30 Carat Pear Diamond</h6>
                                            <p class="diamond-short-note">lorem Ipsum</p>
                                            <p class="diamond-cost">$456.00</p>
                                            <a href="diamond-details.php" class="btn btn-primary">View Diamond</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col col-12 col-sm-12 col-md-12 col-lg-9">
                                    <div class="search-diamond-table">
                                        <div class="table-responsive">
                                            <table class="table mb-0" id="result-table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" class="text-center">Carat</th>
                                                        <th scope="col" class="text-center">Price</th>
                                                        <th scope="col" class="text-center">Shape</th>
                                                        <th scope="col" class="text-center">Cut</th>
                                                        <th scope="col" class="text-center">Color</th>
                                                        <th scope="col" class="text-center">Clarity</th>
                                                        <th scope="col" class="text-center">Compare</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="recently-viwed" role="tabpanel" aria-labelledby="recently-viwed-tab">
                        <div class="result-tab-content">
                            <div class="row">
                                <div class="col col-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="selected-diamonds">
                                        <div class="select-diamond">
                                            <div class="diamond-img">
                                                <img src="/assets/images/Opalescentwhitediamond.png" class="img-fluid">
                                            </div>
                                            <h6 class="diamond-name">0.30 Carat Pear Diamond</h6>
                                            <p class="diamond-short-note">lorem Ipsum</p>
                                            <p class="diamond-cost">$456.00</p>
                                            <a href="#" class="btn btn-primary">View Diamond</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col col-12 col-sm-12 col-md-12 col-lg-9">
                                    <div class="search-diamond-table">
                                        <div class="table-responsive">
                                            <table class="table mb-0" id="recent-view">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" class="text-center">Shape</th>
                                                        <th scope="col" class="text-center">Price</th>
                                                        <th scope="col" class="text-center">Carat</th>
                                                        <th scope="col" class="text-center">Cut</th>
                                                        <th scope="col" class="text-center">Color</th>
                                                        <th scope="col" class="text-center">Clarity</th>
                                                        <th scope="col" class="text-center">Compare</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($recently_viewed as $rv)
                                                    <tr>
                                                        <td scope="col" class="text-center">{{ $rv->carat }}</td>
                                                        <td scope="col" class="text-center">{{ $rv->price }}</td>
                                                        <td scope="col" class="text-center">{{ $rv->shape }}</td>
                                                        <td scope="col" class="text-center">{{ $rv->cut }}</td>
                                                        <td scope="col" class="text-center">{{ $rv->color }}</td>
                                                        <td scope="col" class="text-center">{{ $rv->clarity }}</td>
                                                        <td scope="col" class="text-center">
                                                            <div class="compare-checkbox">
                                                                <label class="custom-check-box">
                                                                    <input type="checkbox" class="diamond-checkbox">
                                                                    <span class="checkmark"></span>
                                                                </label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="comparision" role="tabpanel" aria-labelledby="comparision-tab">
                        <div class="result-tab-content">
                            <div class="row">
                                <div class="col col-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="selected-diamonds">
                                        <div class="select-diamond">
                                            <div class="diamond-img">
                                                <img src="/assets/images/Opalescentwhitediamond.png" class="img-fluid">
                                            </div>
                                            <h6 class="diamond-name">0.30 Carat Pear Diamond</h6>
                                            <p class="diamond-short-note">lorem Ipsum</p>
                                            <p class="diamond-cost">$456.00</p>
                                            <a href="#" class="btn btn-primary">View Diamond</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col col-12 col-sm-12 col-md-12 col-lg-9">
                                    <div class="search-diamond-table">
                                        <div class="table-responsive">
                                            <table class="table mb-0" id="compare-table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" class="text-center">Shape</th>
                                                        <th scope="col" class="text-center">Price</th>
                                                        <th scope="col" class="text-center">Carat</th>
                                                        <th scope="col" class="text-center">Cut</th>
                                                        <th scope="col" class="text-center">Color</th>
                                                        <th scope="col" class="text-center">Clarity</th>
                                                        <th scope="col" class="text-center">Compare</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<div class="live-chat">
	<button class="live-chat-btn" onclick="openForm()">
		<img src="/assets/images/chat_conversation.svg" alt="chat-icon" class="chat-icon img-fluid">
	</button>

	<div class="chat-popup" id="myForm">
		<div class="chat-header">
			<a href="index.php"><img src="/assets/images/logo.png" class="img-fluid" alt="logo"></a>
			<button type="button" class="btn cancel" onclick="closeForm()"><img src="/assets/images/close.svg" alt="close" class="img-fluid"></button>
		</div>
		<div class="chat-body">
			<div class="chat-container">
				<div class="sender">
					<div class="chat-content">
						<p class="">ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
						tempor incididunt ut labore et dolore magna aliqua.</p>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>

<!-- site-footer -->

<footer class="site-footer">
	<div class="container">
		<div class="footer-form">
			<div class="d-flex align-items-center">
				<img src="/assets/images/envelope.svg" class="img-fluid"><p class="mb-0">Signup Newsletter</p></div>
				<form class="footer_form">
					<div class="input-group">
						<input type="email" class="form-control" placeholder="Enter your email" aria-label="Enter your email" aria-describedby="button-addon">
						<button class="btn btn-primary" type="button" id="button-addon">Subscribe</button>
					</div>
				</form>
			</div>
			<div class="footer-content">
				<div class="row">
					<div class="col col-12 col-sm-12 col-md-6 col-lg-3">
						<div class="quick-link-content">
							<h4 class="title">About Janvi</h4>
							<ul class="list-unstyled footer-link mb-0">
								<li class="item"><a href="about.php">About us</a></li>
								<li class="item"><a href="gallery.php">Gallery</a></li>
								<li class="item"><a href="media.php">Media</a></li>
								<li class="item"><a href="event.php">Events</a></li>
								<li class="item"><a href="business-policy.php">Business Policy</a></li>
								<li class="item"><a href="blog.php">Blogs</a></li>
							</ul>
						</div>
					</div>
					<div class="col col-12 col-sm-12 col-md-6 col-lg-3">
						<div class="quick-link-content">
							<h4 class="title">Information</h4>
							<ul class="list-unstyled footer-link mb-0">
								<li class="item"><a href="order-details.php">Order Details</a></li>
								<li class="item"><a href="privacy-policy.php"> Privacy Policy </a></li>
								<li class="item"><a href="terms-condition.php"> Terms & Conditions </a></li>
								<li class="item"><a href="Javascript:;">Support Now</a></li>
								<li class="item"><a href="manufacturing.php">Manufacturing</a></li>
								<li class="item"><a href="grading.php">Grading</a></li>
							</ul>
						</div>
					</div>
					<div class="col col-12 col-sm-12 col-md-6 col-lg-3">
						<div class="quick-link-content">
							<h4 class="title">My Account</h4>
							<ul class="list-unstyled footer-link mb-0">
								<li class="item"><a href="my-account.php">My Account</a></li>
								<li class="item"><a href="wishlist.php">Wishlist</a></li>
								<li class="item"><a href="checkout.php">Checkout</a></li>
								<li class="item"><a href="cart.php">Cart</a></li>
							</ul>
						</div>
					</div>
					<div class="col col-12 col-sm-12 col-md-6 col-lg-3">
						<div class="quick-link-content">
							<h4 class="title">Contact Us</h4>
							<div class="footer-info">
								<ul class="country_address_links">
									<li>
										<span class="flag-icon">
											<img src="/assets/images/india.png" alt="">
										</span>
										<span class="location">India</span>
										<div class="location-address">
											<div class="location_inner">
												<p class="add"><span>Address :</span>It is a long edad fg fact that a reader will be distr</p>
												<p class="mail"><span>Email :</span><a href="mailto:abc@gmail.com">abc@gmail.com</a></p>
												<p class="phone"><span>Phone No. :</span><a href="tel:+91 4567890923">+91 4567890923</a></p>
											</div>
										</div>
									</li>
									<li>
										<span class="flag-icon">
											<img src="/assets/images/usa.png" alt="">
										</span>
										<span class="location">USA</span>
										<div class="location-address">
											<div class="location_inner">
												<p class="add"><span>Address :</span>It is a long edad fg fact that a reader will be distr</p>
												<p class="mail"><span>Email :</span><a href="mailto:abc@gmail.com">abc@gmail.com</a></p>
												<p class="phone"><span>Phone No. :</span><a href="tel:+91 4567890923">+91 4567890923</a></p>
											</div>
										</div>
									</li>
								</ul>

								<p class="social-media-link"><span>Connect With :</span></p>
								<ul class="list-unstyled social-link mb-0">
									<li class="link-item"><a href="https://www.facebook.com/" target="_blank"><img src="/assets/images/facebook.svg" class="img-fluid"></a></li>
									<li class="link-item"><a href="https://www.instagram.com/" target="_blank"><img src="/assets/images/instagram.svg" class="img-fluid"></a></li>
									<li class="link-item"><a href="https://twitter.com/" target="_blank"><img src="/assets/images/twitter.svg" class="img-fluid"></a></li>
									<li class="link-item"><a href="https://www.youtube.com/" target="_blank"><img src="/assets/images/youtube.svg" class="img-fluid"></a></li>
									<li class="link-item"><a href="javascript:;" target="_blank"><img src="/assets/images/whatsapp.svg" class="img-fluid"></a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="copyright text-center">
			<p class="mb-0">Copyright © 2021 <a href="/">JANVI LGE</a>. All Rights Reserved.</p>
		</div>
	</div>
</footer>
<?php
$file = basename($_SERVER["SCRIPT_FILENAME"], '.php');
// echo $file;
?>
<script src="/assets/js/bootstrap.bundle.min.js"></script>
<script src="/assets/js/parallax.js"></script>
<script src="/assets/js/slick.min.js"></script>
<script src="/assets/js/custom.js"></script>
<script src="{{ asset(check_host().'admin_assets/toast/jquery.toast.js') }}"></script>
{{-- <script src="/assets/js/custom-rSlider.js"></script> --}}
</body>
</html>
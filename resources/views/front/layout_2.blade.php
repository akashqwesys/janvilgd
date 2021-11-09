<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="og:type" content="website" />
	<meta name="twitter:card" content="photo" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>

	<link rel="icon" type="image/png" sizes="32x32" href="/{{ check_host() }}assets/images/favicon-icon.png">

	<link rel="stylesheet" type="text/css" href="/{{ check_host() }}assets/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/{{ check_host() }}assets/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="/{{ check_host() }}assets/css/slick.css">
	<link rel="stylesheet" type="text/css" href="/{{ check_host() }}assets/css/rSlider.min.css">
    <link rel="stylesheet" href="{{ asset(check_host().'admin_assets/toast/jquery.toast.css') }}">
    <script src="/{{ check_host() }}assets/js/rSlider.min.js"></script>
	<link rel="stylesheet" type="text/css" href="/{{ check_host() }}assets/css/style.css">
	<link rel="stylesheet" type="text/css" href="/{{ check_host() }}assets/css/custom.css">
    <script src="/{{ check_host() }}assets/js/jquery-3.6.0.min.js"></script>
    @yield('css')
</head>
<body>
	<header class="header-style-2">
		<nav class="navbar navbar-expand-lg">
		  <div class="container">
		    <a class="navbar-brand" href="/"><img src="/{{ check_host() }}assets/images/logo.png" class="img-fluid"></a>
		   	<button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" aria-label="Toggle navigation">
				<img src="/{{ check_host() }}assets/images/menu-icon.svg">
			</button>
			<div class="navbar-collapse offcanvas-collapse offcanvas-style-2" id="navbarsExampleDefault">
				<div class="offcanvas-header">
					<button type="button" class="btn-close text-reset ms-auto" data-bs-dismiss="offcanvas" aria-label="Close"></button>
				</div>
				<div class="offcanvas-body">
					<ul class="navbar-nav">
						<li class="nav-item">
							<a class="nav-link active" href="/">Home</a>
						</li>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="about" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
								About Us
							</a>
							<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
								<li><a class="dropdown-item" href="gallery">Gallery</a></li>
								<li><a class="dropdown-item" href="media">Media</a></li>
							</ul>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="blog">Blog</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="contact">Contact</a>
						</li>
					</ul>
				</div>
			</div>
		    <ul class="header-icon-menu">
		      	<li><a class="nav-link active" href="/customer/search-diamonds"><img src="/{{ check_host() }}assets/images/theme_search.svg"></a></li>
		      	<li><a class="nav-link active" href="{{ route('get-cart') }}"><img src="/{{ check_host() }}assets/images/shopping-cart.svg"></a></li>
		      	<li><a class="nav-link active" href="/customer/wishlist"><img src="/{{ check_host() }}assets/images/theme_heart_icon.svg"></a></li>
		      	<li><a class="nav-link active" href="/customer/logout"><img src="/{{ check_host() }}assets/images/user.svg"></a></li>
		      </ul>
		  </div>
		</nav>
	</header>

	@yield('content')

	<div class="live-chat">
		<button class="live-chat-btn" onclick="openForm()">
			<img src="/{{ check_host() }}assets/images/chat_conversation.svg" alt="chat-icon" class="chat-icon img-fluid">
		</button>

		<div class="chat-popup" id="myForm">
			<div class="chat-header">
				<a href="index.php"><img src="/{{ check_host() }}assets/images/logo.png" class="img-fluid" alt="logo"></a>
				<button type="button" class="btn cancel" onclick="closeForm()"><img src="/{{ check_host() }}assets/images/close.svg" alt="close" class="img-fluid"></button>
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
				<img src="/{{ check_host() }}assets/images/envelope.svg" class="img-fluid" data-pagespeed-url-hash="650960932" onload="pagespeed.CriticalImages.checkImageForCriticality(this);"><p class="mb-0">Signup Newsletter</p></div>
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
								<li class="item"><a href="about-us">About us</a></li>
								<li class="item"><a href="gallery">Gallery</a></li>
								<li class="item"><a href="media">Media</a></li>
								<li class="item"><a href="events">Events</a></li>
								<li class="item"><a href="business-policy">Business Policy</a></li>
								<li class="item"><a href="blog">Blogs</a></li>
							</ul>
						</div>
					</div>
					<div class="col col-12 col-sm-12 col-md-6 col-lg-3">
						<div class="quick-link-content">
							<h4 class="title">Information</h4>
							<ul class="list-unstyled footer-link mb-0">
								<li class="item"><a href="order-details">Order Details</a></li>
								<li class="item"><a href="privacy-policy"> Privacy Policy </a></li>
								<li class="item"><a href="terms-conditions"> Terms & Conditions </a></li>
								<li class="item"><a href="Javascript:;">Support Now</a></li>
								<li class="item"><a href="manufacturing">Manufacturing</a></li>
								<li class="item"><a href="grading">Grading</a></li>
							</ul>
						</div>
					</div>
					<div class="col col-12 col-sm-12 col-md-6 col-lg-3">
						<div class="quick-link-content">
							<h4 class="title">My Account</h4>
							<ul class="list-unstyled footer-link mb-0">
								<li class="item"><a href="my-account">My Account</a></li>
								<li class="item"><a href="wishlist">Wishlist</a></li>
								<li class="item"><a href="checkout">Checkout</a></li>
								<li class="item"><a href="cart">Cart</a></li>
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
											<img src="/{{ check_host() }}assets/images/india.png" alt="" data-pagespeed-url-hash="4082821628" onload="pagespeed.CriticalImages.checkImageForCriticality(this);">
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
											<img src="/{{ check_host() }}assets/images/usa.png" alt="" data-pagespeed-url-hash="3750728368" onload="pagespeed.CriticalImages.checkImageForCriticality(this);">
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
									<li class="link-item"><a href="https://www.facebook.com/" target="_blank"><img src="/{{ check_host() }}assets/images/facebook.svg" class="img-fluid" data-pagespeed-url-hash="2544917430" onload="pagespeed.CriticalImages.checkImageForCriticality(this);"></a></li>
									<li class="link-item"><a href="https://www.instagram.com/" target="_blank"><img src="/{{ check_host() }}assets/images/instagram.svg" class="img-fluid" data-pagespeed-url-hash="126262214" onload="pagespeed.CriticalImages.checkImageForCriticality(this);"></a></li>
									<li class="link-item"><a href="https://twitter.com/" target="_blank"><img src="/{{ check_host() }}assets/images/twitter.svg" class="img-fluid" data-pagespeed-url-hash="1661735711" onload="pagespeed.CriticalImages.checkImageForCriticality(this);"></a></li>
									<li class="link-item"><a href="https://www.youtube.com/" target="_blank"><img src="/{{ check_host() }}assets/images/youtube.svg" class="img-fluid" data-pagespeed-url-hash="3510677315" onload="pagespeed.CriticalImages.checkImageForCriticality(this);"></a></li>
									<li class="link-item"><a href="javascript:;" target="_blank"><img src="/{{ check_host() }}assets/images/whatsapp.svg" class="img-fluid" data-pagespeed-url-hash="577652750" onload="pagespeed.CriticalImages.checkImageForCriticality(this);"></a></li>
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
<script src="/{{ check_host() }}assets/js/bootstrap.bundle.min.js"></script>
<script src="/{{ check_host() }}assets/js/parallax.js"></script>
<script src="/{{ check_host() }}assets/js/slick.min.js"></script>
<script src="/{{ check_host() }}assets/js/custom.js"></script>
<script src="{{ asset(check_host().'admin_assets/toast/jquery.toast.js') }}"></script>
{{-- <script src="/{{ check_host() }}assets/js/custom-rSlider.js"></script> --}}

<script type="text/javascript">
        $(document).ready(function () {
            $(document).on('click', '.add-to-cart', function () {
                var self = $(this);
                var diamond_id = self.data('id');
                var data = {
                    'diamond_id': diamond_id
                };
                $.ajax({
                    type: "POST",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "{{ route('add-to-cart') }}",
                    data: data,
                    success: function (res) {
                        if (res.suceess) {
                            $.toast({
                                    heading: 'Success',
                                    text: 'Diamond added in cart.',
                                    icon: 'success',
                                    position: 'top-right'
                            });
                        }else{
                            $.toast({
                                    heading: 'Error',
                                    text: 'Oops, something went wrong...!',
                                    icon: 'error',
                                    position: 'top-right'
                            });
                        }
                    }
                });
            });
                        
            $(document).on('click', '.removeFromCart', function () {
                var self = $(this);
                var diamond_id = self.data('id');               
                var data = {
                    'diamond_id': diamond_id                   
                };
                $.ajax({
                    type: "POST",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: "{{ route('remove-from-cart') }}",
                    data: data,
                    success: function (res) {
                        if (res.suceess) {   
                            $.toast({
                                    heading: 'Success',
                                    text: 'Diamond removed from cart.',
                                    icon: 'success',
                                    position: 'top-right'
                            });
                            $("#sub-total-td").text("$"+res.total);
                            $("#final-total-th").text("$"+res.total);
                            $("#diamond_"+diamond_id).remove();
                        }else{
                            $.toast({
                                    heading: 'Error',
                                    text: 'Oops, something went wrong...!',
                                    icon: 'error',
                                    position: 'top-right'
                            });
                        }    
                    }
                });
            });
        });
    </script>
@yield('js')
</body>
</html>
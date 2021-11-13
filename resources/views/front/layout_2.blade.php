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
                      <script data-pagespeed-no-defer>
			//<![CDATA[
				(function(){for(var g="function"==typeof Object.defineProperties?Object.defineProperty:function(b,c,a){if(a.get||a.set)throw new TypeError("ES3 does not support getters and setters.");b!=Array.prototype&&b!=Object.prototype&&(b[c]=a.value)},h="undefined"!=typeof window&&window===this?this:"undefined"!=typeof global&&null!=global?global:this,k=["String","prototype","repeat"],l=0;l<k.length-1;l++){var m=k[l];m in h||(h[m]={});h=h[m]}var n=k[k.length-1],p=h[n],q=p?p:function(b){var c;if(null==this)throw new TypeError("The 'this' value for String.prototype.repeat must not be null or undefined");c=this+"";if(0>b||1342177279<b)throw new RangeError("Invalid count value");b|=0;for(var a="";b;)if(b&1&&(a+=c),b>>>=1)c+=c;return a};q!=p&&null!=q&&g(h,n,{configurable:!0,writable:!0,value:q});var t=this;function u(b,c){var a=b.split("."),d=t;a[0]in d||!d.execScript||d.execScript("var "+a[0]);for(var e;a.length&&(e=a.shift());)a.length||void 0===c?d[e]?d=d[e]:d=d[e]={}:d[e]=c};function v(b){var c=b.length;if(0<c){for(var a=Array(c),d=0;d<c;d++)a[d]=b[d];return a}return[]};function w(b){var c=window;if(c.addEventListener)c.addEventListener("load",b,!1);else if(c.attachEvent)c.attachEvent("onload",b);else{var a=c.onload;c.onload=function(){b.call(this);a&&a.call(this)}}};var x;function y(b,c,a,d,e){this.h=b;this.j=c;this.l=a;this.f=e;this.g={height:window.innerHeight||document.documentElement.clientHeight||document.body.clientHeight,width:window.innerWidth||document.documentElement.clientWidth||document.body.clientWidth};this.i=d;this.b={};this.a=[];this.c={}}function z(b,c){var a,d,e=c.getAttribute("data-pagespeed-url-hash");if(a=e&&!(e in b.c))if(0>=c.offsetWidth&&0>=c.offsetHeight)a=!1;else{d=c.getBoundingClientRect();var f=document.body;a=d.top+("pageYOffset"in window?window.pageYOffset:(document.documentElement||f.parentNode||f).scrollTop);d=d.left+("pageXOffset"in window?window.pageXOffset:(document.documentElement||f.parentNode||f).scrollLeft);f=a.toString()+","+d;b.b.hasOwnProperty(f)?a=!1:(b.b[f]=!0,a=a<=b.g.height&&d<=b.g.width)}a&&(b.a.push(e),b.c[e]=!0)}y.prototype.checkImageForCriticality=function(b){b.getBoundingClientRect&&z(this,b)};u("pagespeed.CriticalImages.checkImageForCriticality",function(b){x.checkImageForCriticality(b)});u("pagespeed.CriticalImages.checkCriticalImages",function(){A(x)});function A(b){b.b={};for(var c=["IMG","INPUT"],a=[],d=0;d<c.length;++d)a=a.concat(v(document.getElementsByTagName(c[d])));if(a.length&&a[0].getBoundingClientRect){for(d=0;c=a[d];++d)z(b,c);a="oh="+b.l;b.f&&(a+="&n="+b.f);if(c=!!b.a.length)for(a+="&ci="+encodeURIComponent(b.a[0]),d=1;d<b.a.length;++d){var e=","+encodeURIComponent(b.a[d]);131072>=a.length+e.length&&(a+=e)}b.i&&(e="&rd="+encodeURIComponent(JSON.stringify(B())),131072>=a.length+e.length&&(a+=e),c=!0);C=a;if(c){d=b.h;b=b.j;var f;if(window.XMLHttpRequest)f=new XMLHttpRequest;else if(window.ActiveXObject)try{f=new ActiveXObject("Msxml2.XMLHTTP")}catch(r){try{f=new ActiveXObject("Microsoft.XMLHTTP")}catch(D){}}f&&(f.open("POST",d+(-1==d.indexOf("?")?"?":"&")+"url="+encodeURIComponent(b)),f.setRequestHeader("Content-Type","application/x-www-form-urlencoded"),f.send(a))}}}function B(){var b={},c;c=document.getElementsByTagName("IMG");if(!c.length)return{};var a=c[0];if(!("naturalWidth"in a&&"naturalHeight"in a))return{};for(var d=0;a=c[d];++d){var e=a.getAttribute("data-pagespeed-url-hash");e&&(!(e in b)&&0<a.width&&0<a.height&&0<a.naturalWidth&&0<a.naturalHeight||e in b&&a.width>=b[e].o&&a.height>=b[e].m)&&(b[e]={rw:a.width,rh:a.height,ow:a.naturalWidth,oh:a.naturalHeight})}return b}var C="";u("pagespeed.CriticalImages.getBeaconData",function(){return C});u("pagespeed.CriticalImages.Run",function(b,c,a,d,e,f){var r=new y(b,c,a,e,f);x=r;d&&w(function(){window.setTimeout(function(){A(r)},0)})});})();pagespeed.CriticalImages.Run('/mod_pagespeed_beacon','https://janvi.qwesys.com/','82dtZm2p5Q',true,false,'dYYqEfCyjKg');
				//]]>
				</script>

		    <a class="navbar-brand" href="/"><img src="/{{ check_host() }}assets/images/logo.png" class="img-fluid"></a>
		   	<button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" aria-label="Toggle navigation">
				<img src="/{{ check_host() }}assets/images/menu-icon.svg">
			</button>
			<div class="navbar-collapse offcanvas-collapse offcanvas-style-2" id="navbarsExampleDefault">
				<div class="offcanvas-header">
					<button type="button" class="btn-close text-reset ms-auto" data-bs-dismiss="offcanvas" aria-label="Close"></button>
				</div>
				<div class="offcanvas-body">
					{{-- <ul class="navbar-nav">
						<li class="nav-item">
							<a class="nav-link active" href="/">Home</a>
						</li>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="/about-us" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
								About Us
							</a>
							<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
								<li><a class="dropdown-item" href="/gallery">Gallery</a></li>
								<li><a class="dropdown-item" href="/media">Media</a></li>
							</ul>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="/blog">Blog</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="/contact">Contact</a>
						</li>
					</ul> --}}
					<ul class="navbar-nav">
						<li class="nav-item">
							<a class="nav-link active" href="/customer/search-diamonds/rough-diamonds">Rough Diamonds</a>
						</li>
						<li class="nav-item">
							<a class="nav-link active" href="/customer/search-diamonds/4p-diamonds">4P Diamonds</a>
						</li>
						<li class="nav-item">
							<a class="nav-link active" href="/customer/search-diamonds/polish-diamonds">Polish Diamonds</a>
						</li>
					</ul>
				</div>
			</div>
		    <ul class="header-icon-menu">
		      	<!-- <li><a class="nav-link active" href="/customer/search-diamonds"><img src="/{{ check_host() }}assets/images/theme_search.svg"></a></li> -->
				<li class="nav-item">
					<a class="nav-link active" aria-current="page" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample"><img src="/{{ check_host() }}assets/images/menu-icon.svg" data-pagespeed-url-hash="1515657107" onload="pagespeed.CriticalImages.checkImageForCriticality(this);"></a>
				</li>
		      	<li><a class="nav-link active" href="{{ route('get-cart') }}"><img src="/{{ check_host() }}assets/images/shopping-cart.svg"></a></li>
		      	<li><a class="nav-link active" href="{{ route('get-wishlist') }}"><img src="/{{ check_host() }}assets/images/theme_heart_icon.svg"></a></li>
		      	<li><a class="nav-link active" href="/customer/logout"><img src="/{{ check_host() }}assets/images/mono-exit.svg"></a></li>
		      </ul>
			  <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
				<div class="offcanvas-header">
					<button type="button" class="btn-close text-reset ms-auto" data-bs-dismiss="offcanvas" aria-label="Close"></button>
				</div>
				<div class="offcanvas-body">
					<ul class="list-unstyled">
						<li><a class="nav-link" aria-current="page" href="/">Home</a></li>
						<li><a class="nav-link" aria-current="page" href="/about-us">About Us</a></li>
						<li><a class="nav-link" aria-current="page" href="/blog">Blog</a></li>
						<li><a class="nav-link" aria-current="page" href="/contact">Contact</a></li>
						<li><a class="nav-link" aria-current="page" href="/manufacturing">Manufacturing</a></li>
						<li><a class="nav-link" aria-current="page" href="/grading">What we follow?</a></li>
						<li><a class="nav-link" aria-current="page" href="/customer/search-diamonds/rough-diamonds">Rough Diamonds</a></li>
						<li><a class="nav-link" aria-current="page" href="/customer/search-diamonds/4p-diamonds">4P Diamonds</a></li>
						<li><a class="nav-link" aria-current="page" href="/customer/search-diamonds/polish-diamonds">Polish Diamonds</a></li>
						<li><a class="nav-link" aria-current="page" href="/why-to-order-online">Why to Order Online?</a></li>
						<li><a class="nav-link" aria-current="page" href="/diamonds">What we have?</a></li>
						<li><a class="nav-link" aria-current="page" href="/events">Events</a></li>
						<li><a class="nav-link" aria-current="page" href="/media">Media</a></li>
						<li><a class="nav-link" aria-current="page" href="/gallery">Gallery</a></li>
						<li><a class="nav-link" aria-current="page" href="/blog">Blogs</a></li>
						<li><a class="nav-link" aria-current="page" href="/business-policy">Business Policy</a></li>
						<li><a class="nav-link" aria-current="page" href="/terms-conditions">Terms & Condition</a></li>
						<li><a class="nav-link" aria-current="page" href="/privacy-policy">Privacy Policy</a></li>
					</ul>
				</div>
			</div>
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
				<a href="/"><img src="/{{ check_host() }}assets/images/logo.png" class="img-fluid" alt="logo"></a>
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
								<li class="item"><a href="/about-us">About us</a></li>
								<li class="item"><a href="/gallery">Gallery</a></li>
								<li class="item"><a href="/media">Media</a></li>
								<li class="item"><a href="/events">Events</a></li>
								<li class="item"><a href="/business-policy">Business Policy</a></li>
								<li class="item"><a href="/blog">Blogs</a></li>
							</ul>
						</div>
					</div>
					<div class="col col-12 col-sm-12 col-md-6 col-lg-3">
						<div class="quick-link-content">
							<h4 class="title">Information</h4>
							<ul class="list-unstyled footer-link mb-0">
								<li class="item"><a href="/customer/order-details">Order Details</a></li>
								<li class="item"><a href="/privacy-policy"> Privacy Policy </a></li>
								<li class="item"><a href="/terms-conditions"> Terms & Conditions </a></li>
								<li class="item"><a href="Javascript:;">Support Now</a></li>
								<li class="item"><a href="/manufacturing">Manufacturing</a></li>
								<li class="item"><a href="/grading">Grading</a></li>
							</ul>
						</div>
					</div>
					<div class="col col-12 col-sm-12 col-md-6 col-lg-3">
						<div class="quick-link-content">
							<h4 class="title">My Account</h4>
							<ul class="list-unstyled footer-link mb-0">
								<li class="item"><a href="/customer/my-account">My Account</a></li>
								<li class="item"><a href="/customer/wishlist">Wishlist</a></li>
								<li class="item"><a href="/customer/checkout">Checkout</a></li>
								<li class="item"><a href="/customer/cart">Cart</a></li>
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
<!-- Button trigger modal -->
<!--<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
  Launch static backdrop modal
</button>-->

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Share</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
          <img src="/{{ check_host() }}assets/flaticon/whatsapp.png" id="click-whatsapp-link">
          <img src="/{{ check_host() }}assets/flaticon/link.png" id="click-copy-link" data-bs-dismiss="modal" data-bs-toggle="tooltip" data-bs-placement="top" title="Click to copy">
      </div>
    </div>
  </div>
</div>
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
            $(document).on('click', '#click-whatsapp-link', function () {
//                staticBackdrop
                var w_link=$("#watsapplink").val();
                window.open(w_link, '_blank');
//                window.location.href = w_link;
            });
            $(document).on('click', '#click-copy-link', function () {
                var c_link=$("#copylink").val();
                navigator.clipboard.writeText(c_link);
            });
            $(document).on('click', '#add-all-to-cart', function () {
			var share_cart_id = $("#share_cart_id").val();
			var data = {
				'share_cart_id': share_cart_id
			};
			$.ajax({
				type: "POST",
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				url: "{{ route('add-all-to-cart') }}",
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
            $(document).on('click', '#add-all-to-wishlist', function () {
                      var share_wishlist_id = $("#share_wishlist_id").val();
                      var data = {
                              'share_wishlist_id': share_wishlist_id
                      };
                      $.ajax({
                              type: "POST",
                              headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                              url: "{{ route('add-all-to-wishlist') }}",
                              data: data,
                              success: function (res) {
                                      if (res.suceess) {
                                              $.toast({
                                                      heading: 'Success',
                                                      text: 'Diamond added in wishlist.',
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




		$(document).on('click', '.add-to-wishlist', function () {
			var self = $(this);
			var diamond_id = self.data('id');
			var data = {
				'diamond_id': diamond_id
			};
			$.ajax({
				type: "POST",
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				url: "{{ route('add-to-wishlist') }}",
				data: data,
				success: function (res) {
					if (res.suceess) {
						$.toast({
							heading: 'Success',
							text: 'Diamond added in wishlist.',
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

		$(document).on('click', '.removeFromWishlist', function () {
			var self = $(this);
			var diamond_id = self.data('id');
			var data = {
				'diamond_id': diamond_id
			};
			$.ajax({
				type: "POST",
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				url: "{{ route('remove-from-wishlist') }}",
				data: data,
				success: function (res) {
					if (res.suceess) {
						$.toast({
							heading: 'Success',
							text: 'Diamond removed from wishlist.',
							icon: 'success',
							position: 'top-right'
						});
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
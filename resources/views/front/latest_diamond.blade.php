@extends('front.layout_2')
@section('title', $title)
@section('css')
    <style>
    </style>
@endsection
@section('content')
    <div class="overlay cs-loader">
      <div class="overlay__inner">
        <div class="overlay__content"><img src='/assets/images/Janvi_Akashs_Logo_Loader_2.gif'></div>
      </div>
    </div>
    <!-- DASHBOARD SECTION -->
	<section class="dashboard-section">
		<div class="container">
            <div class="text-center mb-5">
                <h3>{{ $title }}</h3>
            </div>
            <div class="row">
                @if (count($diamonds))
                <div class="recommended-diamonds-box">
                    <div class="row">
                        @foreach($diamonds as $r)
                        <div class="col-md-3 col-6 mb-3" id="diamond_{{$r['_source']['diamond_id']}}">
                            <div class="card">
                                <div class="card-body- p-1 text-center">
                                    <div class=" mb-2">
                                        <a href="/customer/single-diamonds/{{$r['_source']['barcode']}}">
                                            <img src="{{ count($r['_source']['image']) ? $r['_source']['image'][0] : '/assets/images/No-Preview-Available.jpg' }}" alt="Diamond" class="w-100">
                                        </a>
                                    </div>
                                    <h5>{{ $r['_source']['expected_polish_cts'] . ' CT ' .  $r['_source']['attributes']['SHAPE'] . ' DIAMOND' }}</h5>
                                    <small class="">{{ $r['_source']['attributes']['COLOR'] . ' Color • ' .  $r['_source']['attributes']['CLARITY'] . ' Clarity' }}</small>
                                    <div class="mt-2"><h5><b>${{ number_format($r['_source']['total'], 2, '.', ',') }} USD</b></h5></div>
                                    <a href="javascript:void(0);" class="btn btn-primary w-100 add-to-cart">ADD TO CART</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
		</div>
	</section>
@endsection

@extends('front.layout_2')
@section('title', $title)
@section('css')
    <style>
    </style>
@endsection
@section('content')
    <div class="overlay cs-loader">
      <div class="overlay__inner">
        <div class="overlay__content"><span class="spinner"></span></div>
      </div>
    </div>
    <!-- DASHBOARD SECTION -->
	<section class="dashboard-section">
		<div class="container">
            <div class="text-center mb-5">
                <h3>{{ $title }}</h3>
            </div>
            <div class="row">
                @foreach ($diamonds as $d)
                <div class="col-6 col-md-4 col-lg-3 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="diamond-img mb-2">
                                @if (count($d->image))
                                    <img src="{{ $d->image[0] }}" class="img-fluid">
                                @else
                                    <img src="/assets/images/No-Preview-Available.jpg" class="img-fluid">
                                @endif
                            </div>
                            <h6 class="diamond-name">{{ $d->name }}</h6>
                            <p class="diamond-cost">M.R.P. ${{ round($d->mrp, 2) }}</p>
                            <div class="h4 mb-3"><b class=""> ${{ round($d->price, 2) }}</b></div>
                            <div class="text-center">
                                <a href="/customer/single-diamonds/{{ $d->diamond_id }}" class="btn btn-primary">View Diamond</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
		</div>
	</section>
@endsection

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
                                    <img src="/storage/other_images/{{ $d->image[0] }}" class="img-fluid">
                                @else
                                    <img src="/assets/images/No-Preview-Available.jpg" class="img-fluid">
                                @endif
                            </div>
                            <h6 class="diamond-name">{{ $d->name }}</h6>
                            <div class="text-muted">{{ $d->barcode }}</div>
                            <div class="h4 mb-3 mt-2"><b class=""> ${{ number_format(round($d->price, 2), 2, '.', ',') }}</b></div>
                            <div class="text-center">
                                <a href="/customer/single-diamonds/{{ $d->barcode }}" class="btn btn-primary">View Diamond</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
		</div>
	</section>
@endsection

@extends('front.layout_1')
@section('title', 'Blog')
@section('content')
    <div class='content-wrapper'>
        <section class='media-section sub-header'>
            <div class='container'>
                <div class='section-content'>
                    <div>
                        <h2 class='title bread-crumb-title'>Blog</h2>
                    </div>
                </div>
            </div>
        </section>
        <section class='blog-info-section media-info'>
            <div class='container'>
                <div class='row'>
                    @foreach ($data as $d)
                    <div class='col col-12 col-md-6 col-lg-4'>
                        <div class='media-card'>
                            <div class='card-body p-0'>
                                <div class='media-box'> <img src='storage/other_images/{{ $d->image }}' alt='media' class='img-fluid'>
                                </div>
                                <div class='media-details'>
                                    <h4 class="blog_title">{{ substr($d->title, 0, 35) }} {{ strlen($d->title) > 35 ? '...' : '' }}</h4>
                                    <p class="blog_desc">{{ substr($d->description, 0, 160) . '...' }}</p>
                                    <div class="text-center">
                                        <a href="{{ $d->video_link }}" target="_blank" class='btn btn-primary'>Read More</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
@endsection

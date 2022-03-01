@extends('front.layout_1')
@section('title', 'Gallery')
@section('css')
<link href="/assets/lightbox/dist/simple-lightbox.min.css" rel="stylesheet" />
<style>
    .grid-item {
        width: 24%;
    }
</style>
@endsection
@section('content')
    <div class='content-wrapper'>
        <section class='media-section sub-header'>
            <div class='container'>
                <div class='section-content'>
                    <div>
                        <h2 class='title bread-crumb-title'>Gallery</h2>
                    </div>
                </div>
            </div>
        </section>
        <section class='blog-info-section media-info'>
            <div class='container'>
                <div class="grid mb-5">
                    @foreach ($data as $d)
                    <div class="grid-item">
                        <a href="/storage/other_images/{{ $d->image }}">
                            <img class="lightbox-img mb-3" src="/storage/other_images/{{ $d->image }}" alt="" width="100%">
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
@endsection
@section('js')
{{-- <script src="/assets/lightbox/dist/simple-lightbox.min.js"></script> --}}
<script src="/assets/lightbox/dist/simple-lightbox.jquery.min.js"></script>
<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
<script>
    $('.grid').masonry({
        // options...
        percentPosition: true,
        horizontalOrder: true,
        itemSelector: '.grid-item',
        // rowHeight: 500,
        // columnWidth: 400,
        gutter: 15
    });
    var gallery = $('.grid-item a').simpleLightbox({
        overlay:true,
        spinner:true,
        nav:true,
        fileExt:'png|jpg|jpeg|gif|jfif',
        // animationSlide:true,
        widthRatio: 1,
        heightRatio: 0.8,
        alertError: true,

    });

</script>
@endsection
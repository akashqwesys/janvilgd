@extends('front.layout_1')
@section('title', 'Media | ' . $data->title)
@section('content')
    <div class='content-wrapper'>
        <section class='media-section sub-header'>
            <div class='container'>
                <div class='section-content'>
                    <div>
                        <h2 class='title bread-crumb-title'>Media</h2>
                    </div>
                </div>
            </div>
        </section>

        <section class="blog-info-section">
            <div class="container">
                <div class="row">
                    <div class="col col-12 col-md-8">
                        <div class="blog-info-content">
                            <div class="blog-poster"><img src="/storage/other_images/{{ $data->image }}" alt="blog" class="img-fluid"> </div>
                            <div class="details">
                                <h3 class="mb-3">{{ $data->title }}</h3>
                                <h6 class="blog-author mb-2">Written by : <span>Admin</span></h6>

                                <div class="mb-4">
                                    {!! $data->description !!}
                                </div>

                                {{-- <div class="tag">
                                    <p><span>TAG : </span>Lorem , Lorem , Lorem </p>
                                </div> --}}
                                <div class="share-with mb-4">
                                    <p>Share With : </p>
                                    <ul class="list-unstyled blog-share social-link mb-0">
                                        <li class="link-item"><a href="Javascript:;"><img src="/assets/images/facebook.svg" class="img-fluid"></a></li>
                                        <li class="link-item"><a href="Javascript:;"><img src="/assets/images/instagram.svg" class="img-fluid"></a></li>
                                        <li class="link-item"><a href="Javascript:;"><img src="/assets/images/twitter.svg" class="img-fluid"></a></li>
                                        <li class="link-item"><a href="Javascript:;"><img src="/assets/images/youtube.svg" class="img-fluid"></a></li>
                                        <li class="link-item"><a href="Javascript:;" id="whatsapp-a"><img src="/assets/images/whatsapp.svg" class="img-fluid"></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col col-12 col-md-4">
                        @if ($data->video_link)
                        <div class="mb-5">
                            {{-- <video controls width="100%">
                                <source src="https://www.youtube.com/watch?v=mrJkVvW90L0" type="video/mp4">
                            </video> --}}
                            <iframe width="100%" height="275" src="{{ $data->video_link }}"> </iframe>
                        </div>
                        @endif

                        <div class="recent-post-box">
                            <h4 class="recent-title">Recent Posts</h4>
                            <ul class="list-unstyled mb-0 recent-post-list">
                                @foreach ($recent as $r)
                                <li class="recent-post-item">
                                    <a href="">
                                        <div class="recent-post-image">
                                            <img src="/storage/other_images/{{ $r->image }}" alt="blog-img" class="img-fluid">
                                        </div>
                                        <div class="post-details">
                                            <h6 class="post-title">{{ substr($r->title, 0, 35) }} {{ strlen($r->title) > 35 ? '...' : '' }}</h6>
                                            <p>{{ date('F m, Y', strtotime($r->created_at)) }}</p>
                                        </div>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('js')
<script>
    $(document).on('click', '#whatsapp-a', function () {
        window.open('https://api.whatsapp.com/send?text='+encodeURIComponent('Hey there!,\nCheck this interesting media: ' + location.href));
    });
</script>
@endsection
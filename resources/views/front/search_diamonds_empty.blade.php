@extends('front.layout_2')
@section('title', $title)
@section('css')
    <style>

    </style>
@endsection
@section('content')
    <section class="diamond-cut-section">
        <div class="container">
            <div class="main-box">
                <h2 class="text-center">
                    <img class="img-fluid title-diamond_img" src="/{{ check_host() }}assets/images/title-diamond.svg" alt="">CURRENTLY {{ $category->name }} ARE OUT OF STOCK
                </h2>
            </div>
        </div>
    </section>
@endsection
@section('js')
@endsection

@extends('front.layout_2')
@section('title', $title)
@section('css')
    <link rel="stylesheet" href="/assets/nouislider/nouislider.css" />
    <script type="text/javascript">
        var global_category = {{ $category->category_id }};
        var global_category_slug = '{{ $category->slug }}';
        var table_scroll = '.search-diamond-table .table-responsive';
    </script>
    <script type="text/javascript" src="/assets/nouislider/wNumb.js"></script>
    <script type="text/javascript" src="/assets/nouislider/nouislider.js"></script>
    <script src="/assets/js/search-diamonds.js"></script>
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
        .search-diamond-table {
            position: relative;
        }
        .cs-loader {
            position: absolute;
        }
        .float-right {
            float: right;
        }
        .w-5r {
            width: 5rem;
            margin: .5em 0 0 0;
        }
        .noUi-handle:before, .noUi-handle:after {
            background: none;
        }
        .noUi-target {
            border: none;
            background-color: #ffffff;
        }
        #priceSlider, #caratSlider {
            height: 7px;
        }
        #priceSlider .noUi-connects, #caratSlider .noUi-connects {
            height: 7px;
        }
        #priceSlider .noUi-connect, #caratSlider .noUi-connect {
            background-color: #D2AB66;
        }
        #priceSlider .noUi-handle, #caratSlider .noUi-handle {
            height: 18px;
            width: 18px;
            top: -5px;
            right: -9px; /* half the width */
            border-radius: 50%;
            background-color: #D2AB66;
            border: 1px solid #D2AB66;
            box-shadow: unset;
        }
        .select-diamond {
            display: none;
        }
        .select-diamond-temp {
            height: 100%;
            box-shadow: rgb(0 0 0 / 25%) 0px 0px 10px 0px;
            padding: 20px;
        }
        .pt-25 {
            padding-top: 25%;
        }
    </style>
@endsection
@section('content')
    <section class="diamond-cut-section">
        <div class="container">
            <div class="main-box"><h2 class="text-center"><img class="img-fluid title-diamond_img" src="/{{ check_host() }}assets/images/title-diamond.svg" alt="">Search for {{ $category->name }}</h2></div>
            <div class="diamond-cut-filter">
                <div class="filter-content">
                    <div class="row">
                        {!! $html !!}
                        {{-- <div class="filter-toggle"> --}}
                        {!! $none_fix !!}
                        {{-- </div> --}}
                    </div>
                    <div class="filter-btn text-center">
                        <button class="btn btn-primary" id="filter-toggle">Filters
                            <i class="fas fa-chevron-up ms-2"></i>
                        </button>
                        @if(Session::has('loginId') && Session::has('user-type'))
                            @if(session('user-type') == "MASTER_ADMIN")
                            <a href="javascript:;" data-export='export' class="btn btn-primary" id="export-search-diamond"><i class="fas fa-download me-2"></i> Export for customer</a>
                            <a href="javascript:;" data-export='export-admin' class="btn btn-primary" id="export-search-diamond-admin"><i class="fas fa-download me-2"></i> Export for admin</a>
                            @endif
                        @endif
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
                                                <div class="diamond-img mb-2">
                                                    <img src="" class="img-fluid">
                                                </div>
                                                <h6 class="diamond-name"></h6>
                                                <!-- <p class="diamond-short-note">lorem Ipsum</p> -->
                                                <p class="diamond-cost"></p>
                                                <a href="javascript:void(0);" class="btn btn-primary"></a>
                                            </div>
                                            <div class="select-diamond-temp">
                                                <div class="pt-25">
                                                    <div class="text-center mb-3">
                                                        <img class="img-fluid title-diamond_img" src="/assets/images/title-diamond.svg" alt="">
                                                    </div>
                                                    <p>Hover over a diamond to see further details and shipping information.</p><p> Check the compare box to send multiple diamonds to the comparison tab.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col col-12 col-sm-12 col-md-12 col-lg-9">
                                        <div class="search-diamond-table">
                                            <div class="overlay cs-loader">
                                                <div class="overlay__inner">
                                                    <div class="overlay__content"><span class="spinner"></span></div>
                                                </div>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table mb-0" id="result-table">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col" class="text-center">Barcode</th>
                                                            <th scope="col" class="text-right">Carat</th>
                                                            <th scope="col" class="text-center">Shape</th>
                                                            @if ($category->slug == 'polish-diamonds')
                                                            <th scope="col" class="text-center">Cut</th>
                                                            @endif
                                                            {{-- @if ($category->slug != 'rough-diamonds') --}}
                                                            <th scope="col" class="text-center">Color</th>
                                                            {{-- @endif --}}
                                                            <th scope="col" class="text-center">Clarity
                                                            </th>
                                                            <th scope="col" class="text-right">Price</th>
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
                            <div class="recent-tab-content">
                                <div class="row">
                                    <div class="col col-12 col-sm-12 col-md-12 col-lg-3">
                                        <div class="selected-diamonds">
                                            <div class="select-diamond">
                                                <div class="diamond-img">
                                                    <img src="" class="img-fluid">
                                                </div>
                                                <h6 class="diamond-name"></h6>
                                                <p class="diamond-cost"></p>
                                                <a href="javascript:void(0);" class="btn btn-primary">NO DIAMOND SELECTED</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col col-12 col-sm-12 col-md-12 col-lg-9">
                                        <div class="search-diamond-table">
                                            <div class="table-responsive">
                                                <table class="table mb-0" id="recent-view">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col" class="text-center">Barcode</th>
                                                            <th scope="col" class="text-right">Carat</th>
                                                            <th scope="col" class="text-center">Shape</th>
                                                            @if ($category->slug == 'polish-diamonds')
                                                            <th scope="col" class="text-center">Cut</th>
                                                            @endif
                                                            {{-- @if ($category->slug != 'rough-diamonds') --}}
                                                            <th scope="col" class="text-center">Color</th>
                                                            {{-- @endif --}}
                                                            <th scope="col" class="text-center">Clarity</th>
                                                            <th scope="col" class="text-right">Price</th>
                                                            <th scope="col" class="text-center">Compare</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($recently_viewed as $rv)
                                                        @php $rv_img = json_decode($rv->image); @endphp
                                                        <tr data-diamond="{{ $rv->refDiamond_id }}" data-price="${{ number_format(round($rv->price, 2), 2, '.', ',') }}" data-name="{{ $rv->name }}" data-image="{{ count($rv_img) ? '/storage/other_images/'.$rv_img[0] : '/assets/images/No-Preview-Available.jpg'}}" data-barcode="{{ $rv->barcode }}">
                                                            <td scope="col" class="text-center">{{ $rv->barcode }}</td>
                                                            <td scope="col" class="text-right">{{ $rv->carat }}</td>
                                                            <td scope="col" class="text-center">{{ $rv->shape }}</td>
                                                            @if ($category->slug == 'polish-diamonds')
                                                            <td scope="col" class="text-center">{{ $rv->cut }}</td>
                                                            @endif
                                                            {{-- @if ($category->slug != 'rough-diamonds') --}}
                                                            <td scope="col" class="text-center">{{ $rv->color }}</td>
                                                            {{-- @endif --}}
                                                            <td scope="col" class="text-center">{{ $rv->clarity }}</td>
                                                            <td scope="col" class="text-right">${{ number_format(round($rv->price, 2), 2, '.', ',') }}</td>
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
                            <div class="compare-tab-content">
                                <div class="row">
                                    <div class="col col-12 col-sm-12 col-md-12 col-lg-3">
                                        <div class="selected-diamonds">
                                            <div class="select-diamond">
                                                <div class="diamond-img">
                                                    <img src="" class="img-fluid">
                                                </div>
                                                <h6 class="diamond-name"></h6>
                                                <p class="diamond-cost"></p>
                                                <a href="javascript:void(0);" class="btn btn-primary">NO DIAMOND SELECTED</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col col-12 col-sm-12 col-md-12 col-lg-9">
                                        <div class="search-diamond-table">
                                            <div class="table-responsive">
                                                <table class="table mb-0" id="compare-table">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col" class="text-center">Barcode</th>
                                                            <th scope="col" class="text-right">Carat</th>
                                                            <th scope="col" class="text-center">Shape</th>
                                                            @if ($category->slug == 'polish-diamonds')
                                                            <th scope="col" class="text-center">Cut</th>
                                                            @endif
                                                            {{-- @if ($category->slug != 'rough-diamonds') --}}
                                                            <th scope="col" class="text-center">Color</th>
                                                            {{-- @endif --}}
                                                            <th scope="col" class="text-center">Clarity</th>
                                                            <th scope="col" class="text-right">Price</th>
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
        </div>
    </section>
@endsection
@section('js')
<script>
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
</script>
@endsection

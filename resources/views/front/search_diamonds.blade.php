@extends('front.layout_2')
@section('title', $title)
@section('css')
    <link href="{{ asset(check_host().'admin_assets/datatable/jquery1.dataTables.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset(check_host().'admin_assets/datatable/dataTables.responsive.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset(check_host().'admin_assets/datatable/scroller.dataTables.min.css')}}" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="/assets/nouislider/nouislider.css" />
    <script type="text/javascript">
        var global_category = {{ $category->category_id }};
        var onchange_call = true;
        var global_category_slug = '{{ $category->slug }}';
        var table_scroll = '.search-diamond-table .table-responsive';
        var global_data_offset = 0;
        var stop_on_change = 0;
        var global_sort_column = 'barcode';
        var global_sort_order = 'asc';
        var global_filter_data = [];
        var global_quick_call = 0;
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="/assets/nouislider/wNumb.js"></script>
    <script type="text/javascript" src="/assets/nouislider/nouislider.js"></script>
    <script  src="{{ asset(check_host().'admin_assets/datatable/jquery1.dataTables.min.js')}}" type="text/javascript"></script>
    <script src="{{ asset(check_host().'admin_assets/datatable/dataTables.responsive.min.js')}}" type="text/javascript" ></script>
    <script src="{{ asset(check_host().'admin_assets/datatable/dataTables.scroller.min.js')}}" type="text/javascript" ></script>

    <script src="/assets/js/search-diamonds.js?v={{ time() }}"></script>
    <style>
        #minPrice:focus-visible, #maxPrice:focus-visible, #minCarat:focus-visible, #maxCarat:focus-visible, #myInput:focus-visible {
            outline: none;
        }
        #myInput {
            height: 2rem;
            font-size: 16px;
            background: white;
        }
        /* CSS for input range sliders */
        .diamond-cut-section {
            padding: 110px 0px;
        }
        .loadedcontent {
            min-height: 1200px;
        }
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
        /* .diamond-shape .item img {
            border: 4px solid #00000000;
        } */
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
            text-align: center;
        }
        .select-diamond-temp {
            height: 100%;
            /* box-shadow: rgb(0 0 0 / 25%) 0px 0px 10px 0px; */
            padding: 20px;
        }
        .pt-40 {
            padding-top: 40%;
        }
        .image-shapes {
            width: 35px;
            height: 35px;
        }
        .btn-sm {
            padding: .25rem .5rem;
            font-size: .875rem;
        }
        .compare-checkbox .add-to-cart{
            border: 1px solid white;
        }
        .pdl-0 {
            padding-left: 0;
        }
        .filter-text{
            font-size: 13px;
            text-align: right;
            color: #808080;
        }
         /* .overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 100%;
            height: 100px;
            margin-left: -50%;
            margin-top: -25px;
            padding-top: 20px;
            text-align: center;
            font-size: 1.2em;
        }  */
        #result-table{
            height: 510px;
        }
        table thead th {
            position: sticky;
            top: 0;
            background-color: #D2AB66 !important;
            color: #FFFFFF;
            z-index: 1;
        }
        table thead th.sorting_asc {
            background-image: unset;
            cursor: pointer;
            background-repeat: no-repeat;
            background-position: center right;
            /* padding-right: 10px; */
        }
        table thead th.sorting {
            background-image: unset;
            cursor: pointer;
            background-repeat: no-repeat;
            background-position: center right;
            /* padding-right: 10px; */
        }
        /* width */
        .search-diamond-table ::-webkit-scrollbar {
            width: 6px;
        }

        /* Track */
        .search-diamond-table ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        /* Handle */
        .search-diamond-table ::-webkit-scrollbar-thumb {
            background: #d2ab66;
        }

        /* Handle on hover */
        .search-diamond-table ::-webkit-scrollbar-thumb:hover {
            background: #c69743;
        }
        .img-cs {
            max-width: 100%;
            height: auto;
        }
        .cat-name {
            background-color: #D2AB66;
            border-color: #D2AB66;
            color: #FFFFFF;
            padding: 8px 15px;
            margin-bottom: 1rem;
        }
        .overlay {
            top: 37px;
            height: 92%;
        }
        #result-table, td {
            height: auto;
        }
    </style>
@endsection
@section('content')
@php
if (Session::has('loginId') && Session::has('user-type') && session('user-type') == "MASTER_ADMIN") {
    $admin = true;
} else {
    $admin = false;
}
@endphp
    <section class="diamond-cut-section">
        <div class="container">
            <div class="main-box"><h2 class="text-center"><img class="img-fluid title-diamond_img" src="/{{ check_host() }}assets/images/title-diamond.svg" alt="">Search for {{ $category->name }}</h2></div>
            <div class="diamond-cut-filter">
                <div class="filter-content">
                    <div class="row mb-2">
                        {!! $html !!}
                        {{-- <div class="filter-toggle"> --}}
                        {!! $none_fix !!}
                        {{-- </div> --}}
                    </div>
                    <div class="filter-btn text-center">
                        <button class="btn btn-primary" id="filter-toggle">Filters
                            <i class="fas fa-chevron-down ms-2"></i>
                        </button>
                        @if ($admin === true)
                        <a href="javascript:;" data-export='export' class="btn btn-primary" id="export-search-diamond"><i class="fas fa-download me-2"></i> Export for Customer</a>
                        <a href="javascript:;" class="btn btn-primary" id="export-search-diamond-admin-modal"><i class="fas fa-download me-2"></i> Export for Admin</a>
                        @endif
                        <a href="#" class="btn reset-btn"><i class="fas fa-times me-2"></i> Reset Filters</a>
                    </div>
                </div>
                <div class="search-diamond-view">
                    <div class="w-75 d-inline-block">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="result-tab" data-bs-toggle="tab" data-bs-target="#results" type="button" role="tab" aria-controls="results" aria-selected="true">Results </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="recently-viwed-tab" data-bs-toggle="tab" data-bs-target="#recently-viwed" type="button" role="tab" aria-controls="recently-viwed" aria-selected="false">Recently Viewed ({{ count($e_data) }})</button>
                            </li>
                            @if ($admin === true)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="comparision-tab" data-bs-toggle="tab" data-bs-target="#comparision" type="button" role="tab" aria-controls="comparision" aria-selected="false">Selected Diamonds (<span>0</span>)</button>
                            </li>
                            @endif
                        </ul>
                    </div>
                    <div class="float-right text-right">
                        <div class="input-group">
                            <input type="text" class="form-control" id="myInput" placeholder="Search by Stock No">
                            <span class="input-group-text" id="myInput-search"><i class="fas fa-search"></i></span>
                        </div>
                    </div>

                    <input type="hidden" id="offset_value" value="0">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="results" role="tabpanel" aria-labelledby="result-tab">
                            <div class="result-tab-content">
                                <div class="row">
                                    <div class="col col-12 col-sm-12 col-md-12 col-lg-3" style="padding-right: 0;">
                                        <div class="selected-diamonds">
                                            <div class="select-diamond">
                                                <div class="cat-name"></div>
                                                <div class="diamond-img mb-2">
                                                    <img src="" class="img-cs">
                                                </div>
                                                <h5 class="diamond-shape"></h5>
                                                <small class="diamond-clarity"></small>
                                                <!-- <p class="diamond-short-note">lorem Ipsum</p> -->
                                                <h5 class="diamond-cost mt-2"></h5>
                                                <a href="javascript:void(0);" class="btn btn-primary w-100"></a>
                                            </div>
                                            <div class="select-diamond-temp">
                                                <div class="pt-40">
                                                    <div class="text-center mb-3">
                                                        <img class="img-fluid title-diamond_img" src="/assets/images/title-diamond.svg" alt="">
                                                    </div>
                                                    <p>Hover over a labgrown to see further details/information.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col col-12 col-sm-12 col-md-12 col-lg-9 pdl-0" style="padding-left: 0;">
                                        <div class="search-diamond-table">
                                            <div class="overlay cs-loader">
                                                <div class="overlay__inner">
                                                    <div class="overlay__content"><img src='/assets/images/Janvi_Akashs_Logo_Loader_2.gif'></div>
                                                </div>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table" id="result-table" style="width: 100% !important;">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col" class="text-left sorting_asc sorting_yes" data-name="barcode" style="width: 11%">Stock No <img src="/admin_assets/images/sort_asc.png"></th>
                                                            <th scope="col" class="text-center sorting sorting_yes" data-name="SHAPE" style="width: 11%">Shape <img src="/admin_assets/images/sort_both.png"></th>
                                                            @if ($category->slug == '4p-diamonds')
                                                            <th scope="col" class="text-center sorting sorting_yes" data-name="makable_cts" style="width: 12%">4P Weight <img src="/admin_assets/images/sort_both.png"></th>
                                                            @elseif ($category->slug == 'rough-diamonds')
                                                            <th scope="col" class="text-center sorting sorting_yes" data-name="makable_cts" style="width: 12%">Rough Weight <img src="/admin_assets/images/sort_both.png"></th>
                                                            @endif
                                                            <th scope="col" class="text-center sorting sorting_yes" data-name="expected_polish_cts" style="width: 7%">Carat <img src="/admin_assets/images/sort_both.png"></th>
                                                            <th scope="col" class="text-center sorting sorting_yes" data-name="COLOR" style="width: 7%">Color <img src="/admin_assets/images/sort_both.png"></th>
                                                            <th scope="col" class="text-center sorting sorting_yes" data-name="CLARITY" style="width: 8%">Clarity <img src="/admin_assets/images/sort_both.png"></th>
                                                            @if ($category->slug != 'rough-diamonds')
                                                            <th scope="col" class="text-center sorting sorting_yes" data-name="CUT" style="width: 11%">Cut <img src="/admin_assets/images/sort_both.png"></th>
                                                            @endif
                                                            <th scope="col" class="text-right sorting sorting_yes" data-name="price_ct" style="width: 9%">Price/CT <img src="/admin_assets/images/sort_both.png"></th>
                                                            <th scope="col" class="text-right sorting sorting_yes" data-name="total" style="width: 11%">Price <img src="/admin_assets/images/sort_both.png"></th>
                                                            @php
                                                            $width=10;
                                                            if($category->slug == '4p-diamonds'){
                                                                $width=100;
                                                            }
                                                            @endphp
                                                            @if ($admin === true)
                                                            <th scope="col" class="text-center" data-name="compare" style="width: {{$width}}%">Compare</th>
                                                            @else
                                                            <th scope="col" class="text-center" data-name="compare" style="width: {{$width}}%">Action</th>
                                                            @endif
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
                                    <div class="col col-12 col-sm-12 col-md-12 col-lg-3" style="padding-right: 0;">
                                        <div class="selected-diamonds">
                                            <div class="select-diamond">
                                                <div class="cat-name">{{ strtoupper($category->name) }}</div>
                                                <div class="diamond-img mb-2">
                                                    <img src="" class="img-cs">
                                                </div>
                                                <h5 class="diamond-shape"></h5>
                                                {{-- <h6 class="diamond-color"></h6> --}}
                                                <small class="diamond-clarity"></small>
                                                <h5 class="diamond-cost mt-2"></h5>
                                                <a href="javascript:void(0);" class="btn btn-primary w-100"></a>
                                            </div>
                                            <div class="select-diamond-temp">
                                                <div class="pt-40">
                                                    <div class="text-center mb-3">
                                                        <img class="img-fluid title-diamond_img" src="/assets/images/title-diamond.svg" alt="">
                                                    </div>
                                                    @if (count($e_data))
                                                    <p>Hover over a labgrown to see further details/information.</p>
                                                    @else
                                                    <p>There are no results corresponding to your selections. Please expand your chosen criteria, or contact us for assistance.</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col col-12 col-sm-12 col-md-12 col-lg-9 pdl-0">
                                        <div class="search-diamond-table">
                                            <div class="table-responsive">
                                                <table class="table" id="recent-view" style="width: 100% !important;">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col" class="text-left" style="width: 11%">Stock No</th>
                                                            <th scope="col" class="text-center" style="width: 11%">Shape</th>
                                                            @if ($category->slug == '4p-diamonds')
                                                            <th scope="col" class="text-center" style="width: 12%">4P Weight</th>
                                                            @elseif ($category->slug == 'rough-diamonds')
                                                            <th scope="col" class="text-center" style="width: 12%">Rough Weight</th>
                                                            @endif
                                                            <th scope="col" class="text-center" style="width: 7%">Carat</th>
                                                            <th scope="col" class="text-center" style="width: 7%">Color</th>
                                                            <th scope="col" class="text-center" style="width: 8%">Clarity</th>
                                                            @if ($category->slug != 'rough-diamonds')
                                                            <th scope="col" class="text-center" style="width: 11%">Cut</th>
                                                            @endif
                                                            <th scope="col" class="text-right" style="width: 9%">Price/CT</th>
                                                            <th scope="col" class="text-right" style="width: 11%">Price</th>
                                                            @if ($admin == false)
                                                            <th scope="col" class="text-center">Action</th>
                                                            @endif
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($e_data as $rv)
                                                        @php $rv = $rv['_source']; @endphp
                                                        <tr data-diamond="{{ $rv['diamond_id'] }}" data-price="${{ number_format($rv['total'], 2, '.', ',') }}" data-name="{{ $rv['name'] }}" data-image="{{ count($rv['image']) ? $rv['image'][0] : '/assets/images/No-Preview-Available.jpg'}}" data-barcode="{{ $rv['barcode'] }}" data-carat="{{ $rv['expected_polish_cts'] }}" data-shape="{{ $rv['attributes']['SHAPE'] }}" data-color="{{ $rv['attributes']['COLOR'] }}" data-clarity="{{ $rv['attributes']['CLARITY'] }}">
                                                            <td scope="col" class="text-left">
                                                                @if (isset($rv['attributes']['CERTIFICATE URL']))
                                                                <a class="show-certi" href="{{ $rv['attributes']['CERTIFICATE URL'] }}" target="_blank">{{ $rv['barcode'] }} </a>
                                                                @else
                                                                <a href="javascript:void(0);" >{{ $rv['barcode'] }} </a>
                                                                @endif
                                                                <a href="/customer/single-diamonds/{{ $rv['barcode'] }}" target="_blank"> </a>
                                                            </td>
                                                            <td scope="col" class="text-center">{{ $rv['attributes']['SHAPE'] }}</td>
                                                            @if ($category->slug == '4p-diamonds' || $category->slug == 'rough-diamonds')
                                                            <td scope="col" class="text-center">{{ $rv['makable_cts'] }}</td>
                                                            @endif
                                                            <td scope="col" class="text-center">{{ $rv['expected_polish_cts'] }}</td>
                                                            <td scope="col" class="text-center">{{ $rv['attributes']['COLOR'] }}</td>
                                                            <td scope="col" class="text-center">{{ $rv['attributes']['CLARITY'] }}</td>
                                                            @if ($category->slug != 'rough-diamonds')
                                                            <td scope="col" class="text-center">{{ $rv['attributes']['CUT'] }}</td>
                                                            @endif
                                                            <td scope="col" class="text-right">${{ number_format($rv['price_ct'], 2, '.', ',') }}</td>
                                                            <td scope="col" class="text-right">${{ number_format($rv['total'], 2, '.', ',') }}</td>
                                                            @if ($admin == false)
                                                            <td scope="col" class="text-center">
                                                                @if ($rv['available_pcs'] == 0)
                                                                <b>Out of Stock</b>
                                                                @else
                                                                <button class="btn btn-primary add-to-cart btn-sm" data-id="{{ $rv['diamond_id'] }}">Add To Cart</button>
                                                                @endif
                                                            </td>
                                                            @endif
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
                        @if ($admin === true)
                        <div class="tab-pane fade" id="comparision" role="tabpanel" aria-labelledby="comparision-tab">
                            <div class="compare-tab-content">
                                <div class="row">
                                    <div class="col col-12 col-sm-12 col-md-12 col-lg-3" style="padding-right: 0;">
                                        <div class="selected-diamonds">
                                            <div class="select-diamond">
                                                <div class="cat-name"></div>
                                                <div class="diamond-img mb-2">
                                                    <img src="" class="img-cs">
                                                </div>
                                                <h5 class="diamond-shape"></h5>
                                                {{-- <h6 class="diamond-color"></h6> --}}
                                                <small class="diamond-clarity"></small>
                                                <h5 class="diamond-cost mt-2"></h5>
                                                <a href="javascript:void(0);" class="btn btn-primary w-100"></a>
                                            </div>
                                            <div class="select-diamond-temp">
                                                <div class="pt-40">
                                                    <div class="text-center mb-3">
                                                        <img class="img-fluid title-diamond_img" src="/assets/images/title-diamond.svg" alt="">
                                                    </div>
                                                    <p>There are no results corresponding to your selections. Please expand your chosen criteria, or contact us for assistance.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col col-12 col-sm-12 col-md-12 col-lg-9 pdl-0">
                                        <div class="search-diamond-table">
                                            <div class="table-responsive">
                                                <table class="table" id="compare-table" style="width: 100% !important;">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col" class="text-left" style="width: 11%">Stock No</th>
                                                            <th scope="col" class="text-center" style="width: 11%">Shape</th>
                                                            @if ($category->slug == '4p-diamonds')
                                                            <th scope="col" class="text-center" style="width: 12%">4P Weight</th>
                                                            @elseif ($category->slug == 'rough-diamonds')
                                                            <th scope="col" class="text-center" style="width: 12%">Rough Weight</th>
                                                            @endif
                                                            <th scope="col" class="text-center" style="width: 7%">Carat</th>
                                                            <th scope="col" class="text-center" style="width: 7%">Color</th>
                                                            <th scope="col" class="text-center" style="width: 8%">Clarity</th>
                                                            @if ($category->slug != 'rough-diamonds')
                                                            <th scope="col" class="text-center" style="width: 11%">Cut</th>
                                                            @endif
                                                            <th scope="col" class="text-right" style="width: 9%">Price/CT</th>
                                                            <th scope="col" class="text-right" style="width: 11%">Price</th>
                                                            <th scope="col" class="text-center" >Compare</th>
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
                        @endif
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

    $(document).on('click', '#export-search-diamond-admin-modal', function () {
        $('#export-discount').val('');
        $("#staticBackdrop1").modal("show");
    });
    onchange_call = true;
</script>
@endsection


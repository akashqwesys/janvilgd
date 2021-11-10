@extends('front.layout_2')
@section('title', $title)
@section('css')
    <script type="text/javascript">
        var global_category = {{ $category->category_id }};
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function( xhr ) {
                $( ".cs-loader" ).show();
            }
        });
        $(document).on('click', '.diamond-shape .item img', function () {
            var group_id = $(this).attr('data-group_id');
            if ($(this).attr('data-selected') == 1) {
                $(this).css('border', '4px solid #00000000');
                $(this).attr('data-selected', 0);
            } else {
                $(this).css('border', '4px solid #D2AB66');
                $(this).attr('data-selected', 1);
            }
            var values = [];
            $('.diamond-shape .item img').each(function(index, element) {
                if ($(this).attr('data-selected') == 1) {
                    values.push({'attribute_id': $(this).attr('data-attribute_id'), 'name': $(this).attr('data-name')});
                }
            });
            getAttributeValues(values, [], group_id);
        });

        function getAttributeValues(values, array, group_id) {
            var selected_values = [];
            if (values.length > 1) {
                var strArray = values.split(",");
            }
            if (group_id != 'price' && group_id != 'carat' && array.length !== 0) {
                var first_index = array.map(function (e) {
                    return e.name;
                }).indexOf(strArray[0]);
                var last_index = array.map(function (e) {
                    return e.name;
                }).indexOf(strArray[1]);
                for (let i = first_index; i <= last_index; i++) {
                    selected_values.push(array[i]);
                }
            } else if (array.length === 0) {
                selected_values = values;
            } else {
                selected_values = strArray;
            }
            // console.log(selected_values);

            $.ajax({
                type: "post",
                url: "/customer/search-diamonds",
                data: {
                    'attribute_values': selected_values,
                    'group_id': group_id,
                    'web': 'web',
                    'category': global_category
                },
                // cache: false,
                dataType: "json",
                success: function (response) {
                    $('.cs-loader').hide();
                    /* if (response.success == 1) {
                        $.toast({
                            heading: 'Success',
                            text: response.message,
                            icon: 'success',
                            position: 'top-right'
                        });
                    }
                    else {
                        $.toast({
                            heading: 'Error',
                            text: response.message,
                            icon: 'error',
                            position: 'top-right'
                        });
                    } */
                    $('#result-table tbody').html(response.data);
                },
                failure: function (response) {
                    $('.cs-loader').hide();
                    $.toast({
                        heading: 'Error',
                        text: 'Oops, something went wrong...!',
                        icon: 'error',
                        position: 'top-right'
                    });
                }
            });
        }
        $(document).on('click', '#result-table .diamond-checkbox', function() {
            $(this).attr('checked', true);
            $('#compare-table tbody').append($(this).closest('tr')[0].outerHTML);
            $(this).closest('tr').remove();
        });
        $(document).on('click', '#compare-table .diamond-checkbox', function() {
            $('#result-table tbody').append($(this).closest('tr')[0].outerHTML);
            $(this).closest('tr').remove();
        });
        $(document).on('mouseover', '#result-table tr', function() {
            $('.result-tab-content .select-diamond a').attr('href', '/customer/single-diamonds/'+$(this).attr('data-diamond'));
            $('.result-tab-content .select-diamond .diamond-name').text($(this).attr('data-name'));
            $('.result-tab-content .select-diamond .diamond-cost').text($(this).attr('data-price'));
            $('.result-tab-content .select-diamond .diamond-img img').attr('src', $(this).attr('data-image'));
        });
        $(document).on('mouseover', '#recent-view tr', function() {
            $('.recent-tab-content .select-diamond a').attr('href', '/customer/single-diamonds/'+$(this).attr('data-diamond'));
            $('.recent-tab-content .select-diamond .diamond-name').text($(this).attr('data-name'));
            $('.recent-tab-content .select-diamond .diamond-cost').text($(this).attr('data-price'));
            $('.recent-tab-content .select-diamond .diamond-img img').attr('src', $(this).attr('data-image'));
        });
        $(document).on('mouseover', '#compare-table tr', function() {
            $('.compare-tab-content .select-diamond a').attr('href', '/customer/single-diamonds/'+$(this).attr('data-diamond'));
            $('.compare-tab-content .select-diamond .diamond-name').text($(this).attr('data-name'));
            $('.compare-tab-content .select-diamond .diamond-cost').text($(this).attr('data-price'));
            $('.compare-tab-content .select-diamond .diamond-img img').attr('src', $(this).attr('data-image'));
        });
        $(document).on('click', '#filter-toggle', function() {
            if ($('.filter-toggle').height() > 1) {
                $('.filter-toggle').css({
                    'height': 0,
                    'visibility': 'collapse'
                });
            }
            else {
                $('.filter-toggle').css({
                    'height': 'auto',
                    'visibility': 'visible'
                });
            }
        });

        $(document).on('click', '#export-search-diamond', function () {
            var group_id = $(this).attr('data-group_id');
            if ($(this).attr('data-selected') == 1) {
                $(this).css('border', '4px solid #00000000');
                $(this).attr('data-selected', 0);
            } else {
                $(this).css('border', '4px solid #D2AB66');
                $(this).attr('data-selected', 1);
            }
            var values = [];
            $('.diamond-shape .item img').each(function(index, element) {
                if ($(this).attr('data-selected') == 1) {
                    values.push({'attribute_id': $(this).attr('data-attribute_id'), 'name': $(this).attr('data-name')});
                }
            });
            exportDiamondTables(values, [], group_id);
        });

        function exportDiamondTables(values, array, group_id) {

            var selected_values = [];
            if (values.length > 1) {
                var strArray = values.split(",");
            }
            if (group_id != 'price' && group_id != 'carat' && array.length !== 0) {
                var first_index = array.map(function (e) {
                    return e.name;
                }).indexOf(strArray[0]);
                var last_index = array.map(function (e) {
                    return e.name;
                }).indexOf(strArray[1]);
                for (let i = first_index; i <= last_index; i++) {
                    selected_values.push(array[i]);
                }
            } else if (array.length === 0) {
                selected_values = values;
            } else {
                selected_values = strArray;
            }

            $.ajax({
                type: 'post',
                url: '/customer/search-diamonds',
                data: {
                    'attribute_values': selected_values,
                    'group_id': group_id,
                    'category': global_category,
                    'export': 'export'
                },
                xhrFields: {
                    responseType: 'blob'
                },
                success: function(response){
                    var blob = new Blob([response]);

                    var link = document.createElement('a');

                    link.href = window.URL.createObjectURL(blob);

                    link.download = "Diamonds-data.pdf";

                    link.click();
                },
                error: function(blob){
                    console.log(blob);
                }
            });
        }
    </script>
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
    </style>
@endsection
@section('content')
    <div class="overlay cs-loader">
      <div class="overlay__inner">
        <div class="overlay__content"><span class="spinner"></span></div>
      </div>
    </div>
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
                    <a href="#" class="btn btn-primary" id="filter-toggle">Filters <i class="fas fa-chevron-up ms-2"></i></a>
                    @php
                        if(Session::has('loginId') && Session::has('user-type')){
                            if(session('user-type') == "MASTER_ADMIN"){
                    @endphp 
                    <a href="javascript:;" class="btn btn-primary" id="export-search-diamond"><i class="fas fa-download me-2"></i> Export</a>
                    @php
                            }
                        }
                    @endphp                                             
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
                                                <img src="/{{ check_host() }}assets/images/Opalescentwhitediamond.png" class="img-fluid">
                                            </div>
                                            <h6 class="diamond-name">0.30 Carat Pear Diamond</h6>
                                            <!-- <p class="diamond-short-note">lorem Ipsum</p> -->
                                            <p class="diamond-cost">$456.00</p>
                                            <a href="#" class="btn btn-primary">View Diamond</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col col-12 col-sm-12 col-md-12 col-lg-9">
                                    <div class="search-diamond-table">
                                        <div class="table-responsive">
                                            <table class="table mb-0" id="result-table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" class="text-center">Carat</th>
                                                        <th scope="col" class="text-center">Price</th>
                                                        <th scope="col" class="text-center">Shape</th>
                                                        <th scope="col" class="text-center">Cut</th>
                                                        <th scope="col" class="text-center">Color</th>
                                                        <th scope="col" class="text-center">Clarity</th>
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
                                                <img src="/{{ check_host() }}assets/images/Opalescentwhitediamond.png" class="img-fluid">
                                            </div>
                                            <h6 class="diamond-name">0.30 Carat Pear Diamond</h6>
                                            <!-- <p class="diamond-short-note">lorem Ipsum</p> -->
                                            <p class="diamond-cost">$456.00</p>
                                            <a href="#" class="btn btn-primary">View Diamond</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col col-12 col-sm-12 col-md-12 col-lg-9">
                                    <div class="search-diamond-table">
                                        <div class="table-responsive">
                                            <table class="table mb-0" id="recent-view">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" class="text-center">Carat</th>
                                                        <th scope="col" class="text-center">Price</th>
                                                        <th scope="col" class="text-center">Shape</th>
                                                        <th scope="col" class="text-center">Cut</th>
                                                        <th scope="col" class="text-center">Color</th>
                                                        <th scope="col" class="text-center">Clarity</th>
                                                        <th scope="col" class="text-center">Compare</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($recently_viewed as $rv)
                                                    <tr>
                                                        <td scope="col" class="text-center">{{ $rv->carat }}</td>
                                                        <td scope="col" class="text-center">{{ $rv->price }}</td>
                                                        <td scope="col" class="text-center">{{ $rv->shape }}</td>
                                                        <td scope="col" class="text-center">{{ $rv->cut }}</td>
                                                        <td scope="col" class="text-center">{{ $rv->color }}</td>
                                                        <td scope="col" class="text-center">{{ $rv->clarity }}</td>
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
                                                <img src="/{{ check_host() }}assets/images/Opalescentwhitediamond.png" class="img-fluid">
                                            </div>
                                            <h6 class="diamond-name">0.30 Carat Pear Diamond</h6>
                                            <!-- <p class="diamond-short-note">lorem Ipsum</p> -->
                                            <p class="diamond-cost">$456.00</p>
                                            <a href="#" class="btn btn-primary">View Diamond</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col col-12 col-sm-12 col-md-12 col-lg-9">
                                    <div class="search-diamond-table">
                                        <div class="table-responsive">
                                            <table class="table mb-0" id="compare-table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" class="text-center">Carat</th>
                                                        <th scope="col" class="text-center">Price</th>
                                                        <th scope="col" class="text-center">Shape</th>
                                                        <th scope="col" class="text-center">Cut</th>
                                                        <th scope="col" class="text-center">Color</th>
                                                        <th scope="col" class="text-center">Clarity</th>
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
    </section>
@endsection

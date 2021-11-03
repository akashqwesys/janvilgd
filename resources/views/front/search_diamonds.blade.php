@extends('front.layout_2')
@section('title', $title)
@section('css')
    <script type="text/javascript">
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
            $('.cs-loader').show();
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
                url: "/api/search-diamonds",
                data: {'attribute_values': selected_values, 'group_id': group_id, 'web': 'web'},
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
            $('#compare-table tbody').append('<tr>'+$(this).closest('tr').html()+'</tr>');
            $(this).closest('tr').remove();
        });
        $(document).on('click', '#compare-table .diamond-checkbox', function() {
            $('#result-table tbody').append('<tr>'+$(this).closest('tr').html()+'</tr>');
            $(this).closest('tr').remove();
        });
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
    <section class="diamond-cut-section">
        <div class="container">
            <div class="main-box"><h2 class="text-center"><img class="img-fluid title-diamond_img" src="/{{ check_host() }}assets/images/title-diamond.svg" alt=""> Search for Princess Cut Diamonds</h2></div>
            <div class="diamond-cut-filter">
                <div class="filter-content">
                    <div class="row">
                        {!! $html !!}
                    <div class="filter-toggle">
                        {!! $none_fix !!}
                    </div>
                </div>
                <div class="filter-btn text-center">
                    <a href="#" class="btn btn-primary" id="filter-toggle">Filters <i class="fas fa-chevron-up ms-2"></i></a>
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
                                            <div class="diamond-img">
                                                <img src="/{{ check_host() }}assets/images/Opalescentwhitediamond.png" class="img-fluid">
                                            </div>
                                            <h6 class="diamond-name">0.30 Carat Pear Diamond</h6>
                                            <p class="diamond-short-note">lorem Ipsum</p>
                                            <p class="diamond-cost">$456.00</p>
                                            <a href="diamond-details.php" class="btn btn-primary">View Diamond</a>
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
                        <div class="result-tab-content">
                            <div class="row">
                                <div class="col col-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="selected-diamonds">
                                        <div class="select-diamond">
                                            <div class="diamond-img">
                                                <img src="/{{ check_host() }}assets/images/Opalescentwhitediamond.png" class="img-fluid">
                                            </div>
                                            <h6 class="diamond-name">0.30 Carat Pear Diamond</h6>
                                            <p class="diamond-short-note">lorem Ipsum</p>
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
                                                        <th scope="col" class="text-center">Shape</th>
                                                        <th scope="col" class="text-center">Price</th>
                                                        <th scope="col" class="text-center">Carat</th>
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
                        <div class="result-tab-content">
                            <div class="row">
                                <div class="col col-12 col-sm-12 col-md-12 col-lg-3">
                                    <div class="selected-diamonds">
                                        <div class="select-diamond">
                                            <div class="diamond-img">
                                                <img src="/{{ check_host() }}assets/images/Opalescentwhitediamond.png" class="img-fluid">
                                            </div>
                                            <h6 class="diamond-name">0.30 Carat Pear Diamond</h6>
                                            <p class="diamond-short-note">lorem Ipsum</p>
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
                                                        <th scope="col" class="text-center">Shape</th>
                                                        <th scope="col" class="text-center">Price</th>
                                                        <th scope="col" class="text-center">Carat</th>
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

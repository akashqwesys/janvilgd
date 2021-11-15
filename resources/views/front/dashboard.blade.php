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
            <div class="row justify-content-center mb-4">
                <div class="col col-12 col-md-4 col-lg-4 mb-4 mb-md-0">
                    <a href="/customer/search-diamonds/rough-diamonds" class="btn btn-primary grown-diamonds-btn">
                        <img class="title-diamond_img" src="/assets/images/Rough.png" alt="" data-pagespeed-url-hash="2917607242" onload="pagespeed.CriticalImages.checkImageForCriticality(this);"> Shop Rough Diamonds
                    </a>
                </div>
                <div class="col col-12 col-md-4 col-lg-4 mb-4 mb-md-0">
                    <a href="/customer/search-diamonds/4p-diamonds" class="btn btn-primary grown-diamonds-btn">
                        <img class="title-diamond_img" src="/assets/images/4p.png" alt="" data-pagespeed-url-hash="2838713985" onload="pagespeed.CriticalImages.checkImageForCriticality(this);"> Shop 4p Diamonds
                    </a>
                </div>
                <div class="col col-12 col-md-4 col-lg-4 mb-4 mb-md-0">
                    <a href="/customer/search-diamonds/polish-diamonds" class="btn btn-primary grown-diamonds-btn">
                        <img class="title-diamond_img" src="/assets/images/Polish.png" alt="" data-pagespeed-url-hash="1281385418" onload="pagespeed.CriticalImages.checkImageForCriticality(this);"> Shop Polish Diamonds
                    </a>
                </div>
            </div>
			<div class="row">
				<div class="col col-12 col-md-12 col-lg-4 mb-4">
                    <a href="/customer/latest-diamonds" class="btn btn-primary grown-diamonds-btn mb-4">
                        Latest Diamonds
                    </a>
                    <a href="/customer/recommended-diamonds" class="btn btn-primary grown-diamonds-btn mb-4">
                        Recommended Diamonds
                    </a>
                    <img class="img-fluid w-100 mb-4" src="/assets/images/dashboard.jpg" alt="" data-pagespeed-url-hash="2956928549" onload="pagespeed.CriticalImages.checkImageForCriticality(this);">
				</div>
				<div class="col col-12 col-md-6 col-lg-4 mb-4">
					<div class="card">
						<div class="card-body">
							<h5 class="mb-4">Loyalty</h5>
							<table class="table loyalty-table">
								<tbody>
									<tr>
										<td>Loyalty Slab</td>
										<td>Basic</td>
									</tr>
									<tr>
										<td>Benifits</td>
										<td>0%</td>
									</tr>
									<tr>
										<td>365 Day Parchase</td>
										<td>0.0%</td>
									</tr>
									<tr>
										<td>Diff. to next level</td>
										<td>3000001</td>
									</tr>
									<tr>
										<th colspan="2"><h6 class="mb-0">Quarterly Action</h6></th>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="col col-12 col-md-6 col-lg-4 mb-4">
					<div class="card">
						<div class="card-body">
							<h5 class="mb-4">Recent Search</h5>
							<div class="table-responsive">
								<table class="table recent-search-table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Diamond</th>
                                        </tr>
                                    </thead>
									<tbody>
                                        @if (count($recently_viewed))
                                        @foreach ($recently_viewed as $r)
										<tr>
                                            <td>{{ $r->updated_at }}</td>
											<td>{{ $r->name }}</td>
										</tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="2"> No Data Available</td>
										</tr>
                                        @endif
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class="col col-12 col-md-4 mb-4">
					<div class="card">
						<div class="card-body">
							<h5>Total Rough Diamonds</h5>
							<h2 class="mb-2">{{ $diamond->total_rough }}</h2>
							<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>
						</div>
					</div>
				</div>
				<div class="col col-12 col-md-4 mb-4">
					<div class="card">
						<div class="card-body">
							<h5>Total 4P Diamonds</h5>
							<h2 class="mb-2">{{ $diamond->total_4p }}</h2>
							<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>
						</div>
					</div>
				</div>
				<div class="col col-12 col-md-4 mb-4">
					<div class="card">
						<div class="card-body">
							<h5>Total Polish Diamonds</h5>
							<h2 class="mb-2">{{ $diamond->total_polish }}</h2>
							<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection
@section('js')
<script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function( xhr ) {
                // $( ".cs-loader" ).show();
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
        });
    </script>
@endsection

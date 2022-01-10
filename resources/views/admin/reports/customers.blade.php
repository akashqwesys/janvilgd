@extends('admin.header')
@section('css')
<style>

</style>
@endsection
@section('content')
<!-- content @s -->

<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="components-preview wide mx-auto">
                    <div class="nk-block nk-block-lg">
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <div class="toggle-wrap nk-block-tools-toggle">
                                    <div class="row-">
                                        <h5>{{ $heading }}</h5>
                                    </div>
                                </div>
                            </div><!-- .nk-block-head-content -->
                        </div>
                        <div class="card card-preview">
                            <div id='append_loader' class="overlay">
                                <div class='d-flex justify-content-center' style="padding-top: 10%;">
                                    <div class='spinner-border text-success' role='status'>
                                        <span class='sr-only'>Loading...</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-inner">
                                <table class="table dt-responsive nowrap">
                                    <thead>
                                        <tr>
                                            <th>Sr. No.</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            @if ($request->customer_type == 'top' || $request->customer_type == 'bottom')
                                            <th>Orders</th>
                                            @else
                                            <th>Date</th>
                                            @endif
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @if ($request->customer_type == 'recent')
                                        @foreach ($customers as $c)
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>{{ $c[0]->name }}</td>
                                            <td>{{ $c[0]->email }}</td>
                                            <td>{{ date('dS F Y \a\t h:i A', strtotime($c[0]->date_added)) }}</td>
                                            <td><a href="/admin/orders?date_range_filter={{ date('Y-m-d', strtotime($c[0]->date_added)) . ' - ' . date('Y-m-d', strtotime($c[0]->date_added)) . $filter}}" class="btn btn-xs btn-primary"> <em class="icon ni ni-eye-fill"></em></a></td>
                                        </tr>
                                        @php
                                            $i++;
                                        @endphp
                                        @endforeach
                                        @elseif ($request->customer_type == 'top' || $request->customer_type == 'bottom')
                                        @foreach ($customers as $c)
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>{{ $c->name }}</td>
                                            <td>{{ $c->email_id }}</td>
                                            <td>{{ $c->repeative }}</td>
                                            <td><a href="/admin/orders?date_range_filter={{ date('Y-m-d', strtotime($c->dt_ad)) . ' - ' . date('Y-m-d', strtotime($c->dt_ad)) . $filter}}" class="btn btn-xs btn-primary"> <em class="icon ni ni-eye-fill"></em></a></td>
                                        </tr>
                                        @php
                                            $i++;
                                        @endphp
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div><!-- .card-preview -->
                    </div> <!-- nk-block -->
                </div><!-- .components-preview -->
            </div>
        </div>
    </div>
</div>

<!-- content @e -->
@endsection
@section('script')
<script type="text/javascript">

</script>
@endsection
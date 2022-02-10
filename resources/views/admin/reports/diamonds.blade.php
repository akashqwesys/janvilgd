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
                                            <th>Month</th>
                                            <th>Import</th>
                                            <th>Sales</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $date = date('Y-m-d');
                                        @endphp
                                        @for ($i = 1; $i <= 12; $i++)
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>{{ date('F Y', strtotime($date . ' - '.$i.' month')) }}</td>
                                            <td>{{ $import->{'cur_month'.$i} }}</td>
                                            <td>{{ $export->{'cur_month'.$i} }}</td>
                                            <td><a href="/admin/orders?date_range_filter={{ date('Y-m-01', strtotime($date . ' - '.$i.' month')) . ' - ' . date('Y-m-t', strtotime($date . ' - '.$i.' month')) . $filter}}" class="btn btn-xs btn-primary"> <em class="icon ni ni-eye-fill"></em></a></td>
                                        </tr>
                                        @endfor
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
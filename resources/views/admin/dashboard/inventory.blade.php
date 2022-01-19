@extends('admin.header')

@section('css')
<style type="text/css">
    span.title {
        font-size: 1.05rem;
        font-family: "DM Sans", sans-serif;
        font-weight: 700;
        line-height: 1.1;
        /* color: #364a63; */
    }
    .hv-effect:hover {
        background: #1f327f;
        color: #ffffff;
        transition: 0.5s;
        box-shadow: 0px 10px 30px 0px #616a8f;
    }
    .nk-activity-action {
        margin-left: auto;
        color: #8094ae;
    }
    .a-head {
        display: flex;
        vertical-align: middle;
        align-items: center;
    }
    .a-head .icon.ni {
        font-size: 18px;
    }
</style>
@endsection
@section('content')
<!-- content @s -->
<div class="nk-content">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block card card-bordered">
                    <div class="row g-gs card-body">
                        <div class="col-md-4 col-lg-2 col-6 col-sm-4 {{ $request->path() == 'admin/dashboard/inventory' ? 'bg-primary-dim' : '' }}">
                            <div class="">
                                <a class="a-head" href="/admin/dashboard/inventory">
                                    <em class="icon ni ni-money"></em>
                                    <span class="pl-1"><b>INVENTORY</b></span>
                                </a>
                            </div><!-- .card -->
                        </div><!-- .col -->
                        <div class="col-md-4 col-lg-2 col-6 col-sm-4 {{ $request->path() == 'admin/dashboard/sales' ? 'bg-primary-dim' : '' }}">
                            <div class="">
                                <a class="a-head" href="/admin/dashboard/sales">
                                    <em class="icon ni ni-sign-dollar"></em>
                                    <span class="pl-1"><b>SALES</b></span>
                                </a>
                            </div><!-- .card -->
                        </div><!-- .col -->
                        <div class="col-md-4 col-lg-2 col-6 col-sm-4 {{ $request->path() == 'admin/dashboard' ? 'bg-primary-dim' : '' }}">
                            <div class="">
                                <a class="a-head" href="/admin/dashboard">
                                    <em class="icon ni ni-report-profit"></em>
                                    <span class="pl-1"><b>ACCOUNTS</b></span>
                                </a>
                            </div><!-- .card -->
                        </div><!-- .col -->
                    </div>
                </div>
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">Inventory Dashboard</h3>
                        </div><!-- .nk-block-head-content -->
                        <div class="nk-block-head-content">
                        </div><!-- .nk-block-head-content -->
                    </div><!-- .nk-block-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block">
                    <div class="row g-gs">
                        <div class="col-md-6 col-lg-4 col-12 col-sm-6">
                            <div class="card card-bordered card-full">
                                <div class="card-inner-group">
                                    <div class="card-inner">
                                        <div class="card-title-group">
                                            <div class="card-title">
                                                <h6 class="title">Polish Stock Info</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-inner card-inner-md">
                                        <div class="user-card">
                                            <div class="user-avatar bg-danger-dim">
                                                <span>T</span>
                                            </div>
                                            <div class="user-info">
                                                <span class="lead-text">Total Instock</span>
                                            </div>
                                            <div class="user-action">
                                                <small><b>{{ $total_stock->total_polish }}</b></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-inner card-inner-md">
                                        <div class="user-card">
                                            <div class="user-avatar bg-success-dim">
                                                <span>R</span>
                                            </div>
                                            <div class="user-info">
                                                <span class="lead-text">Total Round</span>
                                            </div>
                                            <div class="user-action">
                                                <small><b>{{ $round_polish['count'] }}</b></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-inner card-inner-md">
                                        <div class="user-card">
                                            <div class="user-avatar bg-warning-dim">
                                                <span>F</span>
                                            </div>
                                            <div class="user-info">
                                                <span class="lead-text">Total Fancy</span>
                                            </div>
                                            <div class="user-action">
                                                <small><b>{{ $total_stock->total_polish - $round_polish['count'] }}</b></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- .card -->
                        </div><!-- .col -->
                        <div class="col-md-6 col-lg-4 col-12 col-sm-6">
                            <div class="card card-bordered card-full">
                                <div class="card-inner-group">
                                    <div class="card-inner">
                                        <div class="card-title-group">
                                            <div class="card-title">
                                                <h6 class="title">4P Stock Info</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-inner card-inner-md">
                                        <div class="user-card">
                                            <div class="user-avatar bg-danger-dim">
                                                <span>T</span>
                                            </div>
                                            <div class="user-info">
                                                <span class="lead-text">Total Instock</span>
                                            </div>
                                            <div class="user-action">
                                                <small><b>{{ $total_stock->total_4p }}</b></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-inner card-inner-md">
                                        <div class="user-card">
                                            <div class="user-avatar bg-success-dim">
                                                <span>R</span>
                                            </div>
                                            <div class="user-info">
                                                <span class="lead-text">Total Round</span>
                                            </div>
                                            <div class="user-action">
                                                <small><b>{{ $round_4p['count'] }}</b></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-inner card-inner-md">
                                        <div class="user-card">
                                            <div class="user-avatar bg-warning-dim">
                                                <span>F</span>
                                            </div>
                                            <div class="user-info">
                                                <span class="lead-text">Total Fancy</span>
                                            </div>
                                            <div class="user-action">
                                                <small><b>{{ $total_stock->total_4p - $round_4p['count'] }}</b></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- .card -->
                        </div><!-- .col -->
                        <div class="col-md-6 col-lg-4 col-12 col-sm-6">
                            <div class="card card-bordered card-full">
                                <div class="card-inner-group">
                                    <div class="card-inner">
                                        <div class="card-title-group">
                                            <div class="card-title">
                                                <h6 class="title">Rough Stock Info</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-inner card-inner-md">
                                        <div class="user-card">
                                            <div class="user-avatar bg-danger-dim">
                                                <span>T</span>
                                            </div>
                                            <div class="user-info">
                                                <span class="lead-text">Total Instock</span>
                                            </div>
                                            <div class="user-action">
                                                <small><b>{{ $total_stock->total_rough }}</b></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-inner card-inner-md">
                                        <div class="user-card">
                                            <div class="user-avatar bg-success-dim">
                                                <span>R</span>
                                            </div>
                                            <div class="user-info">
                                                <span class="lead-text">Total Round</span>
                                            </div>
                                            <div class="user-action">
                                                <small><b>{{ $round_rough['count'] }}</b></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-inner card-inner-md">
                                        <div class="user-card">
                                            <div class="user-avatar bg-warning-dim">
                                                <span>F</span>
                                            </div>
                                            <div class="user-info">
                                                <span class="lead-text">Total Fancy</span>
                                            </div>
                                            <div class="user-action">
                                                <small><b>{{ $total_stock->total_rough - $round_rough['count'] }}</b></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- .card -->
                        </div><!-- .col -->
                    </div>
                </div><!-- .nk-block -->
            </div>
        </div>
    </div>
</div>
<!-- content @e -->
@endsection
@section('script')
<script>
</script>
@endsection

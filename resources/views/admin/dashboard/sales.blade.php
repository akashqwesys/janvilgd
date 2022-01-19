@extends('admin.header')

@section('css')
<link href="/admin_assets/datatable/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
<link href="/admin_assets/datatable/dataTables.responsive.css" rel="stylesheet" type="text/css">
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
    .bg-tile {
        background: url("/admin_assets/images/background/dash-bg-1.jpg");
        background-repeat: no-repeat;
        background-size: 100%;
    }
    .bg-tile-2 {
        background: url("/admin_assets/images/background/dash-bg-2.jpg");
        background-repeat: no-repeat;
        background-size: 100%;
    }
    .mt-4r {
        margin-top: 3rem;
    }
    .p-cs {
        padding: 1.25rem 1.25rem 0;
    }
    .mt-4r .card {
        background-color:#ffffffeb;
    }
    .image-shapes {
        width: 30px;
    }
    .table td {
        vertical-align: middle;
    }
    .table-cs td:first-child, .table-cs th:first-child {
        padding-left: unset;
    }
    .table-cs td:last-child, .table-cs th:last-child {
        padding-right: unset;
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
                                    <span class=""><b>SALES</b></span>
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
                            <h3 class="nk-block-title page-title">Sales Dashboard</h3>
                        </div><!-- .nk-block-head-content -->
                        <div class="nk-block-head-content">
                        </div><!-- .nk-block-head-content -->
                    </div><!-- .nk-block-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block">
                    <div class="row mb-4">
                        <div class="col-md-6 col-lg-6 col-12 col-sm-6">
                            <div class="card card-full">
                                <div class="bg-tile p-cs">
                                    <h6>Invoice Paid Overview</h6>
                                    <div class="row mt-4r">
                                        <div class="col-md-6 col-6 mb-3">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="mb-2"><h6>Sub Total</h6></div>
                                                    <div><h5 class="text-primary">${{ number_format($total_paid->sub_total, 2, '.', ',') }}</h5></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="mb-2"><h6>Total Amount</h6></div>
                                                    <div><h5 class="text-success">${{ number_format($total_paid->total_amount, 2, '.', ',') }}</h5></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="mb-2"><h6>Shipping Charge</h6></div>
                                                    <div><h5 class="text-warning">${{ $total_paid->shipping_charge ?? 0 }}</h5></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="mb-2"><h6>Discount</h6></div>
                                                    <div><h5 class="text-danger">${{ number_format($total_paid->total_discount, 2, '.', ',') }}</h5></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- .card -->
                        </div><!-- .col -->

                        <div class="col-md-6 col-lg-6 col-12 col-sm-6">
                            <div class="card card-full">
                                <div class="bg-tile-2 p-cs">
                                    <h6>Invoice Unpaid Overview</h6>
                                    <div class="row mt-4r">
                                        <div class="col-md-6 col-6 mb-3">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="mb-2"><h6>Sub Total</h6></div>
                                                    <div><h5 class="text-primary">${{ number_format($total_unpaid->sub_total, 2, '.', ',') }}</h5></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="mb-2"><h6>Total Amount</h6></div>
                                                    <div><h5 class="text-success">${{ number_format($total_unpaid->total_amount, 2, '.', ',') }}</h5></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="mb-2"><h6>Shipping Charge</h6></div>
                                                    <div><h5 class="text-warning">${{ $total_unpaid->shipping_charge ?? 0}}</h5></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-6 mb-3">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="mb-2"><h6>Discount</h6></div>
                                                    <div><h5 class="text-danger">${{ number_format($total_unpaid->total_discount, 2, '.', ',') }}</h5></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- .card -->
                        </div><!-- .col -->
                    </div>

                    <div class="row">
                        <div class="col-md-4 col-lg-4 col-sm-6 col-12 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5>Shape Analysis</h5>
                                    <hr>
                                    <div class="table-responsive">
                                        <table class="table table-cs">
                                            <thead class="d-none">
                                                <tr>
                                                    <th width="12%"></th>
                                                    <th width="35%"></th>
                                                    <th width="18%"></th>
                                                    <th width="35%"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div>
                                                            <img src="/assets/images/d_images/Diamond_Shapes_Round_Brilliant.svg" class="image-shapes" alt="Round" >
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <h6>ROUND</h6>
                                                            <div class="sub-text">{{ $analysis->total_round }}</div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        {{ $analysis->total_round ? number_format($analysis_p->total_round * 100 / $analysis->total_round, 2, '.', ',') : 0.00 }}%
                                                    </td>
                                                    <td  align="right">
                                                        <div class="badge badge-outline-danger">
                                                            <b>${{ number_format($analysis->total_round_amount, 2, '.', ',') }}</b>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div>
                                                            <img src="/assets/images/d_images/Diamond_Shapes_Oval_Brilliant.svg" class="image-shapes" alt="Round" >
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <h6>OVAL</h6>
                                                            <div class="sub-text">{{ $analysis->total_oval }}</div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        {{ $analysis->total_oval ? number_format($analysis_p->total_oval * 100 / $analysis->total_oval, 2, '.', ',') : 0.00 }}%
                                                    </td>
                                                    <td  align="right">
                                                        <div class="badge badge-outline-success">
                                                            <b>${{ number_format($analysis->total_oval_amount, 2, '.', ',') }}</b>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div>
                                                            <img src="/assets/images/d_images/Diamond_Shapes_Heart_Brilliant.svg" class="image-shapes" alt="Round" >
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <h6>HEART</h6>
                                                            <div class="sub-text">{{ $analysis->total_heart }}</div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        {{ $analysis->total_heart ? number_format($analysis_p->total_heart * 100 / $analysis->total_heart, 2, '.', ',') : 0.00 }}%
                                                    </td>
                                                    <td  align="right">
                                                        <div class="badge badge-outline-warning">
                                                            <b>${{ number_format($analysis->total_heart_amount, 2, '.', ',') }}</b>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div>
                                                            <img src="/assets/images/d_images/Diamond_Shapes_Pear_Brilliant.svg" class="image-shapes" alt="Round" >
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <h6>PEAR</h6>
                                                            <div class="sub-text">{{ $analysis->total_pear }}</div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        {{ $analysis->total_pear ? number_format($analysis_p->total_pear * 100 / $analysis->total_pear, 2, '.', ',') : 0.00 }}%
                                                    </td>
                                                    <td  align="right">
                                                        <div class="badge badge-outline-info">
                                                            <b>${{ number_format($analysis->total_pear_amount, 2, '.', ',') }}</b>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div>
                                                            <img src="/assets/images/d_images/Diamond_Shapes_Princess_Cut.svg" class="image-shapes" alt="Round" >
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <h6>PRINCESS</h6>
                                                            <div class="sub-text">{{ $analysis->total_princess }}</div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        {{ $analysis->total_princess ? number_format($analysis_p->total_princess * 100 / $analysis->total_princess, 2, '.', ',') : 0.00 }}%
                                                    </td>
                                                    <td  align="right">
                                                        <div class="badge badge-outline-gray">
                                                            <b>${{ number_format($analysis->total_princess_amount, 2, '.', ',') }}</b>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div>
                                                            <img src="/assets/images/d_images/Diamond_Shapes_Radiant.svg" class="image-shapes" alt="Round" >
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <h6>RADIANT</h6>
                                                            <div class="sub-text">{{ $analysis->total_radiant }}</div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        {{ $analysis->total_radiant ? number_format($analysis_p->total_radiant * 100 / $analysis->total_radiant, 2, '.', ',') : 0.00 }}%
                                                    </td>
                                                    <td  align="right">
                                                        <div class="badge badge-outline-primary">
                                                            <b>${{ number_format($analysis->total_radiant_amount, 2, '.', ',') }}</b>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div>
                                                            <img src="/assets/images/d_images/Diamond_Shapes_Asscher.svg" class="image-shapes" alt="Round" >
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <h6>ASSCHER</h6>
                                                            <div class="sub-text">{{ $analysis->total_asscher }}</div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        {{ $analysis->total_asscher ? number_format($analysis_p->total_asscher * 100 / $analysis->total_asscher, 2, '.', ',') : 0.00 }}%
                                                    </td>
                                                    <td  align="right">
                                                        <div class="badge badge-outline-secondary">
                                                            <b>${{ number_format($analysis->total_asscher_amount, 2, '.', ',') }}</b>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div>
                                                            <img src="/assets/images/d_images/Diamond_Shapes_Emerald.svg" class="image-shapes" alt="Round" >
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <h6>EMERALD</h6>
                                                            <div class="sub-text">{{ $analysis->total_emerald }}</div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        {{ $analysis->total_emerald ? number_format($analysis_p->total_emerald * 100 / $analysis->total_emerald, 2, '.', ',') : 0.00 }}%
                                                    </td>
                                                    <td  align="right">
                                                        <div class="badge badge-outline-danger">
                                                            <b>${{ number_format($analysis->total_emerald_amount, 2, '.', ',') }}</b>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div>
                                                            <img src="/assets/images/d_images/Diamond_Shapes_Cushion.svg" class="image-shapes" alt="Round" >
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <h6>CUSHION</h6>
                                                            <div class="sub-text">{{ $analysis->total_cushion }}</div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        {{ $analysis->total_cushion ? number_format($analysis_p->total_cushion * 100 / $analysis->total_cushion, 2, '.', ',') : 0.00 }}%
                                                    </td>
                                                    <td  align="right">
                                                        <div class="badge badge-outline-success">
                                                            <b>${{ number_format($analysis->total_cushion_amount, 2, '.', ',') }}</b>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div>
                                                            <img src="/assets/images/d_images/Diamond_Shapes_Marquise.svg" class="image-shapes" alt="Round" >
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <h6>MARQUISE</h6>
                                                            <div class="sub-text">{{ $analysis->total_marquise }}</div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        {{ $analysis->total_marquise ? number_format($analysis_p->total_marquise * 100 / $analysis->total_marquise, 2, '.', ',') : 0.00 }}%
                                                    </td>
                                                    <td  align="right">
                                                        <div class="badge badge-outline-warning">
                                                            <b>${{ number_format($analysis->total_marquise_amount, 2, '.', ',') }}</b>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div>
                                                            <img src="/assets/images/d_images/Diamond_Shapes_Round_Brilliant.svg" class="image-shapes" alt="Round" >
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <h6>BAGUETTE</h6>
                                                            <div class="sub-text">{{ $analysis->total_baguette }}</div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        {{ $analysis->total_baguette ? number_format($analysis_p->total_baguette * 100 / $analysis->total_baguette, 2, '.', ',') : 0.00 }}%
                                                    </td>
                                                    <td  align="right">
                                                        <div class="badge badge-outline-info">
                                                            <b>${{ number_format($analysis->total_baguette_amount, 2, '.', ',') }}</b>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div>
                                                            <img src="/assets/images/d_images/Diamond_Shapes_Round_Brilliant.svg" class="image-shapes" alt="Round" >
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <h6>TRIANGLE</h6>
                                                            <div class="sub-text">{{ $analysis->total_triangle }}</div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        {{ $analysis->total_triangle ? number_format($analysis_p->total_triangle * 100 / $analysis->total_triangle, 2, '.', ',') : 0.00 }}%
                                                    </td>
                                                    <td  align="right">
                                                        <div class="badge badge-outline-primary">
                                                            <b>${{ number_format($analysis->total_triangle_amount, 2, '.', ',') }}</b>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-lg-4 col-sm-6 col-12 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5>Color Analysis</h5>
                                    <hr>
                                    <div class="table-responsive-">
                                        <div class="badge badge-md badge-outline-primary w-100 mb-1">
                                            <b>ALL COLORS</b>
                                        </div>
                                        <div class="text-center mb-3">
                                            <div class="badge badge-sm badge-danger"><b>D</b></div>
                                            <div class="badge badge-sm badge-success"><b>E</b></div>
                                            <div class="badge badge-sm badge-warning"><b>F</b></div>
                                            <div class="badge badge-sm badge-info"><b>G</b></div>
                                            <div class="badge badge-sm badge-secondary"><b>H</b></div>
                                            <div class="badge badge-sm badge-gray"><b>I</b></div>
                                            <div class="badge badge-sm badge-primary"><b>J</b></div>
                                            <div class="badge badge-sm badge-light"><b>K</b></div>
                                        </div>
                                        <div>
                                            <div class="mb-2">
                                                <div class="row">
                                                    <div class="col-6">D Color</div>
                                                    <div class="col-6 text-right">
                                                        @php
                                                            $color_d = $analysis->total_d ? number_format($analysis_p->total_d * 100 / $analysis->total_d, 2, '.', ',') : 0.00;
                                                            echo $color_d . '%';
                                                        @endphp
                                                    </div>
                                                </div>
                                                <div class="progress">
                                                    <div class="progress-bar bg-danger" data-progress="{{ $color_d }}"></div>
                                                </div>
                                            </div>
                                            <div class="mb-2">
                                                <div class="row">
                                                    <div class="col-6">E Color</div>
                                                    <div class="col-6 text-right">
                                                        @php
                                                            $color_e = $analysis->total_e ? number_format($analysis_p->total_e * 100 / $analysis->total_e, 2, '.', ',') : 0.00;
                                                            echo $color_e . '%';
                                                        @endphp
                                                    </div>
                                                </div>
                                                <div class="progress">
                                                    <div class="progress-bar bg-success" data-progress="{{ $color_e }}"></div>
                                                </div>
                                            </div>
                                            <div class="mb-2">
                                                <div class="row">
                                                    <div class="col-6">F Color</div>
                                                    <div class="col-6 text-right">
                                                        @php
                                                            $color_f = $analysis->total_f ? number_format($analysis_p->total_f * 100 / $analysis->total_f, 2, '.', ',') : 0.00;
                                                            echo $color_f . '%';
                                                        @endphp
                                                    </div>
                                                </div>
                                                <div class="progress">
                                                    <div class="progress-bar bg-warning" data-progress="{{ $color_f }}"></div>
                                                </div>
                                            </div>
                                            <div class="mb-2">
                                                <div class="row">
                                                    <div class="col-6">G Color</div>
                                                    <div class="col-6 text-right">
                                                        @php
                                                            $color_g = $analysis->total_g ? number_format($analysis_p->total_g * 100 / $analysis->total_g, 2, '.', ',') : 0.00;
                                                            echo $color_g . '%';
                                                        @endphp
                                                    </div>
                                                </div>
                                                <div class="progress">
                                                    <div class="progress-bar bg-info" data-progress="{{ $color_g }}"></div>
                                                </div>
                                            </div>
                                            <div class="mb-2">
                                                <div class="row">
                                                    <div class="col-6">H Color</div>
                                                    <div class="col-6 text-right">
                                                        @php
                                                            $color_h = $analysis->total_h ? number_format($analysis_p->total_h * 100 / $analysis->total_h, 2, '.', ',') : 0.00;
                                                            echo $color_h . '%';
                                                        @endphp
                                                    </div>
                                                </div>
                                                <div class="progress">
                                                    <div class="progress-bar bg-secondary" data-progress="{{ $color_h }}"></div>
                                                </div>
                                            </div>
                                            <div class="mb-2">
                                                <div class="row">
                                                    <div class="col-6">I Color</div>
                                                    <div class="col-6 text-right">
                                                        @php
                                                            $color_i = $analysis->total_i ? number_format($analysis_p->total_i * 100 / $analysis->total_i, 2, '.', ',') : 0.00;
                                                            echo $color_i . '%';
                                                        @endphp
                                                    </div>
                                                </div>
                                                <div class="progress">
                                                    <div class="progress-bar bg-gray" data-progress="{{ $color_i }}"></div>
                                                </div>
                                            </div>
                                            <div class="mb-2">
                                                <div class="row">
                                                    <div class="col-6">J Color</div>
                                                    <div class="col-6 text-right">
                                                        @php
                                                            $color_j = $analysis->total_j ? number_format($analysis_p->total_j * 100 / $analysis->total_j, 2, '.', ',') : 0.00;
                                                            echo $color_j . '%';
                                                        @endphp
                                                    </div>
                                                </div>
                                                <div class="progress">
                                                    <div class="progress-bar bg-primary" data-progress="{{ $color_j }}"></div>
                                                </div>
                                            </div>
                                            <div class="mb-2">
                                                <div class="row">
                                                    <div class="col-6">K Color</div>
                                                    <div class="col-6 text-right">
                                                        @php
                                                            $color_k = $analysis->total_k ? number_format($analysis_p->total_k * 100 / $analysis->total_k, 2, '.', ',') : 0.00;
                                                            echo $color_k . '%';
                                                        @endphp
                                                    </div>
                                                </div>
                                                <div class="progress">
                                                    <div class="progress-bar bg-light" data-progress="{{ $color_k }}"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-lg-4 col-sm-6 col-12 mb-4" >
                            <div class="card">
                                <div class="card-body">
                                    <h5>Clarity Analysis</h5>
                                    <hr>
                                    <div class="table-responsive-" >
                                        <canvas class="clarity-chart" id="clarityChartData" height="350"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <h5>Cut Analysis</h5>
                                    <hr>
                                    <div class="table-responsive-" >
                                        <canvas class="cut-chart" id="cutChartData" height="350"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-6 col-sm-12 col-12 mb-4" >
                            <div class="card">
                                <div class="card-body">
                                    <div>
                                        <table class="table" id="datatable-customers">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Diamonds</th>
                                                    <th>Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($final_customers as $c)
                                                    <tr>
                                                        <td>{{ $c['name'] }}</td>
                                                        <td>{{ $c['total_diamonds'] }}</td>
                                                        <td>${{ number_format($c['total_paid_amount'], 2, '.', ',') }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- .nk-block -->
            </div>
        </div>
    </div>
</div>
<!-- content @e -->
@endsection
@section('script')
<script src="/admin_assets/datatable/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="/admin_assets/datatable/dataTables.responsive.min.js" type="text/javascript" ></script>
<script>
    var table = $('#datatable-customers').DataTable({
        // sorting: false,
        "order": []
    });

    !function (NioApp, $) {

        var clarityChartData = {
            labels: ["IF", "VVS1", "VVS2", "VS1", "VS2", "SI1", "SI2", "SI3", "I1", "I2", "I3", "VS", "SI"],
            dataUnit: '%',
            legend: {
                position: 'top',
            },
            datasets: [{
                borderColor: "#fff",
                background: ["#8feac5", "#E85347", "#1EE0AC", "#F4BD0E", "#09C2DE", "#364A63", "#1F327F", "#E85347", "#1EE0AC", "#F4BD0E", "#09C2DE", "#364A63", "#1F327F"],
                data: [
                    "<?= ($analysis->total_if ? number_format($analysis_p->total_if * 100 / $analysis->total_if, 2, '.', ',') : 0.00) ?>",
                    "<?= ($analysis->total_vvs1 ? number_format($analysis_p->total_vvs1 * 100 / $analysis->total_vvs1, 2, '.', ',') : 0.00) ?>",
                    "<?= ($analysis->total_vvs2 ? number_format($analysis_p->total_vvs2 * 100 / $analysis->total_vvs2, 2, '.', ',') : 0.00) ?>",
                    "<?= ($analysis->total_vs1 ? number_format($analysis_p->total_vs1 * 100 / $analysis->total_vs1, 2, '.', ',') : 0.00) ?>",
                    "<?= ($analysis->total_vs2 ? number_format($analysis_p->total_vs2 * 100 / $analysis->total_vs2, 2, '.', ',') : 0.00) ?>",
                    "<?= ($analysis->total_si1 ? number_format($analysis_p->total_si1 * 100 / $analysis->total_si1, 2, '.', ',') : 0.00) ?>",
                    "<?= ($analysis->total_si2 ? number_format($analysis_p->total_si2 * 100 / $analysis->total_si2, 2, '.', ',') : 0.00) ?>",
                    "<?= ($analysis->total_si3 ? number_format($analysis_p->total_si3 * 100 / $analysis->total_si3, 2, '.', ',') : 0.00) ?>",
                    "<?= ($analysis->total_i1 ? number_format($analysis_p->total_i1 * 100 / $analysis->total_i1, 2, '.', ',') : 0.00) ?>",
                    "<?= ($analysis->total_i2 ? number_format($analysis_p->total_i2 * 100 / $analysis->total_i2, 2, '.', ',') : 0.00) ?>",
                    "<?= ($analysis->total_i3 ? number_format($analysis_p->total_i3 * 100 / $analysis->total_i3, 2, '.', ',') : 0.00) ?>",
                    "<?= ($analysis->total_vs ? number_format($analysis_p->total_vs * 100 / $analysis->total_vs, 2, '.', ',') : 0.00) ?>",
                    "<?= ($analysis->total_si ? number_format($analysis_p->total_si * 100 / $analysis->total_si, 2, '.', ',') : 0.00) ?>"
                ]
            }]
        };
        var cutChartData = {
            labels: ["IDEAL", "EXCELLENT", "VERY GOOD", "GOOD", "FAIR", "POOR"],
            dataUnit: '%',
            legend: {
                position: 'top',
            },
            datasets: [{
                borderColor: "#fff",
                background: ["#E85347", "#1EE0AC", "#F4BD0E", "#09C2DE", "#364A63", "#1F327F"],
                data: [
                    "<?= ($analysis->total_ideal ? number_format($analysis_p->total_ideal * 100 / $analysis->total_ideal, 2, '.', ',') : 0.00) ?>",
                    "<?= ($analysis->total_excellent ? number_format($analysis_p->total_excellent * 100 / $analysis->total_excellent, 2, '.', ',') : 0.00) ?>",
                    "<?= ($analysis->total_very_good ? number_format($analysis_p->total_very_good * 100 / $analysis->total_very_good, 2, '.', ',') : 0.00) ?>",
                    "<?= ($analysis->total_good ? number_format($analysis_p->total_good * 100 / $analysis->total_good, 2, '.', ',') : 0.00) ?>",
                    "<?= ($analysis->total_fair ? number_format($analysis_p->total_fair * 100 / $analysis->total_fair, 2, '.', ',') : 0.00) ?>",
                    "<?= ($analysis->total_poor ? number_format($analysis_p->total_poor * 100 / $analysis->total_poor, 2, '.', ',') : 0.00) ?>"
                ]
            }]
        };

        function _clarityChartData(selector, set_data) {
            var $selector = selector ? $(selector) : $('.clarity-chart');
            $selector.each(function () {
                var $self = $(this),
                _self_id = $self.attr('id'),
                _get_data = typeof set_data === 'undefined' ? eval(_self_id) : set_data;

                var selectCanvas = document.getElementById(_self_id).getContext("2d");
                var chart_data = [];

                for (var i = 0; i < _get_data.datasets.length; i++) {
                    chart_data.push({
                        backgroundColor: _get_data.datasets[i].background,
                        borderWidth: 2,
                        borderColor: _get_data.datasets[i].borderColor,
                        hoverBorderColor: _get_data.datasets[i].borderColor,
                        data: _get_data.datasets[i].data
                    });
                }

                var chart = new Chart(selectCanvas, {
                    type: 'doughnut',
                    data: {
                        labels: _get_data.labels,
                        datasets: chart_data
                    },
                    options: {
                        responsive: true,
                        legend: {
                            display: _get_data.legend ? _get_data.legend : false,
                            rtl: NioApp.State.isRTL,
                            labels: {
                                boxWidth: 25,
                                padding: 20,
                                fontColor: '#000000'
                            }
                        },
                        rotation: 1,
                        cutoutPercentage: 40,
                        maintainAspectRatio: false,
                        tooltips: {
                            enabled: true,
                            rtl: NioApp.State.isRTL,
                            callbacks: {
                                title: function title(tooltipItem, data) {
                                    return data['labels'][tooltipItem[0]['index']];
                                },
                                label: function label(tooltipItem, data) {
                                    return data.datasets[tooltipItem.datasetIndex]['data'][tooltipItem['index']] + ' ' + _get_data.dataUnit;
                                }
                            },
                            backgroundColor: '#eff6ff',
                            titleFontSize: 13,
                            titleFontColor: '#6783b8',
                            titleMarginBottom: 6,
                            bodyFontColor: '#9eaecf',
                            bodyFontSize: 12,
                            bodySpacing: 4,
                            yPadding: 10,
                            xPadding: 10,
                            footerMarginTop: 0,
                            displayColors: true
                        },
                        plugins: {
                            datalabels: {
                                display: true,
                                formatter: (val, ctx) => {
                                    return ctx.chart.data.labels[ctx.dataIndex];
                                },
                                color: '#fff',
                                backgroundColor: '#404040'
                            },
                        }
                    }
                });
            });
        } // init doughnut chart

        function _cutChartData(selector, set_data) {
            var $selector = selector ? $(selector) : $('.cut-chart');
            $selector.each(function () {
                var $self = $(this),
                _self_id = $self.attr('id'),
                _get_data = typeof set_data === 'undefined' ? eval(_self_id) : set_data;

                var selectCanvas = document.getElementById(_self_id).getContext("2d");
                var chart_data = [];

                for (var i = 0; i < _get_data.datasets.length; i++) {
                    chart_data.push({
                        backgroundColor: _get_data.datasets[i].background,
                        borderWidth: 2,
                        borderColor: _get_data.datasets[i].borderColor,
                        hoverBorderColor: _get_data.datasets[i].borderColor,
                        data: _get_data.datasets[i].data
                    });
                }

                var chart = new Chart(selectCanvas, {
                    type: 'doughnut',
                    data: {
                        labels: _get_data.labels,
                        datasets: chart_data
                    },
                    options: {
                        responsive: true,
                        legend: {
                            display: _get_data.legend ? _get_data.legend : false,
                            rtl: NioApp.State.isRTL,
                            labels: {
                                boxWidth: 25,
                                padding: 20,
                                fontColor: '#000000'
                            }
                        },
                        rotation: 1,
                        cutoutPercentage: 40,
                        maintainAspectRatio: false,
                        tooltips: {
                            enabled: true,
                            rtl: NioApp.State.isRTL,
                            callbacks: {
                                title: function title(tooltipItem, data) {
                                    return data['labels'][tooltipItem[0]['index']];
                                },
                                label: function label(tooltipItem, data) {
                                    return data.datasets[tooltipItem.datasetIndex]['data'][tooltipItem['index']] + ' ' + _get_data.dataUnit;
                                }
                            },
                            backgroundColor: '#eff6ff',
                            titleFontSize: 13,
                            titleFontColor: '#6783b8',
                            titleMarginBottom: 6,
                            bodyFontColor: '#9eaecf',
                            bodyFontSize: 12,
                            bodySpacing: 4,
                            yPadding: 10,
                            xPadding: 10,
                            footerMarginTop: 0,
                            displayColors: true
                        },
                        plugins: {
                            datalabels: {
                                display: true,
                                formatter: (val, ctx) => {
                                    return ctx.chart.data.labels[ctx.dataIndex];
                                },
                                color: '#fff',
                                backgroundColor: '#404040'
                            },
                        }
                    }
                });
            });
        } // init doughnut chart

        NioApp.coms.docReady.push(function () {
            _clarityChartData();
            _cutChartData();
        });

    }(NioApp, jQuery);
</script>
@endsection

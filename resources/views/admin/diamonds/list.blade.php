@extends('admin.header')
@section('css')
<link href="{{ asset(check_host().'admin_assets/datatable/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset(check_host().'admin_assets/datatable/dataTables.responsive.css')}}" rel="stylesheet" type="text/css">
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
                                    <h4 style="display: inline;" class="nk-block-title"><?php echo $data['cat_name']; ?> list</h4>
                                    <a style="float: right;" href="{{route('diamonds.import_excel')}}" class="btn btn-icon btn-primary">&nbsp;&nbsp;Import Excel<em class="icon ni ni-plus"></em></a>
                                    <a style="float: right;margin-right: 5px;" href="{{route('diamonds.add')}}" class="btn btn-icon btn-primary">&nbsp;&nbsp;Add Diamond<em class="icon ni ni-plus"></em></a>
                                </div>
                            </div><!-- .nk-block-head-content -->
                        </div>
                        <div class="card card-preview">
                            <div class="card-inner">
                                <table id="table" class="table dt-responsive nowrap">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center">#</th>
                                            <th scope="col" class="text-center">Stock No</th>
                                            <th scope="col" class="text-center">Shape</th>
                                            @if ($data['cat_type'] == config('constant.CATEGORY_TYPE_4P'))
                                            <th scope="col" class="text-center">4P Weight</th>
                                            @elseif ($data['cat_type'] == config('constant.CATEGORY_TYPE_ROUGH'))
                                            <th scope="col" class="text-center">Rough Weight</th>
                                            @endif
                                            <th scope="col" class="text-center">Carat</th>
                                            <th scope="col" class="text-center">Color</th>
                                            <th scope="col" class="text-center">Clarity</th>
                                            @if ($data['cat_type'] == config('constant.CATEGORY_TYPE_POLISH') || $data['cat_type'] == config('constant.CATEGORY_TYPE_4P'))
                                            <th scope="col" class="text-center">Cut</th>
                                            @endif
                                            <th scope="col" class="text-right">Rapaport</th>
                                            <th scope="col" class="text-right">Discount</th>
                                            <th scope="col" class="text-right">Price/CT</th>
                                            <th scope="col" class="text-right">Price</th>
                                            {{-- <th>isActive</th>
                                            <th>isDeleted</th>
                                            <th>Date Added</th> --}}
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div><!-- .card-preview -->
                    </div> <!-- nk-block -->
                </div><!-- .components-preview -->
            </div>
        </div>
    </div>
</div>
<div id='append_loader'></div>
<!-- content @e -->
@endsection
@section('script')
<script  src="{{ asset(check_host().'admin_assets/datatable/jquery.dataTables.min.js')}}" type="text/javascript"></script>
<script  src="{{ asset(check_host().'admin_assets/datatable/jquery.dataTables.min.js')}}" type="text/javascript"></script>
<script src="{{ asset(check_host().'admin_assets/datatable/dataTables.responsive.min.js')}}" type="text/javascript" ></script>
<script>
    var filter_shape = '{{ $request['shape'] }}';
</script>
@endsection
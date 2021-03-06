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
                                    <h4 style="display: inline;" class="nk-block-title">Attribute Groups list</h4>
                                    <a style="float: right;" href="{{route('attribute-groups.add')}}" class="btn btn-icon btn-primary">&nbsp;&nbsp;Add Attribute Groups<em class="icon ni ni-plus"></em></a>
                                </div>
                            </div><!-- .nk-block-head-content -->                                   
                        </div>                                       
                        <div class="card card-preview">                                                                                    
                            <div class="card-inner">                                             
                                <table id="table" class="table dt-responsive nowrap">
                                    <thead>
                                        <tr> 
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Image Required</th>
                                            <th>Field Type</th>
                                            <th>Category</th>
                                            <th>Is-Required</th>
                                            <th>isActive</th>
                                            <th>isDeleted</th>
                                            <th>Date Added</th>                                           
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
@endsection
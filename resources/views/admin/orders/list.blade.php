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
                                    <h4 style="display: inline;" class="nk-block-title">Orders list</h4> 
                                    <a style="float: right;" href="{{route('orders.import_excel')}}" class="btn btn-icon btn-primary">&nbsp;&nbsp;Import Excel<em class="icon ni ni-plus"></em></a>                                   
                                </div>
                            </div><!-- .nk-block-head-content -->                                   
                        </div>                                       
                        <div class="card card-preview">                                                                                    
                            <div class="card-inner">                                             
                                <table id="table" class="table dt-responsive nowrap">
                                    <thead>
                                        <tr> 
                                            <th>No</th>
                                            <th>Order Id</th>
                                            <th>Customer Name</th> 
                                            <th>Email</th> 
                                            <th>Mobile No</th>
                                            <th>Payment Mode</th>
                                            <th>Transaction Id</th> 
                                            <th>Added on</th> 
                                            <th>Updated On</th> 
                                            <th>Total Paid Amount</th> 
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
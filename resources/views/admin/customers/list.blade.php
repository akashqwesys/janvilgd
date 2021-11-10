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
                                    <h4 style="display: inline;" class="nk-block-title">Customers list</h4>                                    
                                    <a style="float: right;" href="{{route('customers.add')}}" class="btn btn-icon btn-primary">&nbsp;&nbsp;Add Customer<em class="icon ni ni-plus"></em></a>
                                    <div class="form-group col-2" style="float: right;">
                                        <div class="form-control-wrap">
                                            <select class="form-control" id="is_approved" tabindex="-1" aria-hidden="true">
                                                <option value="2" selected="">All</option>
                                                <option value="1">Verified</option>
                                                <option value="0">UnVerified</option>
                                            </select>
                                        </div>
                                    </div>
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
                                            <th>Mobile</th>
                                            <th>Email</th>
                                            <th>Address</th>
                                            <th>Pincode</th>
                                            <th>City</th>
                                            <th>State</th>
                                            <th>Country</th>
                                            <th>Customer Type</th>
                                            <th>Restrict Transaction</th>                                            
                                            <th>Added by</th>                                                                                  
                                            <th>isActive</th>
                                            <th>isDeleted</th>
                                            <th>isApproved</th>
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
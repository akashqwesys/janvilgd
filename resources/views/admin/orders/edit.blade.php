@extends('admin.header')

@section('content')
<div class="nk-content">
    <!--    @if(Session::has('designation_add'))
        <div class="alert alert-fill alert-success alert-dismissible alert-icon" role="alert">
            <em class="icon ni ni-alert-circle"></em>
            <strong>{{Session::get('designation_add')}}</strong>
        </div>
        @endif-->
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <h3 class="nk-block-title page-title" style="display: inline;">Edit Order</h3>
                        <a style="float: right;" href="/admin/orders" class="btn btn-icon btn-primary">&nbsp;&nbsp;Back To List<em class="icon ni ni-plus"></em></a>
                    </div><!-- .nk-block-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block nk-block-lg">
                    <div class="card">
                        <div class="card-inner">
                        
                            <h3 class="nk-block-title page-title" style="display: inline;">Update Address</h3> 
                            <hr> 

                            <form method="POST" action="{{route('orders.update')}}">
                                @csrf
                                <input type="hidden" name="id" value="{{ $data['result']->order_id }}">
                                <div class="row g-3 align-center">
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label class="form-label float-right" for="refCustomer_company_id_shipping">Shipping Address:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <select class="form-select form-control" id="refCustomer_company_id_shipping" name="refCustomer_company_id_shipping" required="" tabindex="-1" aria-hidden="true" data-search="on">
                                                    <option value="" disabled="" selected="">------ Select Shipping Address ------</option>
                                                    <?php if (!empty($data['address_list'])) {
                                                        foreach ($data['address_list'] as $row) {
                                                    ?>
                                                            <option value="{{ $row->customer_company_id }}" {{ set_selected($row->customer_company_id,$data['result']->refCustomer_company_id_shipping) }}>{{ $row->name }}, {{ $row->office_address }}, {{ $row->city_name }}, {{ $row->state_name }}, {{ $row->country_name }}-{{ $row->pincode }}</option>
                                                    <?php
                                                        }
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label class="form-label float-right" for="refCustomer_company_id_billing">Billing Address:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <select class="form-select form-control" id="refCustomer_company_id_billing" name="refCustomer_company_id_billing" required="" tabindex="-1" aria-hidden="true" data-search="on">
                                                    <option value="" disabled="" selected="">------ Select Billing Address ------</option>
                                                    <?php if (!empty($data['address_list'])) {
                                                        foreach ($data['address_list'] as $row) {
                                                    ?>
                                                            <option value="{{ $row->customer_company_id }}" {{ set_selected($row->customer_company_id,$data['result']->refCustomer_company_id_billing) }}>{{ $row->name }}, {{ $row->office_address }}, {{ $row->city_name }}, {{ $row->state_name }}, {{ $row->country_name }}-{{ $row->pincode }}</option>
                                                    <?php
                                                        }
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row g-3">
                                    <div class="col-sm-12 col-md-2 offset-md-2">
                                        <div class="form-group mt-2">
                                            <button type="submit" class="btn btn-lg btn-primary btn-block">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div><!-- card -->
                </div><!-- .nk-block -->
            </div>

            <br>
            <div class="nk-content-body">
                <div class="nk-block nk-block-lg">
                    <div class="card">
                        <div class="card-inner">
                            <h3 class="nk-block-title page-title" style="display: inline;">History</h3>
                            <hr> 
                            <table id="table" class="table dt-responsive nowrap table-bordered">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Comment</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    if(!empty($data['order_history'])){
                                    foreach($data['order_history'] as $oh_row){
                                    @endphp
                                    <tr>
                                        <td>{{date_time_formate($oh_row->date_added)}}</td>
                                        <td>{{$oh_row->comment}}</td>
                                        <td>{{$oh_row->order_status_name}}</td>
                                    </tr>
                                    @php
                                    }
                                    }
                                    @endphp

                                </tbody>
                            </table>


                                    <br>
                            <h3 class="nk-block-title page-title" style="display: inline;">Add Order History</h3> 
                            <hr>                          
                            <form method="POST" action="{{route('orders.addOrderHistory')}}">                                
                                @csrf
                                <input type="hidden" name="id" value="{{ $data['result']->order_id }}">
                                <div class="row g-3 align-center">
                                    <div class="col-lg-1">
                                        <div class="form-group">
                                            <label class="form-label float-right" for="order_status_name">Order Status:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <select class="form-select form-control" id="order_status_name" name="order_status_name" required="" tabindex="-1" aria-hidden="true" data-search="on">
                                                    <option value="" disabled="" selected="">------ Select Order Status ------</option>
                                                    <?php if (!empty($data['order_sts'])) {
                                                        foreach ($data['order_sts'] as $row) {
                                                    ?>
                                                            <option value="{{ $row->name }}" >{{ $row->name }}</option>
                                                    <?php
                                                        }
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                <div class="row g-3 align-center">
                                    <div class="col-lg-1">
                                        <div class="form-group">
                                            <label class="form-label float-md-right" for="comment">Comment:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <textarea name="comment" class="form-control form-control-sm" id="cf-default-textarea" placeholder="Enter comment"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>                               
                                <hr>
                                <div class="row g-3">
                                    <div class="col-sm-12 col-md-2 offset-md-2">
                                        <div class="form-group mt-2">
                                            <button type="submit" class="btn btn-lg btn-primary btn-block">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div><!-- card -->
                </div><!-- .nk-block -->
            </div>

        </div>
    </div>
</div>
@endsection
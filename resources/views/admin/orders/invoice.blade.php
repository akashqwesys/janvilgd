@extends('admin.header')
@section('css')
<style>
    label {
        margin-bottom: 5px;
    }
    .col-md-4 {
        margin-bottom: 1rem;
    }
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
                        <div class="card card-preview">
                            <div id='append_loader' class="overlay">
                                <div class='d-flex justify-content-center' style="padding-top: 10%;">
                                    <div class='spinner-border text-success' role='status'>
                                        <span class='sr-only'>Loading...</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-inner">
                                <h5>Create Invoice</h5>
                                <hr>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="barcode">Select Stock Nos:</label>
                                        <select name="barcode" id="barcode" class="form-control form-select-" data-placeholder="Select Stock Numbers" multiple required data-search="on">
                                            <option value="12">12</option>
                                            <option value="11">22</option>
                                            <option value="121">125</option>
                                            <option value="556">5454</option>
                                            <option value="5454">5474</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="customer_id">Select Customer:</label>
                                        <select name="customer_id" id="customer_id" class="form-control form-select" data-placeholder="Select Customer" required data-search="on">
                                            @foreach ($customers as $c)
                                            <option value="{{ $c->customer_id }}">{{ $c->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label><b style="letter-spacing: 2px;"> ORDER ID #</b></label>
                                        <h4 style="letter-spacing: 4px;">{{ $order_id }}</h4>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="invoice_date">Invoice Date:</label>
                                        <div class="form-control-wrap">
                                            <div class="form-icon form-icon-right">
                                                <em class="icon ni ni-calendar-alt"></em>
                                            </div>
                                            <input type="text" class="form-control date-picker" name="invoice_date" data-date-format="yyyy-mm-dd" id="invoice_date" required placeholder="Invoice Date">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="attention_to">Attention To:</label>
                                        <input type="text" class="form-control" name="attention_to" id="attention_to" placeholder="Attention To">
                                    </div>
                                </div>
                                <h5 class="mt-5 mb-2">Company Info</h5>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="company_name">Company Name:</label>
                                        <select class="form-control form-select" name="company_name" id="company_name" required data-placeholder="Company Name">
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="company_email">Email Address:</label>
                                        <input type="text" class="form-control" name="company_email" id="company_email" required placeholder="Email Address">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="company_mobile">Mobile Number:</label>
                                        <input type="text" class="form-control" name="company_mobile" id="company_mobile" required placeholder="Mobile Number">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="company_address">Address:</label>
                                        <input type="text" class="form-control" name="company_address" id="company_address" required placeholder="Address">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="company_country">Country:</label>
                                        <select class="form-control" name="company_country" id="company_country" required placeholder="">
                                            <option value="" >Select Country</option>
                                            @foreach ($country as $c)
                                            <option value="{{ $c->country_id }}" >{{ $c->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="company_state">State:</label>
                                        <select class="form-control" name="company_state" id="company_state" required placeholder="">
                                            <option value="" >Select State</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="company_city">City:</label>
                                        <select class="form-control" name="company_city" id="company_city" required placeholder="">
                                            <option value="" >Select City</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="company_zip">Postal/Zip Code:</label>
                                        <input class="form-control" name="company_zip" id="company_zip" type="text" required placeholder="Postal/Zip Code">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="company_remarks">Remarks:</label>
                                        <input class="form-control" name="company_remarks" id="company_remarks" type="text" required placeholder="Remarks">
                                    </div>
                                    <div class="col-md-4">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" data-msg="Required" class="custom-control-input" id="same_shipping" value="0">
                                            <label class="custom-control-label" for="same_shipping"> Is shipping address same as company address?</label>
                                        </div>
                                    </div>
                                </div>

                                <h5 class="mt-5 mb-2">Shipping Info</h5>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="shipping_name">Shipping Name:</label>
                                        <select class="form-control form-select" name="shipping_name" id="shipping_name" required data-placeholder="Shipping Company Name">
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="shipping_email">Email Address:</label>
                                        <input type="text" class="form-control" name="shipping_email" id="shipping_email" required placeholder="Email Address">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="shipping_mobile">Mobile Number:</label>
                                        <input type="text" class="form-control" name="shipping_mobile" id="shipping_mobile" required placeholder="Mobile Number">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="shipping_address">Address:</label>
                                        <input type="text" class="form-control" name="shipping_address" id="shipping_address" required placeholder="Address">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="shipping_country">Country:</label>
                                        <select class="form-control" name="shipping_country" id="shipping_country" required placeholder="">
                                            <option value="" >Select Country</option>
                                            @foreach ($country as $c)
                                            <option value="{{ $c->country_id }}" >{{ $c->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="shipping_state">State:</label>
                                        <select class="form-control" name="shipping_state" id="shipping_state" required placeholder="">
                                            <option value="" >Select State</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="shipping_city">City:</label>
                                        <select class="form-control" name="shipping_city" id="shipping_city" required placeholder="">
                                            <option value="" >Select City</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="shipping_zip">Postal/Zip Code:</label>
                                        <input class="form-control" name="shipping_zip" id="shipping_zip" type="text" required placeholder="Postal/Zip Code">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="shipping_remarks">Remarks:</label>
                                        <input class="form-control" name="shipping_remarks" id="shipping_remarks" type="text" required placeholder="Remarks">
                                    </div>
                                </div>

                                <div class="mt-5">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Stock No</th>
                                                <th>SHAPE</th>
                                                <th>CARAT</th>
                                                <th>COLOR</th>
                                                <th>CLARITY</th>
                                                <th>CUT</th>
                                                <th>RAPRATE</th>
                                                <th>DISCOUNT</th>
                                                <th>SHIPPING</th>
                                                <th>TOTAL</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

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
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#barcode').select2({
        ajax: {
            url: '/admin/orders/getBarcodes',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page
                };
            },
            processResults: function (data, params) {
                // parse the results into the format expected by Select2
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data, except to indicate that infinite
                // scrolling can be used
                params.page = params.page || 1;

                return {
                    results: data.items,
                    pagination: {
                        more: (params.page * 50) < data.total_count
                    }
                };
            },
            cache: true
        },
        minimumInputLength: 3
    });
    var company_details = [];
    $(document).on('change', '#customer_id', function () {
        $('#append_loader').show();
        var refCustomer_id = $(this).val();
        company_details = [];
        $.ajax({
            type: "POST",
            url: "/admin/orders/list/customer-address",
            data: {'refCustomer_id': refCustomer_id},
            dataType: 'json',
            success: function (res) {
                $("#company_name").empty();
                $("#shipping_name").empty();

                // $("#company_name").append(new Option('------ Select Shipping Address ------', ''));
                $.each(res, function (index, value) {
                    company_details[value.customer_company_id] = {
                        'email': value.official_email,
                        'mobile': value.office_no,
                        'address': value.office_address,
                        'pincode': value.pincode,
                        'country': value.refCountry_id,
                        'state': value.refState_id,
                        'city': value.refCity_id,
                    };
                    $('#company_name').append($('<option />').val(value.customer_company_id).text(value.name));
                    $('#shipping_name').append($('<option />').val(value.customer_company_id).text(value.name));
                });
            }
        });
        $('#append_loader').hide();
    });
    $(document).on('change', '#company_name, #shipping_name', function () {
        var val = $(this).val();
        if ($(this).attr('id') == 'company_name') {
            var ap = 'company';
        } else {
            var ap = 'shipping';
        }
        $('#'+ap+'_email').val(company_details[val].email);
        $('#'+ap+'_mobile').val(company_details[val].mobile);
        $('#'+ap+'_address').val(company_details[val].address);
        $('#'+ap+'_country').val(company_details[val].country).trigger('change');
        setTimeout(() => {
            $('#'+ap+'_state').val(company_details[val].state).trigger('change');
            setTimeout(() => {
                $('#'+ap+'_city').val(company_details[val].city);
            }, 1000);
        }, 1000);
        $('#'+ap+'_zip').val(company_details[val].pincode);
    });
    $(document).on('click', '#same_shipping', function () {
        if ($(this).prop('checked') === true) {
            $('#shipping_name').val($('#company_name').val()).trigger('change');
        }
    });
    $(document).on('change', '#company_country, #shipping_country', function () {
        $.ajax({
            type: "POST",
            url: "/getStates",
            data: { 'id': $(this).val() },
            // cache: false,
            context: this,
            dataType: 'JSON',
            success: function (response) {
                $('.cs-loader').hide();
                if (response.error) {
                    $.toast({
                        heading: 'Error',
                        text: response.message,
                        icon: 'error',
                        position: 'top-right'
                    });
                }
                else {
                    if ($(this).attr('id') == 'shipping_country') {
                        $('#shipping_state').html(response.data);
                    } else {
                        $('#company_state').html(response.data);
                    }
                }
            },
            failure: function (response) {
                $.toast({
                    heading: 'Error',
                    text: 'Oops, something went wrong...!',
                    icon: 'error',
                    position: 'top-right'
                });
            }
        });
    });
    $(document).on('change', '#company_state, #shipping_state', function () {
        $.ajax({
            type: "POST",
            url: "/getCities",
            data: { 'id': $(this).val() },
            // cache: false,
            context: this,
            dataType: 'JSON',
            success: function (response) {
                $('.cs-loader').hide();
                if (response.error) {
                    $.toast({
                        heading: 'Error',
                        text: response.message,
                        icon: 'error',
                        position: 'top-right'
                    });
                }
                else {
                    if ($(this).attr('id') == 'shipping_state') {
                        $('#shipping_city').html(response.data);
                    } else {
                        $('#company_city').html(response.data);
                    }
                }
            },
            failure: function (response) {
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
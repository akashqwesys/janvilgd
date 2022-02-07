@extends('admin.header')
@section('css')
<style>
    .spinner-border {
        width: 5rem;
        height: 5rem;
    }
    label {
        margin-bottom: 5px;
    }
    .col-md-4 {
        margin-bottom: 1rem;
    }
    #product-table th, #product-table td {
        padding: 0.75rem 0.5rem;
        border: 1px solid #dbdfea !important;
        vertical-align: middle;
    }
    .fl-ri {
        float: right;
        display: flex;
    }
    .display-inline {
        display: inline-block;
    }
    .custom-modal .form-group {
        margin-bottom: 0;
    }
    .custom-modal .col {
        margin-bottom: 1.25rem;
    }
    .errTxt {
        color: red;
        text-align: center;
        font-size: 0.9em;
    }
    .custom-modal .form-group .input-icon {
        position: absolute;
        top: 0;
        left: 10px;
        bottom: 0;
        width: 20px;
        margin: auto;
    }
    .custom-modal .form-group .form-control, .custom-modal .form-group select.form-select {
        padding-left: 40px;
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
                                <div class='d-flex justify-content-center' style="padding-top: 60%;">
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
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="customer_id">Select Customer:</label>
                                        <select name="customer_id" id="customer_id" class="form-control form-select" data-placeholder="Select Customer" required data-search="on">
                                            <option value="" selected>Select Customer</option>
                                            @foreach ($customers as $c)
                                            <option value="{{ $c->customer_id }}">{{ $c->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label><b style="letter-spacing: 2px;"> ORDER ID #</b></label>
                                        <h4 style="letter-spacing: 4px;">{{ $order_id+1 }}</h4>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="invoice_date">Invoice Date:</label>
                                        <div class="form-control-wrap">
                                            <div class="form-icon form-icon-right">
                                                <em class="icon ni ni-calendar-alt"></em>
                                            </div>
                                            <input type="text" class="form-control date-picker" name="invoice_date" data-date-format="dd-mm-yyyy" id="invoice_date" required placeholder="Invoice Date" value="{{ date('d-m-Y') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="due_date">Due Date:</label>
                                        <div class="form-control-wrap">
                                            <div class="form-icon form-icon-right">
                                                <em class="icon ni ni-calendar-alt"></em>
                                            </div>
                                            <input type="text" class="form-control date-picker" name="due_date" data-date-format="dd-mm-yyyy" id="due_date" required placeholder="Due Date">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="attention_to">Attention To:</label>
                                        <input type="text" class="form-control" name="attention_to" id="attention_to" placeholder="Attention To">
                                    </div>
                                </div>
                                <h5 class="mt-5 mb-2">Company/Billing Info</h5>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="company_name">Company Name:</label>
                                        <div class="w-85 display-inline">
                                            <select class="form-control form-select" name="company_name" id="company_name" required data-placeholder="Company Name">
                                            </select>
                                        </div>
                                        <span>
                                            <button class="btn btn-sm btn-primary" id="add-billing-btn" disabled>+</button>
                                        </span>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="company_email">Email Address:</label>
                                        <input type="text" class="form-control" name="company_email" id="company_email" required placeholder="Email Address" disabled>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="company_mobile">Mobile Number:</label>
                                        <input type="text" class="form-control" name="company_mobile" id="company_mobile" required placeholder="Mobile Number" disabled>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="company_address">Address:</label>
                                        <input type="text" class="form-control" name="company_address" id="company_address" required placeholder="Address" disabled>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="company_country">Country:</label>
                                        <input type="text" class="form-control" name="company_country" id="company_country" required placeholder="Country" disabled>
                                        {{-- <select class="form-control" name="company_country" id="company_country" required placeholder="" disabled>
                                            <option value="" >Select Country</option>
                                            @foreach ($country as $c)
                                            <option value="{{ $c->country_id }}" >{{ $c->name }}</option>
                                            @endforeach
                                        </select> --}}
                                    </div>
                                    <div class="col-md-4">
                                        <label for="company_state">State:</label>
                                        <input type="text" class="form-control" name="company_state" id="company_state" required placeholder="State" disabled>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="company_city">City:</label>
                                        <input type="text" class="form-control" name="company_city" id="company_city" required placeholder="City" disabled>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="company_zip">Postal/Zip Code:</label>
                                        <input class="form-control" name="company_zip" id="company_zip" type="text" required placeholder="Postal/Zip Code" disabled>
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
                                        <div class="w-85 display-inline">
                                            <select class="form-control form-select" name="shipping_name" id="shipping_name" required data-placeholder="Shipping Company Name">
                                            </select>
                                        </div>
                                        <span>
                                            <button class="btn btn-sm btn-primary" id="add-shipping-btn" disabled>+</button>
                                        </span>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="shipping_email">Email Address:</label>
                                        <input type="text" class="form-control" name="shipping_email" id="shipping_email" required placeholder="Email Address" disabled>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="shipping_mobile">Mobile Number:</label>
                                        <input type="text" class="form-control" name="shipping_mobile" id="shipping_mobile" required placeholder="Mobile Number" disabled>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="shipping_address">Address:</label>
                                        <input type="text" class="form-control" name="shipping_address" id="shipping_address" required placeholder="Address" disabled>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="shipping_country">Country:</label>
                                        <input class="form-control" name="shipping_country" id="shipping_country" required placeholder="Country" disabled>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="shipping_state">State:</label>
                                        <input class="form-control" name="shipping_state" id="shipping_state" required placeholder="State" disabled>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="shipping_city">City:</label>
                                        <input class="form-control" name="shipping_city" id="shipping_city" required placeholder="City" disabled>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="shipping_zip">Postal/Zip Code:</label>
                                        <input class="form-control" name="shipping_zip" id="shipping_zip" type="text" required placeholder="Postal/Zip Code" disabled>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="shipping_remarks">Remarks:</label>
                                        <input class="form-control" name="shipping_remarks" id="shipping_remarks" type="text" required placeholder="Remarks">
                                    </div>
                                </div>

                                <div class="mt-5 table-responsive">
                                    <table class="table" id="product-table">
                                        <thead>
                                            <tr>
                                                <th width="10%">STOCK NO</th>
                                                <th width="9%">SHAPE</th>
                                                <th width="7%">CARAT</th>
                                                <th width="7%">COLOR</th>
                                                <th width="8%">CLARITY</th>
                                                <th width="9%">CUT</th>
                                                <th width="8%">RAPRATE</th>
                                                <th width="12%">DISCOUNT (%)</th>
                                                <th width="15%"><div class="text-right">PRICE</div></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="9" style="background: lightgray;"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="8" align="right"><b>SUBTOTAL</b></td>
                                                <td align="right"> $<div class="fl-ri" id="subtotal">0</div></td>
                                            </tr>
                                            <tr>
                                                <td colspan="8" align="right"><b>DISCOUNT</b></td>
                                                <td align="right"> $<div class="fl-ri" id="discount">0</div></td>
                                            </tr>
                                            <tr>
                                                <td colspan="8" align="right"><b>ADD. DISCOUNT</b></td>
                                                <td align="right"> $<div class="fl-ri" id="add_discount">0</div></td>
                                            </tr>
                                            <tr>
                                                <td colspan="8" align="right"><b>TAX</b></td>
                                                <td align="right"> $<div class="fl-ri" id="tax">0</div></td>
                                            </tr>
                                            <tr>
                                                <td colspan="8" align="right"><b>SHIPPING CHARGE ($)</b></td>
                                                <td align="right">
                                                    <div class="fl-ri-">
                                                        <input type="text" id="shipping_charge" class="form-control text-right">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="8" align="right"><h6>TOTAL AMOUNT</h6></td>
                                                <td align="right"> <h6>$<div class="fl-ri" id="total">0</div></h6></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div><!-- .card-preview -->
                        <div class="text-right mt-4">
                            <button class="btn btn-primary mr-2" id="saveInvoice">SAVE</button>
                            <a class="btn btn-light" href="/admin/orders">CANCEL</a>
                        </div>
                    </div> <!-- nk-block -->
                </div><!-- .components-preview -->
            </div>
        </div>
    </div>
</div>
<!-- Add Address Modal -->
<div class="custom-modal add-address modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div class="add-address-content">
                    <h4 class="title mb-4">Add New Address</h4>
                    <div class="add-address-form">
                        <form class="add-form row" method="POST" action="/customer/save-addresses" enctype="multipart/form-data" id="companyForm">
                            @csrf
                            <input type="hidden" name="company_type" id="company_type">
                            <input type="hidden" name="form_customer_id" id="form_customer_id">
                            <div class="col col-12 col-md-6">
                                <div class="form-group">
                                    <img src="/assets/images/architecture_building_city_company.svg" alt="icn" class="img-fluid input-icon">
                                    <input type="text" class="form-control" id="company_name2" name="company_name" placeholder="Company Name">
                                </div>
                                <div class="errTxt"></div>
                            </div>
                            <div class="col col-12 col-md-6">
                                <div class="form-group">
                                    <img src="/assets/images/architecture_building_city_company.svg" alt="icn" class="img-fluid input-icon">
                                    <input type="text" class="form-control" id="company_office_no" name="company_office_no" placeholder="Company Mobile">
                                </div>
                                <div class="errTxt"></div>
                            </div>
                            <div class="col col-12 col-md-6">
                                <div class="form-group">
                                    <img src="/assets/images/envelop.svg" alt="icn" class="img-fluid input-icon">
                                    <input type="email" class="form-control" id="company_email2" name="company_email" placeholder="Company Email Address">
                                </div>
                                <div class="errTxt"></div>
                            </div>
                            <div class="col col-12 col-md-6">
                                <div class="form-group">
                                    <img src="/assets/images/bag_finance_money_icon.svg" alt="icn" class="img-fluid input-icon">
                                    <input type="text" name="company_gst_pan" id="company_gst_pan" class="form-control" placeholder="Company GST/PAN" >
                                </div>
                                <div class="errTxt"></div>
                            </div>
                            <div class="col col-12 col-md-4">
                                <div class="form-group">
                                    <img src="/assets/images/flag.svg" alt="icn" class="img-fluid input-icon">
                                    <select class="form-select- form-control" id="company_country2" name="company_country">
                                        <option value="" >Select Country</option>
                                        @foreach ($country as $c)
                                        <option value="{{ $c->country_id }}" >{{ $c->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="errTxt"></div>
                            </div>
                            <div class="col col-12 col-md-4">
                                <div class="form-group">
                                    <img src="/assets/images/flag.svg" alt="icn" class="img-fluid input-icon">
                                    <select class="form-select- form-control" id="company_state2" name="company_state">
                                        <option value="" >Select State</option>
                                    </select>
                                </div>
                                <div class="errTxt"></div>
                            </div>
                            <div class="col col-12 col-md-4">
                                <div class="form-group">
                                    <img src="/assets/images/building_city.svg" alt="icn" class="img-fluid input-icon">
                                    <select class="form-select- form-control" id="company_city2" name="company_city">
                                        <option value="" >Select City</option>
                                    </select>
                                </div>
                                <div class="errTxt"></div>
                            </div>
                            <div class="col col-12 col-md-8">
                                <div class="form-group">
                                    <img src="/assets/images/location.svg" alt="icn" class="img-fluid input-icon" style="width: 15px">
                                    <input type="text" class="form-control" id="company_address2" name="company_address" placeholder="Company Address" >
                                </div>
                                <div class="errTxt"></div>
                            </div>
                            <div class="col col-12 col-md-4">
                                <div class="form-group">
                                    <img src="/assets/images/location.svg" alt="icn" class="img-fluid input-icon" style="width: 15px">
                                    <input type="text" class="form-control" id="company_pincode" name="company_pincode" placeholder="Company Pincode">
                                </div>
                                <div class="errTxt"></div>
                            </div>
                            <div class="col col-12 col-md-12">
                                <div class="form-group">
                                    <div class="upload-file-box">
                                        <div class="file-upload-box">
                                            <div class="file-select text-center m-auto">
                                                {{-- <img src="/assets/images/upload-file-icon.svg" alt="icn" class="img-fluid mb-3"> --}}
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="id_upload" name="id_upload" id="id_upload" aria-describedby="inputGroupFileAddon01" accept="image/jpeg,image/png,application/pdf">
                                                        <label class="custom-file-label ml-auto mr-auto" for="id_upload">Click here to upload ID proof</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="errTxt"></div>
                                    </div>
                                    <p class="mb-0 mt-3">Business Identity Proof (scan and upload only .jpg, .jpeg, .png and .pdf files)</p>
                                </div>
                            </div>
                            <div class="col col-12 col-md-12 mb-0">
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- content @e -->
@endsection
@section('script')
<script type="text/javascript">
    // $('#due_date').datepicker('setStartDate', "2022-01-01");
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
                        more: (30) < data.total_count
                    }
                };
            },
            cache: true
        },
        minimumInputLength: 3
    });
    $("#exampleModal").on('hidden.bs.modal', function(){
        $('div.errTxt').html('');
        $('#companyForm')[0].reset();
        $('.custom-file-label').text('Click here to upload ID proof');
    });
    $(document).on('click', '#add-shipping-btn', function () {
        $('#exampleModal .title').text('Add Shipping Address');
        $('#company_type').val('shipping');
        $('#form_customer_id').val($('#customer_id').val());
        $('#exampleModal').modal('show');
    });
    $(document).on('click', '#add-billing-btn', function () {
        $('#exampleModal .title').text('Add Billing Address');
        $('#company_type').val('billing');
        $('#form_customer_id').val($('#customer_id').val());
        $('#exampleModal').modal('show');
    });

    var company_details = [];
    var shipping_charge = null;
    var address_added = false;
    var address_id = null;
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
                        'country': value.country_name,
                        'state': value.state_name,
                        'city': value.city_name,
                    };
                    $('#company_name').append($('<option />').val(value.customer_company_id).text(value.name));
                    $('#shipping_name').append($('<option />').val(value.customer_company_id).text(value.name));
                });
                if (address_added == false) {
                    $('#company_name, #shipping_name').trigger('change');
                    $('#add-billing-btn, #add-shipping-btn').attr('disabled', false);
                } else {
                    if ($('#company_type').val() == 'shipping') {
                        $("#shipping_name").val(address_id).trigger('change');
                    } else {
                        $("#company_name").val(address_id).trigger('change');
                    }
                }
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
            if ($('#barcode').val().length > 0) {
                $.ajax({
                    type: "POST",
                    url: "/admin/orders/get-updated-tax",
                    data: {'shipping_id': $(this).val(), 'customer_id': $('#customer_id').val()},
                    success: function (res) {
                        if (res.success) {
                            var disc = parseFloat($("#discount").text());
                            var add_disc = parseFloat($("#add_discount").text());
                            var tax = (parseFloat($("#subtotal").text()) - disc - add_disc) * parseFloat(res.tax) / 100;
                            var total = parseFloat($("#total").text()) - parseFloat($("#tax").text().replace(',', '')) + tax;
                            $("#tax").text(tax.toFixed(2));
                            $("#total").text(total.toFixed(2));
                        }
                    }
                });
            }
        }
        $('#'+ap+'_email').val(company_details[val].email);
        $('#'+ap+'_mobile').val(company_details[val].mobile);
        $('#'+ap+'_address').val(company_details[val].address);
        $('#'+ap+'_country').val(company_details[val].country);
        $('#'+ap+'_state').val(company_details[val].state);
        $('#'+ap+'_city').val(company_details[val].city);
        $('#'+ap+'_zip').val(company_details[val].pincode);
    });

    $(document).on('click', '#same_shipping', function () {
        if ($(this).prop('checked') === true) {
            $('#shipping_name').val($('#company_name').val()).trigger('change');
        }
    });

    $(document).on('change', /*'#company_country, #shipping_country,*/ '#company_country2', function () {
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
                    // if ($(this).attr('id') == 'shipping_country') {
                    //     $('#shipping_state').html(response.data);
                    // } else if ($(this).attr('id') == 'company_country') {
                    //     $('#company_state').html(response.data);
                    // } else {
                        $('#company_state2').html(response.data);
                    // }
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

    $(document).on('change', /*'#company_state, #shipping_state,*/ '#company_state2', function () {
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
                    // if ($(this).attr('id') == 'shipping_state') {
                    //     $('#shipping_city').html(response.data);
                    // } else if ($(this).attr('id') == 'company_state') {
                    //     $('#company_city').html(response.data);
                    // } else {
                        $('#company_city2').html(response.data);
                    // }
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

    $(document).on('change', '#barcode', function () {
        $('.tr_products').remove();
        if ($(this).val().length > 0) {
            $.ajax({
                type: "POST",
                url: "/admin/orders/getDiamonds",
                data: {
                    'barcode': $(this).val(),
                    'customer_id': $('#customer_id').val(),
                    'shipping_id': $('#shipping_name').val()
                },
                // cache: false,
                context: this,
                dataType: 'JSON',
                success: function (response) {
                    if (response.error) {
                        $.toast({
                            heading: 'Error',
                            text: response.message,
                            icon: 'error',
                            position: 'top-right'
                        });
                    }
                    else {
                        $('#product-table tbody').prepend(response.data.data);
                        $('#subtotal').text(response.data.subtotal);
                        $('#discount').text(response.data.discount);
                        $('#add_discount').text(response.data.add_discount);
                        $('#tax').text(response.data.tax);
                        $('#shipping_charge').val(response.data.shipping_charge);
                        shipping_charge = parseFloat(response.data.shipping_charge);
                        $('#total').text(response.data.total);
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
        } else {
            $('#subtotal').text(0);
            $('#discount').text(0);
            $('#add_discount').text(0);
            $('#tax').text(0);
            $('#shipping_charge').val(0);
            shipping_charge = 0;
            $('#total').text(0);
        }
    });

    $("#companyForm").validate({
        errorClass: 'red-error',
        errorElement: 'div',
        rules: {
            company_name: {required: true, minlength: 4, maxlength: 200},
            company_office_no: { required: true, rangelength: [10, 11]},
            company_email: {required: true, email: true},
            company_gst_pan: {required: true, minlength: 10, maxlength: 15},
            company_address: {required: true, rangelength: [10, 200]},
            company_country: {required: true},
            company_state: {required: true},
            company_city: {required: true},
            company_pincode: { required: true, number: true},
            // id_upload: { required: true }
        },
        messages: {
            company_name: {required: "Please enter your company name"},
            company_email: {
                required: "Please enter your email address",
                email: "Your email address must be in the format of name@domain.com"
            },
            company_office_no: {
                required: "Please enter your mobile number",
                number: "Your contact number should only consist of numeric digits"
            },
            company_email: { required: "Please enter your company email address"},
            company_gst_pan: {required: "Please enter your company GST or PAN"},
            company_address: {required: "Please enter your company address"},
            company_country: {required: "Please select the country"},
            company_state: {required: "Please select the state/province"},
            company_city: {required: "Please enter the city name"},
            company_pincode: {required: "Please enter the pincode"},
            // id_upload: {required: "Please select the identity proof"}
        },
        errorPlacement: function(error, element) {
            if (element.attr('id') == 'id_upload') {
                error.appendTo( element.closest('.file-upload-box').nextAll("div.errTxt") );
            } else {
                error.appendTo( element.parent().nextAll("div.errTxt") );
            }
        },
        submitHandler: function(form) {
            // do other things for a valid form
            // form.submit();
            var formData = new FormData(form);
            if ($('#id_upload')[0].files.length > 0) {
                formData.append('id_upload', $('#id_upload')[0].files);
            }
            $.ajax({
                type: "POST",
                url: "/admin/customers/save-addresses",
                data: formData,
                processData : false,
                contentType : false,
                context: this,
                dataType: 'JSON',
                success: function(response) {
                    $('.cs-loader').hide();
                    if (response.success == 1) {
                        $.toast({
                            heading: 'Success',
                            text: response.message,
                            icon: 'success',
                            position: 'top-right'
                        });
                        /* var opt = null;
                        $(response.data).each(function (i, v) {
                            opt += '<option value="'+ v.customer_company_id +'" >'+ v.name +' </option>';
                        });
                        $('#company_name, #shipping_name').html(opt);
                        $('#company_name, #shipping_name').select2('destroy').select2({
                            width: '100%'
                        });
                        if ($('#company_type').val() == 'shipping') {
                            $("#shipping_name").val(response.id).trigger('change');
                        } else {
                            $("#company_name").val(response.id).trigger('change');
                        }*/
                        address_added = true;
                        address_id = response.id;
                        $("#customer_id").trigger('change');
                        $('#exampleModal').modal('hide');
                    }
                    if(response.error) {
                        $.toast({
                            heading: 'Error',
                            text: response.message,
                            icon: 'error',
                            position: 'top-right'
                        });
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
        }
    });
    $(document).on('change', '#id_upload', function () {
        $(this).next('label').text($(this)[0].files[0].name);
    });

    var labour_4p = {{ $labour_charge_4p->amount }};
    var labour_rough = {{ $labour_charge_rough->amount }};
    $(document).on('change', '.newDiscount', function () {
        var new_discount = $(this).val();
        // var price = parseFloat($(this).parent('td').next('td').text());
        var category = $(this).attr('data-category');
        var rapa_price = parseFloat($(this).parent('td').prev('td').text().substring(1));
        var exp_pol_cts = parseFloat($(this).closest('tr').find('td').eq(2).text());
        if (category == 3) {
            var new_price = rapa_price * exp_pol_cts * ((100 - new_discount) / 100);
        } else if (category == 2) {
            var new_price = (rapa_price * exp_pol_cts * ((100 - new_discount) / 100)) - (exp_pol_cts * labour_4p);
        } else {
            var makable_cts = $(this).attr('data-makable');
            var new_price = ((rapa_price * exp_pol_cts * ((100 - new_discount) / 100) / makable_cts) - labour_rough) * makable_cts;
        }
        $(this).parent('td').next('td').text('$' + new_price.toFixed(2));
        var subtotal = 0;
        $('.price_td').each(function () {
            subtotal += parseFloat($(this).text().substring(1));
        });
        var new_total = subtotal.toFixed(2) - parseFloat($('#discount').text()) - parseFloat($('#add_discount').text()) + parseFloat($('#tax').text()) + parseFloat($('#shipping_charge').val());
        $('#subtotal').text(subtotal.toFixed(2));
        $('#total').text(new_total.toFixed(2));
    });

    $(document).on('change', '#shipping_charge', function () {
        var new_shipping_charge = parseFloat($(this).val());
        var new_total = parseFloat($('#total').text());
        $('#total').text((new_total - shipping_charge + new_shipping_charge).toFixed(2));
        shipping_charge = new_shipping_charge;
    });

    function _validate_ (msg) {
        $.toast({
            heading: 'Error',
            text: msg,
            icon: 'error',
            position: 'top-right'
        });
    }
    $(document).on('click', '#saveInvoice', function() {
        if ($('#barcode').val().length < 1) {
            _validate_('Select atleast one Stock Number');
            return false;
        } else if ($('#customer_id').val() == '') {
            _validate_('Select a Customer');
            return false;
        } else if ($('#company_name').val() == '') {
            _validate_('Select Billing Company');
            return false;
        } else if ($('#shipping_name').val() == '') {
            _validate_('Select Shipping Company');
            return false;
        }
        var discounts = {};
        $('.newDiscount').each(function() {
            discounts[$(this).closest('tr').find('td').eq(0).text()] = $(this).val();
        });

        var barcodes = [];
        $('.tr_products').each(function() {
            barcodes.push($(this).find('td').eq(0).text());
        });
        $('#append_loader').show();
        $.ajax({
            type: "POST",
            url: "/admin/orders/save-invoice",
            data: {
                'customer_id': $('#customer_id').val(),
                'invoice_date': $('#invoice_date').val(),
                'barcode': $('#barcode').val(),
                'attention_to': $('#attention_to').val(),
                'billing_id': $('#company_name').val(),
                'shipping_id': $('#shipping_name').val(),
                'discounts': discounts,
                'shipping_remarks': $('#shipping_remarks').val(),
                'company_remarks': $('#company_remarks').val(),
                'shipping_charge': $('#shipping_charge').val(),
                'due_date': $('#due_date').val()
            },
            dataType: 'json',
            success: function (res) {
                if (res.success) {
                    $.toast({
                        heading: 'Success',
                        text: res.message,
                        icon: 'success',
                        position: 'top-right'
                    });
                    setTimeout(() => {
                        location.href = '/admin/orders';
                    }, 3000);
                } else {
                    $.toast({
                        heading: 'Error',
                        text: res.message,
                        icon: 'error',
                        position: 'top-right'
                    });
                }
            }
        });
        $('#append_loader').hide();
    });
</script>
@endsection
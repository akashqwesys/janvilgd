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
    }
    .fl-ri {
        float: right;
        display: flex;
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
                                            <input type="text" class="form-control date-picker" name="invoice_date" data-date-format="yyyy-mm-dd" id="invoice_date" required placeholder="Invoice Date">
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
                                        <select class="form-control form-select" name="company_name" id="company_name" required data-placeholder="Company Name">
                                        </select>
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
                                        <select class="form-control" name="company_country" id="company_country" required placeholder="" disabled>
                                            <option value="" >Select Country</option>
                                            @foreach ($country as $c)
                                            <option value="{{ $c->country_id }}" >{{ $c->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="company_state">State:</label>
                                        <select class="form-control" name="company_state" id="company_state" required placeholder="" disabled>
                                            <option value="" >Select State</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="company_city">City:</label>
                                        <select class="form-control" name="company_city" id="company_city" required placeholder="" disabled>
                                            <option value="" >Select City</option>
                                        </select>
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
                                        <select class="form-control form-select" name="shipping_name" id="shipping_name" required data-placeholder="Shipping Company Name">
                                        </select>
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
                                        <select class="form-control" name="shipping_country" id="shipping_country" required placeholder="" disabled>
                                            <option value="" >Select Country</option>
                                            @foreach ($country as $c)
                                            <option value="{{ $c->country_id }}" >{{ $c->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="shipping_state">State:</label>
                                        <select class="form-control" name="shipping_state" id="shipping_state" required placeholder="" disabled>
                                            <option value="" >Select State</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="shipping_city">City:</label>
                                        <select class="form-control" name="shipping_city" id="shipping_city" required placeholder="" disabled>
                                            <option value="" >Select City</option>
                                        </select>
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
                                                <td colspan="8" align="right"><b>SHIPPING CHARGE</b></td>
                                                <td align="right"> $<div class="fl-ri" id="shipping_charge">0</div></td>
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
                        more: (30) < data.total_count
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
                $('#company_name').trigger('change');
                $('#shipping_name').trigger('change');
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
                        $('#shipping_charge').text(response.data.shipping_charge);
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
        }
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
        var new_total = subtotal.toFixed(2) - parseFloat($('#discount').text()) - parseFloat($('#add_discount').text()) + parseFloat($('#tax').text()) + parseFloat($('#shipping_charge').text());
        $('#subtotal').text(subtotal.toFixed(2));
        $('#total').text(new_total.toFixed(2));
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
        console.log(discounts);
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
                'billing_id': $('#company_name').val(),
                'shipping_id': $('#shipping_name').val(),
                'discounts': discounts,
                'shipping_remarks': $('#shipping_remarks').val(),
                'company_remarks': $('#company_remarks').val()
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
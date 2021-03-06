@extends('front.layout_2')
@section('title', $title)
@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"/>
<style class="text/css">
    .custom-modal .form-group {
        margin-bottom: 0;
    }
    .custom-modal .col {
        margin-bottom: 2rem;
    }
    .errTxt {
        color: red;
        text-align: center;
        font-size: 0.9em;
    }
    .spaceBlock {
        min-height: 15rem;
        padding: 2rem 2rem 1rem;
    }
    .select2:not(:first-child) {
        width: 100% !important;
        /* padding-left: 40px; */
    }
    .select2-selection.select2-selection--single {
        height: 43px;
        padding: 8px 0px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 40px;
    }
    form label {
        margin-bottom: 0.5rem;
    }
</style>
@endsection
@section('content')
<div class="overlay cs-loader">
    <div class="overlay__inner">
    <div class="overlay__content"><img src='/assets/images/Janvi_Akashs_Logo_Loader_2.gif'></div>
    </div>
</div>
<section class="sub-header">
    <div class="container">
        <div class="section-content">
            <div>
                <h2 class="title bread-crumb-title">Checkout</h2>
            </div>
        </div>
    </div>
</section>
<div class="cart-page mb-5">
    <div class="container">
        @if (count($response) == 0)
        <div class="alert alert-danger text-center mb-5">
            <h4 class="m-0"><b> YOUR CART IS EMPTY</b></h4>
        </div>
        @else
        <div class="row">
            {{-- <div class="col col-12 pb-3">
                <ul class="chekot-menu-list">
                    <li>Address</li>
                    <li>Payment</li>
                </ul>
                <!-- <h2>Select Address</h2> -->
            </div> --}}
            <div class="col col-12 col-md-6">
                <div class="accordion checkout-accordion" id="checkoutaccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <h5>Billing Address</h5>
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo" data-bs-parent="#checkoutaccordion">
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="col col-sm-12 col-md-8 col-lg-9">
                                        <select class="form-control select2" id="billing-select">
                                            {{-- <option value="" disabled selected>SELECT BILLING ADDRESS</option> --}}
                                            @foreach($response['all_company_details'] as $c)
                                            <option value="{{ $c->customer_company_id }}"
                                                data-name="{{ $c->name }}"
                                                data-office_no="{{ $c->office_no }}"
                                                data-official_email="{{ $c->official_email }}"
                                                data-office_address="{{ $c->office_address }}"
                                                data-pincode="{{ $c->pincode }}"
                                                data-city_name="{{ $c->city_name }}"
                                                data-state_name="{{ $c->state_name }}"
                                                data-country_name="{{ $c->country_name }}"
                                                >{{ $c->name .'.  '. $c->city_name .' - '. $c->pincode .', '. $c->state_name .', '. $c->country_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <div class="spaceBlock">
                                            <div id="billing-address-block"></div>
                                        </div>
                                        <hr>
                                        <div class="m-3">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="same_shipping" value="0">
                                                <label class="form-check-label" for="same_shipping"> <i>Click here to select same as a billing address</i></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col col-sm-12 col-md-4 col-lg-3">
                                        <button class="btn btn-primary add-billing-btn">+ Add New</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <h5>Shipping Address</h5>
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#checkoutaccordion">
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="col col-sm-12 col-md-8 col-lg-9">
                                        <select class="form-control select2" id="shipping-select">
                                            <option value="" disabled selected>SELECT SHIPPING ADDRESS</option>
                                            @foreach($response['all_company_details'] as $c)
                                            <option value="{{ $c->customer_company_id }}"
                                                data-name="{{ $c->name }}"
                                                data-office_no="{{ $c->office_no }}"
                                                data-official_email="{{ $c->official_email }}"
                                                data-office_address="{{ $c->office_address }}"
                                                data-pincode="{{ $c->pincode }}"
                                                data-city_name="{{ $c->city_name }}"
                                                data-state_name="{{ $c->state_name }}"
                                                data-country_name="{{ $c->country_name }}"
                                                >{{ $c->name .'.  '. $c->city_name .' - '. $c->pincode .', '. $c->state_name .', '. $c->country_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <div class="spaceBlock">
                                            <div id="shipping-address-block"></div>
                                        </div>
                                    </div>
                                    <div class="col col-sm-12 col-md-4 col-lg-3">
                                        <button class="btn btn-primary add-shipping-btn">+ Add New</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col col-12 col-md-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="text-center mb-4">Order Summary</h5>
                        <table class="table summary-table">
                            <tbody>
                                <tr>
                                    <td>Subtotal</td>
                                    <td align="right" id="sub-total-td">${{ isset($response['summary']) ? $response['summary']['subtotal'] : 0 }}</td>
                                </tr>
                                <tr>
                                    <td>Discount</td>
                                    <td align="right" id="discount">${{ isset($response['summary']) ? $response['summary']['discount'] : 0 }}</td>
                                </tr>
                                @if (isset($response['summary']) && $response['summary']['additional_discount'] > 0)
                                <tr>
                                    <td>Additional Discount</td>
                                    <td align="right" id="additional_discount">${{ $response['summary']['additional_discount'] }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <td>Tax (Tentative)</td>
                                    <td align="right" id="tax">${{ isset($response['summary']) ? $response['summary']['tax'] : 0 }}</td>
                                </tr>
                                <tr>
                                    <td>Shipping charge</td>
                                    <td align="right" id="shipping">${{ isset($response['summary']) ? $response['summary']['shipping'] : 0 }}</td>
                                </tr>
                                <tr>
                                    <th>Total Amount</th>
                                    <th id="final-total-th"><div class="text-right">${{ isset($response['summary']) ? $response['summary']['total'] : 0 }}</div></td>
                                </tr>
                            </tbody>
                        </table>
                        <button class="btn btn-primary w-100" disabled id="checkout-btn">Checkout</button>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
<!-- Add Address Modal -->
<div class="custom-modal add-address modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="add-address-content">
                    <h3 class="title mb-4"></h3>
                    <div class="add-address-form">
                        <form class="add-form row" method="POST" action="/customer/save-addresses" enctype="multipart/form-data" id="companyForm">
                            @csrf
                            <input type="hidden" name="company_type" id="company_type">
                            <div class="col col-12 col-md-6">
                                <div class="form-group">
                                    <label for="company_name">Company Name</label>
                                    <input type="text" class="form-control" id="company_name" name="company_name" placeholder="Company Name">
                                </div>
                                <div class="errTxt"></div>
                            </div>
                            <div class="col col-12 col-md-6">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="company_country_code">Country Code</label>
                                            <select class="form-select" id="company_country_code" name="company_country_code">
                                                @foreach ($response['country'] as $row)
                                                <option value="{{ $row->country_id }}" {{ set_selected(101, $row->country_id) }}>{{ '+' . $row->country_code . ' (' . $row->name . ')' }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="errTxt"></div>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="form-group">
                                            <label for="company_office_no">Company Mobile Number</label>
                                            <input type="text" class="form-control" id="company_office_no" name="company_office_no" placeholder="Company Mobile">
                                        </div>
                                        <div class="errTxt"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col col-12 col-md-6">
                                <div class="form-group">
                                    <label for="company_email">Company Email</label>
                                    <input type="email" class="form-control" id="company_email" name="company_email" placeholder="Company Email Address">
                                </div>
                                <div class="errTxt"></div>
                            </div>
                            <div class="col col-12 col-md-6">
                                <div class="form-group">
                                    <label for="company_gst_pan">Company VAT/TIN/GST/PAN/OTHER</label>
                                    <input type="text" name="company_gst_pan" id="company_gst_pan" class="form-control" placeholder="Company VAT/TIN/GST/PAN/OTHER" >
                                </div>
                                <div class="errTxt"></div>
                            </div>
                            <div class="col col-12 col-md-4">
                                <div class="form-group">
                                    <label for="company_country">Company Country</label>
                                    <select class="form-select" id="company_country" name="company_country">
                                        <option value="" >Select Country</option>
                                        @foreach ($response['country'] as $c)
                                        <option value="{{ $c->country_id }}" >{{ $c->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="errTxt"></div>
                            </div>
                            <div class="col col-12 col-md-4">
                                <div class="form-group">
                                    <label for="company_state">Company State</label>
                                    <select class="form-select" id="company_state" name="company_state">
                                        <option value="" >Select State</option>
                                    </select>
                                </div>
                                <div class="errTxt"></div>
                            </div>
                            <div class="col col-12 col-md-4">
                                <div class="form-group">
                                    <label for="company_city">Company City</label>
                                    <select class="form-select" id="company_city" name="company_city">
                                        <option value="" >Select City</option>
                                    </select>
                                </div>
                                <div class="errTxt"></div>
                            </div>
                            <div class="col col-12 col-md-8">
                                <div class="form-group">
                                    <label for="company_address">Company Address</label>
                                    <input type="text" class="form-control" id="company_address" name="company_address" placeholder="Company Address" >
                                </div>
                                <div class="errTxt"></div>
                            </div>
                            <div class="col col-12 col-md-4">
                                <div class="form-group">
                                    <label for="company_pincode">Company Pincode</label>
                                    <input type="text" class="form-control" id="company_pincode" name="company_pincode" placeholder="Company Pincode">
                                </div>
                                <div class="errTxt"></div>
                            </div>
                            <div class="col col-12 col-md-12">
                                <div class="form-group">
                                    <div class="upload-file-box">
                                        <div class="file-upload-box">
                                            <div class="file-select text-center m-auto">
                                                <img src="/assets/images/upload-file-icon.svg" alt="icn" class="img-fluid mb-3">
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="id_upload" name="id_upload" id="id_upload" aria-describedby="inputGroupFileAddon01" accept="image/jpeg,image/png,application/pdf">
                                                        <label class="custom-file-label ml-auto mr-auto" for="id_upload">Drag An Image Here</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="errTxt"></div>
                                    </div>
                                    <p class="mb-0 mt-3">Business Identity Proof (scan and upload only .jpg, .jpeg, .png and .pdf files)</p>
                                </div>
                            </div>
                            <div class="col col-12 col-md-12">
                                <div class="text-right">
                                    <button type="submit" class="btn btn-dark">Save</button>
                                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/additional-methods.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function( xhr ) {
            $( ".cs-loader" ).show();
        }
    });
    setTimeout(() => {
        $('#company_country, #company_state, #company_city, #company_country_code').select2({
            dropdownParent: $('#exampleModal')
        });
        $('#company_country_code').trigger('change');
        $('#company_country_code').on('select2:open', function (e) {
            setTimeout(() => {
                $('#select2-company_country_code-results').parent().parent().css('width', '15vw');
            }, 10);
        });
    }, 1000);

    $(document).on('keydown keyup', 'input[aria-controls="select2-company_country_code-results"]', function() {
        $('#select2-company_country_code-results').parent().parent().css('width', '15rem');
    });

    $(document).on('change', '#company_country_code', function () {
        if ($(this).val()) {
            $('#company_country').val($(this).val()).trigger('change').attr('disabled', true);
        } else {
            $('#company_country').val($(this).val()).trigger('change').attr('disabled', false);
        }
    });

    $(document).on('click', '#same_shipping', function () {
        $('#headingOne button').trigger('click');
        if ($(this).prop('checked') === true) {
            $('#shipping-select').val($('#billing-select').val()).trigger('change');
        }
    });

    $(document).ready(function() {
        function formatSearch(item) {
            var selectionText = item.text.split("||");
            var $returnString = $('<span>' + selectionText[0] + '</br>' + selectionText[1] + '</br>' + selectionText[2] +'</span>');
            return $returnString;
        };
        function formatSelected(item) {
            var selectionText = item.text.split("||");
            var $returnString = $('<span>' + selectionText[0].substring(0, 21) +'</span>');
            return $returnString;
        };
        $('#billing-select, #shipping-select').select2({
            width: '100%'
            // templateResult: formatSearch,
            // templateSelection: formatSelected
        });
        $("#billing-select").trigger('change');
    });

    $(document).on('change', '#shipping-select', function() {
        if ($(this).val() && $('#billing-select').val()) {
            $('#checkout-btn').attr('disabled', false);
        } else {
            $('#checkout-btn').attr('disabled', true);
        }
        $('#shipping-address-block').html('<div>'+$('option:selected', this).attr('data-name')+'</div><div>'+$('option:selected', this).attr('data-office_address')+'</div><div>'+$('option:selected', this).attr('data-city_name')+' - '+$('option:selected', this).attr('data-pincode')+'</div><div>'+$('option:selected', this).attr('data-state_name')+', '+$('option:selected', this).attr('data-country_name')+'</div><div>Mobile: '+$('option:selected', this).attr('data-office_no')+'</div><div>Email: '+$('option:selected', this).attr('data-official_email')+'</div>');

        $.ajax({
            type: "POST",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: "/customer/get-updated-tax",
            data: {'shipping_company_id': $(this).val()},
            success: function (res) {
                $( ".cs-loader" ).hide();
                if (res.success) {
                    var disc = parseFloat($("#discount").text().replace(',', '').substring(1));
                    var add_disc = $("#additional_discount").text().replace(',', '').substring(1) == '' ? 0 : parseFloat($("#additional_discount").text().replace(',', '').substring(1));
                    var tax = (parseFloat($("#sub-total-td").text().replace(',', '').substring(1)) - disc - add_disc) * parseFloat(res.tax) / 100;
                    var total = parseFloat($("#final-total-th div").text().replace(',', '').substring(1)) - parseFloat($("#tax").text().replace(',', '').substring(1)) + tax;
                    $("#tax").text("$"+tax.toFixed(2));
                    $("#final-total-th div").text(total.toLocaleString("en-US", {style:"currency", currency:"USD"}));
                }
            }
        });
    });

    $(document).on('click', '#checkout-btn', function() {
        var token = window.btoa($('#shipping-select').val()+'---'+$('#billing-select').val());
        window.location = '/customer/place-order/'+token;
    });

    $(document).on('change', '#billing-select', function() {
        if ($(this).val() && $('#shipping-select').val()) {
            $('#checkout-btn').attr('disabled', false);
        } else {
            $('#checkout-btn').attr('disabled', true);
        }
        $('#billing-address-block').html('<div>'+$('option:selected', this).attr('data-name')+'</div><div>'+$('option:selected', this).attr('data-office_address')+'</div><div>'+$('option:selected', this).attr('data-city_name')+' - '+$('option:selected', this).attr('data-pincode')+'</div><div>'+$('option:selected', this).attr('data-state_name')+', '+$('option:selected', this).attr('data-country_name')+'</div><div>Mobile: '+$('option:selected', this).attr('data-office_no')+'</div><div>Email: '+$('option:selected', this).attr('data-official_email')+'</div>');
    });

    $("#exampleModal").on('hidden.bs.modal', function(){
        $('div.errTxt').html('');
        $('#companyForm')[0].reset();
        $('#company_country, #company_state, #company_city').val(null).trigger('change');
        $('#company_country_code').val(101).trigger('change');
        $('.custom-file-label').text('Click here to upload ID proof');
    });

    $(document).on('click', '.add-shipping-btn', function () {
        $('#exampleModal .title').text('Add Shipping Address');
        $('#company_type').val('shipping');
        $('#exampleModal').modal('show');
    });

    $(document).on('click', '.add-billing-btn', function () {
        $('#exampleModal .title').text('Add Billing Address');
        $('#company_type').val('billing');
        $('#exampleModal').modal('show');
    });

    $(document).on('change', '#company_country', function () {
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
                    $('#company_state').html(response.data).select2({
                        dropdownParent: $('#exampleModal')
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
    });
    $(document).on('change', '#company_state', function () {
        if ($(this).val()) {
            $(this).parent().next('.errTxt').find('.red-error').text('');
        }
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
                    $('#company_city').html(response.data).select2({
                        dropdownParent: $('#exampleModal')
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
    });

    $(document).on('change', '#company_city', function () {
        if ($(this).val()) {
            $(this).parent().next('.errTxt').find('.red-error').text('');
        }
    });
    $("#companyForm").validate({
        errorClass: 'red-error',
        errorElement: 'div',
        rules: {
            company_name: {required: true, minlength: 4, maxlength: 200},
            company_office_no: { required: true, rangelength: [10, 11]},
            company_email: {required: true, email: true},
            company_gst_pan: {required: true, minlength: 8},
            company_address: {required: true, rangelength: [10, 200]},
            company_country: {required: true},
            company_state: {required: true},
            company_city: {required: true},
            company_pincode: { required: true, number: true},
            // id_upload: {required: true}
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
            var formData = new FormData(form);
            if ($('#id_upload')[0].files.length > 0) {
                formData.append('id_upload', $('#id_upload')[0].files);
            }
            $.ajax({
                type: "POST",
                url: "/customer/save-addresses",
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
                        var opt = null;
                        $(response.data).each(function (i, v) {
                            opt += '<option value="'+ v.customer_company_id +'" data-name="'+ v.name +'" data-office_no="'+ v.office_no +'" data-official_email="'+ v.official_email +'" data-office_address="'+ v.office_address +'" data-pincode="'+ v.pincode +'" data-city_name="'+ v.city_name +'" data-state_name="'+ v.state_name +'" data-country_name="'+ v.country_name +'" >'+ v.name +'.  '+ v.city_name +' - '+ v.pincode +', '+ v.state_name +', '+ v.country_name +' </option>';
                        });
                        $('#billing-select, #shipping-select').html(opt);
                        $('#billing-select, #shipping-select').select2('destroy').select2({
                            width: '100%'
                        });
                        if ($('#company_type').val() == 'shipping') {
                            $("#shipping-select").val(response.id).trigger('change');
                        } else {
                            $("#billing-select").val(response.id).trigger('change');
                        }
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
        if ($(this).val()) {
            $(this).parent().next('.errTxt').find('.red-error').text('');
        }
        $(this).next('label').text($(this)[0].files[0].name);
    });
</script>
@endsection
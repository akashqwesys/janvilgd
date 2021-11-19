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
        padding: 2rem;
    }
    .select2-selection__rendered {
        line-height: 40px !important;
    }
    .select2-container .select2-selection--single {
        height: 40px !important;
    }
    .select2-selection__arrow {
        height: 37px !important;
    }
</style>
@endsection
@section('content')
<div class="overlay cs-loader">
    <div class="overlay__inner">
    <div class="overlay__content"><span class="spinner"></span></div>
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
<div class="cart-page">
    <div class="container">
        @if (count($response) == 0)
        <div class="alert alert-danger text-center mb-5">
            <h4 class="m-0"><b> YOUR CART IS EMPTY</b></h4>
        </div>
        @else
        <div class="row">
            <div class="col col-12 pb-3">
                <ul class="chekot-menu-list">
                    <li>Address</li>
                    <li>Payment</li>
                </ul>
                <!-- <h2>Select Address</h2> -->
            </div>
            <div class="col col-12 col-md-6">
                <div class="accordion checkout-accordion" id="checkoutaccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <h5>Shipping Address</h5>
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#checkoutaccordion">
                            <div class="accordion-body">
                                {{-- <div class="row">
                                    <div class="col col-12 col-xl-6">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text"><img src="assets/images/comapny-icon.svg" alt=""></span>
                                            <input type="text" name="name" class="form-control" placeholder="Company Name" value="{{$response['company_details']->name}}">
                                        </div>
                                    </div>
                                    <div class="col col-12 col-xl-6">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text"><img src="assets/images/phone.svg" alt=""></span>
                                            <input type="text" name="number" class="form-control" placeholder="Contact no" value="{{$response['company_details']->office_no}}">
                                        </div>
                                    </div>
                                    <div class="col col-12 col-xl-6">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text"><img src="assets/images/email.svg" alt=""></span>
                                            <input type="text" name="email" class="form-control" placeholder="Email" value="{{$response['company_details']->official_email}}">
                                        </div>
                                    </div>
                                    <div class="col col-12 col-xl-6">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text"><img src="assets/images/location.svg" alt=""></span>
                                            <input type="text" name="address" class="form-control" placeholder="Address" value="{{$response['company_details']->office_address}}">
                                        </div>
                                    </div>
                                    <div class="col col-12 col-xl-6">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text"><img src="assets/images/country.svg" alt=""></span>
                                            <select class="form-select" aria-label="Default select example">
                                                <option value="" selected="" disabled="">Country</option>
                                                @php
                                                    foreach($response['country'] as $row){
                                                @endphp
                                                <option value="{{$row->country_id}}" {{ set_selected($row->country_id,$response['company_details']->refCountry_id) }}>{{$row->name}}</option>
                                                @php
                                                    }
                                                @endphp
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col col-12 col-xl-6">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text"><img src="assets/images/country.svg" alt=""></span>
                                            <select class="form-select" aria-label="Default select example">
                                                <option value="" selected="" disabled="">State</option>
                                                @php
                                                    foreach($response['shipping_state'] as $row){
                                                @endphp
                                                <option value="{{$row->state_id}}" {{ set_selected($row->state_id,$response['company_details']->refState_id) }}>{{$row->name}}</option>
                                                @php
                                                    }
                                                @endphp
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col col-12 col-xl-6">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text"><img src="assets/images/apartment_building_city.svg" alt=""></span>
                                            <select class="form-select" aria-label="Default select example">
                                                <option value="" selected="" disabled="">City</option>
                                                @php
                                                    foreach($response['shipping_city'] as $row){
                                                @endphp
                                                <option value="{{$row->city_id}}" {{ set_selected($row->city_id,$response['company_details']->refCity_id) }}>{{$row->name}}</option>
                                                @php
                                                    }
                                                @endphp
                                            </select>
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="row">
                                    <div class="col col-md-8 col-lg-9">
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
                                                >{{ $c->office_no .'. '. $c->name .'.  '. $c->city_name .' - '. $c->pincode .', '. $c->state_name .', '. $c->country_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <div class="spaceBlock">
                                            <div id="shipping-address-block"></div>
                                        </div>
                                    </div>
                                    <div class="col col-md-4 col-lg-3">
                                        <button class="btn btn-primary add-shipping-btn">+ Add New</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <h5>Billing Address</h5>
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#checkoutaccordion">
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="col col-md-8 col-lg-9">
                                        <select class="form-control select2" id="billing-select">
                                            <option value="" disabled selected>SELECT BILLING ADDRESS</option>
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
                                                >{{ $c->office_no .'. '. $c->name .'.  '. $c->city_name .' - '. $c->pincode .', '. $c->state_name .', '. $c->country_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <div class="spaceBlock">
                                            <div id="billing-address-block"></div>
                                        </div>
                                    </div>
                                    <div class="col col-md-4 col-lg-3">
                                        <button class="btn btn-primary add-billing-btn">+ Add New</button>
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
                        <h5 class="text-center mb-4">Price Details</h5>
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
                                <tr>
                                    <td>Additional Discount</td>
                                    <td align="right" id="additional_discount">${{ isset($response['summary']) ? $response['summary']['additional_discount'] : 0 }}</td>
                                </tr>
                                <tr>
                                    <td>Tax</td>
                                    <td align="right" id="tax">${{ isset($response['summary']) ? $response['summary']['tax'] : 0 }}</td>
                                </tr>
                                <tr>
                                    <td>Shipping charge</td>
                                    <td align="right" id="shipping">${{ isset($response['summary']) ? $response['summary']['shipping'] : 0 }}</td>
                                </tr>
                                <tr>
                                    <th>Total</th>
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
                                    <img src="/assets/images/architecture_building_city_company.svg" alt="icn" class="img-fluid input-icon">
                                    <input type="text" class="form-control" id="company_name" name="company_name" placeholder="Company Name">
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
                                    <input type="email" class="form-control" id="company_email" name="company_email" placeholder="Company Email Address">
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
                                    <img src="/assets/images/flag.svg" alt="icn" class="img-fluid input-icon">
                                    <select class="form-select" id="company_state" name="company_state">
                                        <option value="" >Select State</option>
                                    </select>
                                </div>
                                <div class="errTxt"></div>
                            </div>
                            <div class="col col-12 col-md-4">
                                <div class="form-group">
                                    <img src="/assets/images/building_city.svg" alt="icn" class="img-fluid input-icon">
                                    <select class="form-select" id="company_city" name="company_city">
                                        <option value="" >Select City</option>
                                    </select>
                                </div>
                                <div class="errTxt"></div>
                            </div>
                            <div class="col col-12 col-md-8">
                                <div class="form-group">
                                    <img src="/assets/images/location.svg" alt="icn" class="img-fluid input-icon">
                                    <input type="text" class="form-control" id="company_address" name="company_address" placeholder="Company Address" >
                                </div>
                                <div class="errTxt"></div>
                            </div>
                            <div class="col col-12 col-md-4">
                                <div class="form-group">
                                    <img src="/assets/images/location.svg" alt="icn" class="img-fluid input-icon">
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
        $('select.select2').select2({
            width: '100%'
            // templateResult: formatSearch,
            // templateSelection: formatSelected
        });
    });
    $(document).on('change', '#shipping-select', function() {
        if ($(this).val() && $('#billing-select').val()) {
            $('#checkout-btn').attr('disabled', false);
        } else {
            $('#checkout-btn').attr('disabled', true);
        }
        $('#shipping-address-block').html('<div>'+$('option:selected', this).attr('data-name')+'</div><div>'+$('option:selected', this).attr('data-office_address')+'</div><div>'+$('option:selected', this).attr('data-city_name')+' - '+$('option:selected', this).attr('data-pincode')+'</div><div>'+$('option:selected', this).attr('data-state_name')+', '+$('option:selected', this).attr('data-country_name')+'</div><div>Mobile: '+$('option:selected', this).attr('data-office_no')+'</div><div>Email: '+$('option:selected', this).attr('data-official_email')+'</div>');
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
                    $('#company_state').html(response.data);
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
                    $('#company_city').html(response.data);
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
            id_upload: {required: true}
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
            id_upload: {required: "Please select the identity proof"}
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
            formData.append('id_upload', $('#id_upload')[0].files);
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
                            opt += '<option value="'+ v.customer_company_id +'" data-name="'+ v.name +'" data-office_no="'+ v.office_no +'" data-official_email="'+ v.official_email +'" data-office_address="'+ v.office_address +'" data-pincode="'+ v.pincode +'" data-city_name="'+ v.city_name +'" data-state_name="'+ v.state_name +'" data-country_name="'+ v.country_name +'" >'+ v.office_no +'. '+ v.name +'.  '+ v.city_name +' - '+ v.pincode +', '+ v.state_name +', '+ v.country_name +' </option>';
                        });
                        $('select.select2').html(opt);
                        $('select.select2').select2('destroy').select2({
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
        $(this).next('label').text($(this)[0].files[0].name);
    });
</script>
@endsection
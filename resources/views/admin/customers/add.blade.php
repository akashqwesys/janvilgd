@extends('admin.header')
@section('css')
<style>
    .actions ul li button {
        display: inline-block;
        position: relative;
        color: #fff;
        font-weight: 500;
        transition: all .4s ease;
        border-color: #1f327f;
        background: #1f327f;
        padding: 0.4375rem 1rem;
        font-size: 0.8125rem;
        line-height: 1rem;
        border-radius: 4px;
    }
    .errTxt {
        color: red;
        text-align: center;
        font-size: 0.9em;
    }
    .actions ul li:first-child {
        order: 0;
    }
</style>
@endsection
@section('content')

<div class="nk-content">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <h3 class="nk-block-title page-title" style="display: inline;">Add Customer</h3>
                        <a style="float: right;" href="/admin/customers" class="btn btn-icon btn-primary">&nbsp;&nbsp;Back To List<em class="icon ni ni-plus"></em></a>
                    </div><!-- .nk-block-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block nk-block-lg">
                    <div class="card">
                        <div class="card-inner">
                            <div id='append_loader' class="overlay">
                                <div class='d-flex justify-content-center' style="padding-top: 30%;">
                                    <div class='spinner-border text-success' role='status'>
                                        <span class='sr-only'>Loading...</span>
                                    </div>
                                </div>
                            </div>
                            <form  method="POST" action="{{route('customers.save')}}" enctype="multipart/form-data" class="nk-wizard nk-wizard-simple is-alter" id="customerForm">
                                @csrf
                                <div class="nk-wizard-head">
                                    <h5>Step 1</h5>
                                </div>
                                <div class="nk-wizard-content">
                                    <div class="row g-3 align-center">
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label class="form-label float-md-right" for="name">Name:</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter name" required="" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 align-center">
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label class="form-label float-md-right" for="email">Email:</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <input type="email" class="form-control" name="email" id="email" placeholder="Enter email" autocomplete="off" required>
                                                @if($errors->has('email'))
                                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 align-center">
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label class="form-label float-md-right" for="password">Password:</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <input type="password" class="form-control" name="password" id="password" placeholder="Enter password" autocomplete="off" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 align-center">
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label class="form-label float-md-right" for="confirm_password"> Confirm Password:</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Enter confirm password" autocomplete="off" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 align-center">
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label class="form-label float-md-right" for="mobile">Mobile:</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <select class="form-control" id="country_code" name="country_code" data-search="on">
                                                                @foreach ($data['country'] as $row)
                                                                <option value="{{ $row->country_id }}" {{ set_selected(101, $row->country_id) }}>{{ '+' . $row->country_code . ' (' . $row->name . ')' }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input type="text" class="form-control" name="mobile" id="mobile" placeholder="Enter mobile number" autocomplete="off">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 align-center">
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label class="form-label float-md-right" for="address">Address:</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <textarea name="address" class="form-control form-control-sm" id="cf-default-textarea" placeholder="Enter address"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 align-center">
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label class="form-label float-md-right" for="pincode">Pincode:</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" name="pincode" id="pincode" placeholder="Enter pincode" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 align-center">
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label class="form-label float-right" for="refCountry_id">Country:</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <select class="form-control" id="refCountry_id" name="refCountry_id" required=""  data-search="on" >
                                                        <option value="">------ Select Country ------</option>
                                                        @foreach ($data['country'] as $row)
                                                        <option value="{{ $row->country_id }}">{{ $row->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row g-3 align-center">
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label class="form-label float-right" for="refState_id">State:</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <select class="form-control" id="refState_id" name="refState_id" required="" tabindex="-1" aria-hidden="true" data-search="on">
                                                        <option value="">------ Select State ------</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 align-center">
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label class="form-label float-right" for="refCity_id">City:</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <select class="form-control" id="refCity_id" name="refCity_id" required="" tabindex="-1" aria-hidden="true" data-search="on">
                                                        <option value="">------ Select City ------</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 align-center">
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label class="form-label float-right" for="refCustomerType_id">Customer Type:</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <select class="form-control" id="refCustomerType_id" name="refCustomerType_id" required="" tabindex="-1" aria-hidden="true" data-search="on">
                                                        <option value="">------ Select Type ------</option>
                                                        @foreach ($data['customer_type'] as $row)
                                                        <option value="{{ $row->customer_type_id }}">{{ $row->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 align-center">
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label class="form-label float-right" for="restrict_transactions">Restrict Transactions:</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <select class="form-control" id="restrict_transactions" name="restrict_transactions" required="" tabindex="-1" aria-hidden="true" data-search="on">
                                                        <option value="1">YES</option>
                                                        <option value="0">NO</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="nk-wizard-head">
                                    <h5>Step 2</h5>
                                </div>
                                <div class="nk-wizard-content">
                                    <div class="row g-3 align-center">
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label class="form-label float-md-right" for="company_name">Company Name:</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" name="company_name" id="company_name" placeholder="Enter name" required="" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 align-center">
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label class="form-label float-md-right" for="office_no">Office no:</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <select class="form-control" id="company_country_code" name="company_country_code" data-search="on" required>
                                                                @foreach ($data['country'] as $row)
                                                                <option value="{{ $row->country_id }}" {{ set_selected(101, $row->country_id) }}>{{ '+' . $row->country_code . ' (' . $row->name . ')' }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <input type="text" class="form-control" name="office_no" id="office_no" placeholder="Enter mobile number" autocomplete="off" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 align-center">
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label class="form-label float-md-right" for="official_email">Email:</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <input type="email" class="form-control" name="official_email" id="official_email" placeholder="Enter email" autocomplete="off" required>
                                                    @if($errors->has('email'))
                                                    <span class="text-danger">{{ $errors->first('official_email') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="row g-3 align-center">
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label class="form-label float-right" for="designation_id">Designation:</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <select class="form-control" id="designation_id" name="designation_id" required="" tabindex="-1" aria-hidden="true" data-search="on">
                                                        <option value="">------ Select Designation ------</option>
                                                        @foreach ($data['designation'] as $row)
                                                        <option value="{{ $row->id }}">{{ $row->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}
                                    <div class="row g-3 align-center">
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label class="form-label float-md-right" for="office_address">Office Address:</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <textarea name="office_address" class="form-control form-control-sm" id="office_address" placeholder="Enter address" required></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 align-center">
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label class="form-label float-md-right" for="office_pincode">Office Pincode:</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" name="office_pincode" id="office_pincode" placeholder="Enter pincode" autocomplete="off" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 align-center">
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label class="form-label float-right" for="office_country_id">Company Country:</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <select class="form-control" id="office_country_id" name="office_country_id" required="" data-search="on" disabled>
                                                        <option value="">------ Select Country ------</option>
                                                        @foreach ($data['country'] as $row)
                                                        <option value="{{ $row->country_id }}">{{ $row->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row g-3 align-center">
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label class="form-label float-right" for="office_state_id">Company State:</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <select class="form-control" id="office_state_id" name="office_state_id" required="" tabindex="-1" aria-hidden="true" data-search="on">
                                                        <option value="">------ Select State ------</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 align-center">
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label class="form-label float-right" for="office_city_id">Company City:</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <select class="form-control" id="office_city_id" name="office_city_id" required="" tabindex="-1" aria-hidden="true" data-search="on">
                                                        <option value="">------ Select City ------</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 align-center">
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label class="form-label float-md-right" for="pan_gst_no">VAT/TIN/GST/PAN/OTHER:</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" name="pan_gst_no" id="pan_gst_no" placeholder="Enter VAT/TIN/GST/PAN/OTHER" autocomplete="off" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 align-center">
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label class="form-label float-md-right" for="pan_gst_no_file">VAT/TIN/GST/PAN/OTHER Files:</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <div class="custom-file">
                                                        <input type="file" name="pan_gst_no_file" class="custom-file-input" id="pan_gst_no_file" accept="image/jpeg,image/png,application/pdf" required>
                                                        <label class="custom-file-label" for="pan_gst_no_file">Choose file</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div><!-- .nk-block -->
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function (xhr) {
            $("#append_loader").show();
        }
    });

    /* $(document).on('click', '.submit_btn', function () {
        $('.submit_btn').get(0).submit();
    }); */
    setTimeout(() => {
        $('ul li a[href="#finish"]').addClass("d-none");
        $('ul li a[href="#finish"]').parent('li').append('<button class="submit_btn" type="submit">Submit</button>');

        $('#country_code, #refCountry_id, #office_country_id, #company_country_code').select2({});
        $('#country_code').on('select2:open', function (e) {
            setTimeout(() => {
                $('#select2-country_code-results').parent().parent().css('width', '15vw');
            }, 10);
        });
        $('#company_country_code').on('select2:open', function (e) {
            setTimeout(() => {
                $('#select2-company_country_code-results').parent().parent().css('width', '15vw');
            }, 10);
        });
        $('#country_code, #company_country_code').trigger('change');
    }, 1000);
    $(document).on('change', '#country_code', function () {
        if ($(this).val()) {
            $(this).siblings('.error').text('');
            $('#refCountry_id').val($(this).val()).trigger('change').attr('disabled', true);
        } else {
            $('#refCountry_id').val($(this).val()).trigger('change').attr('disabled', false);
        }
    });
    $(document).on('change', '#company_country_code', function () {
        if ($(this).val()) {
            $(this).siblings('.error').text('');
            $('#office_country_id').val($(this).val()).trigger('change').attr('disabled', true);
        } else {
            $('#office_country_id').val($(this).val()).trigger('change').attr('disabled', false);
        }
    });
    $(document).on('change', '#refCountry_id, #office_country_id', function () {
        if ($(this).val()) {
            $(this).siblings('.error').text('');
        }
        $.ajax({
            type: "POST",
            url: "/getStates",
            data: { 'id': $(this).val() },
            // cache: false,
            context: this,
            dataType: 'JSON',
            success: function (response) {
                $('#append_loader').hide();
                if (response.error) {
                    $.toast({
                        heading: 'Error',
                        text: response.message,
                        icon: 'error',
                        position: 'top-right'
                    });
                }
                else {
                    if ($(this).attr('id') == 'refCountry_id') {
                        $('#refState_id').html(response.data).select2();
                    } else {
                        $('#office_state_id').html(response.data).select2();
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
    $(document).on('change', '#refState_id, #office_state_id', function () {
        if ($(this).val()) {
            $(this).siblings('.error').text('');
        }
        $.ajax({
            type: "POST",
            url: "/getCities",
            data: { 'id': $(this).val() },
            // cache: false,
            context: this,
            dataType: 'JSON',
            success: function (response) {
                $('#append_loader').hide();
                if (response.error) {
                    $.toast({
                        heading: 'Error',
                        text: response.message,
                        icon: 'error',
                        position: 'top-right'
                    });
                }
                else {
                    if ($(this).attr('id') == 'refState_id') {
                        $('#refCity_id').html(response.data).select2();
                    } else {
                        $('#office_city_id').html(response.data).select2();
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
    $(document).on('change', '#refCity_id', function () {
        if ($(this).val()) {
            $(this).siblings('.error').text('');
        }
    });
    $(document).on('change', '#office_city_id', function () {
        if ($(this).val()) {
            $(this).siblings('.error').text('');
        }
    });
    $("#customerForm").validate({
        rules: {
            mobile: { number:true, rangelength: [10,11]},
            password: { required: true, rangelength: [6, 15] },
            confirm_password: { required: true, equalTo: "#password" },
            pincode: { required: true, number: true},
            office_no: { required: true, number:true, rangelength: [10,11]},
            pan_gst_no: {required: true, minlength: 8},
            office_address: {required: true, rangelength: [10,200]},
            office_pincode: { required: true, number: true},
        },
        messages: {
            name: {required: "Please enter your name"},
            email: {
                required: "Please enter your email address",
                email: "Your email address must be in the format of name@domain.com"
            },
            password: { required: "Please enter password" },
            confirm_password: { required: "Please enter confirm password", equalTo: 'Those password didn\'t match. Try again' },
            // country_code: { required: "Please select country code" },
            mobile: {
                // required: "Please enter your mobile number",
                number: "Your contact number should only consist of numeric digits"
            },
            address: {required: "Please enter your address"},
            country: {required: "Please select the country"},
            state: {required: "Please select the state/province"},
            city: {required: "Please enter the city name"},
            pincode: {required: "Please enter the pincode"},
            company_name: {required: "Please enter your company name"},
            office_no: {required: "Please enter your company office number", number: "Your contact number should only consist of numeric digits"},
            official_email: { required: "Please enter your company email address"},
            pan_gst_no: {required: "Please enter your company VAT/TIN/GST/PAN/OTHER"},
            office_address: {required: "Please enter your company address"},
            office_country_id: {required: "Please select the country"},
            office_state_id: {required: "Please select the state/province"},
            office_city_id: {required: "Please enter the city name"},
            office_pincode: {required: "Please enter the pincode"},
            pan_gst_no_file: {required: "Please upload your business ID proof"},
        },
        submitHandler: function(form) {
            // do other things for a valid form
            // form.submit();
            var formData = new FormData(form);
            if ($('#pan_gst_no_file')[0].files.length > 0) {
                formData.append('pan_gst_no_file', $('#pan_gst_no_file')[0].files);
            }
            $.ajax({
                type: "POST",
                url: "/admin/customers/save",
                data: formData,
                processData : false,
                contentType : false,
                context: this,
                dataType: 'JSON',
                success: function(response) {
                    $('#append_loader').hide();
                    if (response.success == 1) {
                        $.toast({
                            heading: 'Success',
                            text: response.message,
                            icon: 'success',
                            position: 'top-right'
                        });
                        $('.submit_btn').hide();
                        setTimeout(() => {
                            location.href = '/admin/customers';
                        }, 2000);
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
</script>
@endsection
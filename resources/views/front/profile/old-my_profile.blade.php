@extends('front.layout_2')
@section('title', $title)
@section('css')
<style type="text/css">
    .profile-details .form-group {
        margin-bottom: 0;
    }
    .profile-details .col {
        margin-bottom: 2rem;
    }
    .errTxt {
        color: red;
        text-align: center;
        font-size: 0.9em;
    }
</style>
@endsection

@section('content')
<div class="overlay cs-loader">
    <div class="overlay__inner">
    <div class="overlay__content"><span class="spinner"></span></div>
    </div>
</div>
<section class="profile-section">
    <div class="container">
        <div class="profile-content">
            <h2 class="title">Janvi LGD</h2>
            <div class="row main-box">
                <div class="col col-12 col-sm-12 col-md-4 col-lg-3">
                    <div class="navbar-tabs">
                        <ul class="list-unstyled mb-0">
                            <li class="tab-item"><a href="/customer/my-account" class="tab-link">Account</a></li>
                            <li class="tab-item"><a href="javascript::void(0)" class="tab-link">Profile</a></li>
                            <li class="tab-item"><a href="/customer/my-saved-cards" class="tab-link">Saved Cards</a></li>
                            <li class="tab-item"><a href="/customer/my-addresses" class="tab-link">Addresses</a></li>
                        {{-- </ul>
                        <hr>
                        <ul class="list-unstyled mb-0"> --}}
                            <li class="tab-item"><a href="/customer/my-orders" class="tab-link">Orders</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col col-12 col-sm-12 col-md-8 col-lg-9">
                    <form method="POST" action="/customer/update-profile" enctype="multipart/form-data" id="profileForm">
                        @csrf
                        <div class="profile-info">
                            <h2 class="title">Profile Details</h2>
                            @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('message') }}
                            </div>
                            @elseif (session('error'))
                            <div class="alert alert-danger">
                                {{ session('message') }}
                            </div>
                            @endif
                            <div class="detail-content">
                                <ul class="list-unstyled profile-details">
                                    <li class="details-item">
                                        <div class="profile_details">
                                            <h6>1. Personal Info</h6>
                                            <div class="form-row row">
                                                <div class="col col-12 col-lg-6">
                                                    <div class="form-group">
                                                        <img src="/assets/images/user.svg" alt="icn" class="img-fluid input-icon">
                                                        <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ $customer->name }}" required>
                                                    </div>
                                                    <div class="errTxt"></div>
                                                </div>
                                                <div class="col col-12 col-lg-6">
                                                    <div class="form-group">
                                                        <img src="/assets/images/alt-phone.svg" alt="icn" class="img-fluid input-icon">
                                                        <input type="tel" class="form-control" id="mobile" name="mobile" placeholder="Email Address" value="{{ $customer->mobile }}" {{ $customer->mobile ? 'disabled' : '' }}>
                                                    </div>
                                                    <div class="errTxt"></div>
                                                </div>
                                                <div class="col col-12 col-lg-6">
                                                    <div class="form-group">
                                                        <img src="/assets/images/envelop.svg" alt="icn" class="img-fluid input-icon">
                                                        <input type="email" class="form-control" id="email" name="email" placeholder="Mobile Number" value="{{ $customer->email }}" {{ $customer->email ? 'disabled' : '' }}>
                                                    </div>
                                                    <div class="errTxt"></div>
                                                </div>
                                                <div class="col col-12 col-lg-6">
                                                    <div class="form-group">
                                                        <img src="/assets/images/location.svg" alt="icn" class="img-fluid input-icon">
                                                        <input type="text" class="form-control" id="address" name="address" placeholder="Address" value="{{ $customer->address }}">
                                                    </div>
                                                    <div class="errTxt"></div>
                                                </div>
                                                <div class="col col-12 col-lg-4">
                                                    <div class="form-group">
                                                        <img src="/assets/images/flag.svg" alt="icn" class="img-fluid input-icon">
                                                        <select class="form-select" id="country" name="country" required>
                                                            @foreach ($country as $c)
                                                            <option value="{{ $c->country_id }}" {{ $customer->refCountry_id == $c->country_id ? 'selected' : '' }}>{{ $c->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="errTxt"></div>
                                                </div>
                                                <div class="col col-12 col-lg-4">
                                                    <div class="form-group">
                                                        <img src="/assets/images/building_city.svg" alt="icn" class="img-fluid input-icon">
                                                        <select class="form-select" id="state" name="state" required>
                                                            @foreach ($state as $c)
                                                            <option value="{{ $c->state_id }}" {{ $customer->refState_id == $c->state_id ? 'selected' : '' }}>{{ $c->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="errTxt"></div>
                                                </div>
                                                <div class="col col-12 col-lg-4">
                                                    <div class="form-group">
                                                        <img src="/assets/images/flag.svg" alt="icn" class="img-fluid input-icon">
                                                        <select class="form-select" id="city" name="city" required>
                                                            @foreach ($city as $c)
                                                            <option value="{{ $c->city_id }}" {{ $customer->refCity_id == $c->city_id ? 'selected' : '' }}>{{ $c->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="errTxt"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="details-item">
                                        <div class="profile_details">
                                            <h6>2. Business Info</h6>
                                            <div class="form-row row">
                                                <div class="col col-12 col-lg-6">
                                                    <div class="form-group">
                                                        <img src="/assets/images/architecture_building_city_company.svg" alt="icn" class="img-fluid input-icon">
                                                        <input type="text" class="form-control" id="company_name" name="company_name" placeholder="Company Name" required value="{{ $company->name }}">
                                                    </div>
                                                    <div class="errTxt"></div>
                                                </div>
                                                <div class="col col-12 col-lg-6">
                                                    <div class="form-group">
                                                        <img src="/assets/images/architecture_building_city_company.svg" alt="icn" class="img-fluid input-icon">
                                                        <input type="tel" class="form-control" id="company_office_no" name="company_office_no" placeholder="Company Mobile" required value="{{ $company->office_no }}">
                                                    </div>
                                                    <div class="errTxt"></div>
                                                </div>
                                                <div class="col col-12 col-lg-6">
                                                    <div class="form-group">
                                                        <img src="/assets/images/envelop.svg" alt="icn" class="img-fluid input-icon">
                                                        <input type="email" class="form-control" id="company_email" name="company_email" placeholder="Company Email" required value="{{ $company->official_email }}">
                                                    </div>
                                                    <div class="errTxt"></div>
                                                </div>
                                                <div class="col col-12 col-lg-6">
                                                    <div class="form-group">
                                                        <img src="/assets/images/bag_finance_money_icon.svg" alt="icn" class="img-fluid input-icon">
                                                        <input type="text" name="company_gst_pan" id="company_gst_pan" class="form-control" placeholder="Company GST/PAN" value="{{ $company->pan_gst_no }}">
                                                    </div>
                                                    <div class="errTxt"></div>
                                                </div>
                                                <div class="col col-12 col-lg-4">
                                                    <div class="form-group">
                                                        <img src="/assets/images/flag.svg" alt="icn" class="img-fluid input-icon">
                                                        <select class="form-select" id="company_country" name="company_country">
                                                            @foreach ($country as $c)
                                                            <option value="{{ $c->country_id }}" {{ $company->refCountry_id == $c->country_id ? 'selected' : '' }}>{{ $c->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="errTxt"></div>
                                                </div>
                                                <div class="col col-12 col-lg-4">
                                                    <div class="form-group">
                                                        <img src="/assets/images/building_city.svg" alt="icn" class="img-fluid input-icon">
                                                        <select class="form-select" id="company_state" name="company_state">
                                                            @foreach ($cp_state as $c)
                                                            <option value="{{ $c->state_id }}" {{ $company->refState_id == $c->state_id ? 'selected' : '' }}>{{ $c->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="errTxt"></div>
                                                </div>
                                                <div class="col col-12 col-lg-4">
                                                    <div class="form-group">
                                                        <img src="/assets/images/flag.svg" alt="icn" class="img-fluid input-icon">
                                                        <select class="form-select" id="company_city" name="company_city">
                                                            @foreach ($cp_city as $c)
                                                            <option value="{{ $c->city_id }}" {{ $company->refCity_id == $c->city_id ? 'selected' : '' }}>{{ $c->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="errTxt"></div>
                                                </div>
                                                <div class="col col-12">
                                                    <div class="form-group">
                                                        <img src="/assets/images/location.svg" alt="icn" class="img-fluid input-icon">
                                                        <input type="text" class="form-control" id="company_address" name="company_address" placeholder="Company Address" value="{{ $company->office_address }}">
                                                    </div>
                                                    <div class="errTxt"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="details-item">
                                        <div class="profile_details">
                                            <h6>3. ID Proof</h6>
                                            <p class="mb-3"><b>Business Identity Proof</b></p>
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
                                            </div>
                                            <p class="mb-0 mt-3">Business Card (scan and upload only .jpg, .jpeg, .png and .pdf files)</p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="edit-btn d-flex">
                            <button class="btn btn-primary ms-auto" type="submit">Update Profile</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/additional-methods.min.js"></script>
<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
    },
    beforeSend: function (xhr) {
        $(".cs-loader").show();
    }
});
$(document).on('change', '#country', function () {
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
                $('#state').html(response.data);
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
$(document).on('change', '#state', function () {
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
                $('#city').html(response.data);
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
$("#profileForm").validate({
    errorClass: 'red-error',
    errorElement: 'div',
    rules: {
        name: {required: true, rangelength: [3,50]},
        email: {
            // required: true,
            email: true
        },
        mobile: {/*required: true,*/ number: true, rangelength: [10,11]},
        address: {required: true, rangelength: [10,200]},
        country: {required: true},
        state: {required: true},
        city: {required: true},
        // pincode: { required: true, number: true},
        company_name: {required: true, minlength: 4, maxlength: 100},
        company_office_no: { required: true, rangelength: [2, 10]},
        company_email: {required: true, email: true},
        company_gst_pan: {required: true, minlength: 10, maxlength: 15},
        company_address: {required: true, rangelength: [10,200]},
        company_country: {required: true},
        company_state: {required: true},
        company_city: {required: true},
        // company_pincode: { required: true, number: true},
        // id_upload: {required: true},
        // privacy_terms: {required: true}
    },
    messages: {
        name: {required: "Please enter your name"},
        email: {
            required: "Please enter your email address",
            email: "Your email address must be in the format of name@domain.com"
        },
        mobile: {
            required: "Please enter your mobile number",
            number: "Your contact number should only consist of numeric digits"
        },
        address: {required: "Please enter your address"},
        country: {required: "Please select the country"},
        state: {required: "Please select the state/province"},
        city: {required: "Please enter the city name"},
        pincode: {required: "Please enter the pincode"},
        company_name: {required: "Please enter your company name"},
        company_office_no: {required: "Please enter your company office number"},
        company_email: { required: "Please enter your company email address"},
        company_gst_pan: {required: "Please enter your company GST or PAN"},
        company_address: {required: "Please enter your company address"},
        company_country: {required: "Please select the country"},
        company_state: {required: "Please select the state/province"},
        company_city: {required: "Please enter the city name"},
        company_pincode: {required: "Please enter the pincode"},
        id_proof: {required: "Please upload your business ID proof"},
        privacy_terms: {required: "Please check-mark/accept our terms of use and privacy policy"}
    },
    errorPlacement: function(error, element) {
        error.appendTo( element.parent().nextAll("div.errTxt") );
    },
    submitHandler: function(form) {
        // do other things for a valid form
        form.submit();
    }
});
$(document).on('change', '#id_upload', function () {
    $(this).next('label').text($(this)[0].files[0].name);
});
</script>
@endsection
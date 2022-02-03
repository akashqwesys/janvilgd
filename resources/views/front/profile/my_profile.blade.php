@extends('front.layout_2')
@section('title', $title)
@section('css')
<style type="text/css">
    .account-tabs li a {
        display: block;
    }
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
        <div class="row mb-5">
            <div class="col col-12 col-sm-4 col-md-3 col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="navbar-tabs account-tabs">
                        <ul class="list-unstyled mb-0">
                            <li class="tab-item"><a href="/customer/my-account" class="tab-link">Account</a></li>
                            <hr>
                            <li class="tab-item"><a href="javascript:void(0);" class="tab-link">Profile</a></li>
                            <hr>
                            <li class="tab-item"><a href="/customer/my-addresses" class="tab-link">Addresses</a></li>
                            <hr>
                            <li class="tab-item"><a href="/customer/my-orders" class="tab-link">Orders</a></li>
                        </ul>
                    </div>
                    </div>
                </div>
            </div>
            <div class="col col-12 col-sm-8 col-md-9 col-lg-9">
                <div class="card">
                    <div class="card-body">
                        <h4 class="mb-3">Personal Information</h4>
                        <form method="POST" action="/customer/update-profile" enctype="multipart/form-data" id="profileForm">
                            @csrf
                            <div class="profile-info-">
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
                                                <div class="form-row row">
                                                    <div class="col col-12 col-lg-6">
                                                        <div class="form-group">
                                                            <img src="/assets/images/user.svg" alt="icn" class="img-fluid input-icon text-gray">
                                                            <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ $customer->name }}" required>
                                                        </div>
                                                        <div class="errTxt"></div>
                                                    </div>
                                                    <div class="col col-12 col-lg-6">
                                                        <div class="form-group">
                                                            <img src="/assets/images/alt-phone.svg" alt="icn" class="img-fluid input-icon">
                                                            <input type="tel" class="form-control" id="mobile" name="mobile" placeholder="Mobile Number" value="{{ $customer->mobile }}" {{ $customer->mobile ? 'disabled' : '' }}>
                                                        </div>
                                                        <div class="errTxt"></div>
                                                    </div>
                                                    <div class="col col-12 col-lg-6">
                                                        <div class="form-group">
                                                            <img src="/assets/images/envelop.svg" alt="icn" class="img-fluid input-icon">
                                                            <input type="email" class="form-control" id="email" name="email" placeholder="Email Address" value="{{ $customer->email }}" {{ $customer->email ? 'disabled' : '' }}>
                                                        </div>
                                                        <div class="errTxt"></div>
                                                    </div>
                                                    <div class="col col-12 col-lg-6">
                                                        <div class="form-group">
                                                            <img src="/assets/images/location.svg" alt="icn" class="img-fluid input-icon">
                                                            <input type="text" class="form-control" id="pincode" name="pincode" placeholder="Pincode" value="{{ $customer->pincode }}">
                                                        </div>
                                                        <div class="errTxt"></div>
                                                    </div>
                                                    <div class="col col-12 col-lg-12">
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
                                                    <div class="col-12 edit-btn d-flex">
                                                        <button class="btn btn-primary ms-auto" type="submit">Update Profile</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </form>

                        </div>
                    </div>
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
        pincode: { required: true, number: true}
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
        pincode: {required: "Please enter the pincode"}
    },
    errorPlacement: function(error, element) {
        error.appendTo( element.parent().nextAll("div.errTxt") );
    },
    submitHandler: function(form) {
        // do other things for a valid form
        form.submit();
    }
});
</script>
@endsection
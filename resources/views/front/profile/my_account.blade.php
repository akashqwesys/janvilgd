@extends('front.layout_2')
@section('title', $title)
@section('css')
<style>
    .account-tabs li a {
        display: block;
    }
</style>
@endsection

@section('content')
<section class="profile-section">
    <div class="container">
        <div class="row mb-5">
            <div class="col col-12 col-sm-4 col-md-3 col-lg-3">
                {{-- <div class="card">
                    <div class="card-body">
                        <h3 class="title">JANVI LGD</h3>
                    </div>
                </div> --}}
                <div class="card">
                    <div class="card-body">
                        <div class="navbar-tabs account-tabs">
                        <ul class="list-unstyled mb-0">
                            <li class="tab-item"><a href="javascript:void(0);" class="tab-link">Account</a></li>
                            <hr>
                            <li class="tab-item"><a href="/customer/my-profile" class="tab-link">Profile</a></li>
                            <hr>
                            {{-- <li class="tab-item"><a href="/customer/my-saved-cards" class="tab-link">Saved Cards</a></li>
                            <hr> --}}
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
                        <div class="row mb-3">
                            <div class="col-8 col-md-10">
                                <h4 class="">Personal Information</h4>
                            </div>
                            <div class="col-4 col-md-2">
                                <div class="edit-btn d-flex">
                                    <a href="/customer/my-profile" class="btn btn-primary ms-auto">Edit Profile</a>
                                </div>
                            </div>
                        </div>
                        <div class="profile-info-">
                            <div class="detail-content">
                                <ul class="list-unstyled profile-details">
                                    <li class="details-item">
                                        <div class="profile_details">
                                            <div class="form-row row">
                                                <div class="col col-12 col-lg-6">
                                                    <div class="form-group">
                                                        <img src="/assets/images/user.svg" alt="icn" class="img-fluid input-icon text-gray">
                                                        <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ $customer->name }}" required disabled>
                                                    </div>
                                                    <div class="errTxt"></div>
                                                </div>
                                                <div class="col col-12 col-lg-6">
                                                    <div class="form-group">
                                                        <img src="/assets/images/alt-phone.svg" alt="icn" class="img-fluid input-icon">
                                                        <input type="tel" class="form-control" id="mobile" name="mobile" placeholder="Email Address" value="{{ $customer->mobile }}" disabled>
                                                    </div>
                                                    <div class="errTxt"></div>
                                                </div>
                                                <div class="col col-12 col-lg-6">
                                                    <div class="form-group">
                                                        <img src="/assets/images/envelop.svg" alt="icn" class="img-fluid input-icon">
                                                        <input type="email" class="form-control" id="email" name="email" placeholder="Mobile Number" value="{{ $customer->email }}" disabled>
                                                    </div>
                                                    <div class="errTxt"></div>
                                                </div>
                                                <div class="col col-12 col-lg-6">
                                                    <div class="form-group">
                                                        <img src="/assets/images/location.svg" alt="icn" class="img-fluid input-icon">
                                                        <input type="text" class="form-control" id="pincode" name="pincode" placeholder="Pincode" value="{{ $customer->pincode }}" disabled>
                                                    </div>
                                                    <div class="errTxt"></div>
                                                </div>
                                                <div class="col col-12 col-lg-12">
                                                    <div class="form-group">
                                                        <img src="/assets/images/location.svg" alt="icn" class="img-fluid input-icon">
                                                        <input type="text" class="form-control" id="address" name="address" placeholder="Address" value="{{ $customer->address }}" disabled>
                                                    </div>
                                                    <div class="errTxt"></div>
                                                </div>
                                                <div class="col col-12 col-lg-4">
                                                    <div class="form-group">
                                                        <img src="/assets/images/flag.svg" alt="icn" class="img-fluid input-icon">
                                                        <select class="form-select" id="country" name="country" required disabled>
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
                                                        <select class="form-select" id="state" name="state" required disabled>
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
                                                        <select class="form-select" id="city" name="city" required disabled>
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
                                </ul>
                            </div>
                        </div>
                            {{-- <li class="details-item">
                                <div class="text-center"><h4>Company Details</h4></div>
                            </li>
                            @foreach ($company as $c)
                            <li class="details-item">
                                <div class="profile_details">
                                    <div class="row">
                                        <div class="col col-12 col-lg-7">
                                            <ul class="list-unstyled mb-0">
                                                <li><span>Company Name :</span>{{ $c->name }}</li>
                                                <li><span>Company Office No :</span>{{ $c->office_no }}</li>
                                                <li><span>Email Address :</span>{{ $c->official_email }}</li>
                                                <li><span>Company GST/PAN :</span>{{ $c->pan_gst_no }}</li>
                                                <li><span>Address :</span>{{ $c->office_address }}</li>
                                            </ul>
                                        </div>
                                        <div class="col col-12 col-lg-5">
                                            <ul class="list-unstyled mb-0">
                                                <li><span>Country :</span>{{ $c->country_name }}</li>
                                                <li><span>State :</span>{{ $c->state_name }}</li>
                                                <li><span>City :</span>{{ $c->city_name }}</li>
                                                <li><span>Business Proof :</span>
                                                    <a href="/storage/user_files/{{ $c->pan_gst_attachment }}" target="_blank">
                                                        <img src="/assets/images/file.png" alt="proof" class="business-img">
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @endforeach --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('js')

@endsection
@extends('front.layout_2')
@section('title', $title)
@section('css')

@endsection

@section('content')
<section class="profile-section">
    <div class="container">
        <div class="profile-content">
            <h2 class="title">Janvi LGD</h2>
            <div class="row main-box">
                <div class="col col-12 col-sm-12 col-md-4 col-lg-3">
                    <div class="navbar-tabs">
                        <ul class="list-unstyled mb-0">
                            <li class="tab-item"><a href="javascript:void(0);" class="tab-link">Account</a></li>
                            <li class="tab-item"><a href="/customer/my-profile" class="tab-link">Profile</a></li>
                            <li class="tab-item"><a href="/customer/my-saved-cards" class="tab-link">Saved Cards</a></li>
                            <li class="tab-item"><a href="/customer/my-addresses" class="tab-link">Addresses</a></li>
                        {{-- </ul>
                        <hr>
                        <ul class="list-unstyled mb-0"> --}}
                            <li class="tab-item"><a href="/customer/my-orders" class="tab-link">Orders</a></li>
                        </ul>
                    </div>
                    <hr>
                </div>
                <div class="col col-12 col-sm-12 col-md-8 col-lg-9">
                    <div class="profile-info">
                        <h2 class="title- text-center">Profile Details</h2>
                        <div class="detail-content">
                            <ul class="list-unstyled profile-details">
                                <li class="details-item">
                                    <div class="profile_details">
                                        {{-- <h6>1. Personal Info</h6> --}}
                                        <div class="row">
                                            <div class="col col-12 col-lg-7">
                                                <ul class="list-unstyled mb-0">
                                                    <li><span>Name :</span>{{ $customer->name }}</li>
                                                    <li><span>Phone No :</span>{{ $customer->mobile }}</li>
                                                    <li><span>Email Address :</span>{{ $customer->email }}</li>
                                                    <li><span>Address :</span>{{ $customer->address }}</li>
                                                </ul>
                                            </div>
                                            <div class="col col-12 col-lg-5">
                                                <ul class="list-unstyled mb-0">
                                                    <li><span>Country :</span>{{ $customer->country_name }}</li>
                                                    <li><span>State :</span>{{ $customer->state_name }}</li>
                                                    <li><span>City :</span>{{ $customer->city_name }}</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="edit-btn d-flex">
                                            <a href="/customer/my-profile" class="btn btn-primary ms-auto">Edit Profile</a>
                                        </div>
                                    </div>
                                </li>
                                <hr>
                                <li class="details-item">
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
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('js')

@endsection
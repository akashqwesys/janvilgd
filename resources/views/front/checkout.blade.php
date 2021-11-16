@extends('front.layout_2')
@section('title', $title)
@section('css')
@endsection
@section('content')
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
                                <div class="row">
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
<!--                                    <div class="col-md-12 text-end">   
                                        <a href="#" class="btn btn-primary">Add New</a>
                                        <button class="btn btn-primary">Save</button>
                                    </div>-->
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col col-10 col-xl-10">
                                        <h4>
                                            My address list
                                        </h4>
                                    </div>
                                </div>                                
                                @php
                                    foreach($response['all_company_details'] as $row){
                                @endphp
                                <hr>
                                    <div class="row">
                                        <div class="col col-10 col-xl-10">
                                            <p>Company Name : {{$row->name}}
                                                <br>Office no : {{$row->office_no}}
                                                <br>Office email : {{$row->official_email}}
                                                <br>Office address : {{$row->office_address}}
                                                <br>City : {{$row->city_name}}
                                                <br>State : {{$row->state_name}}
                                                <br>Country : {{$row->country_name}}
                                            </p>                                                                                        
                                        </div>
                                        <div class="col col-2 col-xl-2" style="border-left: 1px solid #c8c9ca">
                                            <input type="radio" name="shipping_address" style="margin: 0 auto;" value="{{$row->customer_company_id}}" class="shipping_address">
                                        </div>
                                    </div>
                                @php
                                    }
                                @endphp                                
                                
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
                                   <div class="col col-12 col-xl-6">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text"><img src="assets/images/comapny-icon.svg" alt=""></span>
                                            <input type="text" name="name" class="form-control" placeholder="Company Name" value="{{$response['users_details']->name}}">
                                        </div>
                                    </div>
                                    <div class="col col-12 col-xl-6">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text"><img src="assets/images/phone.svg" alt=""></span>
                                            <input type="text" name="number" class="form-control" placeholder="Contact no" value="{{$response['users_details']->mobile}}">
                                        </div>
                                    </div>
                                    <div class="col col-12 col-xl-6">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text"><img src="assets/images/email.svg" alt=""></span>
                                            <input type="text" name="email" class="form-control" placeholder="Email" value="{{$response['users_details']->email}}">
                                        </div>
                                    </div>
                                    <div class="col col-12 col-xl-6">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text"><img src="assets/images/location.svg" alt=""></span>
                                            <input type="text" name="address" class="form-control" placeholder="Address" value="{{$response['users_details']->address}}">
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
                                                <option value="{{$row->country_id}}" {{ set_selected($row->country_id,$response['users_details']->refCountry_id) }}>{{$row->name}}</option>
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
                                                    foreach($response['billing_state'] as $row){
                                                @endphp
                                                <option value="{{$row->state_id}}" {{ set_selected($row->state_id,$response['users_details']->refState_id) }}>{{$row->name}}</option>
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
                                                    foreach($response['billing_city'] as $row){
                                                @endphp
                                                <option value="{{$row->city_id}}" {{ set_selected($row->city_id,$response['users_details']->refCity_id) }}>{{$row->name}}</option>
                                                @php
                                                    }
                                                @endphp
                                            </select>
                                        </div>
                                    </div>  
                                    <div class="col-md-12 text-end">                             
                                        <button class="btn btn-primary">Save</button>
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
                                    <th id="final-total-th"><div class="text-right">${{isset($response['summary']) ? $response['summary']['total'] : 0 }}</div></td>
                                </tr>
                            </tbody>
                        </table>
                        <a href="checkout-2.html" class="btn btn-primary d-block">Checkout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
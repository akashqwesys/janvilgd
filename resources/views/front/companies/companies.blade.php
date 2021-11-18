@extends('front.layout_2')
@section('title', $title)
@section('css')
<style type="text/css">
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
                            <li class="tab-item"><a href="/customer/my-profile" class="tab-link">Profile</a></li>
                            <li class="tab-item"><a href="/customer/my-saved-cards" class="tab-link">Saved Cards</a></li>
                            <li class="tab-item"><a href="javascript::void(0);" class="tab-link">Addresses</a></li>
                            <li class="tab-item"><a href="/customer/my-orders" class="tab-link">Orders</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col col-12 col-sm-12 col-md-8 col-lg-9">
                    <div class="address-content">
                        <div class="add-address">
                            <h2 class="title mb-0">Address</h2>
                            <div class="edit-btn ms-auto">
                                <a href="javascript::void(0);" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">+ Add New</a>
                            </div>
                        </div>
                        @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                        @elseif (session('error'))
                        <div class="alert alert-danger">
                            {{ session('message') }}
                        </div>
                        @endif
                        <div class="row">
                            @for ($i = 0; $i < count($company); $i++)
                            <div class="col col-12 col-xl-6">
                                <table class="table address-details table-bordered">
                                    <tbody>
                                        <tr>
                                            <th colspan="2">
                                                Address - {{ $i+1 }}
                                                <div class="add-edit-delete-btn">
                                                    <a href="javascript::void(0);"
                                                        class="edit-btn btn btn-primary"
                                                        data-id="{{ $company[$i]->customer_company_id }}"
                                                        data-name="{{ $company[$i]->name }}"
                                                        data-company_office_no="{{ $company[$i]->office_no }}"
                                                        data-company_email="{{ $company[$i]->official_email }}"
                                                        data-company_gst_pan="{{ $company[$i]->pan_gst_no }}"
                                                        data-company_country="{{ $company[$i]->refCountry_id }}"
                                                        data-company_state="{{ $company[$i]->refState_id }}"
                                                        data-company_city="{{ $company[$i]->refCity_id }}"
                                                        data-company_address="{{ $company[$i]->office_address }}"
                                                        data-company_pincode="{{ $company[$i]->pincode }}"
                                                        >
                                                        <img src="/assets/images/edit.svg">
                                                    </a>
                                                    <a href="javascript::void(0);"
                                                        class="delete-btn btn btn-primary"
                                                        data-id="{{ $company[$i]->customer_company_id }}"
                                                        >
                                                        <img src="/assets/images/close.svg">
                                                    </a>
                                                </div>
                                            </th>
                                        </tr>
                                        <tr>
                                            <td>Company Name</td>
                                            <td>{{ $company[$i]->name }}</td>
                                        </tr>
                                        <tr>
                                            <td>Company Office No</td>
                                            <td>{{ $company[$i]->office_no }}</td>
                                        </tr>
                                        <tr>
                                            <td>Compant Email ID</td>
                                            <td>{{ $company[$i]->official_email }}</td>
                                        </tr>
                                        <tr>
                                            <td>Company GST/PAN</td>
                                            <td>{{ $company[$i]->pan_gst_no }}</td>
                                        </tr>
                                        <tr>
                                            <td>Country</td>
                                            <td>{{ $company[$i]->country_name }}</td>
                                        </tr>
                                        <tr>
                                            <td>State</td>
                                            <td>{{ $company[$i]->state_name }}</td>
                                        </tr>
                                        <tr>
                                            <td>City</td>
                                            <td>{{ $company[$i]->city_name }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            @endfor
                        </div>
                        {{-- <div class="row">
                            <div class="col col-12">
                                <div class="accordion checkout-accordion" id="checkoutaccordion">
                                    <div class="accordion-item card">
                                        <h2 class="accordion-header" id="headingOne">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                Addresses
                                            </button>
                                        </h2>
                                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#checkoutaccordion">
                                            <div class="accordion-body">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item card">
                                        <h2 class="accordion-header" id="headingTwo">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                Billing Address
                                            </button>
                                        </h2>
                                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#checkoutaccordion">
                                            <div class="accordion-body">
                                                <div class="row">
                                                    <div class="col col-12 col-xl-6">
                                                        <table class="table address-details table-bordered">
                                                            <tbody>
                                                                <tr>
                                                                    <th colspan="2">
                                                                        Address1
                                                                        <div class="add-edit-delete-btn">
                                                                            <a href="#" class="edit-add btn btn-primary"><img src="/assets/images/edit.svg"></a>
                                                                            <a href="#" class="delet-add btn btn-primary"><img src="/assets/images/close.svg"></a>
                                                                        </div>
                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                    <td>Company Name</td>
                                                                    <td>Janvi LEG</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Company Office No</td>
                                                                    <td>1234456778</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Compant Email ID</td>
                                                                    <td>abc@gmail.com</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Company GST Plan No</td>
                                                                    <td>123456</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Country</td>
                                                                    <td>India</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>State</td>
                                                                    <td>Gujarat</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>City</td>
                                                                    <td>Surat</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Add Address Modal -->
<div class="custom-modal add-address modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="add-address-content">
                    <h3 class="title mb-4">Add New Address</h3>
                    <div class="add-address-form">
                        <form class="add-form row" method="POST" action="/customer/save-addresses" enctype="multipart/form-data" id="companyForm">
                            @csrf
                            <input type="hidden" name="customer_company_id" id="customer_company_id">
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
<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
    },
    beforeSend: function (xhr) {
        $(".cs-loader").show();
    }
});
$(document).on('click', '.edit-btn', function () {
    $('#customer_company_id').val($(this).attr('data-id'));
    $('#company_name').val($(this).attr('data-name'));
    $('#company_office_no').val($(this).attr('data-company_office_no'));
    $('#company_email').val($(this).attr('data-company_email'));
    $('#company_gst_pan').val($(this).attr('data-company_gst_pan'));
    $('#company_address').val($(this).attr('data-company_address'));
    $('#company_pincode').val($(this).attr('data-company_pincode'));
    $('#company_country').val($(this).attr('data-company_country')).trigger('change');
    setTimeout(() => {
        $('#company_state').val($(this).attr('data-company_state')).trigger('change');
    }, 1000);
    setTimeout(() => {
        $('#company_city').val($(this).attr('data-company_city'));
    }, 2000);
    $('#exampleModal').modal('show');
});
$(document).on('click', '.delete-btn', function () {
    if(!confirm('Are you sure you want to delete?')) {
        return false;
    }
    $.ajax({
        type: "POST",
        url: "/customer/deleteMyCompany",
        data: { 'customer_company_id': $(this).attr('data-id') },
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
                $.toast({
                    heading: 'Success',
                    text: response.message,
                    icon: 'success',
                    position: 'top-right'
                });
                $(this).closest('.col').remove();
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
$("#exampleModal").on('hidden.bs.modal', function(){
    $('div.errTxt').html('');
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
        id_upload: {
            required: function (element) {
                return $('#customer_company_id').val() == '';
            }
        }
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
        form.submit();
    }
});
$(document).on('change', '#id_upload', function () {
    $(this).next('label').text($(this)[0].files[0].name);
});
</script>
@endsection
@extends('front.layout_2')
@section('title', $title)
@section('css')
<style type="text/css">
    body p {
        color: unset;
    }
    .account-tabs li a {
        display: block;
    }
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
    .add-address-btn {
        padding: 0.8rem;
        border: 1px solid #dddddd;
        width: 100%;
        margin-bottom: 2rem;
        cursor: pointer;
        color: #D2AB66;
    }
    .cs-table {
        width: 100%;
    }
    .cs-table td {
        padding: 1.25rem;
        border: 1px solid #dddddd;
    }
    .dropdown:hover > .dropdown-menu {
        display: block;
    }
    /* .dropdown-menu */ .edit-delete {
        padding: 0 !important;
        top: 0 !important;
        right: 10px;
        background-color: unset !important;
        width: fit-content;
        min-width: unset;
    }
    .dropdown-item.active, .dropdown-item:active {
        background-color: unset;
    }
    .select2.select2-container:not(:first-child) {
        width: 100% !important;
        padding-left: 40px;
    }
    .select2-selection.select2-selection--single {
        height: 43px;
        padding: 8px 0px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 40px;
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
                            <li class="tab-item"><a href="/customer/my-account" class="tab-link">My Personal Account</a></li>
                            <hr>
                            {{-- <li class="tab-item"><a href="/customer/my-profile" class="tab-link">Profile</a></li>
                            <hr> --}}
                            <li class="tab-item"><a href="javascript::void(0);" class="tab-link">My Companies</a></li>
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
                        <h4 class="mb-4">Manage Addresses</h4>
                        <div class="address-content-">
                            <div class="add-address">
                                <div class="add-address-btn" data-bs-toggle="modal" data-bs-target="#exampleModal">+ ADD A NEW ADDRESS</div>
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
                            <div class="table-responsive">
                                <table class="cs-table">
                                    <tbody>
                                        @for ($i = 0; $i < count($company); $i++)
                                        <tr>
                                            <td>
                                                <div class="row">
                                                    <div class="col-md-11 col-12">
                                                        <p><b>{{ $company[$i]->name . ' - ' . $company[$i]->office_no }}</b></p>
                                                        <div>{{ $company[$i]->office_address . ' - ' . $company[$i]->pincode }}</div>
                                                        <div>{{ $company[$i]->city_name . ', ' . $company[$i]->state_name . ', ' . $company[$i]->country_name }}</div>
                                                    </div>
                                                    <div class="col-md-1 col-1 text-right">
                                                        <div class="dropdown">
                                                            <i class="fa fa-ellipsis-v dropdown-toggle-" data-bs-toggle="dropdown" aria-expanded="false"> </i>
                                                            <ul class="dropdown-menu edit-delete">
                                                                <li>
                                                                    <a href="javascript:void(0);"
                                                                        class="edit-btn dropdown-item"
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
                                                                        > Edit
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="javascript:void(0);"
                                                                        class="delete-btn dropdown-item"
                                                                        data-id="{{ $company[$i]->customer_company_id }}"
                                                                        > Delete
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endfor
                                    </tbody>
                                </table>
                            </div>
                        </div>
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
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <select class="form-select" id="company_country_code" name="company_country_code">
                                                <option selected value="">CC</option>
                                                @foreach ($country as $row)
                                                <option value="{{ $row->country_id }}">{{ '+' . $row->country_code . ' (' . $row->name . ')' }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="errTxt"></div>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="form-group">
                                            <img src="/assets/images/phone.svg" alt="icn" class="img-fluid input-icon">
                                            <input type="text" class="form-control" id="company_office_no" name="company_office_no" placeholder="Company Mobile">
                                        </div>
                                        <div class="errTxt"></div>
                                    </div>
                                </div>
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
                            <div class="col col-12 col-md-12 mb-0">
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
    $('#company_country_code').val($(this).attr('data-company_country')).trigger('change');
    $('#company_country').val($(this).attr('data-company_country')).trigger('change');
    setTimeout(() => {
        $('#company_state').val($(this).attr('data-company_state')).trigger('change');
    }, 1000);
    setTimeout(() => {
        $('#company_city').val($(this).attr('data-company_city')).trigger('change');
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
                $(this).closest('tr').remove();
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
    $('#companyForm')[0].reset();
    $('#company_country, #company_country_code, #company_state, #company_city').val(null).trigger('change');
    $('div.errTxt').html('');
});
setTimeout(() => {
    $('#company_country, #company_state, #company_city, #company_country_code').select2({
        dropdownParent: $('#exampleModal')
    });
    $('#company_country_code').on('select2:open', function (e) {
        setTimeout(() => {
            $('#select2-company_country_code-results').parent().parent().css('width', '15vw');
        }, 10);
    });
}, 1000);
$(document).on('change', '#company_country_code', function () {
    if ($(this).val()) {
        $('#company_country').val($(this).val()).trigger('change').attr('disabled', true).parent().css('background', '#e9ecef');
    } else {
        $('#company_country').val($(this).val()).trigger('change').attr('disabled', false).parent().css('background', '#fff');
    }
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
        /* id_upload: {
            required: function (element) {
                return $('#customer_company_id').val() == '';
            }
        } */
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
        form.submit();
    }
});
$(document).on('change', '#id_upload', function () {
    $(this).next('label').text($(this)[0].files[0].name);
});
</script>
@endsection
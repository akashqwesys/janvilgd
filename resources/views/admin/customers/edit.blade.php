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
    .add-edit-delete-btn {
        float: right;
    }
    .add-edit-delete-btn img {
        width: 15px;
        height: 15px;
        filter: brightness(0) invert(1);
    }
    .custom-modal .form-group {
        margin-bottom: 0;
    }
    .custom-modal .col {
        margin-bottom: 1.25rem;
    }
    .errTxt {
        color: red;
        text-align: center;
        font-size: 0.9em;
    }
    .custom-modal .form-group .input-icon {
        position: absolute;
        top: 0;
        left: 10px;
        bottom: 0;
        width: 20px;
        margin: auto;
    }
    .custom-modal .form-group .form-control, .custom-modal .form-group select.form-select {
        padding-left: 40px;
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
                         <h3 class="nk-block-title page-title" style="display: inline;">Edit Customer</h3>
                        <a style="float: right;" href="/admin/customers" class="btn btn-icon btn-primary">&nbsp;&nbsp;Back To List<em class="icon ni ni-plus"></em></a>
                    </div><!-- .nk-block-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block nk-block-lg">
                    <div class="card">
                        <div class="card-inner">
                            <h5>Personal Details</h5>
                            <hr>
                            <form  method="POST" action="{{route('customers.update')}}" enctype="multipart/form-data" class="">
                                @csrf
                                <input type="hidden" name="id" value="{{ $data['result']->customer_id }}">
                                <div class="nk-wizard-content-">
                                    <div class="row g-3 align-center">
                                        <div class="col-lg-1">
                                            <div class="form-group">
                                                <label class="form-label float-md-right" for="name">Name:</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter name" required="" autocomplete="off" value="{{ $data['result']->name }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 align-center">
                                        <div class="col-lg-1">
                                            <div class="form-group">
                                                <label class="form-label float-md-right" for="mobile">Mobile:</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" name="mobile" id="mobile" placeholder="Enter mobile number" autocomplete="off"  value="{{ $data['result']->mobile }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 align-center">
                                        <div class="col-lg-1">
                                            <div class="form-group">
                                                <label class="form-label float-md-right" for="email">Email:</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <input type="email" class="form-control" name="email" id="email" placeholder="Enter email" autocomplete="off"  value="{{ $data['result']->email }}">
                                                    @if($errors->has('email'))
                                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 align-center">
                                        <div class="col-lg-1">
                                            <div class="form-group">
                                                <label class="form-label float-md-right" for="address">Address:</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <textarea name="address" class="form-control form-control-sm" id="cf-default-textarea" placeholder="Enter address"> {{ $data['result']->address }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 align-center">
                                        <div class="col-lg-1">
                                            <div class="form-group">
                                                <label class="form-label float-md-right" for="pincode">Pincode:</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" name="pincode" id="pincode" placeholder="Enter pincode" autocomplete="off"  value="{{ $data['result']->pincode }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 align-center">
                                        <div class="col-lg-1">
                                            <div class="form-group">
                                                <label class="form-label float-right" for="refCountry_id">Country:</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <div class="form-control-wrap-">
                                                    <select class="form-control form-select-" id="refCountry_id" name="refCountry_id" required=""  data-search="on" data-placeholder="------ Select Country ------">
                                                        <option value="">------ Select Country ------</option>
                                                        <?php
                                                        if (!empty($data['country'])) {
                                                            foreach ($data['country'] as $row) {
                                                                ?>
                                                                <option value="{{ $row->country_id }}" {{ set_selected($row->country_id,$data['result']->refCountry_id) }}>{{ $row->name }}</option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row g-3 align-center">
                                        <div class="col-lg-1">
                                            <div class="form-group">
                                                <label class="form-label float-right" for="refState_id">State:</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <select class="form-control form-select-" id="refState_id" name="refState_id" required="" tabindex="-1" aria-hidden="true" data-search="on" data-placeholder="------ Select State ------">
                                                        <option value="">------ Select State ------</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 align-center">
                                        <div class="col-lg-1">
                                            <div class="form-group">
                                                <label class="form-label float-right" for="refCity_id">City:</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <select class="form-control form-select-" id="refCity_id" name="refCity_id" required="" tabindex="-1" aria-hidden="true" data-search="on" data-placeholder="------ Select City ------">
                                                        <option value="">------ Select City ------</option>
                                                        <?php
                                                        /* if (!empty($data['city'])) {
                                                            foreach ($data['city'] as $row) {
                                                                ?>
                                                                <option value="{{ $row->city_id }}" {{ set_selected($row->city_id,$data['result']->refCity_id) }}>{{ $row->name }}</option>
                                                                <?php
                                                            }
                                                        } */
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 align-center">
                                        <div class="col-lg-1">
                                            <div class="form-group">
                                                <label class="form-label float-right" for="refCustomerType_id">Customer Type:</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <select class="form-control" id="refCustomerType_id" name="refCustomerType_id" required="" tabindex="-1" aria-hidden="true" data-search="on">
                                                        <option value="">------ Select Type ------</option>
                                                        <?php
                                                        if (!empty($data['customer_type'])) {
                                                            foreach ($data['customer_type'] as $row) {
                                                                ?>
                                                                <option value="{{ $row->customer_type_id }}" {{ set_selected($row->customer_type_id,$data['result']->refCustomerType_id) }}>{{ $row->name }}</option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 align-center">
                                        <div class="col-lg-1">
                                            <div class="form-group">
                                                <label class="form-label float-right" for="restrict_transactions">Restrict Transactions:</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <select class="form-control" id="restrict_transactions" name="restrict_transactions" required="" tabindex="-1" aria-hidden="true" data-search="on">
                                                        <option value="1" {{ set_selected(1,$data['result']->restrict_transactions) }}>YES</option>
                                                        <option value="0" {{ set_selected(0,$data['result']->restrict_transactions) }}>No</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 align-center">
                                        <div class="col-lg-1"></div>
                                        <div class="col-lg-3">
                                            <button class="btn btn-primary" type="submit">SAVE</button>
                                        </div>
                                    </div>

                                </div>


                            </form>
                        </div>
                    </div>
                </div><!-- .nk-block -->
                <div class="nk-block nk-block-lg">
                    <div class="card">
                        <div class="card-inner">
                            <h5>Company Details</h5>
                            <hr>
                            <div class="row">
                                @php
                                    $company = $data['result2'];
                                @endphp
                                @for ($i = 0; $i < count($company); $i++)
                                <div class="col col-12 col-xl-6 mb-3">
                                    <table class="table address-details table-bordered">
                                        <tbody>
                                            <tr>
                                                <th colspan="2">
                                                    <h6 class="float-left">Address - {{ $i+1 }}</h6>
                                                    <div class="add-edit-delete-btn">
                                                        <a href="javascript:void(0);"
                                                            class="edit-btn btn btn-primary btn-sm"
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
                                                        <a href="javascript:void(0);"
                                                            class="delete-btn btn btn-primary btn-sm"
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Add Address Modal -->
<div class="custom-modal add-address modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div class="add-address-content">
                    <h3 class="title mb-4">Add New Address</h3>
                    <div class="add-address-form">
                        <form class="add-form row" method="POST" action="/admin/customers/save-addresses" enctype="multipart/form-data" id="companyForm">
                            @csrf
                            <input type="hidden" name="customer_company_id" id="customer_company_id">
                            <input type="hidden" name="form_customer_id" id="customer_id" value="{{ $data['result']->customer_id }}">
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
                                    <select class="form-select- form-control" id="company_country" name="company_country">
                                        <option value="" >Select Country</option>
                                        @foreach ($data['country'] as $c)
                                        <option value="{{ $c->country_id }}" >{{ $c->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="errTxt"></div>
                            </div>
                            <div class="col col-12 col-md-4">
                                <div class="form-group">
                                    <img src="/assets/images/flag.svg" alt="icn" class="img-fluid input-icon">
                                    <select class="form-select- form-control" id="company_state" name="company_state">
                                        <option value="" >Select State</option>
                                    </select>
                                </div>
                                <div class="errTxt"></div>
                            </div>
                            <div class="col col-12 col-md-4">
                                <div class="form-group">
                                    <img src="/assets/images/building_city.svg" alt="icn" class="img-fluid input-icon">
                                    <select class="form-select- form-control" id="company_city" name="company_city">
                                        <option value="" >Select City</option>
                                    </select>
                                </div>
                                <div class="errTxt"></div>
                            </div>
                            <div class="col col-12 col-md-8">
                                <div class="form-group">
                                    <img src="/assets/images/location.svg" alt="icn" class="img-fluid input-icon" style="width: 15px">
                                    <input type="text" class="form-control" id="company_address" name="company_address" placeholder="Company Address" >
                                </div>
                                <div class="errTxt"></div>
                            </div>
                            <div class="col col-12 col-md-4">
                                <div class="form-group">
                                    <img src="/assets/images/location.svg" alt="icn" class="img-fluid input-icon" style="width: 15px">
                                    <input type="text" class="form-control" id="company_pincode" name="company_pincode" placeholder="Company Pincode">
                                </div>
                                <div class="errTxt"></div>
                            </div>
                            <div class="col col-12 col-md-12">
                                <div class="form-group">
                                    <div class="upload-file-box">
                                        <div class="file-upload-box">
                                            <div class="file-select text-center m-auto">
                                                {{-- <img src="/assets/images/upload-file-icon.svg" alt="icn" class="img-fluid mb-3"> --}}
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="id_upload" name="id_upload" id="id_upload" aria-describedby="inputGroupFileAddon01" accept="image/jpeg,image/png,application/pdf">
                                                        <label class="custom-file-label ml-auto mr-auto" for="id_upload">Click here to upload ID proof</label>
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
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
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
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/additional-methods.min.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
    });
    setTimeout(() => {
        $('#refCountry_id').trigger('change');
    }, 500);
    setTimeout(() => {
        $('#refState_id').val(<?= $data['result']->refState_id ?>).trigger('change');
    }, 1000);
    setTimeout(() => {
        $('#refCity_id').val(<?= $data['result']->refCity_id ?>);
    }, 2000);
    $(document).on('change', '#refCountry_id', function () {
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
                    $('#refState_id').html(response.data);
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
    $(document).on('change', '#refState_id', function () {
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
                    $('#refCity_id').html(response.data);
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
        url: "/admin/customers/delete-addresses",
        data: {
            'customer_id': $('#customer_id').val(),
            'customer_company_id': $(this).attr('data-id')
        },
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
    $('.custom-file-label').text('Click here to upload ID proof');
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
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
                            <form  method="POST" action="{{route('customers.save')}}" enctype="multipart/form-data" class="nk-wizard nk-wizard-simple is-alter">
                                @csrf
                                <div class="nk-wizard-head">
                                    <h5>Step 1</h5>
                                </div>
                                <div class="nk-wizard-content">
                                    <div class="row g-3 align-center">
                                        <div class="col-lg-1">
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
                                        <div class="col-lg-1">
                                            <div class="form-group">
                                                <label class="form-label float-md-right" for="mobile">Mobile:</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" name="mobile" id="mobile" placeholder="Enter mobile number" autocomplete="off">
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
                                                    <input type="email" class="form-control" name="email" id="email" placeholder="Enter email" autocomplete="off">
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
                                                    <textarea name="address" class="form-control form-control-sm" id="cf-default-textarea" placeholder="Enter address"></textarea>
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
                                                    <input type="text" class="form-control" name="pincode" id="pincode" placeholder="Enter pincode" autocomplete="off">
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
                                                <div class="form-control-wrap">
                                                    <select class="form-control" id="refCountry_id" name="refCountry_id" required="" tabindex="-1" aria-hidden="true" data-search="on">
                                                        <option value="">------ Select Country ------</option>
                                                        <?php
                                                        if (!empty($data['country'])) {
                                                            foreach ($data['country'] as $row) {
                                                                ?>
                                                                <option value="{{ $row->country_id }}">{{ $row->name }}</option>
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
                                                    <select class="form-control" id="refState_id" name="refState_id" required="" tabindex="-1" aria-hidden="true" data-search="on">
                                                        <option value="">------ Select State ------</option>
                                                        <?php
                                                        /* if (!empty($data['state'])) {
                                                            foreach ($data['state'] as $row) {
                                                                ?>
                                                                <option value="{{ $row->state_id }}">{{ $row->name }}</option>
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
                                                <label class="form-label float-right" for="refCity_id">City:</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <select class="form-control" id="refCity_id" name="refCity_id" required="" tabindex="-1" aria-hidden="true" data-search="on">
                                                        <option value="">------ Select City ------</option>
                                                        <?php
                                                        /* if (!empty($data['city'])) {
                                                            foreach ($data['city'] as $row) {
                                                                ?>
                                                                <option value="{{ $row->city_id }}">{{ $row->name }}</option>
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
                                                                <option value="{{ $row->customer_type_id }}">{{ $row->name }}</option>
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
                                                        <option value="1">YES</option>
                                                        <option value="0">No</option>
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
                                        <div class="col-lg-1">
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
                                        <div class="col-lg-1">
                                            <div class="form-group">
                                                <label class="form-label float-md-right" for="office_no">Office no:</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" name="office_no" id="office_no" placeholder="Enter mobile number" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 align-center">
                                        <div class="col-lg-1">
                                            <div class="form-group">
                                                <label class="form-label float-md-right" for="official_email">Email:</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <input type="email" class="form-control" name="official_email" id="official_email" placeholder="Enter email" autocomplete="off">
                                                    @if($errors->has('email'))
                                                    <span class="text-danger">{{ $errors->first('official_email') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 align-center">
                                        <div class="col-lg-1">
                                            <div class="form-group">
                                                <label class="form-label float-right" for="designation_id">Designation:</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <select class="form-control" id="designation_id" name="designation_id" required="" tabindex="-1" aria-hidden="true" data-search="on">
                                                        <option value="">------ Select Country ------</option>
                                                        <?php
                                                        if (!empty($data['designation'])) {
                                                            foreach ($data['designation'] as $row) {
                                                                ?>
                                                                <option value="{{ $row->id }}">{{ $row->name }}</option>
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
                                                <label class="form-label float-md-right" for="office_address">Office Address:</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <textarea name="office_address" class="form-control form-control-sm" id="office_address" placeholder="Enter address"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 align-center">
                                        <div class="col-lg-1">
                                            <div class="form-group">
                                                <label class="form-label float-md-right" for="office_pincode">Office Pincode:</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" name="office_pincode" id="office_pincode" placeholder="Enter pincode" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 align-center">
                                        <div class="col-lg-1">
                                            <div class="form-group">
                                                <label class="form-label float-right" for="office_country_id">Company Country:</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <select class="form-control" id="office_country_id" name="office_country_id" required="" tabindex="-1" aria-hidden="true" data-search="on">
                                                        <option value="">------ Select Country ------</option>
                                                        <?php
                                                        if (!empty($data['country'])) {
                                                            foreach ($data['country'] as $row) {
                                                                ?>
                                                                <option value="{{ $row->country_id }}">{{ $row->name }}</option>
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
                                                <label class="form-label float-right" for="office_state_id">Company State:</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <select class="form-control" id="office_state_id" name="office_state_id" required="" tabindex="-1" aria-hidden="true" data-search="on">
                                                        <option value="">------ Select State ------</option>
                                                        <?php
                                                        if (!empty($data['state'])) {
                                                            foreach ($data['state'] as $row) {
                                                                ?>
                                                                <option value="{{ $row->state_id }}">{{ $row->name }}</option>
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
                                                <label class="form-label float-right" for="office_city_id">Company City:</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <select class="form-control" id="office_city_id" name="office_city_id" required="" tabindex="-1" aria-hidden="true" data-search="on">
                                                        <option value="">------ Select City ------</option>
                                                        <?php
                                                        if (!empty($data['city'])) {
                                                            foreach ($data['city'] as $row) {
                                                                ?>
                                                                <option value="{{ $row->city_id }}">{{ $row->name }}</option>
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
                                                <label class="form-label float-md-right" for="pan_gst_no">PAN or GST No:</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" name="pan_gst_no" id="pan_gst_no" placeholder="Enter pan or gst no" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 align-center">
                                        <div class="col-lg-1">
                                            <div class="form-group">
                                                <label class="form-label float-md-right" for="pan_gst_no_file">PAN/GST Files:</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <div class="custom-file">
                                                        <input type="file" name="pan_gst_no_file" class="custom-file-input" id="pan_gst_no_file">
                                                        <label class="custom-file-label" for="pan_gst_no_file">Choose file</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 align-center">
                                    <div class="col-md-11 offset-1">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" data-msg="Required" class="custom-control-input required" name="is_approved" id="is_approved" required value="1">
                                            <label class="custom-control-label" for="is_approved">Is Approved</label>
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
        }
    });
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
</script>
@endsection
@extends('admin.header')
@section('css')
<style>
    .errTxt {
        color: red;
        text-align: center;
        font-size: 0.9em;
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
                        <h3 class="nk-block-title page-title" style="display: inline;">Add User</h3>
                        <a style="float: right;" href="/admin/users" class="btn btn-icon btn-primary">&nbsp;&nbsp;Back To List<em class="icon ni ni-plus"></em></a>
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
                            <form method="POST" action="{{route('users.save')}}" enctype="multipart/form-data" id="usersForm">
                                @csrf
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
                                            <label class="form-label float-md-right" for="mobile">Mobile:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <select class="form-control" id="country_code" name="country_code" data-search="on">
                                                        @foreach ($data['country'] as $row)
                                                        <option value="{{ $row->country_id }}" {{ set_selected(101, $row->country_id) }}>{{ '+' . $row->country_code . ' (' . $row->name . ')' }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-lg-6">
                                                    <input type="text" class="form-control" name="mobile" id="mobile" placeholder="Enter mobile number" autocomplete="off" required>
                                                </div>
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
                                            <div class="form-control-wrap">
                                                <input type="email" class="form-control" name="email" id="email" placeholder="Enter email" autocomplete="off" required>
                                                @if($errors->has('email'))
                                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                                @endif
                                            </div>
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
                                            <label class="form-label float-right" for="country_id">Country:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <select class="form-control" id="country_id" name="country_id" required="" data-search="on" disabled>
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
                                            <label class="form-label float-right" for="state_id">State:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <select class="form-control" id="state_id" name="state_id" tabindex="-1" aria-hidden="true" data-search="on">
                                                    <option value="">------ Select State ------</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label class="form-label float-right" for="city_id">City:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <select class="form-control" id="city_id" name="city_id" tabindex="-1" aria-hidden="true" data-search="on">
                                                    <option value="">------ Select City ------</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label class="form-label float-md-right" for="id_proof_1">id proof 1:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <div class="custom-file">
                                                    <input type="file" name="id_proof_1" class="custom-file-input" id="id_proof_1">
                                                    <label class="custom-file-label" for="id_proof_1">Choose file</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label class="form-label float-md-right" for="id_proof_2">id proof 2:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <div class="custom-file">
                                                    <input type="file" name="id_proof_2" class="custom-file-input" id="id_proof_2">
                                                    <label class="custom-file-label" for="image">Choose file</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label class="form-label float-md-right" for="profile_pic">Profile Image:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <div class="custom-file">
                                                    <input type="file" name="profile_pic" class="custom-file-input" id="profile_pic">
                                                    <label class="custom-file-label" for="image">Choose file</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label class="form-label float-right" for="role_id">User Role:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <select class="form-control" id="role_id" name="role_id"  >
                                                    <option value="">------ Select Role ------</option>
                                                    @foreach ($data['user_role'] as $row)
                                                    <option value="{{ $row->user_role_id }}">{{ $row->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label class="form-label float-right" for="user_type">User Type:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <select class="form-control" id="user_type" name="user_type" required="" >
                                                    <option value="">------ Select Type ------</option>
                                                    <option value="MASTER_ADMIN">MASTER ADMIN</option>
                                                    <option value="USER">USER</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row g-3">
                                    <div class="col-sm-12 col-md-2 offset-md-2">
                                        <div class="form-group mt-2">
                                            <button type="submit" class="btn btn-lg btn-primary btn-block">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div><!-- card -->
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
    setTimeout(() => {
        $('#country_code, #country_id').select2({});
        $('#country_code').on('select2:open', function (e) {
            setTimeout(() => {
                $('#select2-country_code-results').parent().parent().css('width', '15vw');
            }, 10);
        });
        $('#country_code').trigger('change');
    }, 1000);
    $(document).on('keydown keyup', 'input[aria-controls="select2-country_code-results"]', function() {
        $('#select2-country_code-results').parent().parent().css('width', '15rem');
    });

    $(document).on('change', '#country_code', function () {
        if ($(this).val()) {
            $(this).siblings('.error').text('');
            $('#country_id').val($(this).val()).trigger('change').attr('disabled', true);
        } else {
            $('#country_id').val($(this).val()).trigger('change').attr('disabled', false);
        }
    });

    $(document).on('change', '#country_id', function () {
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
                    $('#state_id').html(response.data).select2();
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
    $(document).on('change', '#state_id', function () {
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
                    $('#city_id').html(response.data).select2();
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
    $(document).on('change', '#city_id', function () {
        if ($(this).val()) {
            $(this).siblings('.error').text('');
        }
    });

    $("#usersForm").validate({
        rules: {
            name: { required:true},
            email: { required:true, email: true},
            mobile: { number:true, rangelength: [10,11]},
            password: { required: true, rangelength: [6, 15] },
            confirm_password: { required: true, equalTo: "#password" },
            address: { required: true},
            // role_id: { required: true},
            user_type: { required: true},
        },
        messages: {
            name: {required: "Please enter your name"},
            email: {
                required: "Please enter your email address",
                email: "Your email address must be in the format of name@domain.com"
            },
            password: { required: "Please enter password" },
            confirm_password: { required: "Please enter confirm password", equalTo: 'Those password didn\'t match. Try again' },
            mobile: {
                required: "Please enter your mobile number",
                number: "Your contact number should only consist of numeric digits"
            },
            address: {required: "Please enter your address"},
        },
        submitHandler: function(form) {
            // do other things for a valid form
            // form.submit();
            var formData = new FormData(form);
            if ($('#id_proof_1')[0].files.length > 0) {
                formData.append('id_proof_1', $('#id_proof_1')[0].files);
            }
            if ($('#id_proof_2')[0].files.length > 0) {
                formData.append('id_proof_2', $('#id_proof_2')[0].files);
            }
            if ($('#profile_pic')[0].files.length > 0) {
                formData.append('profile_pic', $('#profile_pic')[0].files);
            }
            $.ajax({
                type: "POST",
                url: "/admin/users/save",
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
                            location.href = '/admin/users';
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
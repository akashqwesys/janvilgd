<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" sizes="32x32" href="/{{ check_host() }}assets/images/favicon-icon.png">

    <link rel="stylesheet" type="text/css" href="/{{ check_host() }}assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/{{ check_host() }}assets/css/slick.css">
    <link rel="stylesheet" type="text/css" href="/{{ check_host() }}assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="/{{ check_host() }}assets/css/custom.css">
    <link rel="stylesheet" href="{{ asset(check_host().'admin_assets/toast/jquery.toast.css') }}">
    <style type="text/css">
        .errTxt {
            color: red;
            text-align: center;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <div class="overlay cs-loader">
      <div class="overlay__inner">
        <div class="overlay__content"><img src='/assets/images/Janvi_Akashs_Logo_Loader_2.gif'></div>
      </div>
    </div>
    <div class="content-wrapper">
        <section class="signup-section">
            <div class="login-bg">
                <img src="/{{ check_host() }}assets/images/PSNM.gif" alt="PSNM">
            </div>
            <div class="container">
                <div class="row">
                    <div class="col col-12 col-md-10 col-lg-7 m-auto">
                        <div class="form-header text-center">
                            <a href="/"><img src="/{{ check_host() }}assets/images/logo.png" alt="logo" class="img-fluid"></a>
                        </div>
                        <form id="msform" class="msform">

                            <h4>Signup here in just 2 minutes</h4>
                            <ul class="progressbar" id="progressbar">
                                <li class="active">Personal Info</li>
                                <li>Business Info</li>
                                <li>Id Proof</li>
                            </ul>
                            <fieldset>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text"><img src="/{{ check_host() }}assets/images/comapny-icon.svg" alt=""></span>
                                            <input type="text" name="name" id="name" class="form-control" placeholder="Name">
                                        </div>
                                        <div class="errTxt"></div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text"><img src="/{{ check_host() }}assets/images/phone.svg" alt=""></span>
                                            <input type="text" id="mobile" class="form-control" value="{{ empty(trim($mobile)) ? '' : $mobile }}" placeholder="Mobile Number" {{ empty(trim($mobile)) ? '' : 'disabled' }}>
                                        </div>
                                        <div class="errTxt"></div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text"><img src="/{{ check_host() }}assets/images/email.svg" alt=""></span>
                                            <input type="email" id="email" class="form-control" value="{{ empty(trim($email)) ? '' : $email }}" placeholder="Email Address" {{ empty(trim($email)) ? '' : 'disabled' }}>
                                        </div>
                                        <div class="errTxt"></div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text"><img src="/{{ check_host() }}assets/images/location.svg" alt=""></span>
                                            <input type="text" name="address" id="address" class="form-control" placeholder="Address">
                                        </div>
                                        <div class="errTxt"></div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text"><img src="/{{ check_host() }}assets/images/country.svg" alt=""></span>
                                            <select class="form-select" id="country" name="country">
                                                <option selected value="">Select Country</option>
                                                @foreach ($country as $c)
                                                    <option value="{{ $c->country_id }}">{{ $c->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="errTxt"></div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text"><img src="/{{ check_host() }}assets/images/country.svg" alt=""></span>
                                            <select class="form-select" id="state" name="state">
                                                <option selected value="">Select State</option>
                                                {{-- @foreach ($state as $c)
                                                    <option value="{{ $c->state_id }}">{{ $c->name }}</option>
                                                @endforeach --}}
                                            </select>
                                        </div>
                                        <div class="errTxt"></div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text"><img src="/{{ check_host() }}assets/images/apartment_building_city.svg" alt=""></span>
                                            <select class="form-select" id="city" name="city">
                                                <option selected value="">Select City</option>
                                                {{-- @foreach ($city as $c)
                                                    <option value="{{ $c->city_id }}">{{ $c->name }}</option>
                                                @endforeach --}}
                                            </select>
                                        </div>
                                        <div class="errTxt"></div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text"><img src="/{{ check_host() }}assets/images/location.svg" alt=""></span>
                                            <input type="text" name="pincode" id="pincode" class="form-control" placeholder="Pincode">
                                        </div>
                                        <div class="errTxt"></div>
                                    </div>
                                </div>
                                <button class="next-1 action-button btn">Next</button>
                                {{-- <input type="button" name="next" class="next action-button" value="Next" /> --}}
                            </fieldset>
                            <fieldset>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text"><img src="/{{ check_host() }}assets/images/comapny-icon.svg" alt=""></span>
                                            <input type="text" name="company_name" id="company_name" class="form-control" placeholder="Company Name">
                                        </div>
                                        <div class="errTxt"></div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text"><img src="/{{ check_host() }}assets/images/comapny-icon.svg" alt=""></span>
                                            <input type="text" name="company_office_no" id="company_office_no" class="form-control" placeholder="Company Office No.">
                                        </div>
                                        <div class="errTxt"></div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text"><img src="/{{ check_host() }}assets/images/email.svg" alt=""></span>
                                            <input type="email" name="company_email" id="company_email" class="form-control" placeholder="Company Email ID">
                                        </div>
                                        <div class="errTxt"></div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text"><img src="/{{ check_host() }}assets/images/bag_finance_money.svg" alt=""></span>
                                            <input type="text" name="company_gst_pan" id="company_gst_pan" class="form-control" placeholder="Company GST/Pan No">
                                        </div>
                                        <div class="errTxt"></div>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text"><img src="/{{ check_host() }}assets/images/location.svg" alt=""></span>
                                            <input type="text" name="company_address" id="company_address" class="form-control" placeholder="Company Address">
                                        </div>
                                        <div class="errTxt"></div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text"><img src="/{{ check_host() }}assets/images/country.svg" alt=""></span>
                                            <select class="form-select" id="company_country" name="company_country">
                                                <option selected value="">Select Country</option>
                                                @foreach ($country as $c)
                                                    <option value="{{ $c->country_id }}">{{ $c->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="errTxt"></div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text"><img src="/{{ check_host() }}assets/images/country.svg" alt=""></span>
                                            <select class="form-select" id="company_state" name="company_state">
                                                <option selected value="">Select State</option>
                                                @foreach ($state as $c)
                                                    <option value="{{ $c->state_id }}">{{ $c->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="errTxt"></div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text"><img src="/{{ check_host() }}assets/images/apartment_building_city.svg" alt=""></span>
                                            <select class="form-select" id="company_city" name="company_city">
                                                <option selected value="">Select City</option>
                                                @foreach ($city as $c)
                                                    <option value="{{ $c->city_id }}">{{ $c->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="errTxt"></div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text"><img src="/{{ check_host() }}assets/images/location.svg" alt=""></span>
                                            <input type="text" name="company_pincode" id="company_pincode" class="form-control" placeholder="Pincode">
                                        </div>
                                        <div class="errTxt"></div>
                                    </div>
                                </div>
                                <a class="previous-1 action-button-previous btn" href="javascript:void(0);">Previous</a>
                                <button class="next-2 action-button btn">Next</button>
                            </fieldset>
                            <fieldset>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h5>Business Identity Proof</h5>
                                        <div class="form-group custom-file-field">
                                            <label for="id_upload" class="et_pb_contact_form_label" data-content="Drag and Drop a file here">Enter</label>
                                            <input type="file" id="id_upload" name="id_upload" class="id_upload" accept="image/jpeg,image/png,application/pdf">
                                        </div>
                                        <div class="errTxt"></div>
                                        <p>Business Identity Proof (Upload only .jpg, .jpeg, .png and .pdf files)</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="privacy_terms" name="privacy_terms">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                I have read and agree to the <a href="/terms-conditions"><span>Terms & Conditions*</span></a>
                                            </label>
                                        </div>
                                        <div class="errTxt"></div>
                                    </div>
                                </div>
                                <a class="previous-2 action-button-previous btn" href="javascript:void(0);">Previous</a>
                                <button type="submit" class="submit action-button btn"> Done </button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script src="/{{ check_host() }}assets/js/jquery-3.6.0.min.js"></script>
    <script src="/{{ check_host() }}assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/additional-methods.min.js"></script>
    <script src="{{ asset(check_host().'admin_assets/toast/jquery.toast.js') }}"></script>
    <script type="text/javascript">
        var gmail = '{{ $email }}';
    </script>
    <script src="/{{ check_host() }}assets/js/sign-up.js"></script>
</body>
</html>

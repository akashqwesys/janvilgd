@extends('front.layout_1')
@section('title', 'Contact Us')
@section('content')
    <div class="content-wrapper contact-section">
        <section>
            <div class="container contact">
                <div class="row">
                    <div class="col-md-8 datadiv boxshadow">
                        <div class="contact-form" action="/customer/contact" method="post">
                            <h2 style="margin-bottom: 15px">Want us to contact you</h2>
                            <p style="margin-bottom: 5px">Leave a message</p>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 mb-4"> <label class="control-label" for="name">Name</label>
                                    <input type="text" class="form-control" id="fname" placeholder="Name" name="txt_name"
                                        required="" /> </div>
                                <div class="col-sm-12 col-md-6"> <label class="control-label" for="email">Email</label>
                                    <input type="email" class="form-control" id="email" placeholder="Email Address"
                                        name="txt_email" required="" /> </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 mb-4"> <label class="control-label"
                                        for="subject">Subject</label> <input type="text" class="form-control" id="subject"
                                        placeholder="Subject" name="txt_subject" required="" /> </div>
                                <div class="col-sm-12 col-md-6 mb-4"> <label class="control-label" for="phone">Phone
                                        Number</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <select class="form-control form-select" id="cs-fc" name="country_code">
                                                @foreach ($country as $c)
                                                <option value="{{ $c->country_id }}" {{ $c->country_code == 91 ? 'selected' : '' }}> +{{ $c->country_code . ' (' . $c->name . ')'}} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6"> <input class="form-control" id="phone"
                                                placeholder="Phone Number" name="txt_phone" type="tel" requird="" /> </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 mb-4"> <label class="control-label" for="message">I would like to
                                        discuss</label>
                                    <textarea class="form-control" rows="5" id="message" name="txt_msg" placeholder="Message" required=""></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-offset-2 col-sm-10"> <button id="contact-submit-btn" type="submit"
                                        class="btn btn-default">Submit</button> </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 infodiv boxshadow">
                        <div class="contact-info">
                            <h3>Contact Us</h3> <br />
                            <?php $get_settings = get_address_settings(); ?>
                            <ul>
                                <li class="firstli">{{ collect($get_settings)->where('key', 'contact_indian_address')->pluck('value')->first() }}</li>
                                <li class="secondli">{{ collect($get_settings)->where('key', 'contact_email')->pluck('value')->first() }}</li>
                                <li class="thirdli">{{ collect($get_settings)->where('key', 'contact_indian_mobile')->pluck('value')->first() }}</li>
                            </ul>
                            <br />
                            <a class="btn" href="https://goo.gl/maps/PtNLVBLpCF4tSbnY7">
                                <img src="assets/images/placeholder.png" width="40%" data-toggle="tooltip"
                                    data-placement="top" title="" data-original-title="Click to view location" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
        setTimeout(() => {
            $('.select2.select2-container').remove();
        }, 500);
    </script>
@endsection

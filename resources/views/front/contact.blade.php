@extends('front.layout_1')
@section('title', 'Contact Us')
@section('content')
<section class="contact-section sub-header">
    <div class="container">
        <div class="section-content">
            <div>
                <h2 class="title bread-crumb-title">Contact Us</h2>
            </div>
        </div>
    </div>
</section>

<section class="contact-info-section">
    <div class="container">
        <div class="row">
            <div class="col col-12 col-md-6">
                <h2>Contact Details</h2>
                <form class="contact-form">
                    <div class="form-row">
                        <div class="col col-12 col-lg-6">
                            <div class="form-group">
                                <input type="text" class="form-control" id="txt_name" placeholder="Name*">
                            </div>
                        </div>
                        <div class="col col-12 col-lg-6">
                            <div class="form-group">
                                <input type="tel" class="form-control" id="txt_phone" placeholder="Phone No.*">
                            </div>
                        </div>
                        <div class="col col-12 col-lg-6">
                            <div class="form-group">
                                <input type="email" class="form-control" id="txt_email" placeholder="Email*">
                            </div>
                        </div>
                        <div class="col col-12 col-lg-6">
                            <div class="form-group">
                                <input type="text" class="form-control" id="txt_subject" placeholder="Subject*">
                            </div>
                        </div>
                        <div class="col col-12">
                            <div class="form-group">
                                <textarea class="form-control" id="txt_msg" placeholder="Message*" rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Send</button>
                </form>
            </div>
            <div class="col col-12 col-md-6">
                <div class="contact-content">
                    <h2>Contact us</h2>
                    <p class="description">
                        Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica, quam nunc putamus parum claram anteposuerit litterarum formas human.
                    </p>
                    <ul class="country_address_links">
                        <li>
                            <span class="flag-icon">
                                <img src="assets/images/india.png" alt="" >
                            </span>
                            <span class="location">India</span>
                            <div class="location-address">
                                <div class="location_inner">
                                    <p class="add"><span>Address :</span>It is a long edad fg fact that a reader will be distr</p>
                                    <p class="mail"><span>Email :</span><a href="mailto:abc@gmail.com">abc@gmail.com</a></p>
                                    <p class="phone"><span>Phone No. :</span><a href="tel:+91 4567890923">+91 4567890923</a></p>
                                    <p><b>Working hours</b>Monday – Saturday:08AM – 22PM</p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <span class="flag-icon">
                                <img src="assets/images/usa.png" alt="" >
                            </span>
                            <span class="location">Usa</span>
                            <div class="location-address">
                                <div class="location_inner">
                                    <p class="add"><span>Address :</span>It is a long edad fg fact that a reader will be distr</p>
                                    <p class="mail"><span>Email :</span><a href="mailto:abc@gmail.com">abc@gmail.com</a></p>
                                    <p class="phone"><span>Phone No. :</span><a href="tel:+91 4567890923">+91 4567890923</a></p>
                                    <p><b>Working hours</b>Monday – Saturday:08AM – 22PM</p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</section>
<section class="map-section pt-0 mb-5">
    <div class="container">
        <div class="row">
            <div class="google-map">
                <iframe width="100%" height="400" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?width=100%25&amp;height=600&amp;hl=en&amp;q=new%20york+(My%20Business%20Name)&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe>
            </div>
        </div>
    </div>
</section>
@endsection
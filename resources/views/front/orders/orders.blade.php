@extends('front.layout_2')
@section('title', $title)
@section('css')
<style type="text/css">
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
                            <li class="tab-item"><a href="/customer/my-addresses" class="tab-link">Addresses</a></li>
                            <li class="tab-item"><a href="javascript::void(0);" class="tab-link">Orders</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col col-12 col-sm-12 col-md-8 col-lg-9">
                    <div class="order-info text-center">
                        <div class="order-details">
                            <img src="/assets/images/dilevery-boy.png" alt="dilevery-boy.png" class="img-fluid mb-5">
                            <p>You haven't placed any order yet!<br><br>Order section is empty. After placing order, You can track them from here!</p>
                            <div class="edit-btn d-flex mt-5">
                                <a href="/" class="btn btn-primary m-auto">Start Shopping</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('js')
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
$("#exampleModal").on('hidden.bs.modal', function(){
    $('div.errTxt').html('');
});
</script>
@endsection
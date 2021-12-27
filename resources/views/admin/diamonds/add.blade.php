@extends('admin.header')
@section('content')
<style>
    #ajaxForm{
        width:200px;
        height:100%;
        position: relative;
    }
    #append_loader_rapa{
        position: absolute;
        top:50%;
        right:0px;
        width:100%;
        height:100%;
        background-image:url('ajax-loader.gif');
        background-size: 50px;
        background-repeat:no-repeat;
        background-position:center;
        z-index:10000000;
        opacity: 0.4;
        filter: alpha(opacity=40);
    }
    .red-error {
        color: red;
    }
</style>

<div class="nk-content">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <h3 class="nk-block-title page-title" style="display: inline;">Add Diamonds</h3>
                        <a style="float: right;" href="/admin/diamonds/list/{{session('add_category')}}" class="btn btn-icon btn-primary">&nbsp;&nbsp;Back To List<em class="icon ni ni-plus"></em></a>
                    </div><!-- .nk-block-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block nk-block-lg">
                    <div class="card">
                        <div class="card-inner row gs">
                            <div class="col-md-6">
                                <form method="POST" action="{{route('diamonds.save')}}" enctype="multipart/form-data" id="add_diamond_form">
                                    @csrf
                                    <div class="row g-3 align-center">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-label float-right" for="refCategory_id">Category:</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <select class="form-select form-control" id="refCategory_id" name="refCategory_id" tabindex="-1" aria-hidden="true" data-search="on">
                                                        <option value="0" selected="">------ Select Category ------</option>
                                                        <?php
                                                        if (!empty($data['category'])) {
                                                            foreach ($data['category'] as $row) {
                                                        ?>
                                                                <option value="<?php echo $row->category_id; ?>" <?php echo set_selected($row->category_id, session('add_category')); ?>><?php echo $row->name; ?></option>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 align-center d-none" id="barcode">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-label float-md-right" for="barcode">Barcode:</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" name="barcode" placeholder="Enter barcode" autocomplete="off">
                                                </div>
                                                <div class="errTxt"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 align-center d-none" id="makable_cts">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-label float-md-right" for="makable_cts" id="makable_cts_label">Makable CTS:</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <input type="number" step="0.01" class="form-control" name="makable_cts" id="makable_cts_input" placeholder="Enter makable CTS" autocomplete="off">
                                                </div>
                                                <div class="errTxt"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 align-center d-none" id="expected_polish_cts">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-label float-md-right" for="expected_polish_cts" id="expected_polish_cts_label">Expected Polish CTS:</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <input type="number" step="0.01" class="form-control" name="expected_polish_cts" id="expected_polish_cts_input" placeholder="Enter expected polish CTS" autocomplete="off">
                                                </div>
                                                <div class="errTxt"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <input type="hidden" class="form-control" name="weight_loss" id="weight_loss_input" placeholder="Enter weight loss" autocomplete="off" readonly="">
                                    <?php
                                    $ag_i = 0;
                                    foreach ($data['attribute_groups'] as $row) {
                                        $ag_i = $ag_i + 1;
                                        if ($row->is_fix === 1) {
                                    ?>
                                            <?php
                                            if ($row->field_type === 1) {
                                            ?>
                                                <div class="row g-3 align-center attr_grp_<?php echo $row->refCategory_id; ?> d-none attr_group">
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label class="form-label float-right" for="attribute_group_id_value"><?php echo $row->name; ?>:</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <div class="form-control-wrap">
                                                                <select class="form-select form-control" name="attribute_group_id_value[]" tabindex="-1" aria-hidden="true" data-search="on" id='<?php echo $row->name . '_' . $row->category_type; ?>'>
                                                                    <option value="default" selected="">------ Select ------</option>
                                                                    <?php
                                                                    foreach ($data['attributes'] as $atr_row) {

                                                                        if ($row->attribute_group_id == $atr_row->attribute_group_id) {
                                                                    ?>
                                                                            <option value="<?php echo $atr_row->attribute_id . '_' . $row->attribute_group_id; ?>"><?php echo $atr_row->name; ?></option>
                                                                    <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                                <input type="hidden" name="attribute_group_id[]" value="<?php echo $row->attribute_group_id; ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php
                                            }
                                            if ($row->field_type === 0) {
                                            ?>
                                                <div class="row g-3 align-center attr_grp_<?php echo $row->refCategory_id; ?> d-none attr_group">
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label class="form-label float-md-right" for="attribute_group_id_value"><?php echo $row->name; ?>:</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" name="attribute_group_id_value[]" placeholder="Enter value" autocomplete="off">
                                                                <input type="hidden" name="attribute_group_id[]" value="<?php echo $row->attribute_group_id; ?>">
                                                            </div>
                                                            <div class="errTxt"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                    <?php
                                            }
                                        }
                                    }
                                    ?>

                                    <input type="hidden" class="form-control" name="actual_pcs" placeholder="Enter actual pcs" autocomplete="off">
                                    <input type="hidden" class="form-control" name="available_pcs" placeholder="Enter available pcs" autocomplete="off">
                                    <div class="row g-3 align-center d-none" id="available_pcs">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-label float-md-right" for="available_pcs">Available pcs:</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <input type="number" step="0.01" class="form-control" name="available_pcs" placeholder="Enter available pcs" autocomplete="off">
                                                </div>
                                                <div class="errTxt"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row g-3 align-center d-none" id="packate_no">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-label float-md-right" for="packate_no">Packate No:</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" name="packate_no" placeholder="Enter packate no" autocomplete="off">
                                                </div>
                                                <div class="errTxt"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 align-center d-none" id="remarks">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-label float-md-right" for="remarks">Remarks:</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" name="remarks" placeholder="Enter remarks" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 align-center d-none" id="discount">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-label float-md-right" for="discount">Discount:</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <div class="form-icon form-icon-right">
                                                        <em class="icon ni ni-percent"></em>
                                                    </div>
                                                    <input type="number" step="0.01" class="form-control" name="discount" id="discount_input" min="0" max="100" minlength="0" maxlength="3" placeholder="Enter discount" autocomplete="off">
                                                </div>
                                                <div class="errTxt"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" class="form-control" name="rapaport_price" id="rapaport_price_input" placeholder="Enter rapaport price" autocomplete="off">

                                    <div class="row g-3 align-center" id="image">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-label float-md-right" for="image">Image:</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    {{-- <div class="custom-file">
                                                        <input type="file" name="image[]" class="custom-file-input" multiple="">
                                                        <label class="custom-file-label" for="image">Choose file</label>
                                                    </div> --}}
                                                    <textarea class="form-control" name="image"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 align-center" id="video_link">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-label float-md-right" for="video_link">Video link:</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <input type="url" class="form-control" name="video_link" placeholder="Enter video link" autocomplete="off">
                                                </div>
                                                <div class="errTxt"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row g-3 align-center">
                                        <div class="col-md-6 offset-4">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" data-msg="Required" class="custom-control-input" name="is_recommended" id="is_recommended" value="1">
                                                <label class="custom-control-label" for="is_recommended">Is Recommended</label>
                                            </div>
                                        </div>
                                    </div>


                                    <hr>
                                    <?php
                                    foreach ($data['attribute_groups'] as $row) {
                                        if ($row->is_fix === 0) {
                                    ?>
                                            <?php
                                            if ($row->field_type === 1) {
                                            ?>

                                                <div class="row g-3 align-center attr_grp_<?php echo $row->refCategory_id; ?> d-none attr_group">

                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label class="form-label float-right" for="attribute_group_id_value"><?php echo $row->name; ?>:</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <div class="form-control-wrap">
                                                                <select class="form-select form-control" name="attribute_group_id_value[]" tabindex="-1" aria-hidden="true" data-search="on">
                                                                    <option value="default" selected="">------ Select ------</option>
                                                                    <?php
                                                                    foreach ($data['attributes'] as $atr_row) {

                                                                        if ($row->attribute_group_id == $atr_row->attribute_group_id) {
                                                                    ?>
                                                                            <option value="<?php echo $atr_row->attribute_id . '_' . $row->attribute_group_id; ?>"><?php echo $atr_row->name; ?></option>
                                                                    <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                                <input type="hidden" name="attribute_group_id[]" value="<?php echo $row->attribute_group_id; ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php
                                            }
                                            if ($row->field_type === 0) {
                                                $is_required = '';
                                                if ($row->is_required) {
                                                    $is_required = 'required';
                                                }
                                            ?>

                                                <div class="row g-3 align-center attr_grp_<?php echo $row->refCategory_id; ?> d-none attr_group">

                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label class="form-label float-md-right" for="attribute_group_id_value"><?php echo $row->name; ?>:</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" name="attribute_group_id_value[]" placeholder="Enter value" autocomplete="off">
                                                                <input type="hidden" name="attribute_group_id[]" value="<?php echo $row->attribute_group_id; ?>">
                                                            </div>
                                                            <div class="errTxt"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                    <?php
                                            }
                                        }
                                    }
                                    ?>
                                    <hr>
                                    <div class="row g-3">
                                        <div class="col-sm-12 col-md-2 offset-md-4">
                                            <div class="form-group mt-2">
                                                <button type="submit" class="btn btn-lg btn-primary btn-block">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-6" id="ajaxForm">
                                <div id='append_loader_rapa'></div>
                                <div class="card bg-lighter text-dark align-items-center">
                                    <div class="card-inner">
                                        <div class="align-items-center">
                                            <div class="card-title">
                                                <h3 class="title text-center card-title-lg">Current Price</h3>
                                            </div>
                                        </div>
                                        <input type="hidden" id="labour_charge_4p" value="<?php echo $data['labour_charge_4p']; ?>">
                                        <input type="hidden" id="labour_charge_rough" value="<?php echo $data['labour_charge_rough']; ?>">
                                        <div class="traffic-channel text-dark">
                                            <div class="traffic-channel-group g-2">
                                                <div class="traffic-channel-data">
                                                    <div class="title text-dark"><span class="dot dot-lg sq" data-bg="#1f327f"></span><span>Rapaport Price/CT</span></div>
                                                    <div class="amount" id="display_rapa"></div>
                                                </div>

                                                <div class="traffic-channel-data price_div">
                                                    <div class="title text-dark"><span class="dot dot-lg sq" data-bg="#1f327f"></span><span>Price/CT</span></div>
                                                    <div class="amount" id="display_price"></div>
                                                </div>
                                                <div class="traffic-channel-data makable_cts_div">
                                                    <div class="title text-dark"><span class="dot dot-lg sq" data-bg="#1f327f"></span><span id="display_makable_cts_text">Makable CTS</span></div>
                                                    <div class="amount" id="display_makable_cts"></div>
                                                </div>
                                                <div class="traffic-channel-data">
                                                    <div class="title text-dark"><span class="dot dot-lg sq" data-bg="#1f327f"></span><span id="display_exp_pol_cts_text">Expected Polish CTS</span></div>
                                                    <div class="amount" id="display_exp_pol_cts"></div>
                                                </div>

                                                <div class="traffic-channel-data">
                                                    <div class="title text-dark"><span class="dot dot-lg sq" data-bg="#1f327f"></span><span>Discount</span></div>
                                                    <div class="amount" id="display_discount"></div>
                                                </div>
                                                <div class="traffic-channel-data labour_charges_div">
                                                    <div class="title text-dark"><span class="dot dot-lg sq" data-bg="#1f327f"></span><span>Labour Charges/CT</span></div>
                                                    <div class="amount" id="display_labour_charges"></div>
                                                </div>
                                                <div class="traffic-channel-data wieght_loss_div">
                                                    <div class="title text-dark"><span class="dot dot-lg sq" data-bg="#1f327f"></span><span>Weight loss</span></div>
                                                    <div class="amount" id="display_wieght_loss"></div>
                                                </div>
                                                @if (session('add_category') == 1)
                                                <div class="traffic-channel-data total_labour_div">
                                                    <div class="title text-dark"><span class="dot dot-lg sq" data-bg="#1f327f"></span><span>Total Labour Charges</span></div>
                                                    <div class="amount" id="display_total_labour"></div>
                                                </div>
                                                @endif
                                                <div class="traffic-channel-data" style="width:100%">
                                                    <hr>
                                                    <div class="title text-dark text-center align-center"><span class="dot dot-lg sq" data-bg="#1f327f"></span><span>
                                                            <h6>Current Price in USD($)</h6>
                                                        </span></div>
                                                    <div class="amount text-center align-center" style="font-size:25px;font-weight: 800;" id="display_current_price"></div>
                                                </div>
                                                @if (session('add_category') == 2)
                                                <div class="traffic-channel-data alert-danger mt-2" style="width:100%">
                                                    <b>NOTE: HERE Price/CT = Rapaport Price/CT - Discount %</b>
                                                </div>
                                                @endif
                                            </div><!-- .traffic-channel-group -->
                                        </div><!-- .traffic-channel -->
                                    </div>
                                </div><!-- .card -->
                            </div><!-- .col -->
                        </div>
                    </div><!-- card -->
                </div><!-- .nk-block -->
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/additional-methods.min.js"></script>
<script>
    $.validator.addMethod("alphanumeric", function(value, element) {
        return this.optional(element) || /^[a-zA-Z0-9]+$/i.test(value);
    }, "Enter valid alphanumeric value");

    $("#add_diamond_form").validate({
        errorClass: 'red-error',
        errorElement: 'div',
        rules: {
            barcode: {required: true, alphanumeric: true},
            expected_polish_cts: {required: true, number: true},
            video_link: {url: true},
            discount: { number: true, max: 100, min: 0.01},
            // 'attribute_group_id_value[]': {alphanumeric: true}
        },
        messages: {
            barcode: {required: "Barcode is required"}
        },
        errorPlacement: function(error, element) {
            error.appendTo(element.parent().nextAll("div.errTxt"));
        },
        submitHandler: function(form) {
            // do other things for a valid form
            form.submit();
        }
    });
</script>
@endsection
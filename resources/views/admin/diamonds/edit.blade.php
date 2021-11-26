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
</style>


<div class="nk-content">
    <!--    @if(Session::has('designation_add'))
        <div class="alert alert-fill alert-success alert-dismissible alert-icon" role="alert">
            <em class="icon ni ni-alert-circle"></em>
            <strong>{{Session::get('designation_add')}}</strong>
        </div>
        @endif-->
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                                <h3 class="nk-block-title page-title" style="display: inline;">Edit Diamonds</h3>
                        <a style="float: right;" href="/admin/diamonds/list/{{$data['result']->refCategory_id}}" class="btn btn-icon btn-primary">&nbsp;&nbsp;Back To List<em class="icon ni ni-plus"></em></a>
                    </div><!-- .nk-block-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block nk-block-lg">
                    <div class="card">
                        <div class="card-inner row gs">
                            <div class="col-md-6">
                                <form method="POST" action="{{route('diamonds.update')}}" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id" value="<?php echo $data['result']->diamond_id; ?>">
                                    <div class="row g-3 align-center">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-label float-right" for="refCategory_id">Category:</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <select class="form-select form-control" id="refCategory_id" name="refCategory_id" required="" tabindex="-1" aria-hidden="true" data-search="on">
                                                        <option value="" disabled="" selected="">------ Select Category ------</option>
                                                        <?php
                                                        if (!empty($data['category'])) {
                                                            foreach ($data['category'] as $row) {
                                                                ?>
                                                                <option value="<?php echo $row->category_id; ?>" <?php if(set_selected($row->category_id, $data['result']->refCategory_id)==' selected="selected" '){echo ' selected="selected" ';}else{echo ' disabled="" ';} ?>><?php echo $row->name; ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" class="form-control" name="name" placeholder="Enter name"  autocomplete="off" value="<?php echo $data['result']->name; ?>" readonly="">
                                    <!-- <div class="row g-3 align-center">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-label float-md-right" for="name">Name:</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <input type="hidden" class="form-control" name="name" placeholder="Enter name"  autocomplete="off" value="<?php //echo $data['result']->name; ?>" readonly="">
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->
                                    <div class="row g-3 align-center d-none" id="barcode">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-label float-md-right" for="barcode">Barcode:</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" name="barcode"  placeholder="Enter barcode"  autocomplete="off" value="<?php echo $data['result']->barcode; ?>">
                                                </div>
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
                                                    <input type="number" class="form-control" name="makable_cts" id="makable_cts_input" placeholder="Enter Makable CTS"  autocomplete="off" value="<?php echo $data['result']->makable_cts; ?>">
                                                </div>
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
                                                    <input type="number" class="form-control" name="expected_polish_cts" id="expected_polish_cts_input" placeholder="Enter Expected Polish CTS"  autocomplete="off" value="<?php echo $data['result']->expected_polish_cts; ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 align-center d-none" id="weight_loss">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-label float-md-right" for="weight_loss">Weight loss:</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <input type="number" class="form-control" name="weight_loss" id="weight_loss_input"  placeholder="Enter weight loss"  autocomplete="off" value="<?php echo round($data['result']->weight_loss,2); ?>" readonly="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    foreach ($data['attribute_groups'] as $row) {
                                        if ($row->is_fix == 1) {
                                            ?>
                                            <?php
                                            if ($row->field_type == 1) {
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
                                                                <select class="form-select form-control" name="attribute_group_id_value[]" tabindex="-1" aria-hidden="true" data-search="on" id='<?php echo $row->name.'_'.$row->category_type; ?>'>
                                                                    <option value="default">------ Select ------</option>
                                                                    <?php
                                                                    foreach ($data['attributes'] as $atr_row) {
                                                                        if ($row->attribute_group_id == $atr_row->attribute_group_id) {
                                                                            $chek = '';
                                                                            foreach ($data['diamond_attributes'] as $d_a_row) {
                                                                                if ($d_a_row->refDiamond_id == $data['result']->diamond_id && $d_a_row->refAttribute_group_id == $row->attribute_group_id) {
                                                                                    $chek = set_selected($atr_row->attribute_id, $d_a_row->refAttribute_id);
                                                                                }
                                                                            }
                                                                            ?>
                                                                            <option value="<?php echo $atr_row->attribute_id . '_' . $row->attribute_group_id; ?>" <?php echo $chek; ?>><?php echo $atr_row->name; ?></option>
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
                                            if ($row->field_type == 0) {
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
                                                                <?php
                                                                foreach ($data['diamond_attributes'] as $d_a_row) {
                                                                    if ($d_a_row->refAttribute_group_id == $row->attribute_group_id) {
                                                                        ?>
                                                                        <input type="text" class="form-control" name="attribute_group_id_value[]" value="<?php echo $d_a_row->value; ?>" placeholder="Enter value" autocomplete="off">
                                                                        <input type="hidden" name="attribute_group_id[]" value="<?php echo $row->attribute_group_id; ?>">
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        }
                                    }
                                    ?>
                                    
                                 
                                    
                                    
                                     <input type="hidden" class="form-control" name="actual_pcs"  placeholder="Enter actual pcs" autocomplete="off" value="<?php echo $data['result']->actual_pcs; ?>">
                                    
<!--                                    <div class="row g-3 align-center d-none" id="actual_pcs">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-label float-md-right" for="actual_pcs">Actual pcs:</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" name="actual_pcs"  placeholder="Enter actual pcs" autocomplete="off" value="<?php echo $data['result']->actual_pcs; ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>-->
<input type="hidden" class="form-control" name="available_pcs" placeholder="Enter available pcs" autocomplete="off" value="<?php echo $data['result']->available_pcs; ?>">
<!--                                    <div class="row g-3 align-center d-none" id="available_pcs">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-label float-md-right" for="available_pcs">Available pcs:</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" name="available_pcs" placeholder="Enter available pcs" autocomplete="off" value="<?php echo $data['result']->available_pcs; ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>-->
                                   

                                    <div class="row g-3 align-center d-none" id="packate_no">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-label float-md-right" for="packate_no">Packate No:</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" name="packate_no"  placeholder="Enter packate no"  autocomplete="off" value="<?php echo $data['result']->packate_no; ?>">
                                                </div>
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
                                                    <input type="text" class="form-control" name="remarks"  placeholder="Enter remarks" autocomplete="off" value="<?php echo $data['result']->remarks; ?>">
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
                                                    <input type="number" class="form-control" name="discount" min="0" max="100" minlength="0" maxlength="3" id="discount_input"  placeholder="Enter discount"  autocomplete="off" value="<?php echo abs(($data['result']->discount) * 100); ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                     <input type="hidden" class="form-control" name="rapaport_price" id="rapaport_price_input"  placeholder="Enter rapaport price"  autocomplete="off" value="<?php echo $data['result']->rapaport_price; ?>">
                                    
<!--                                    <div class="row g-3 align-center d-none" id="rapaport_price">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-label float-md-right" for="rapaport_price">Rapaport price:</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <input type="hidden" class="form-control" name="rapaport_price" id="rapaport_price_input"  placeholder="Enter rapaport price"  autocomplete="off" value="<?php echo $data['result']->rapaport_price; ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>-->

                                    
                                    <div class="row g-3 align-center" id="image">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-label float-md-right" for="image">Image:</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <div class="custom-file">
                                                        <input type="file" name="image[]" class="custom-file-input" multiple="">
                                                        <label class="custom-file-label" for="image">Choose file</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
<!--                                    <div class="row g-3 align-center d-none " id="video_link">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-label float-md-right" for="video_link">Video link:</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" name="video_link" placeholder="Enter video link"  autocomplete="off" value="<?php echo $data['result']->video_link; ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>-->
                                    <div class="row g-3 align-center">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                &nbsp;
                                            </div>
                                        </div>
                                        <?php
                                        if (!empty($data['result']->image)) {
                                            $image = json_decode($data['result']->image);
                                            if (!empty($image)) {
                                                $i = 0;
                                                foreach ($image as $img_row) {
                                                    ?>
                                                    <div class="col-lg-2" id="img_<?php echo $data['result']->diamond_id . '_' . $i; ?>">
                                                        <div class="form-group">
                                                            <div class="form-control-wrap">
                                                                <div class="removeimg">
                                                                    <img src="{{ '/storage/other_images/' . $img_row }}" style="height: 150px;width:150px;"/>
                                                                    <span class="btn btn-xs btn-danger delete_img_button" data-id="<?php echo $data['result']->diamond_id; ?>" data-inc="<?php echo $i; ?>" data-image="<?php echo $img_row; ?>" data-table="diamonds" data-wherefield="diamond_id"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    $i = $i + 1;
                                                }
                                            }
                                        }
                                        ?>
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
                                                    <input type="text" class="form-control" name="video_link" placeholder="Enter video link"  autocomplete="off" value="<?php echo $data['result']->video_link; ?>">                                             
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 align-center">
                                    <div class="col-md-6 offset-4">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" data-msg="Required" class="custom-control-input" name="is_recommended" id="is_recommended" value="1" {{ set_cheked(1, $data['result']->is_recommended) }}>
                                            <label class="custom-control-label" for="is_recommended">Is Recommended</label>
                                        </div>
                                    </div>
                                    </div>
                                    <hr>
                                    <?php
                                    foreach ($data['attribute_groups'] as $row) {
                                        if ($row->is_fix == 0) {
                                            ?>
                                            <?php
                                            if ($row->field_type == 1) {
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
                                                                    <option value="default">------ Select ------</option>
                                                                    <?php
                                                                    foreach ($data['attributes'] as $atr_row) {
                                                                        if ($row->attribute_group_id == $atr_row->attribute_group_id) {
                                                                            $chek = '';
                                                                            foreach ($data['diamond_attributes'] as $d_a_row) {
                                                                                if ($d_a_row->refDiamond_id == $data['result']->diamond_id && $d_a_row->refAttribute_group_id == $row->attribute_group_id) {
                                                                                    $chek = set_selected($atr_row->attribute_id, $d_a_row->refAttribute_id);
                                                                                }
                                                                            }
                                                                            ?>
                                                                            <option value="<?php echo $atr_row->attribute_id . '_' . $row->attribute_group_id; ?>" <?php echo $chek; ?>><?php echo $atr_row->name; ?></option>
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
                                            if ($row->field_type == 0) {
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
                                                                <?php
                                                                foreach ($data['diamond_attributes'] as $d_a_row) {
                                                                    if ($d_a_row->refAttribute_group_id == $row->attribute_group_id) {
                                                                        ?>
                                                                        <input type="text" class="form-control" name="attribute_group_id_value[]" value="<?php echo $d_a_row->value; ?>" placeholder="Enter value" autocomplete="off">
                                                                        <input type="hidden" name="attribute_group_id[]" value="<?php echo $row->attribute_group_id; ?>">
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </div>
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
                                        <div class="col-sm-12 col-md-2 offset-md-2">
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
                                                    <div class="amount" id="display_rapa">$<?php echo number_format($data['result']->rapaport_price); ?></div>
                                                </div>
                                                <div class="traffic-channel-data price_div">
                                                    <div class="title text-dark"><span class="dot dot-lg sq" data-bg="#1f327f"></span><span>Price/CT</span></div>                                                    
                                                    @php
                                                    if($data['result']->refCategory_id==1){
                                                        @endphp
                                                        <div class="amount" id="display_price">$<?php echo round(abs($data['result']->total/$data['result']->makable_cts)); ?></div>
                                                        @php    
                                                    }else{
                                                        @endphp
                                                        <div class="amount" id="display_price">$<?php echo round(abs((100-(($data['result']->discount) * 100))/100)*$data['result']->rapaport_price,2); ?></div>
                                                        @php  
                                                    }
                                                    @endphp
                                                    
                                                    
                                                </div>
                                                <div class="traffic-channel-data makable_cts_div">
                                                    <div class="title text-dark"><span class="dot dot-lg sq" data-bg="#1f327f"></span><span id="display_makable_cts_text">Makable CTS</span></div>
                                                    <div class="amount" id="display_makable_cts"><?php echo $data['result']->makable_cts; ?></div>
                                                </div>
                                                  <div class="traffic-channel-data">
                                                    <div class="title text-dark"><span class="dot dot-lg sq" data-bg="#1f327f"></span><span id="display_exp_pol_cts_text">Expected Polish CTS</span></div>
                                                    <div class="amount" id="display_exp_pol_cts"><?php echo $data['result']->expected_polish_cts; ?></div>
                                                </div>
                                                                                                
                                                <div class="traffic-channel-data">
                                                    <div class="title text-dark"><span class="dot dot-lg sq" data-bg="#1f327f"></span><span>Discount</span></div>
                                                    <div class="amount" id="display_discount"><?php echo abs(($data['result']->discount) * 100); ?>%</div>
                                                </div>                                                                                                                                             
                                                <div class="traffic-channel-data labour_charges_div">
                                                    <div class="title text-dark"><span class="dot dot-lg sq" data-bg="#1f327f"></span><span>Labour Charges/CT</span></div>
                                                    <div class="amount" id="display_labour_charges"></div>
                                                </div>                                                
                                                <div class="traffic-channel-data wieght_loss_div">
                                                    <div class="title text-dark"><span class="dot dot-lg sq" data-bg="#1f327f"></span><span>Wieght loss</span></div>
                                                    <div class="amount" id="display_wieght_loss"><?php echo round($data['result']->weight_loss,2); ?>%</div>
                                                </div>
                                                <div class="traffic-channel-data" style="width:100%">
                                                    <hr>
                                                    <div class="title text-dark text-center align-center"><span class="dot dot-lg sq" data-bg="#1f327f"></span><span><h6>Current Price in USD($)</h6></span></div>
                                                    <div class="amount text-center align-center" style="font-size:25px;font-weight: 800;" id="display_current_price">$<?php echo number_format($data['result']->total); ?></div>
                                                </div>
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
@extends('admin.header')

@section('content')
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
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">Edit Diamonds</h3>
                        </div>
                    </div><!-- .nk-block-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block nk-block-lg">                   
                    <div class="card">
                        <div class="card-inner">                           
                            <form method="POST" action="{{route('diamonds.update')}}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="<?php echo $data['result']->diamond_id; ?>">
                                <div class="row g-3 align-center">
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label class="form-label float-right" for="refCategory_id">Category:</label>                                            
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <div class="form-control-wrap">                                                                                                  
                                                <select class="form-select form-control" id="refCategory_id" name="refCategory_id" required="" tabindex="-1" aria-hidden="true" data-search="on">                                                    
                                                    <option value="" disabled="" selected="">------ Select Category ------</option> 
                                                    <?php
                                                    if (!empty($data['category'])) {
                                                        foreach ($data['category'] as $row) {
                                                            ?>
                                                            <option value="<?php echo $row->category_id; ?>" <?php echo set_selected($row->category_id, $data['result']->refCategory_id); ?>><?php echo $row->name; ?></option>
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
                                    <div class="col-lg-2">
                                        <div class="form-group">                                            
                                            <label class="form-label float-md-right" for="name">Name:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" name="name" placeholder="Enter name" required="" autocomplete="off" value="<?php echo $data['result']->name; ?>">                                             
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center d-none" id="barcode">
                                    <div class="col-lg-2">
                                        <div class="form-group">                                            
                                            <label class="form-label float-md-right" for="barcode">Barcode:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" name="barcode"  placeholder="Enter barcode" required="" autocomplete="off" value="<?php echo $data['result']->barcode; ?>">                                             
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center d-none" id="packate_no">
                                    <div class="col-lg-2">
                                        <div class="form-group">                                            
                                            <label class="form-label float-md-right" for="packate_no">Packate No:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" name="packate_no"  placeholder="Enter packate no" required="" autocomplete="off" value="<?php echo $data['result']->packate_no; ?>">                                             
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                 <?php
                                foreach ($data['attribute_groups'] as $row) { 
                                    if($row->is_fix==1){    
                                    $drop_down_value=0;
                                    ?>                                                                   
                                    <?php
                                    if ($row->field_type == 1) {
                                        $is_required = '';
                                        if ($row->is_required) {
                                            $is_required = 'required';
                                        }
                                        ?>
                                        <div class="row g-3 align-center attr_grp_<?php echo $row->refCategory_id; ?> d-none attr_group">                                       
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <label class="form-label float-right" for="attribute_group_id_value"><?php echo $row->name; ?>:</label>                                            
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">                                                                                                  
                                                        <select class="form-select form-control" name="attribute_group_id_value[]" <?php echo $is_required; ?> tabindex="-1" aria-hidden="true" data-search="on">                                                    
                                                            <!--<option value="" disabled="" selected="">------ Select ------</option>-->
                                                            <?php
                                                            foreach ($data['attributes'] as $atr_row) {
                                                                if ($row->attribute_group_id == $atr_row->attribute_group_id) {
                                                                    foreach ($data['diamond_attributes'] as $d_a_row) {                                                                        
                                                                        if ($d_a_row->refAttribute_group_id == $row->attribute_group_id && $d_a_row->refAttribute_id != 0) {
                                                                            $drop_down_value=1;
                                                                            ?>                                                                                                                                         
                                                                            <option value="<?php echo $atr_row->attribute_id . '_' . $row->attribute_group_id; ?>" <?php echo set_selected($atr_row->attribute_id, $d_a_row->refAttribute_id); ?>><?php echo $atr_row->name; ?></option>
                                                                            <?php
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>                                            
                                        </div>
                                <?php
                                if($drop_down_value==1){
                                    ?>
                                 <input type="hidden" name="attribute_group_id[]" value="<?php echo $row->attribute_group_id; ?>">
                                <?php
                                }                                
                                        }
                                        if ($row->field_type == 0) {
                                            ?>
                                  <input type="hidden" name="attribute_group_id[]" value="<?php echo $row->attribute_group_id; ?>">
                                        <div class="row g-3 align-center attr_grp_<?php echo $row->refCategory_id; ?> d-none attr_group">
                                            <div class="col-lg-2">
                                                <div class="form-group">                                            
                                                    <label class="form-label float-md-right" for="attribute_group_id_value"><?php echo $row->name; ?>:</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <?php
                                                        foreach ($data['diamond_attributes'] as $d_a_row) {
                                                            if ($d_a_row->refAttribute_group_id == $row->attribute_group_id) {
                                                                ?>
                                                                <input type="text" class="form-control" name="attribute_group_id_value[]" value="<?php echo $d_a_row->value; ?>" placeholder="Enter value" required="" autocomplete="off">                                             
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
                                
                                
                                <div class="row g-3 align-center d-none" id="actual_pcs">
                                    <div class="col-lg-2">
                                        <div class="form-group">                                            
                                            <label class="form-label float-md-right" for="actual_pcs">Actual pcs:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" name="actual_pcs"  placeholder="Enter actual pcs" required="" autocomplete="off" value="<?php echo $data['result']->actual_pcs; ?>">                                             
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center d-none" id="available_pcs">
                                    <div class="col-lg-2">
                                        <div class="form-group">                                            
                                            <label class="form-label float-md-right" for="available_pcs">Available pcs:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" name="available_pcs" placeholder="Enter available pcs" required="" autocomplete="off" value="<?php echo $data['result']->available_pcs; ?>">                                             
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center d-none" id="makable_cts">
                                    <div class="col-lg-2">
                                        <div class="form-group">                                            
                                            <label class="form-label float-md-right" for="makable_cts">Makable cts:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" name="makable_cts" id="makable_cts_input" placeholder="Enter makable cts" required="" autocomplete="off" value="<?php echo $data['result']->makable_cts; ?>">                                             
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center d-none" id="expected_polish_cts">
                                    <div class="col-lg-2">
                                        <div class="form-group">                                            
                                            <label class="form-label float-md-right" for="expected_polish_cts">Expected polish cts:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" name="expected_polish_cts" id="expected_polish_cts_input" placeholder="Enter expected polish cts" required="" autocomplete="off" value="<?php echo $data['result']->expected_polish_cts; ?>">                                             
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center d-none" id="remarks">
                                    <div class="col-lg-2">
                                        <div class="form-group">                                            
                                            <label class="form-label float-md-right" for="remarks">Remarks:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" name="remarks"  placeholder="Enter remarks" required="" autocomplete="off" value="<?php echo $data['result']->remarks; ?>">                                             
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-3 align-center d-none" id="rapaport_price">
                                    <div class="col-lg-2">
                                        <div class="form-group">                                            
                                            <label class="form-label float-md-right" for="rapaport_price">Rapaport price:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" name="rapaport_price"  placeholder="Enter rapaport price" required="" autocomplete="off" value="<?php echo $data['result']->rapaport_price; ?>">                                             
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center d-none" id="discount">
                                    <div class="col-lg-2">
                                        <div class="form-group">                                            
                                            <label class="form-label float-md-right" for="discount">Discount:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" name="discount"  placeholder="Enter discount" required="" autocomplete="off" value="<?php echo $data['result']->discount; ?>">                                              
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center d-none" id="weight_loss">
                                    <div class="col-lg-2">
                                        <div class="form-group">                                            
                                            <label class="form-label float-md-right" for="weight_loss">Weight loss:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" name="weight_loss" id="weight_loss_input"  placeholder="Enter weight loss" required="" autocomplete="off" value="<?php echo $data['result']->weight_loss; ?>" readonly="">                                             
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center d-none " id="video_link">
                                    <div class="col-lg-2">
                                        <div class="form-group">                                            
                                            <label class="form-label float-md-right" for="video_link">Video link:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="url" class="form-control" name="video_link" placeholder="Enter video link" required="" autocomplete="off" value="<?php echo $data['result']->video_link; ?>">                                             
                                            </div>
                                        </div>
                                    </div>
                                </div>                            
                                <div class="row g-3 align-center d-none" id="image">
                                    <div class="col-lg-2">
                                        <div class="form-group">                                            
                                            <label class="form-label float-md-right" for="image">Image:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">                                           
                                            <div class="form-control-wrap">
                                                <div class="custom-file">
                                                    <input type="file" name="image" class="custom-file-input">
                                                    <label class="custom-file-label" for="image">Choose file</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>  
                                <?php if (!empty($data['result']->images)) { ?>
                                    <div class="row g-3 align-center" id="img_<?php echo $data['result']->diamond_id; ?>">
                                        <div class="col-lg-2">
                                            <div class="form-group">                                            
                                                &nbsp;
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">                                           
                                                <div class="form-control-wrap">
                                                    <div class="removeimg">
                                                        <img src="{{ asset(check_host().'images') }}<?php echo '/' . $data['result']->images; ?>"/>
                                                        <span class="btn btn-xs btn-danger delete_img_button" data-id="<?php echo $data['result']->diamond_id; ?>" data-image="<?php echo $data['result']->images; ?>" data-table="diamonds" data-wherefield="diamond_id"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                                    
                                    </div>
                                <?php } ?>

                                <hr>
                                <?php
                                foreach ($data['attribute_groups'] as $row) { 
                                    if($row->is_fix==0){    
                                    $drop_down_value=0;
                                    ?>                                                                   
                                    <?php
                                    if ($row->field_type == 1) {
                                        $is_required = '';
                                        if ($row->is_required) {
                                            $is_required = 'required';
                                        }
                                        ?>
                                        <div class="row g-3 align-center attr_grp_<?php echo $row->refCategory_id; ?> d-none attr_group">                                       
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <label class="form-label float-right" for="attribute_group_id_value"><?php echo $row->name; ?>:</label>                                            
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">                                                                                                  
                                                        <select class="form-select form-control" name="attribute_group_id_value[]" <?php echo $is_required; ?> tabindex="-1" aria-hidden="true" data-search="on">                                                    
                                                            <!--<option value="" disabled="" selected="">------ Select ------</option>-->
                                                            <?php
                                                            foreach ($data['attributes'] as $atr_row) {
                                                                if ($row->attribute_group_id == $atr_row->attribute_group_id) {
                                                                    foreach ($data['diamond_attributes'] as $d_a_row) {                                                                        
                                                                        if ($d_a_row->refAttribute_group_id == $row->attribute_group_id && $d_a_row->refAttribute_id != 0) {
                                                                            $drop_down_value=1;
                                                                            ?>                                                                                                                                         
                                                                            <option value="<?php echo $atr_row->attribute_id . '_' . $row->attribute_group_id; ?>" <?php echo set_selected($atr_row->attribute_id, $d_a_row->refAttribute_id); ?>><?php echo $atr_row->name; ?></option>
                                                                            <?php
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>                                            
                                        </div>
                                <?php
                                if($drop_down_value==1){
                                    ?>
                                 <input type="hidden" name="attribute_group_id[]" value="<?php echo $row->attribute_group_id; ?>">
                                <?php
                                }                                
                                        }
                                        if ($row->field_type == 0) {
                                            ?>
                                  <input type="hidden" name="attribute_group_id[]" value="<?php echo $row->attribute_group_id; ?>">
                                        <div class="row g-3 align-center attr_grp_<?php echo $row->refCategory_id; ?> d-none attr_group">
                                            <div class="col-lg-2">
                                                <div class="form-group">                                            
                                                    <label class="form-label float-md-right" for="attribute_group_id_value"><?php echo $row->name; ?>:</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <?php
                                                        foreach ($data['diamond_attributes'] as $d_a_row) {
                                                            if ($d_a_row->refAttribute_group_id == $row->attribute_group_id) {
                                                                ?>
                                                                <input type="text" class="form-control" name="attribute_group_id_value[]" value="<?php echo $d_a_row->value; ?>" placeholder="Enter value" required="" autocomplete="off">                                             
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
                    </div><!-- card -->
                </div><!-- .nk-block -->
            </div>
        </div>
    </div>
</div>
@endsection
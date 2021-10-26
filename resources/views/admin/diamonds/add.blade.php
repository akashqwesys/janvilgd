@extends('admin.header')
@section('content')
<div class="nk-content">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">   
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">Add Diamonds</h3>
                        </div>
                    </div><!-- .nk-block-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block nk-block-lg">                   
                    <div class="card">
                        <div class="card-inner">                           
                            <form method="POST" action="{{route('diamonds.save')}}" enctype="multipart/form-data">
                                @csrf
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
                                                            <option value="<?php echo $row->category_id; ?>"><?php echo $row->name; ?></option>
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
                                                <input type="text" class="form-control" name="name" id="name" placeholder="Enter name" required="" autocomplete="off">                                             
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
                                                <input type="text" class="form-control" name="barcode"  placeholder="Enter barcode" required="" autocomplete="off">                                             
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
                                                <input type="text" class="form-control" name="packate_no"  placeholder="Enter packate no" required="" autocomplete="off">                                             
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center d-none" id="actual_pcs">
                                    <div class="col-lg-2">
                                        <div class="form-group">                                            
                                            <label class="form-label float-md-right" for="actual_pcs">Actual pcs:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" name="actual_pcs"  placeholder="Enter actual pcs" required="" autocomplete="off">                                             
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
                                                <input type="text" class="form-control" name="available_pcs"  placeholder="Enter available pcs" required="" autocomplete="off">                                             
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
                                                <input type="text" class="form-control" name="makable_cts"  placeholder="Enter makable cts" required="" autocomplete="off">                                             
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
                                                <input type="text" class="form-control" name="expected_polish_cts"  placeholder="Enter expected polish cts" required="" autocomplete="off">                                             
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
                                                <input type="text" class="form-control" name="remarks"  placeholder="Enter remarks" required="" autocomplete="off">                                             
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
                                                <input type="text" class="form-control" name="rapaport_price"  placeholder="Enter rapaport price" required="" autocomplete="off">                                             
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
                                                <input type="text" class="form-control" name="discount"  placeholder="Enter discount" required="" autocomplete="off">                                             
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
                                                <input type="text" class="form-control" name="weight_loss"  placeholder="Enter weight loss" required="" autocomplete="off">                                             
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
                                                <input type="url" class="form-control" name="video_link"  placeholder="Enter video link" required="" autocomplete="off">                                             
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
                                                    <input type="file" name="image" class="custom-file-input" >
                                                    <label class="custom-file-label" for="image">Choose file</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                  
                                <hr>
                                <?php
                                foreach ($data['attribute_groups'] as $row) {
                                    ?>
                                <input type="hidden" name="attribute_group_id[]" value="<?php echo $row->attribute_group_id; ?>">
                                <?php
                                    if ($row->field_type == 1) {
                                        $is_required='';
                                        if($row->is_required){
                                            $is_required='required';
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
                                                            <option value="" disabled="" selected="">------ Select ------</option>
                                                            <?php
                                                            foreach ($data['attributes'] as $atr_row) {
                                                                if ($row->attribute_group_id == $atr_row->attribute_group_id) {
                                                                    ?>                                                                                                                                         
                                                                    <option value="<?php echo $atr_row->attribute_id.'_'.$row->attribute_group_id; ?>"><?php echo $atr_row->name; ?></option>
                                                                    <?php                                                                        
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    if ($row->field_type == 0) {
                                        ?>
                                        <div class="row g-3 align-center attr_grp_<?php echo $row->refCategory_id; ?> d-none attr_group">
                                            <div class="col-lg-2">
                                                <div class="form-group">                                            
                                                    <label class="form-label float-md-right" for="attribute_group_id_value"><?php echo $row->name; ?>:</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control" name="attribute_group_id_value[]" placeholder="Enter value" required="" autocomplete="off">                                             
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
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
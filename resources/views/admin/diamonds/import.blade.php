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
                            <form method="POST" action="{{route('diamonds.import')}}" enctype="multipart/form-data">
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
                                                <select class="form-select form-control" name="refCategory_id" required="" tabindex="-1" aria-hidden="true" data-search="on">                                                    
                                                    <option value="" selected="">------ Select Category ------</option> 
                                                    <?php
                                                    if (!empty($data['category'])) {
                                                        foreach ($data['category'] as $row) {
                                                            ?>
                                                            <option value="<?php echo $row->category_id; ?>" <?php echo set_selected($row->category_id,session('add_category')); ?>><?php echo $row->name; ?></option>
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
                                            <label class="form-label float-md-right" for="image">File:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">                                           
                                            <div class="form-control-wrap">
                                                <div class="custom-file">
                                                    <input type="file" name="file" class="custom-file-input" id="file" required="">
                                                    <label class="custom-file-label" for="file">Select file</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-2">
                                        <div class="form-group">                                            
                                            &nbsp;
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">                                           
                                            <div class="form-control-wrap bg-lighter">
                                                <br>
                                                <h6>&nbsp;&nbsp;&nbsp;Sample Sheet</h6>                                                
                                                &nbsp;&nbsp;&nbsp;<a href="{{ asset(check_host().'admin_assets/sample/Rough-Diamonds.xlsx') }}" download="" style="text-decoration: underline;text-decoration-color: blue;">Rough Diamond Sheet</a>
                                                <br>&nbsp;&nbsp;&nbsp;<a href="{{ asset(check_host().'admin_assets/sample/4P-Diamonds.xlsx') }}" download="" style="text-decoration: underline;text-decoration-color: blue;">4P Diamond Sheet</a>
                                                <br>&nbsp;&nbsp;&nbsp;<a href="{{ asset(check_host().'admin_assets/sample/Polish-Diamonds.xlsx') }}" download="" style="text-decoration: underline;text-decoration-color: blue;">Polish Diamond Sheet</a>
                                                <br>&nbsp;
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                                <hr>                                
                                <div class="row g-3">
                                    <div class="col-sm-12 col-md-2 offset-md-2">
                                        <div class="form-group mt-2">
                                            <button type="submit" class="btn btn-lg btn-primary btn-block">Import</button>                                          
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
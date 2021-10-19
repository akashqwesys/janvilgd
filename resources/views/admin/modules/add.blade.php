@extends('admin.header')
@section('content')
<div class="nk-content">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">   
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">Add Modules</h3>
                        </div>
                    </div><!-- .nk-block-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block nk-block-lg">                   
                    <div class="card">
                        <div class="card-inner">                           
                            <form method="POST" action="{{route('modules.save')}}">
                                @csrf
                                <div class="row g-3 align-center">
                                    <div class="col-lg-1">
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
                                    <div class="col-lg-1">
                                        <div class="form-group">                                            
                                            <label class="form-label float-md-right" for="icon">Icon:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" name="icon" id="icon" placeholder="Enter icon" required="" autocomplete="off">                                             
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-1">
                                        <div class="form-group">                                            
                                            <label class="form-label float-md-right" for="slug">Slug:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" name="slug" id="slug" placeholder="Enter slug" required="" autocomplete="off">                                             
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-1">
                                        <div class="form-group">
                                            <label class="form-label float-right" for="parent_id">Parent Module:</label>                                            
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <div class="form-control-wrap">                                                                                                  
                                                <select class="form-select form-control" id="parent_id" name="parent_id" required="" tabindex="-1" aria-hidden="true" data-search="on">                                                    
                                                    <option value="0">None</option>   
                                                     <?php if(!empty($data['module'])){
                                                        foreach ($data['module'] as $row){
                                                            ?>
                                                            <option value="<?php echo $row->module_id; ?>"><?php echo $row->name; ?></option>
                                                    <?php
                                                        }
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-1">
                                        <div class="form-group">                                            
                                            <label class="form-label float-md-right" for="sort_order">Sort order:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" name="sort_order" id="sort_order" placeholder="Enter sort value" required="" autocomplete="off">                                             
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>                                
                                <div class="row g-3">
                                    <div class="col-sm-12 col-md-2 offset-md-1">
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
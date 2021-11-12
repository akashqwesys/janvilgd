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
                             <h3 class="nk-block-title page-title" style="display: inline;">Edit Slider</h3>
                        <a style="float: right;" href="/admin/sliders" class="btn btn-icon btn-primary">&nbsp;&nbsp;Back To List<em class="icon ni ni-plus"></em></a>
                    </div><!-- .nk-block-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block nk-block-lg">
                    <div class="card">
                        <div class="card-inner">
                            <form method="POST" action="{{route('sliders.update')}}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="<?php echo $data['result']->slider_id; ?>">
                                <div class="row g-3 align-center">
                                    <div class="col-lg-1">
                                        <div class="form-group">
                                            <label class="form-label float-md-right" for="title">Title:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" name="title" id="title" placeholder="Enter title" required="" autocomplete="off" value="<?php echo $data['result']->title; ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-1">
                                        <div class="form-group">
                                            <label class="form-label float-md-right" for="image">Image:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <div class="custom-file">
                                                    <input type="file" name="image" class="custom-file-input" id="image">
                                                    <label class="custom-file-label" for="image">Choose file</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

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
                                        $i=0;
                                        foreach ($image as $img_row) {
                                            ?>
                                                <div class="col-lg-2" id="img_<?php echo $data['result']->slider_id.'_'.$i; ?>">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <div class="removeimg">
                                                                <img src="/storage/sliders/{{ $img_row }}"/>
                                                                <span class="btn btn-xs btn-danger delete_img_button" data-id="<?php echo $data['result']->slider_id; ?>" data-inc="<?php echo $i; ?>" data-image="<?php echo $img_row; ?>" data-table="sliders" data-wherefield="slider_id"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php
                                            $i=$i+1;
                                        }
                                    }
                                }
                                ?>
                                    </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-1">
                                        <div class="form-group">
                                            <label class="form-label float-md-right" for="video_link">Video link:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="url" class="form-control" name="video_link" id="video_link" placeholder="Video link" autocomplete="off" value="<?php echo $data['result']->video_link; ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-3 align-center">
                                    <div class="col-lg-1">
                                        <div class="form-group">
                                            <label class="form-label float-right" for="refCategory_id">Category:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <select class="form-select form-control" id="refCategory_id" name="refCategory_id" required="" tabindex="-1" aria-hidden="true" data-search="on">
                                                    <option value="" disabled="" selected="">------ Select Category ------</option>
                                                     <?php if(!empty($data['category'])){
                                                        foreach ($data['category'] as $row){
                                                            ?>
                                                            <option value="<?php echo $row->category_id; ?>" <?php echo set_selected($row->category_id,$data['result']->refCategory_id); ?>><?php echo $row->name; ?></option>
                                                    <?php
                                                        }
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

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
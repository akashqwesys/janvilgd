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
                         <h3 class="nk-block-title page-title" style="display: inline;">Edit Attribute</h3>
                        <a style="float: right;" href="/admin/attributes" class="btn btn-icon btn-primary">&nbsp;&nbsp;Back To List<em class="icon ni ni-plus"></em></a>
                    </div><!-- .nk-block-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block nk-block-lg">
                    <div class="card">
                        <div class="card-inner">
                            <form method="POST" action="{{route('attributes.update')}}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{ $data['result']->attribute_id }}">
                               
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
                                                     @php if(!empty($data['category'])){
                                                        foreach ($data['category'] as $row){
                                                            @endphp
                                                            <option value="{{ $row->category_id }}" {{ set_selected($row->category_id,$data['refCategory_id']) }}> {{ $row->name }}</option>
                                                    @php
                                                        }
                                                    } @endphp
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                

                                <div class="row g-3 align-center">
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label class="form-label float-right" for="attribute_group_id">Attribute groups:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <select class="form-select form-control" id="attribute_group_id" name="attribute_group_id" required="" tabindex="-1" aria-hidden="true" data-search="on">
                                                    <option value="" disabled="" selected="">------ Select Attribute groups ------</option>
                                                    @php
                                                    if (!empty($data['attribute_groups'])) {
                                                        foreach ($data['attribute_groups'] as $row) {
                                                            if ($row->image_required) {
                                                                $class = "yes_" . $row->attribute_group_id;
                                                            } else {
                                                                $class = "no_" . $row->attribute_group_id;
                                                            }
                                                            @endphp
                                                            <option value="{{ $row->attribute_group_id }}" <?php echo set_selected($row->attribute_group_id, $data['result']->attribute_group_id); ?> class="{{ $class }}"> {{ $row->name }}</option>
                                                            @php
                                                        }
                                                    }
                                                    @endphp
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
                                                <input type="text" class="form-control" name="name" id="name" placeholder="Enter name" required="" autocomplete="off" value="{{ $data['result']->name }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label class="form-label float-md-right" for="sort_order">Sort No:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" name="sort_order" id="sort_order" placeholder="Enter sort order number" required="" autocomplete="off" value="{{ $data['result']->sort_order }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                               
                                <div class="row g-3 align-center image_div {{ $data['is_image'] }}">
                                        <div class="col-lg-2">
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
                                                <div class="col-lg-2 {{ $data['is_image']}}" id="img_<?php echo $data['result']->attribute_id.'_'.$i; ?>">
                                                    <div class="form-group">                                           
                                                        <div class="form-control-wrap">
                                                            <div class="removeimg">
                                                                <img src="{{ asset(check_host().'images') }}<?php echo '/' . $img_row; ?>"/>
                                                                <span class="btn btn-xs btn-danger delete_img_button" data-id="<?php echo $data['result']->attribute_id; ?>" data-inc="<?php echo $i; ?>" data-image="<?php echo $img_row; ?>" data-table="attributes" data-wherefield="attribute_id"></span>
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
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
                                     <h3 class="nk-block-title page-title" style="display: inline;">Edit Category</h3>
                        <a style="float: right;" href="/admin/categories" class="btn btn-icon btn-primary">&nbsp;&nbsp;Back To List<em class="icon ni ni-plus"></em></a>
                    </div><!-- .nk-block-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block nk-block-lg">
                    <div class="card">
                        <div class="card-inner">
                            <form method="POST" action="{{route('categories.update')}}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{ $data['result']->category_id }}">
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
                                                <div class="col-lg-2" id="img_<?php echo $data['result']->category_id.'_'.$i; ?>">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <div class="removeimg">
                                                                <img src="/storage/other_images/{{ $img_row }}"/>
                                                                <span class="btn btn-xs btn-danger delete_img_button" data-id="<?php echo $data['result']->category_id; ?>" data-inc="<?php echo $i; ?>" data-image="<?php echo $img_row; ?>" data-table="categories" data-wherefield="category_id"></span>
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
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label class="form-label float-md-right" for="description">Description:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <textarea name="description" class="form-control form-control-sm" id="cf-default-textarea" placeholder="Enter description">{{ $data['result']->description }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label class="form-label float-md-right" for="slug">Slug:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" name='slug' id="slug" placeholder="Enter slug" autocomplete="off" value="{{ $data['result']->slug }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-3 align-center">
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label class="form-label float-md-right" for="sort_order">Sort order:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" name="sort_order" id="sort_order" placeholder="Enter sort oreder" required="" autocomplete="off" value="{{ $data['result']->sort_order }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

<!--                                <div class="row g-3 align-center">
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label class="form-label float-md-right" for="category_type">Category Type Number:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" name="category_type" id="category_type" placeholder="Enter number" required="" autocomplete="off" value="{{ $data['result']->category_type }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>-->

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
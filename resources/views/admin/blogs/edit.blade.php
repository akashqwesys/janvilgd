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
                            <h3 class="nk-block-title page-title">Edit Blog</h3>
                        </div>
                    </div><!-- .nk-block-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block nk-block-lg">                   
                    <div class="card">
                        <div class="card-inner">                           
                            <form method="POST" action="{{route('blogs.update')}}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="<?php echo $data['result']->blog_id; ?>">
                                <div class="row g-3 align-center">
                                    <div class="col-lg-2">
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
                                <?php if(!empty($data['result']->image)){ ?>
                                <div class="row g-3 align-center" id="img_<?php echo $data['result']->blog_id; ?>">
                                    <div class="col-lg-2">
                                        <div class="form-group">                                            
                                            &nbsp;
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">                                           
                                            <div class="form-control-wrap">
                                                <div class="removeimg">
                                                    <img src="{{ asset(check_host().'images') }}<?php echo '/'.$data['result']->image; ?>"/>
                                                    <span class="btn btn-xs btn-danger delete_img_button" data-id="<?php echo $data['result']->blog_id; ?>" data-image="<?php echo $data['result']->image; ?>" data-table="blogs" data-wherefield="blog_id"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>
                                <?php } ?>                                
                                <div class="row g-3 align-center">
                                    <div class="col-lg-2">
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
                                    <div class="col-lg-2">
                                        <div class="form-group">                                            
                                            <label class="form-label float-md-right" for="description">Description:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">                                            
                                            <div class="form-control-wrap">
                                                <textarea name="description" class="form-control form-control-sm" id="cf-default-textarea" placeholder="Enter description"><?php echo $data['result']->description; ?></textarea>
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
                                                <input type="text" class="form-control" name='slug' id="slug" placeholder="Enter slug" autocomplete="off" value="<?php echo $data['result']->slug; ?>">                                             
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
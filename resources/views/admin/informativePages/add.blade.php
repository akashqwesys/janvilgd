@extends('admin.header')
@section('content')
<div class="nk-content">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">   
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">Add Informative Pages</h3>
                        </div>
                    </div><!-- .nk-block-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block nk-block-lg">                   
                    <div class="card">
                        <div class="card-inner">                           
                            <form method="POST" action="{{route('informative-pages.save')}}">
                                @csrf
                                <div class="row g-3 align-center">
                                    <div class="col-lg-1">
                                        <div class="form-group">                                            
                                            <label class="form-label float-md-right" for="name">Nane:</label>
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
                                            <label class="form-label float-right" for="content">Content:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-control-wrap">
                                            <div class="card card-bordered">
                                                <div class="card-inner">
                                                    <textarea class="summernote-basic-id" name="content"></textarea>
                                                </div>
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
                                                <input type="text" class="form-control" name='slug' id="slug" placeholder="Enter slug" autocomplete="off">                                             
                                            </div>
                                        </div>
                                    </div>
                                </div>                                                                
                                <hr>                                
                                <div class="row g-3">
                                    <div class="col-sm-12 col-md-2 offset-md-1">
                                        <div class="form-group mt-2">
                                            <button class="btn btn-lg btn-primary btn-block summuer_note_button">Submit</button>       
                                            <button type="submit" class="btn btn-lg btn-primary btn-block d-none summuer_note_submit_button">Submit</button>                                          
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
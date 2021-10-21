@extends('admin.header')
@section('content')
<div class="nk-content">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">Add User Role</h3>
                        </div>
                    </div><!-- .nk-block-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block nk-block-lg">
                    <div class="card">
                        <div class="card-inner">
                            <form method="POST" action="{{route('user-role.save')}}">
                                @csrf
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

                                <hr>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label class="form-label float-md-right" for="access_permission">Access Permission:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-10">
                                        <div class="form-group">
                                            <label class="form-label float-md-right" for="access_permission">&nbsp;</label>
                                        </div>
                                    </div>
                                    <?php if(!empty($data['module'])){
                                                    $i=1;
                                                    foreach ($data['module'] as $row){
                                                    ?>

                                    <div class="col-lg-2 offset-2">
                                        <div class="form-group">

                                            <div class="form-control-wrap">
                                                <input type="checkbox" name="access_permission[]" value="{{ $row->module_id }}" > {{ $row->name }}
                                            </div>

                                        </div>
                                    </div>
                                     <?php
                                                if($i%5==0){
                                                    ?>
                                                <br>
                                                <?php
                                                }
                                                $i=$i+1;
                                                    }
                                                } ?>
                                </div>
                                <hr>
                                 <div class="row g-3 align-center">
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label class="form-label float-md-right" for="modify_permission">Modify Permission:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-10">
                                        <div class="form-group">
                                            <label class="form-label float-md-right" for="modify_permission">&nbsp;</label>
                                        </div>
                                    </div>
                                    <?php if(!empty($data['module'])){
                                                    $i=1;
                                                    foreach ($data['module'] as $row){
                                                    ?>

                                    <div class="col-lg-2 offset-2">
                                        <div class="form-group">

                                            <div class="form-control-wrap">
                                                <input type="checkbox" name="modify_permission[]" value="{{ $row->module_id }}"> {{ $row->name }}
                                            </div>

                                        </div>
                                    </div>
                                     <?php
                                                if($i%5==0){
                                                    ?>
                                                <br>
                                                <?php
                                                }
                                                $i=$i+1;
                                                    }
                                                } ?>
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
@extends('admin.header')
@section('css')
<style>
    .form-control-wrap label {
        margin-bottom: 0;
    }
    .form-control-wrap input {
        vertical-align: middle;
    }
</style>
@endsection
@section('content')
<div class="nk-content">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                            <h3 class="nk-block-title page-title" style="display: inline;">Add User Role</h3>
                        <a style="float: right;" href="/admin/user-role" class="btn btn-icon btn-primary">&nbsp;&nbsp;Back To List<em class="icon ni ni-plus"></em></a>
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
                                            <h6 class="form-label- float-md-right" for="access_permission">Access Permission:</h6>
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
                                    <div class="col-lg-3 offset-1">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="checkbox" name="access_permission[]" value="{{ $row->module_id }}" id="ap_{{ $row->module_id }}">
                                                <label for="ap_{{ $row->module_id }}">{{ $row->name . ' - ' . $row->p_name }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if($i%5==0) { ?>
                                    <br>
                                        <?php } $i=$i+1;
                                        }
                                    } ?>
                                </div>
                                <hr>
                                 <div class="row g-3 align-center">
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <h6 class="form-label- float-md-right" for="modify_permission">Modify Permission:</h6>
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

                                    <div class="col-lg-3 offset-1">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="checkbox" name="modify_permission[]" value="{{ $row->module_id }}" id="mp_{{ $row->module_id }}">
                                                <label for="mp_{{ $row->module_id }}">{{ $row->name . ' - ' . $row->p_name }}</label>
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
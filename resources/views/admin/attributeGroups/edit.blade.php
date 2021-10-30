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
                        <h3 class="nk-block-title page-title" style="display: inline;">Edit Attribute Groups</h3>
                        <a style="float: right;" href="/admin/attribute-groups" class="btn btn-icon btn-primary">&nbsp;&nbsp;Back To List<em class="icon ni ni-plus"></em></a>
                    </div><!-- .nk-block-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block nk-block-lg">
                    <div class="card">
                        <div class="card-inner">
                            <form method="POST" action="{{route('attribute-groups.update')}}">
                                @csrf
                                <input type="hidden" name="id" value="{{ $data['result']->attribute_group_id }}">
                                <div class="row g-3 align-center">
                                    <div class="col-lg-1">
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
                                    <div class="col-lg-1">
                                        <div class="form-group">
                                            <label class="form-label float-right" for="image_required">Image Required:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <select class="form-select form-control" id="image_required" name="image_required" required="" tabindex="-1" aria-hidden="true" data-search="on">
                                                    <option value="">------ Select ------</option>
                                                    <option value="1" {{ set_selected(1,$data['result']->image_required) }}>YES</option>
                                                    <option value="0" {{ set_selected(0,$data['result']->image_required) }}>No</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-1">
                                        <div class="form-group">
                                            <label class="form-label float-right" for="filed_type">Filed Type:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <select class="form-select form-control" id="filed_type" name="filed_type" required="" tabindex="-1" aria-hidden="true" data-search="on">
                                                    <option value="">------ Select Filed Type ------</option>
                                                    <option value="1" {{ set_selected(1,$data['result']->field_type) }}>SELECT</option>
                                                    <option value="0" {{ set_selected(0,$data['result']->field_type) }}>TEXT</option>
                                                </select>
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
                                                     @php if(!empty($data['category'])){
                                                        foreach ($data['category'] as $row){
                                                            @endphp
                                                            <option value="{{ $row->category_id }}" {{ set_selected($row->category_id,$data['result']->refCategory_id) }}> {{ $row->name }}</option>
                                                    @php
                                                        }
                                                    } @endphp
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-1">
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
<!--                                <div class="row g-3 align-center">
                                    <div class="col-lg-1">
                                        <div class="form-group">
                                            <label class="form-label float-right" for="is_fix">Is Fix:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <select class="form-select form-control" id="is_fix" name="is_fix" required="" tabindex="-1" aria-hidden="true" data-search="on">
                                                    <option value="">------ Select Type ------</option>
                                                    <option value="1" {{ set_selected(1,$data['result']->is_fix) }}>YES</option>
                                                    <option value="0" {{ set_selected(0,$data['result']->is_fix) }}>NO</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>-->
                                <div class="row g-3 align-center">
                                    <div class="col-md-11 offset-1">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" data-msg="Required" class="custom-control-input" name="is_required" id="is_required" value="1" {{ set_cheked(1, $data['result']->is_required) }} >
                                            <label class="custom-control-label" for="is_required">Is Required</label>
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
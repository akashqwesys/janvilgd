@extends('admin.header')

@section('content')
<div class="nk-content">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <!--<div class="nk-block-head-content">-->
                            <h3 class="nk-block-title page-title" style="display: inline;">Edit Setting</h3>
                            <a style="float: right;" href="/admin/settings" class="btn btn-icon btn-primary">&nbsp;&nbsp;Back To List<em class="icon ni ni-plus"></em></a>
                        <!--</div>-->
                    </div><!-- .nk-block-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block nk-block-lg">
                    <div class="card">
                        <div class="card-inner">
                            <form method="POST" action="{{route('settings.update')}}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{ $data['result']->setting_id }}">
                                <div class="row g-3 align-center">
                                    <div class="col-lg-1">
                                        <div class="form-group">
                                            <label class="form-label float-md-right" for="key">Key:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" name="key" id="key" placeholder="Enter key" required="" autocomplete="off" value="{{ $data['result']->key }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                 <div class="row g-3 align-center">
                                    <div class="col-lg-1">
                                        <div class="form-group">
                                            <label class="form-label float-md-right" for="value">Value:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" name="value" id="value" placeholder="Enter value" required="" autocomplete="off" value="{{ $data['result']->value }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                        <div class="col-lg-1">
                                            <div class="form-group">
                                                <label class="form-label float-md-right" for="attachment">Attachment:</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <div class="custom-file">
                                                        <input type="file" name="attachment" class="custom-file-input" id="attachment">
                                                        <label class="custom-file-label" for="attachment">Choose file</label>
                                                    </div>
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
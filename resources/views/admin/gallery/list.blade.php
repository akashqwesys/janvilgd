@extends('admin.header')
@section('css')
<link href="{{ asset(check_host().'admin_assets/datatable/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset(check_host().'admin_assets/datatable/dataTables.responsive.css')}}" rel="stylesheet" type="text/css">
<style>
    table.table td {
        vertical-align: middle;
    }
</style>
@endsection
@section('content')
<!-- content @s -->
<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="components-preview wide mx-auto">
                    <div class="nk-block nk-block-lg">
                        <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <div class="toggle-wrap nk-block-tools-toggle">
                                    <h4 style="display: inline;" class="nk-block-title">Gallery Image list</h4>
                                    <button style="float: right;" class="btn btn-icon btn-primary add-gallery" >&nbsp;&nbsp;Add Image to Gallery<em class="icon ni ni-plus"></em></button>
                                </div>
                            </div><!-- .nk-block-head-content -->
                        </div>
                        <div class="card card-preview">
                            <div class="card-inner">
                                <table id="table" class="table dt-responsive nowrap">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Image</th>
                                            <th>isActive</th>
                                            <th>isDeleted</th>
                                            <th>Date Added</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div><!-- .card-preview -->
                    </div> <!-- nk-block -->
                </div><!-- .components-preview -->
            </div>
        </div>
    </div>
</div>
<div id='append_loader'></div>
<!-- Add Address Modal -->
<div class="custom-modal add-address modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-body">
                <div class="add-address-content">
                    <h4 class="title mb-4">Add New Image to Gallery</h4>
                    <div class="add-address-form">
                        <form class="add-form row" method="POST" action="/admin/gallery/save" enctype="multipart/form-data" id="GalleryForm">
                            @csrf
                            <input type="hidden" name="id" id="gallery_id">
                            <div class="col col-12 col-md-12 mb-3">
                                <div class="form-group">
                                    <div class="upload-file-box">
                                        <div class="file-upload-box">
                                            <div class="file-select text-center m-auto">
                                                {{-- <img src="/assets/images/upload-file-icon.svg" alt="icn" class="img-fluid mb-3"> --}}
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="id_upload" name="image[]" id="id_upload" aria-describedby="inputGroupFileAddon01" accept="image/jpeg,image/png" multiple required>
                                                        <label class="custom-file-label ml-auto mr-auto" for="id_upload">Click here to upload</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="errTxt"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col col-12 col-md-12 mb-0">
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary" id="submit-gallery">Save</button>&nbsp;
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- content @e -->
@endsection
@section('script')
<script  src="{{ asset(check_host().'admin_assets/datatable/jquery.dataTables.min.js')}}" type="text/javascript"></script>
<script  src="{{ asset(check_host().'admin_assets/datatable/jquery.dataTables.min.js')}}" type="text/javascript"></script>
<script src="{{ asset(check_host().'admin_assets/datatable/dataTables.responsive.min.js')}}" type="text/javascript" ></script>
<script>
    $("#exampleModal").on('hidden.bs.modal', function(){
        $('#GalleryForm').attr('action', '/admin/gallery/save');
        $('#id_upload').attr('multiple', true).attr('name', 'image[]');
        $('div.errTxt').html('');
        $('#GalleryForm')[0].reset();
        $('#submit-gallery').text('Save');
        $('.custom-file-label').text('Click here to upload');
    });

    $(document).on('click', '.add-gallery', function () {
        $('#exampleModal').modal('show');
    });

    $(document).on('click', '.edit-gallery', function () {
        $('#GalleryForm').attr('action', '/admin/gallery/update');
        $('#id_upload').attr('multiple', false).attr('name', 'image');
        $('#gallery_id').val($(this).attr('data-id'));
        $('#submit-gallery').text('Update');
        $('#exampleModal').modal('show');
    });

    $(document).on('change', '#id_upload', function () {
        if ($(this)[0].files.length > 1) {
            $(this).next('label').text($(this)[0].files.length + ' Files Selected');
        } else {
            $(this).next('label').text($(this)[0].files[0].name);
        }
    });
</script>
@endsection
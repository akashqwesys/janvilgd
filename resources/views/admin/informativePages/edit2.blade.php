@extends('admin.header')

@section('css')
@endsection
@section('content')
<div class="nk-content">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                             <h3 class="nk-block-title page-title" style="display: inline;">Edit Informative Pages</h3>
                        <a style="float: right;" href="/admin/informative-pages" class="btn btn-icon btn-primary">&nbsp;&nbsp;Back To List<em class="icon ni ni-plus"></em></a>
                    </div><!-- .nk-block-between -->
                </div><!-- .nk-block-head -->
                <div class="nk-block nk-block-lg">
                    <div class="card">
                        <div class="card-inner">
                            <input type="hidden" name="default_content" id="default_content_hidden_input" value="{!! $data['result']->default_content !!}">
                            <form method="POST" action="{{route('informative-pages.update')}}" id="myForm">
                                @csrf
                                <input type="hidden" name="id" value="{{ $data['result']->informative_page_id }}">
                                <div class="row g-3 align-center">
                                    <div class="col-lg-1">
                                        <div class="form-group">
                                            <label class="form-label float-md-right" for="name">Page Name:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" name="name" id="name" placeholder="Enter title" required="" autocomplete="off" value="{{ $data['result']->name }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-1">
                                        <div class="form-group">
                                            <label class="form-label float-md-right" for="slug">Page Slug:</label>
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
                                <div class="mt-2 mb-2">
                                    <h5>SECTION 1</h5>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-1">
                                        <div class="form-group">
                                            <label class="form-label float-md-right" for="slug">Video File:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="file" class="form-control" name="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-1">
                                        <div class="form-group">
                                            <label class="form-label float-md-right" for="slug">Logo File:</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="file" class="form-control" name="">
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
                                    <div class="col-lg-10">
                                        <div class="form-control-wrap">
                                            <textarea id="summernote-basic-id" name="content"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row g-3">
                                    <div class="col-sm-12 col-md-2 offset-md-1">
                                        <div class="form-group mt-2">
                                            <button type="submit" id="submitForm" class="btn btn-lg btn-primary btn-block">Submit</button>
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
@section('script')
{{-- <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script> --}}
{{-- <script src="//cdnjs.cloudflare.com/ajax/libs/jodit/3.4.25/jodit.min.js"></script> --}}
<script type="text/javascript">
    /* var editor = new Jodit('#cf-default-textarea', {
        "defaultMode": "3"
    }); */
    $('#summernote-basic-id').summernote();

    /* ClassicEditor
        .create( document.querySelector( '#cf-default-textarea' ), {
            plugins: [ 'HtmlEmbed', 'Autoformat', 'Bold', 'Italic', 'BlockQuote', 'Heading', 'Image', 'ImageCaption', 'ImageStyle', 'ImageToolbar', 'ImageUpload', 'Link', 'List', 'Paragraph', 'Alignment'],
            toolbar: [ 'htmlEmbed', 'heading', '|', 'alignment', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'uploadImage', 'blockQuote', 'undo', 'redo' ],
        } )
        .catch( error => {
            console.error( error );
        } ); */

    $(document).ready(function () {
        $('#back_to_default').on('click', function () {
            $("#summernote-basic-id").summernote('code', '');
            $("#summernote-basic-id").summernote('code', $("#default_content_hidden_input").val());
            // $("#summernote-basic-id").val($("#default_content_hidden_input").val());
        });
    });

    $(document).on('click', '#submitForm', function(e) {
        e.preventDefault();
        var formData = new FormData($('#myForm')[0]);
        var myjson = {
            'id': <?php echo $data['result']->informative_page_id; ?>,
            'name': $('#name').val(),
            'content': $('#summernote-basic-id').val(),
            'slug': $('#slug').val()
        };
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            type: "post",
            enctype: 'multipart/form-data',
            url: "/admin/informative-pages/update",
            data: { 'data': JSON.stringify(myjson) },
            // processData: false,
            // contentType: false,
            cache: false,
            dataType: "json",
            success: function (response) {
                $('.cs-loader').hide();
                if (response.success == 1) {
                    setTimeout(() => {
                        window.location = response.url;
                    }, 2000);
                }
            },
            failure: function (response) {
                $.toast({
                    heading: 'Error',
                    text: 'Oops, something went wrong...!',
                    icon: 'error',
                    position: 'top-right'
                });
            }
        });
    });
</script>
@endsection
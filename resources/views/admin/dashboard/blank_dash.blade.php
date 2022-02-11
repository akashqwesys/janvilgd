@extends('admin.header')

@section('css')
<style type="text/css">
</style>
@endsection
@section('content')
<!-- content @s -->
<div class="nk-content">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block card card-bordered">
                    <div class="card-body">
                        @if (session()->has('access-denied'))
                        <div class="nk-block-content nk-error-ld text-center">
                            <h1 class="nk-error-head">Access Denied...!</h1>
                            <h3 class="nk-error-title">You does not have access to this module.</h3>
                        </div>
                        @php
                            session()->put('access-denied', null);
                        @endphp
                        @else
                        <div><h5>Welcome {{ session()->get('user_fullname') }}!</h5> </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- content @e -->
@endsection
@section('script')
<script>
</script>
@endsection

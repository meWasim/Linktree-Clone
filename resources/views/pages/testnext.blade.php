@extends('layouts.app')
@section('content')
<link href="{{ url('assets/css/dropify.min.css') }}" rel="stylesheet" type="text/css" />

    <div class="container my-5" style="position: relative;">
        <div class="row">
            {{-- Appearance Edit Section --}}
            <div class="col-12 col-md-7" style="min-width: 400px;">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">File Upload 3</h4>
                        <p class="text-muted mb-0">You can set the height</p>
                    </div><!--end card-header-->
                    <div class="card-body">
                        <input type="file" id="input-file-now-custom-2" class="dropify" data-height="500" />
                    </div><!--end card-body-->
                </div><!--end card-->
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="{{ url('assets/js/dropify.min.js') }}"></script>
    <script src="{{ url('assets/js/jquery.form-upload.init.js') }}"></script>
@endsection

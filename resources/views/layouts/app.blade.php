<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'LinkHive') }}</title>
    <!-- App favicon -->
    <link rel="shortcut icon" href="/assets/icons/link-icon.png">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="{{ url('assets/css/dropify.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/dropify-app.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('/assets/css/custom.css') }}" rel="stylesheet" type="text/css" />
    <script src="https://kit.fontawesome.com/965bd2f436.js" crossorigin="anonymous"></script>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            @yield('content')
        </main>
    </div>
    <!-- Modal - Start -->
    <div class="modal fade" id="shareModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-end">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Share your LinkHive</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <button id="generateQrCodeBtn" type="button" class="btn p-1 w-100" data-bs-toggle="modal" data-bs-target="#qrModal">
                        <div class="card mb-2 w-100">
                            <div class="d-flex align-items-center justify-content-between p-3 btn-modal">
                                <div class="d-flex align-items-center">
                                    <div class="p-2" style="background:pink; border-radius:6px;">
                                        <i class="fa fa-qrcode" aria-hidden="true"></i>
                                    </div>
                                    <p class="m-0 px-2">My LinkHive QR Code</p>
                                </div>
                                <i class="fas fa-chevron-right"></i>
                            </div>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="qrModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-end">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">QR Code</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card mb-2 w-100">
                        <!--Generating qr code are-->
                        <div class="p-2 d-flex justify-content-center">
                            <img id="qrCodeImage" src="" alt="QR Code">
                        </div>
                        <div class="p-2 d-flex justify-content-center">
                            <p id="profile_link"></p>
                        </div>
                        <a id="downloadPNG" download="qrcode.png" class="btn">
                            <div class="row no-gutters p-2 qr-btn">
                                <div class="col-12 col-sm-6 col-md-8">Download PNG</div>
                                <div class="col-6 col-md-4">.PNG  <i class="fa fa-download text-concrete text-xs ml-2" aria-hidden="true"></i></div>
                            </div>
                        </a>
                        <a id="downloadSVG" download="qrcode.svg" class="btn">
                            <div class="row no-gutters p-2 qr-btn">
                                <div class="col-12 col-sm-6 col-md-8">Download SVG</div>
                                <div class="col-6 col-md-4">.SVG  <i class="fa fa-download text-concrete text-xs ml-2" aria-hidden="true"></i></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal - End -->
    
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="{{ url('assets/js/jquery.min.js') }}"></script>
    <script src="{{ url('assets/js/bootstrap.bundle.min.js') }}"></script>   
    <script src="{{ url('assets/js/dropify.min.js') }}"></script>
    <script src="{{ url('assets/js/jquery.form-upload.init.js') }}"></script>
    <script src="{{ url('assets/js/custom.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#generateQrCodeBtn').click(function () {
                $.ajax({
                    url: '/generate-qrcode',
                    method: 'POST',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        // Update the image source with the generated QR code
                        $('#qrCodeImage').attr('src', response.pathPNG);
                        $('#profile_link').html(response.profile_url);
                        // Update the download links
                        $('#downloadPNG').attr('href', response.pathPNG);
                        $('#downloadSVG').attr('href', response.pathSVG);
                    },
                    error: function (error) {
                        // Handle errors
                        console.log(error);
                    }
                });
            });
        });
    </script>
</body>

</html>

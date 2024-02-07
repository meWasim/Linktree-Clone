<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- App favicon -->
    <link rel="shortcut icon" href="/assets/icons/link-icon.png">
    <!-- Fonts -->
    <script src="https://kit.fontawesome.com/965bd2f436.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.bunny.net">

    <link href="{{ url('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @if ($theme == 'custom')
        <style>
            body {
                background: {{ isset($customColor->backgroundColor) ? $customColor->backgroundColor : 'grey' }};
                background-attachment: fixed;
            }

            .btn {
                position: relative;
                font-family: {{ isset($customColor->font) ? $customColor->font : 'Arial' }};
                background-color: {{ isset($customColor->buttonColor) ? $customColor->buttonColor : '#000000' }};
                color: {{ isset($customColor->fontColor) ? $customColor->fontColor : '#fdfdfd' }};
            }

            .btn-color {
                position: relative;
                background-color: rgb(176, 161, 137);
                color: #fff;
                border-radius: 0.37rem;
                padding-right: 1.5rem;
            }

            .btn-color :hover {
                color: #fff !important;
                background-color: {{ isset($customColor->buttonColor) ? $customColor->buttonColor : 'lightgrey' }};
            }

            .profile-img {
                width:100px;
                height:100px;
                box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.8);
            }

            .thumbnail-image{
                width: 30px !important;
                height: 30px !important;
                border-radius: 5px;
                margin-left: 5px;
            }

            .btn-modal {
                position: relative;
                background-color: #e9dcdc;
                color: #fff;
                border-radius: 0.37rem;
                padding-right: 1.5rem;
            }

            .btn-modal :hover {
                color: #fff !important;
                background-color: #c0c0c0 !important;
            }

            .btn-modal :hover {
                color: #fff !important;
                background-color: #c0c0c0 !important;
            }

            .btn-response {
                width: 50%;
            }

            .a-response {
                font-size: 20px;
            }

            @media (max-width: 350px) {
                .btn-response {
                    width: 90%;
                }

                .a-response {
                    font-size: 13px;
                }
            }

            .preview {
                /* Your default styles here */
                position: fixed;
                top: 0;
                right: 0;
                width: 200px;
                height: 100%;
                background-color: #f0f0f0;
                padding: 20px;
                border: 1px solid #ccc;
            }

            @media (min-width: 1000px) {
                .preview {
                    position: relative;
                }
            }
        </style>
    @else
        <link href="{{ asset('css/' . $theme . '.css') }}" rel="stylesheet" type="text/css" />
    @endif
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">

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
    <script src="{{ url('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</body>

</html>

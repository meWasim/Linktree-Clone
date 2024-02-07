@extends('layouts.master')
@section('content')
    <!-- Content container -->
    <div class="container">
        <div class="text-center py-5">
            <!-- Image and name container. Change to your picture here. -->
            @if (isset($profile_image))
                <img src="{{ url('storage/' . $profile_image) }}" class="rounded-circle mx-auto profile-img" alt="Profile image">
            @else
                <img src="{{ asset('assets/images/no_user.png') }}" alt="Image" class="mb-2 rounded-circle profile-img">
            @endif
            <div class="my-4">
                <p class="text-dark fw-bold fs-4 mb-1 preview-name">{{ $title }}</p>
                <p class="text-dark fw-semibold fs-6 preview-bio">{{ $bio }}</p>
            </div>

            {{-- Links Section --}}
            <div class="d-flex flex-column align-items-center">
                @if (isset($data))
                    @foreach ($data as $key => $value)

                        @if (isset($value->visibility))

                            @if ($value->visibility == 'true')
                                <div class="mb-2 btn-response">
                                    <div class="p-0 btn-color position-relative">
                                        @if (isset($value->thumbnail))
                                            <img src="{{ url('storage/') . '/' . $value->thumbnail }}"
                                                class="position-absolute top-50 start-10 translate-middle-y thumbnail-image"
                                                style="
                                                            width: 40px;
                                                            height: 40px;
                                                            border-radius: 5px;
                                                            margin-left: 5px;
                                                        ">
                                        @endif
                                        <a href="{{ $value->url }}" class="btn btn-lg btn-rounded w-100 a-response"
                                            target="_blank">{{ $value->title }}</a>
                                        <button type="button"
                                            class="btn position-absolute top-50 end-0 translate-middle-y rounded-circle"
                                            data-bs-toggle="modal" data-bs-target="#modal_{{ $key }}">
                                            <i class="fas fa-ellipsis-h light-icon"></i>
                                        </button>
                                    </div>
                                </div>
                            @endif

                        @else                        
                            <div class="mb-2 btn-response">
                                <div class="p-0 btn-color position-relative">
                                    @if (isset($value->thumbnail))
                                        <img src="{{ url('storage') . '/' . $value->thumbnail }}"
                                            class="thumbnail-image position-absolute top-50 start-10 translate-middle-y"
                                            style="
                                                            width: 40px;
                                                            height: 40px;
                                                            border-radius: 5px;
                                                            margin-left: 5px;
                                                        ">
                                    @endif
                                    <a href="{{ $value->url }}" class="btn btn-lg btn-rounded w-100 a-response"
                                        target="_blank">{{ $value->title }}</a>
                                    <button type="button"
                                        class="btn position-absolute top-50 end-0 translate-middle-y rounded-circle"
                                        data-bs-toggle="modal" data-bs-target="#modal_{{ $key }}">
                                        <i class="fas fa-ellipsis-h light-icon"></i>
                                    </button>
                                </div>
                            </div>
                        @endif

                        {{-- Sharing Modal --}}
                        <div class="modal fade" id="modal_{{ $key }}" tabindex="-1" aria-labelledby="modalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalLabel">Share this link</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="card mb-2 w-100">
                                            <div class="d-flex p-0 card-body btn-modal">
                                                <a class="btn w-100"
                                                    href="https://www.snapchat.com/scan?attachmentUrl={{ $value->url }}"
                                                    target="_blank">
                                                    <div class="float-start">
                                                        <i class="fa-brands fa-snapchat fa-lg me-2"></i>
                                                        <p class="d-inline">Share on Snapchat</p>
                                                    </div>
                                                    <i class="fas fa-chevron-right float-end mt-1"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="card mb-2 w-100">
                                            <div class="d-flex p-0 card-body btn-modal">
                                                <a class="btn w-100"
                                                    href="https://www.facebook.com/sharer.php?{{ $value->url }}"
                                                    target="_blank">
                                                    <div class="float-start">
                                                        <i class="fa-brands fa-facebook fa-lg me-2"></i>
                                                        <p class="d-inline">Share on Facebook</p>
                                                    </div>
                                                    <i class="fas fa-chevron-right float-end mt-1"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="card mb-2 w-100">
                                            <div class="d-flex p-0 card-body btn-modal">
                                                <a class="btn w-100"
                                                    href="https://www.linkedin.com/sharing/share-offsite/?url={{ $value->url }}"
                                                    target="_blank">
                                                    <div class="float-start">
                                                        <i class="fa-brands fa-linkedin fa-lg me-2"></i>
                                                        <p class="d-inline">Share on LinkedIn</p>
                                                    </div>
                                                    <i class="fas fa-chevron-right float-end mt-1"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="card mb-2 w-100">
                                            <div class="d-flex p-0 card-body btn-modal">
                                                <a class="btn w-100"
                                                    href="https://x.com/intent/tweet?text={{ $value->title }} - {{ $value->url }}"
                                                    target="_blank">
                                                    <div class="float-start">
                                                        <i class="fa-brands fa-x-twitter fa-lg me-2"></i>
                                                        <p class="d-inline">Share on X</p>
                                                    </div>
                                                    <i class="fas fa-chevron-right float-end mt-1"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="card mb-2 w-100">
                                            <div class="d-flex p-0 card-body btn-modal">
                                                <a class="btn w-100"
                                                    href="https://wa.me/?text={{ $value->title }} - {{ $value->url }}"
                                                    target="_blank">
                                                    <div class="float-start">
                                                        <i class="fa-brands fa-whatsapp fa-lg me-2"></i>
                                                        <p class="d-inline">Share via WhatsApp</p>
                                                    </div>
                                                    <i class="fas fa-chevron-right float-end mt-1"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="card mb-2 w-100">
                                            <div class="d-flex p-0 card-body btn-modal">
                                                <a class="btn w-100" href="https://www.messenger.com/new"
                                                    target="_blank">
                                                    <div class="float-start">
                                                        <i class="fa-brands fa-facebook-messenger fa-lg me-2"></i>
                                                        <p class="d-inline">Share via Messenger</p>
                                                    </div>
                                                    <i class="fas fa-chevron-right float-end mt-1"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="card mb-2 w-100">
                                            <div class="d-flex p-0 card-body btn-modal">
                                                <a class="btn w-100"
                                                    href="mailto:?subject= {{ 'Check Out this LinkHive!' }} &body= {{ $value->title }} - {{ $value->url }}"
                                                    target="_blank">
                                                    <div class="float-start">
                                                        <i class="fa fa-envelope fa-lg me-2"></i>
                                                        <p class="d-inline">Share via Email</p>
                                                    </div>
                                                    <i class="fas fa-chevron-right float-end mt-1"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="card mb-2 mt-4 w-100">
                                            <div class="d-flex align-items-center p-0 card-body">
                                                <input class="form-control" type="text" id="link"
                                                    value="{{ url($urlSlug) }}">
                                                <button class="btn" onclick="myFunction(this)">Copy</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-dark"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-light">Find Out More</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="mb-2 w-50">
                        <div class="p-0 btn-color position-relative">
                            <a href="#" class="btn btn-lg btn-rounded w-100">
                                <p></p>
                            </a>
                        </div>
                    </div>
                    <div class="mb-2 w-50">
                        <div class="p-0 btn-color position-relative">
                            <a href="#" class="btn btn-lg btn-rounded w-100">
                                <p></p>
                            </a>
                        </div>
                    </div>
                    <div class="mb-2 w-50">
                        <div class="p-0 btn-color position-relative">
                            <a href="#" class="btn btn-lg btn-rounded w-100">
                                <p></p>
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Social Media --}}
        @if (isset($links))
            <div class="row justify-content-center mt-4">
                @if ($links->facebook != null)
                    <div class="col-auto">
                        <a href="{{ $links->facebook }}" class="btn btn-lg btn-rounded" target="_blank"><i
                                class="fa fa-facebook"></i></a>
                    </div>
                @endif
                @if ($links->instagram != null)
                    <div class="col-auto">
                        <a href="{{ $links->facebook }}" class="btn btn-lg btn-rounded" target="_blank"><i
                                class="fa fa-instagram"></i></a>
                    </div>
                @endif
                @if ($links->whatsapp != null)
                    <div class="col-auto">
                        <a href="{{ $links->whatsapp }}" class="btn btn-lg btn-rounded" target="_blank"><i
                                class="fa fa-whatsapp"></i></a>
                    </div>
                @endif
                @if ($links->x != null)
                    <div class="col-auto">
                        <a href="{{ $links->x }}" class="btn btn-lg btn-rounded" target="_blank"><i
                                class="fa-brands fa-x-twitter"></i></a>
                    </div>
                @endif
            </div>
        @endif
    </div>
    <script>
        function myFunction(button) {
            var copyText = document.getElementById("link");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            navigator.clipboard.writeText(copyText.value);

            button.textContent = 'Copied';
            setTimeout(function() {
                button.textContent = 'Copy';
            }, 2000);
        }
    </script>
@endsection

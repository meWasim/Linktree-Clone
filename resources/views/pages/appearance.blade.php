@extends('layouts.app')
@section('content')
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <div class="container my-5" style="position: relative;">
        <div class="row">
            {{-- Appearance Edit Section --}}
            <div class="col-12 col-md-7" style="min-width: 400px;">
                <div class="row">
                    <h5>Profile</h5>
                    <div class="card border-light-subtle rounded-4 py-2">
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="profile-image-wrapper" id="profileImageWrapper">
                                        @if ($user->appearance && $user->appearance->image)
                                            <img id="uploadedImage" src="{{ asset('storage/' . $user->appearance->image) }}"
                                                alt="Profile Image">
                                        @elseif($user->appearance && $user->appearance->profile_title)
                                            {{ strtoupper(substr($user->appearance->profile_title, 0, 1)) }}
                                        @else
                                            @
                                        @endif
                                    </div>
                                    <div class="ms-4 flex-grow-1">
                                        <button type="button" class="btn btn-dark rounded-pill w-100 mb-2"
                                            data-bs-toggle="modal" data-bs-target="#uploadImageModal">Upload Image</button>
                                        <button id="removeProfileImageButton" type="button"
                                            class="btn btn-outline-secondary rounded-pill w-100"
                                            @if (!$user->appearance || !$user->appearance->image) disabled @endif>Remove</button>
                                    </div>
                                    <!-- Upload Image Modal -->
                                    <div class="modal fade" id="uploadImageModal" tabindex="-1"
                                        aria-labelledby="uploadImageModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header py-2">
                                                    <h5 class="modal-title mt-0" id="uploadImageModalLabel">Upload Profile Image
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="uploadProfileImageForm" enctype="multipart/form-data">
                                                        @csrf
                                                        <input type="file" id="input-file-now-custom-3" name="image" class="form-control dropify" data-default-file="{{ $user->appearance && $user->appearance->image ? asset('storage/' . $user->appearance->image) : '' }}">
                                                        <button id="uploadProfileImageButton" type="button" class="btn btn-dark mt-3 float-end">Upload</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <div class="mb-3">
                                        <label for="basic-url" class="form-label">Your URL Slug</label>
                                        <div class="input-group">
                                            <span class="input-group-text" id="base_url">{{ config('app.url') }}</span>
                                            <input type="text" class="form-control" id="url_slug" name="url_slug"
                                                value="{{ $user->appearance ? $user->appearance->url_slug : $user->name }}"
                                                aria-describedby="basic-addon3 basic-addon4">
                                        </div>
                                        <div id="urlSlugErrorContainer" class="text-danger"></div>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" name="profile_title" id="profile_title"
                                            value="{{ $user->appearance ? $user->appearance->profile_title : '' }}">
                                        <label for="profile_title">Profile Title</label>
                                    </div>
                                    <div class="form-floating">
                                        <textarea class="form-control" name="bio" id="bio" style="height: 100px">{{ $user->appearance ? $user->appearance->bio : '' }}</textarea>
                                        <label for="bio">Bio</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <h5>Themes</h5>
                    <div class="card border-light-subtle rounded-4 py-2">
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                    <button type="button"
                                        class="btn btn-outline-dark btn-block theme-btn p-0 border border-secondary-subtle"
                                        onclick="enableAndScroll()" data-theme="custom">
                                        <h5 class="mb-0">CREATE YOUR OWN</h5>
                                    </button>
                                    <p>Custom</p>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                    <button type="button"
                                        class="btn btn-outline-dark btn-block theme-btn p-0 border-0 btn-selected"
                                        data-theme="default">
                                        <img src="{{ asset('assets/images/default.png') }}" alt="Image"
                                            class="border rounded-2">
                                    </button>
                                    <p>Default</p>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                    <button type="button" class="btn btn-outline-dark btn-block theme-btn p-0 border-0"
                                        data-theme="theme1">
                                        <img src="{{ asset('assets/images/theme1.png') }}" alt="Image"
                                            class="border rounded-2">
                                    </button>
                                    <p>Theme 1</p>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                    <button type="button" class="btn btn-outline-dark btn-block theme-btn p-0 border-0"
                                        data-theme="theme2">
                                        <img src="{{ asset('assets/images/theme2.png') }}" alt="Image"
                                            class="border rounded-2">
                                    </button>
                                    <p>Theme 2</p>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                    <button type="button" class="btn btn-outline-dark btn-block theme-btn p-0 border-0"
                                        data-theme="theme3">
                                        <img src="{{ asset('assets/images/theme3.png') }}" alt="Image"
                                            class="border rounded-2">
                                    </button>
                                    <p>Theme 3</p>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                    <button type="button" class="btn btn-outline-dark btn-block theme-btn p-0 border-0"
                                        data-theme="theme4">
                                        <img src="{{ asset('assets/images/theme4.png') }}" alt="Image"
                                            class="border rounded-2">
                                    </button>
                                    <p>Theme 4</p>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                    <button type="button" class="btn btn-outline-dark btn-block theme-btn p-0 border-0"
                                        data-theme="theme5">
                                        <img src="{{ asset('assets/images/theme5.png') }}" alt="Image"
                                            class="border rounded-2">
                                    </button>
                                    <p>Theme 5</p>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                    <button type="button" class="btn btn-outline-dark btn-block theme-btn p-0 border-0"
                                        data-theme="theme6">
                                        <img src="{{ asset('assets/images/theme6.png') }}" alt="Image"
                                            class="border rounded-2">
                                    </button>
                                    <p>Theme 6</p>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                    <button type="button" class="btn btn-outline-dark btn-block theme-btn p-0 border-0"
                                        data-theme="theme7">
                                        <img src="{{ asset('assets/images/theme7.png') }}" alt="Image"
                                            class="border rounded-2">
                                    </button>
                                    <p>Theme 7</p>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                    <button type="button" class="btn btn-outline-dark btn-block theme-btn p-0 border-0"
                                        data-theme="theme8">
                                        <img src="{{ asset('assets/images/theme8.png') }}" alt="Image"
                                            class="border rounded-2">
                                    </button>
                                    <p>Theme 8</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4" id="customThemeSectionHeading" style="display: none">
                    <h3 id="ThemesCustomHeading"
                        class="text-black text-sm font-semibold leading-heading mb-md mt-2xl !text-lg font-semibold">Custom
                        appearance</h3>
                    <p class="text-black text-md ">Completely customize your Linktree profile. Change your background with
                        colors, gradients and images. Choose a button style, change the typeface and more.</p>
                </div>
                <div class="row mt-4" id="customThemeSection" class="custom-theme-section" style="display: none">
                    <h5>Backgrounds</h5>
                    <div class="card border-light-subtle rounded-4 py-2">
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                    <button type="button" class="btn btn-outline-secondary btn-block bg-info bg-button"
                                        name="flat">
                                    </button>
                                    <p>Flat Color</p>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                    <button type="button"
                                        class="btn btn-outline-secondary btn-block bg-info gradient bg-button"
                                        name="gradient">
                                    </button>
                                    <p>Gradient</p>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                    <button type="button" class="btn btn-outline-secondary btn-block bg-button" disabled>
                                    </button>
                                    <p>Image</p>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                    <button type="button" class="btn btn-outline-secondary btn-block bg-button" disabled>
                                    </button>
                                    <p>Video</p>
                                </div>
                            </div>
                            <div class="row my-3" id="grad-dir-container">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gradDirection" 
                                        class="grad-button" id="flexRadioDefault1" data-direction="to right" checked >
                                    <label class="form-check-label" for="gradDirection">
                                        Gradient Right
                                    </label>
                                </div>
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="radio" name="gradDirection"
                                        id="flexRadioDefault2" data-direction="to left">
                                    <label class="form-check-label" for="gradDirection">
                                        Gradient Left
                                    </label>
                                </div>
                            </div>
                            <div class="row my-3">
                                <div class="col-4">
                                    <label for="exampleColorInput" class="form-label">Background Color</label>
                                    <input type="color" class="form-control form-control-color"
                                        id="backgroundColorPicker"
                                        value="{{ isset($user->appearance) && isset($user->appearance->custom) ? json_decode($user->appearance->custom)->lastBackgroundColor : '' }}"
                                        title="Choose your color">
                                </div>
                                <div class="col-4">
                                    <label for="exampleColorInput" class="form-label">Font Color</label>
                                    <input type="color" class="form-control form-control-color" id="fontColorPicker"
                                        value="{{ isset($user->appearance) && isset($user->appearance->custom) ? json_decode($user->appearance->custom)->fontColor : '' }}"
                                        title="Choose your color">
                                </div>
                                <div class="col-4">
                                    <label for="exampleColorInput" class="form-label">Button Color</label>
                                    <input type="color" class="form-control form-control-color" id="buttonColorPicker"
                                        value="{{ isset($user->appearance) && isset($user->appearance->custom) ? json_decode($user->appearance->custom)->buttonColor : '' }}"
                                        title="Choose your color">
                                </div>
                            </div>
                            <div class="row my-3" id="newFont">
                                <div class="col-3">
                                    <p class="inline mt-1">Font Style</p>
                                </div>
                                <div class="col-4">
                                    <select class="form-select" aria-label="Default select example" id="fontSelector">
                                        <option selected disabled>Choose Font</option>
                                        <option class="arial"
                                            value="Arial"{{ isset($user->appearance) && isset($user->appearance->custom) && json_decode($user->appearance->custom)->font === 'Arial' ? ' selected' : '' }}>
                                            Arial</option>
                                        <option class="georgia"
                                            value="Georgia, serif"{{ isset($user->appearance) && isset($user->appearance->custom) && json_decode($user->appearance->custom)->font === 'Georgia, serif' ? ' selected' : '' }}>
                                            Georgia</option>
                                        <option class="monospace"
                                            value="Courier New, monospace"{{ isset($user->appearance) && isset($user->appearance->custom) && json_decode($user->appearance->custom)->font === 'Courier New, monospace' ? ' selected' : '' }}>
                                            Courier New</option>
                                        <option class="sanserif"
                                            value="sans-serif"{{ isset($user->appearance) && isset($user->appearance->custom) && json_decode($user->appearance->custom)->font === 'sans-serif' ? ' selected' : '' }}>
                                            Sans-serif</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            {{-- Preview Section --}}
            <div class="col-12 col-md-5" style="min-width: 400px; position: relative;">
                <h5>Preview</h5>
                <div class="d-flex justify-content-center align-items-center preview"
                    style="margin-left: 81px; position:fixed">
                    <div class="loading-overlay" id="loadingOverlay">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    <iframe src="{{ $user->appearance ? $user->appearance->url_slug : '' }}" scrolling="yes"
                        id="theme-preview-iframe" width="270px" height="520px"
                        style="border:10px solid black; border-radius:35px;" sandbox="allow-same-origin allow-scripts">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
        // AJAX for appearance details and image upload
        const urlSlugInput = document.getElementById('url_slug');
        const profileTitleInput = document.getElementById('profile_title');
        const bioInput = document.getElementById('bio');
        const removeImageButton = document.getElementById('removeProfileImageButton');
        const uploadProfileImageForm = document.getElementById('uploadProfileImageForm');
        const uploadProfileImageButton = document.getElementById('uploadProfileImageButton');
        const themePreviewIframe = document.getElementById('theme-preview-iframe');
        const urlSlugErrorContainer = document.getElementById('urlSlugErrorContainer');
        let originalUrlSlug = urlSlugInput.value;
        const fontColorPicker = document.getElementById('fontColorPicker');
        const backgroundColorPicker = document.getElementById('backgroundColorPicker');
        const buttonColorPicker = document.getElementById('buttonColorPicker');
        const gradientDirectionInput = document.getElementById('gradientDirectionInput');
        var checkedInput = $('input:checked');
        var gradientDirection = checkedInput.data('direction');

        urlSlugInput.addEventListener('change', updateAppearanceDetails);
        profileTitleInput.addEventListener('change', updateAppearanceDetails);
        bioInput.addEventListener('change', updateAppearanceDetails);
        removeImageButton.addEventListener('click', removeImage);
        uploadProfileImageButton.addEventListener('click', uploadImage);
        var loadingOverlay = $('#loadingOverlay');
        loadingOverlay.hide();

        // Saving profile details
        function updateAppearanceDetails() {
            const urlSlug = urlSlugInput.value;
            const profileTitle = profileTitleInput.value;
            const bio = bioInput.value;
            loadingOverlay.show();

            // AJAX request to update appearance details
            $.ajax({
                url: '{{ route('themes.updateAppearance') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    url_slug: urlSlug,
                    profile_title: profileTitle,
                    bio: bio,
                },
                success: function(response) {
                    const profileImageWrapper = document.getElementById('profileImageWrapper');
                    const removeProfileImageButton = document.getElementById('removeProfileImageButton');

                    // Remove any existing content inside the profileImageWrapper
                    while (profileImageWrapper.firstChild) {
                        profileImageWrapper.removeChild(profileImageWrapper.firstChild);
                    }

                    // If the image exists, create and append the img tag
                    if (response.image) {
                        const img = document.createElement('img');
                        img.id = 'profileImage';
                        img.src = '{{ asset('storage/') }}' + '/' + response.image;
                        img.alt = 'Profile Image';
                        profileImageWrapper.appendChild(img);

                        // Enable the "Remove" button if an image is present
                        removeProfileImageButton.removeAttribute('disabled');
                    } else {
                        // If the profile_title is not null, show its first letter, else show "@"
                        const contentToShow = response.profile_title ? response.profile_title.charAt(0) : '@';

                        // Create and append the content
                        const content = document.createTextNode(contentToShow);
                        profileImageWrapper.appendChild(content);

                        // Disable the "Remove" button if no image is present
                        removeProfileImageButton.setAttribute('disabled', true);
                    }
                    setTimeout(function() {
                        if (response.url_slug) {
                            themePreviewIframe.src = response.url_slug;
                        }
                        
                        loadingOverlay.hide();
                    }, 2000);
                },
                error: function(error) {
                    console.error('Error updating appearance details', error);

                    // Check if the error response contains the specific error for the URL slug
                    if (error.responseJSON && error.responseJSON.errors && error.responseJSON.errors.url_slug) {
                        urlSlugErrorContainer.innerHTML = '<p>' + error.responseJSON.errors.url_slug[0] + '</p>';
                        setTimeout(() => {
                            urlSlugInput.value = originalUrlSlug;
                            urlSlugErrorContainer.innerHTML = '';
                        }, 5000);
                    } else {
                        // Display a generic error message for other errors
                        alert('An error occurred while updating appearance details. Please try again later.');
                    }
                    // Hide loading overlay in case of error
                    loadingOverlay.hide();
                }
            });
        }

        // Removing Profile image
        function removeImage() {
            loadingOverlay.show();
            $.ajax({
                url: '{{ route('user.remove.profile.image') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    console.log('Profile image removed successfully');

                    const profileImageWrapper = document.getElementById('profileImageWrapper');
                    const removeProfileImageButton = document.getElementById('removeProfileImageButton');

                    // Remove any existing content inside the profileImageWrapper
                    while (profileImageWrapper.firstChild) {
                        profileImageWrapper.removeChild(profileImageWrapper.firstChild);
                    }

                    // If the image exists, create and append the img tag
                    if (response.image) {
                        const img = document.createElement('img');
                        img.id = 'profileImage';
                        img.src = '{{ asset('storage/') }}' + '/' + response.image;
                        img.alt = 'Profile Image';
                        profileImageWrapper.appendChild(img);

                        // Enable the "Remove" button if an image is present
                        removeProfileImageButton.removeAttribute('disabled');
                    } else {
                        // If the profile_title is not null, show its first letter, else show "@"
                        const contentToShow = response.profile_title ? response.profile_title.charAt(0) : '@';

                        // Create and append the content
                        const content = document.createTextNode(contentToShow);
                        profileImageWrapper.appendChild(content);

                        // Disable the "Remove" button if no image is present
                        removeProfileImageButton.setAttribute('disabled', true);
                    }
                    setTimeout(function() {
                        if (response.url_slug) {
                            themePreviewIframe.src = response.url_slug;
                        }

                        loadingOverlay.hide();
                    }, 2000);
                },
                error: function(error) {
                    console.error('Error removing profile image', error);
                    // Hide loading overlay in case of error
                    loadingOverlay.hide();
                }
            });
        }

        // Uploading Profile image
        function uploadImage() {
            const formData = new FormData(uploadProfileImageForm);
            loadingOverlay.show();

            $.ajax({
                url: '{{ route('themes.updateAppearance') }}',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log('Profile image uploaded successfully');

                    const profileImageWrapper = document.getElementById('profileImageWrapper');
                    const removeProfileImageButton = document.getElementById('removeProfileImageButton');

                    // Remove any existing content inside the profileImageWrapper
                    while (profileImageWrapper.firstChild) {
                        profileImageWrapper.removeChild(profileImageWrapper.firstChild);
                    }

                    // If the image exists, create and append the img tag
                    if (response.image) {
                        const img = document.createElement('img');
                        img.id = 'profileImage';
                        img.src = '{{ asset('storage/') }}' + '/' + response.image;
                        img.alt = 'Profile Image';
                        profileImageWrapper.appendChild(img);

                        // Enable the "Remove" button if an image is present
                        removeProfileImageButton.removeAttribute('disabled');
                    } else {
                        // If the profile_title is not null, show its first letter, else show "@"
                        const contentToShow = response.profile_title ? response.profile_title.charAt(0) : '@';

                        // Create and append the content
                        const content = document.createTextNode(contentToShow);
                        profileImageWrapper.appendChild(content);

                        // Disable the "Remove" button if no image is present
                        removeProfileImageButton.setAttribute('disabled', true);
                    }
                    setTimeout(function() {
                        if (response.url_slug) {
                            themePreviewIframe.src = response.url_slug;
                        }

                        loadingOverlay.hide();
                    }, 2000);

                    $('#uploadImageModal').modal('hide'); // Close the modal
                },
                error: function(error) {
                    console.error('Error uploading profile image', error);
                    // Hide loading overlay in case of error
                    loadingOverlay.hide();
                }
            });
        }

        // Theme Select Script
        $(document).ready(function() {
            $('.theme-btn').removeClass('btn-selected');
            var userTheme = '{{ $user->appearance->theme }}';
            $('.theme-btn[data-theme="' + userTheme + '"]').addClass('btn-selected');
            if ($('.theme-btn[data-theme="custom"]').hasClass('btn-selected')) {
                enableCustomThemeSection();
            } else {
                disableCustomThemeSection();
            }

            $('.theme-btn').on('click', function() {
                var selectedTheme = $(this).data('theme');
                $('.theme-btn').removeClass('btn-selected');
                $(this).addClass('btn-selected');

                if ($('.theme-btn[data-theme="custom"]').hasClass('btn-selected')) {
                    enableCustomThemeSection();
                } else {
                    disableCustomThemeSection();
                }
                
                loadingOverlay.show();

                $.ajax({
                    url: '{{ route('setTheme') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        theme: selectedTheme
                    },
                    success: function(response) {
                        setTimeout(function() {
                            if (response.url_slug) {
                                themePreviewIframe.src = response.url_slug;
                            }
                            if (response.existingCustomData) {
                                let lastBackgroundColor = response.existingCustomData.lastBackgroundColor;
                                let fontColor = response.existingCustomData.fontColor;
                                let buttonColor = response.existingCustomData.buttonColor;
                                backgroundColorPicker.value = lastBackgroundColor;
                                fontColorPicker.value = fontColor;
                                buttonColorPicker.value = buttonColor;
                            }

                            loadingOverlay.hide();
                        }, 2000);

                    },
                    error: function(error) {
                        console.error('Error setting theme:', error);
                        // Hide loading overlay in case of error
                        loadingOverlay.hide();
                    }
                });
            });
        });

        //enable custom section 
        function enableCustomThemeSection() {
            $('#customThemeSection').show();
            $('#customThemeSectionHeading').show();
        }

        function disableCustomThemeSection() {
            $('#customThemeSection').hide();
            $('#customThemeSectionHeading').hide();
        }

        // gets triggered on enableAndScroll function 
        function smoothScroll(targetId) {
            const targetElement = document.getElementById(targetId);
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        }

        // binds both function smooth scroll and enable custom theme section
        function enableAndScroll() {
            enableCustomThemeSection();
            smoothScroll('ThemesCustomHeading');
        }

        //Setting Color input to color picker
        $(document).ready(function() {
            $('#color').colorpicker();
        });

        $(document).ready(function() {
            $('#grad-dir-container').hide();
            
            var appearanceData = @json($appearanceData);
            var customData = appearanceData ? appearanceData.custom : null;

            // Set initial selected state based on appearance data
            if (customData) {
                var backgroundType = customData.backgroundType;
                $('.bg-button[name="' + backgroundType + '"]').addClass('bg-type-selected');
                
                if (backgroundType === 'gradient') {
                    $('#grad-dir-container').show();

                    // Check the radio button based on the gradientDirection value
                    $('input[name="gradDirection"][data-direction="' + customData.gradientDirection + '"]').prop('checked', true);
                    $('#backgroundColorPicker').val(customData.lastBackgroundColor);
                    $('#fontColorPicker').val(customData.fontColor);
                    $('#buttonColorPicker').val(customData.buttonColor);
                    $('#fontSelector').val(customData.font);
                }
            }

            // Attach click event to the buttons
            $('.bg-button').on('click', function() {
                loadingOverlay.show();
                var backgroundType = $(this).attr('name');
                var backgroundColor = $('#backgroundColorPicker').val();
                var fontColor = $('#fontColorPicker').val();
                var buttonColor = $('#buttonColorPicker').val();
                var font = $('#fontSelector').val();
                var gradientDirection = $('input[name="gradDirection"]:checked').data('direction'); 

                $('.bg-button').removeClass('bg-type-selected');
                $(this).addClass('bg-type-selected');

                if (backgroundType === 'gradient') {
                    $('#grad-dir-container').show();
                } else {
                    $('#grad-dir-container').hide();
                }

                // Make an Ajax request to save data in the database
                updateThemeData(backgroundType, backgroundColor, fontColor, buttonColor, font, gradientDirection);
            });

            // Attach change event to the gradient radio buttons
            $('input[name="gradDirection"]').on('change', function() {
                loadingOverlay.show();
                var gradientDirection = $(this).data('direction');
                var backgroundType = 'gradient';
                var backgroundColor = $('#backgroundColorPicker').val();
                var fontColor = $('#fontColorPicker').val();
                var buttonColor = $('#buttonColorPicker').val();
                var font = $('#fontSelector').val();
                var gradientDirection = $('input[name="gradDirection"]:checked').data('direction'); 

                // Make an Ajax request to save data in the database
                updateThemeData(backgroundType, backgroundColor, fontColor, buttonColor, font, gradientDirection);
            });

            // Attach change event to the color pickers and font selector
            $('#backgroundColorPicker, #fontColorPicker, #buttonColorPicker, #fontSelector').on('change', function() {
                loadingOverlay.show();
                var backgroundType = $('.bg-type-selected').attr('name');
                var backgroundColor = $('#backgroundColorPicker').val();
                var fontColor = $('#fontColorPicker').val();
                var buttonColor = $('#buttonColorPicker').val();
                var font = $('#fontSelector').val();
                var gradientDirection = $('input[name="gradDirection"]:checked').data('direction'); 

                // Make an Ajax request to save data in the database
                updateThemeData(backgroundType, backgroundColor, fontColor, buttonColor, font, gradientDirection);
            });

            function updateThemeData(backgroundType, backgroundColor, fontColor, buttonColor, font, gradientDirection = null) {
                console.log(backgroundType, backgroundColor, gradientDirection, fontColor, buttonColor, font);
                $.ajax({
                    url: '{{ route('customTheme') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        backgroundType: backgroundType,
                        backgroundColor: backgroundColor,
                        gradientDirection: gradientDirection,
                        fontColor: fontColor,
                        buttonColor: buttonColor,
                        font: font
                    },
                    success: function(response) {
                        console.log('Data saved in the database:', response);

                        // Update appearance data if the server responds with new data
                        if (response.custom) {
                            customData = response.custom;
                        }

                        setTimeout(function() {
                            if (response.url_slug) {
                                themePreviewIframe.src = response.url_slug;
                            }

                            loadingOverlay.hide();
                        }, 2000);
                    },
                    error: function(error) {
                        console.error('Ajax request error:', error);
                        // Hide loading overlay in case of error
                        loadingOverlay.hide();
                    }
                });
            }
        });
    </script>
@endsection

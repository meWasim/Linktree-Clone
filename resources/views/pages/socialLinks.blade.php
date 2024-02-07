@extends('layouts.app')
@section('content')
    <div class="container mt-5">
        <div class="row">
            {{-- Add Link Section --}}
            <div class="col-7" style="min-width: 400px;">
                <h5>Social Links</h5>
                {{-- <div class="card border-light-subtle rounded-4">
                    <div class="card-body">
                        <div class="mb-3">
                            <button class="btn btn-primary rounded-pill mt-4" data-bs-toggle="modal"
                                data-bs-target="#addSocialIcon"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp Add icon</button>
                        </div>
                    </div>
                </div> --}}
                <div class="card mt-2 border-light-subtle rounded-4">
                    <div class="card-body">
                        <div class="row">
                            @if(isset($socialLinks))
                            <div class="d-flex align-items-center mb-2">
                                <label for="facebook" class="d-flex d-inline me-2"><i class="fa fa-facebook-square"></i></label>
                                <input class="socialLinks" id="facebook" type="text" value= "{{$socialLinks->facebook}}" placeholder="facebook.com/john">
                                <button type="button" class="btn deleteButton">
                                    <i class="fa fa-trash"></i>
                                </button>                               
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <label for="instagram" class="d-flex d-inline me-2"><i class="fa-brands fa-instagram"></i></label>
                                <input class="socialLinks" id="instagram" type="text" value= "{{$socialLinks->instagram}}" placeholder="instagram.com/john">
                                <button type="button" class="btn deleteButton">
                                    <i class="fa fa-trash"></i>
                                </button>                             
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <label for="whatsapp" class="d-flex d-inline me-2"><i class="fa fa-whatsapp"></i></label>
                                <input class="socialLinks" id="whatsapp" type="text" value= "{{$socialLinks->whatsapp}}" placeholder="wa.me/john">
                                <button type="button" class="btn deleteButton">
                                    <i class="fa fa-trash"></i>
                                </button>                               
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <label for="x" class="d-flex d-inline me-2"><i class="fa-brands fa-x-twitter"></i></label>
                                <input class="socialLinks" id="x" type="text" value= "{{$socialLinks->x}}" placeholder="x.com/john">
                                <button type="button" class="btn deleteButton">
                                    <i class="fa fa-trash"></i>
                                </button>                             
                            </div> 
                            @else
                            <div class="d-flex align-items-center mb-2">
                                <label for="facebook" class="d-flex d-inline me-2"><i class="fa fa-facebook-square"></i></label>
                                <input class="socialLinks" id="facebook" type="text" value= "" placeholder="facebook.com/john">
                                <button type="button" class="btn deleteButton">
                                    <i class="fa fa-trash"></i>
                                </button>                               
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <label for="instagram" class="d-flex d-inline me-2"><i class="fa-brands fa-instagram"></i></label>
                                <input class="socialLinks" id="instagram" type="text" value= "" placeholder="instagram.com/john">
                                <button type="button" class="btn deleteButton">
                                    <i class="fa fa-trash"></i>
                                </button>                             
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <label for="whatsapp" class="d-flex d-inline me-2"><i class="fa fa-whatsapp"></i></label>
                                <input class="socialLinks" id="whatsapp" type="text" value= "" placeholder="wa.me/john">
                                <button type="button" class="btn deleteButton">
                                    <i class="fa fa-trash"></i>
                                </button>                               
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <label for="x" class="d-flex d-inline me-2"><i class="fa-brands fa-x-twitter"></i></label>
                                <input class="socialLinks" id="x" type="text" value= "" placeholder="x.com/john">
                                <button type="button" class="btn deleteButton">
                                    <i class="fa fa-trash"></i>
                                </button>                             
                            </div> 
                            @endif
                                                       
                        </div>
                        <div id="messageBox" class="d-inline text-danger"></div>
                    </div>
                </div>
            </div>

            {{-- Preview Section --}}
            <div class="col-5" style="min-width: 400px;">
                <h5>Preview</h5>
                <div class="d-flex justify-content-center align-items-center">
                    <iframe src="{{$url_slug}}" scrolling="yes" id="theme-preview-iframe" width="270px" height="520px"
                        style="border:10px solid black; border-radius:35px;" sandbox="allow-same-origin allow-scripts">
                    </iframe>
                </div>
            </div>
        </div>
    </div>

    <script>
        const socialLinks = document.getElementsByClassName('socialLinks');
        const deleteButton = document.getElementsByClassName('deleteButton');
        const themePreviewIframe = document.getElementById('theme-preview-iframe');

        for (let i = 0; i < socialLinks.length; i++) {
            socialLinks[i].addEventListener('change', function() {
                updateData(i);
            });
            deleteButton[i].addEventListener('click', function() {
                deleteData(i);
            });
        }

        function updateData(index) {
            const uniqueId = socialLinks[index].id;
            const newValue = socialLinks[index].value;
            console.log(uniqueId, newValue);
            $.ajax({
                url: '{{route("updateLink")}}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: uniqueId,
                    value: newValue,
                },
                success: function (response) {
                    console.log('Data updated successfully');
                    if(response.url_slug){
                        themePreviewIframe.src = response.url_slug;
                    }
                },
                error: function (error) {
                    console.error('Error updating data:', error);
                }
            });
        }

        function deleteData(index) {
            const uniqueId = socialLinks[index].id;
            console.log(uniqueId);
            $.ajax({
                url: '{{route("deleteLink")}}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: uniqueId,
                },
                success: function (response) {
                    console.log('Data deleted successfully');
                    // You can handle the success response as needed
                    if(response.url_slug){
                        themePreviewIframe.src = response.url_slug;
                    }
                },
                error: function (error) {
                    console.error('Error deleted data:', error);
                    // You can handle the error as needed
                }
            });
        }
    </script>
@endsection

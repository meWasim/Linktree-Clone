@extends('layouts.app')
@section('content')
    <div class="container my-5" style="position: relative;">
        <div class="row">
            {{-- Appearance Edit Section --}}
            <div class="col-12 col-md-7" style="min-width: 400px;">
                <div class="row">
                    <h5>Test</h5>
                    <div id="sortable-container">
                        @foreach($cards as $card)
                            <div class="card mb-2" data-id="{{ $card->id }}">
                                <div class="card-body">
                                    {{ $card->content }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                
            </div>

            {{-- Preview Section --}}
            <div class="col-12 col-md-5" style="min-width: 400px;">
                <h5>Preview</h5>
                
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
    <script>
        var sortable = new Sortable(document.getElementById('sortable-container'), {
            onEnd: function (event) {
                // Handle the card reordering and update priorities
                var cardIds = sortable.toArray();
                // Send an AJAX request to update priorities in the database
                // You can use a route in Laravel to handle this update
            }
        });
    </script>
@endsection

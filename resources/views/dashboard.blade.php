@extends('layouts.app')

@section('content')

@php
    $user = Auth::user();
@endphp
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                Hello, <strong>{{$user->name}}</strong> Check your profile link <a class="" href="{{ $user->appearance ? $user->appearance->url_slug : $user->name }}" target="_blank">here</a>
            </div>
        </div>
    </div>
@endsection

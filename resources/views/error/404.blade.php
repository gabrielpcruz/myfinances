@extends('layout.layout')

@section('title', 'My finances | Page not found')

@section('custom-head-tags')
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,900" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/page-not-found.css') }}">

@endsection

@section('content')
    <div id="notfound">
        <div class="notfound">
            <div class="notfound-404">
                <h1>Oops!</h1>
            </div>
            <h2>404 - Page not found</h2>
            <p>The page you are looking for might have been removed had its name changed or is temporarily unavailable.</p>
            <a href="{{ url('/') }}">Go To Homepage</a>
        </div>
    </div>
@endsection

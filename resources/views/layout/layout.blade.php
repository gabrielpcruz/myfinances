<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/toastr.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome.css') }}">

    <title>@yield('title')</title>
</head>

<body>

@include('layout.componentes.navbar')

<br>

<div class="container mt-5">
    @yield('content')
</div>

<script type="text/javascript" src="{{ asset('assets/js/config.js') }}"></script>

@include('layout.scripts')

<!-- Custom JavaScript-->
<script type="text/javascript" src="{{ asset('assets/js/Script.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/Message.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/storage/AccountStorage.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/account/Account.js') }}"></script>

<script>
    $(document).ready(function () {
        Account.init();
    });
</script>

</body>
</html>

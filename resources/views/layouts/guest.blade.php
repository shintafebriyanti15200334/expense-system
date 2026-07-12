<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <meta name="csrf-token"
          content="{{ csrf_token() }}">

    <title>
        @yield('title', config('app.name'))
    </title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
          rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css"
          rel="stylesheet">

    <style>

        body{
            min-height:100vh;
            background:
                linear-gradient(
                    135deg,
                    #0d6efd,
                    #6f42c1
                );
        }

        .auth-wrapper{
            min-height:100vh;
        }

        .auth-card{
            border:none;
            border-radius:20px;
            overflow:hidden;
        }

        .logo{
            width:90px;
        }

    </style>

</head>

<body>

<div class="container">

    <div class="row justify-content-center align-items-center auth-wrapper">

        <div class="col-md-6 col-lg-5">

            {{-- Logo --}}
            {{-- <div class="text-center mb-4">

                <a href="{{ url('/') }}">

                    <img src="{{ asset('images/logo.png') }}"
                         class="logo img-fluid"
                         alt="Logo">

                </a>

            </div> --}}

            {{-- Card --}}
            <div class="card auth-card shadow-lg">

                <div class="card-body p-4 p-md-5">

                    @yield('content')

                </div>

            </div>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>


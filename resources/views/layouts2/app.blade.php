<!DOCTYPE html>
<html>
<head>
    <title>Lavanaya Expense System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css"
          rel="stylesheet">
</head>
<body>

<div class="d-flex">

    @include('layouts.sidebar')

    <div class="flex-grow-1">

        @include('layouts.navbar')

        <div class="container py-4">

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
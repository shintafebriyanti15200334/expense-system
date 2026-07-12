@extends('layouts.app')

@section('title', 'Profile')

@section('header')

<div class="d-flex justify-content-between align-items-center">

```
<div>
    <h3 class="fw-bold mb-1">
        <i class="bi bi-person-circle me-2"></i>
        Profile
    </h3>

    <small class="text-muted">
        Kelola informasi akun dan keamanan Anda
    </small>
</div>
```

</div>

@endsection

@section('content')

<div class="row justify-content-center">

```
<div class="col-lg-8">

    <!-- Profile Information -->
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            @include('profile.partials.update-profile-information-form')

        </div>

    </div>


    <!-- Update Password -->
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            @include('profile.partials.update-password-form')

        </div>

    </div>


    <!-- Delete Account -->
    <div class="card border-0 shadow-sm">

        <div class="card-body">

            @include('profile.partials.delete-user-form')

        </div>

    </div>

</div>
```

</div>

@endsection

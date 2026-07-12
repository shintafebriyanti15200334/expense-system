<div class="card border-0 shadow-sm">

```
<div class="card-header bg-white py-3">
    <h5 class="fw-bold mb-1">
        <i class="bi bi-person-circle me-2"></i>
        Profile Information
    </h5>

    <small class="text-muted">
        Update your account's profile information and email address.
    </small>
</div>

<div class="card-body p-4">

    <form id="send-verification"
          method="POST"
          action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="POST"
          action="{{ route('profile.update') }}">

        @csrf
        @method('PATCH')

        <!-- Name -->
        <div class="mb-4">

            <label for="name"
                   class="form-label fw-semibold">
                Name
            </label>

            <input type="text"
                   id="name"
                   name="name"
                   class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name', $user->name) }}"
                   required
                   autofocus>

            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror

        </div>


        <!-- Email -->
        <div class="mb-4">

            <label for="email"
                   class="form-label fw-semibold">
                Email
            </label>

            <input type="email"
                   id="email"
                   name="email"
                   class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email', $user->email) }}"
                   required>

            @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror


            @if (
                $user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail
                && ! $user->hasVerifiedEmail()
            )

                <div class="alert alert-warning mt-3 mb-0">

                    <i class="bi bi-exclamation-triangle me-2"></i>

                    Your email address is unverified.

                    <div class="mt-2">

                        <button form="send-verification"
                                class="btn btn-sm btn-outline-warning">

                            Send Verification Email

                        </button>

                    </div>

                </div>

                @if (session('status') === 'verification-link-sent')

                    <div class="alert alert-success mt-3 mb-0">

                        <i class="bi bi-check-circle me-2"></i>

                        A new verification link has been sent to your email address.

                    </div>

                @endif

            @endif

        </div>


        <!-- Button -->
        <div class="d-flex align-items-center gap-3">

            <button type="submit"
                    class="btn btn-primary">

                <i class="bi bi-save me-1"></i>
                Save Changes

            </button>

            @if (session('status') === 'profile-updated')

                <span class="text-success">

                    <i class="bi bi-check-circle-fill me-1"></i>
                    Saved successfully.

                </span>

            @endif

        </div>

    </form>

</div>
```

</div>

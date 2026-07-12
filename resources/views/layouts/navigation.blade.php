<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
    <div class="container">

    <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">
        Expense System
    </a>

    <button class="navbar-toggler" type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNav">

        <span class="navbar-toggler-icon"></span>

    </button>

    <div class="collapse navbar-collapse" id="navbarNav">

        <!-- Menu -->
        <ul class="navbar-nav me-auto">

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                   href="{{ route('dashboard') }}">
                    Dashboard
                </a>
            </li>

            @if(Auth::user()->role->name == 'Staff')

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('submissions.*') ? 'active' : '' }}"
                   href="{{ route('submissions.index') }}">
                    Pengajuan
                </a>
            </li>

            <li class="nav-item">

    <a
        href="{{ route('submissions.history') }}"
        class="nav-link">

        <i class="bi bi-clock-history me-2"></i>
        History Pengajuan

    </a>

</li>

            @endif


            @if(
                Auth::user()->role->name == 'SPV' ||
                Auth::user()->role->name == 'Manager' ||
                Auth::user()->role->name == 'Director'
            )

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('approvals.*') ? 'active' : '' }}"
                   href="{{ route('approvals.index') }}">
                    Approval
                </a>
            </li>

            <li class="nav-item">

<a href="{{ route('approvals.history') }}"
class="nav-link">


<i class="bi bi-clock-history me-1"></i>

History Approval


</a>

</li>

            @endif


            @if(Auth::user()->role->name == 'Finance')

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('finance.*') ? 'active' : '' }}"
                   href="{{ route('finance.index') }}">
                    Finance
                </a>
            </li>

            <li class="nav-item">
    <a class="nav-link"
       href="{{ route('finance.history') }}">
       
        <i class="bi bi-clock-history"></i>
        History Pembayaran

    </a>
</li>

            @endif

        </ul>

        <!-- User Dropdown -->
        <ul class="navbar-nav">

            <li class="nav-item dropdown">

                <a class="nav-link dropdown-toggle"
                   href="#"
                   role="button"
                   data-bs-toggle="dropdown">

                    {{ Auth::user()->name }}

                </a>

                <ul class="dropdown-menu dropdown-menu-end">

                    {{-- <li>
                        <a class="dropdown-item"
                           href="{{ route('profile.partials.edit') }}">
                            Profile
                        </a>
                    </li> --}}
{{-- 
                    <li>
                        <hr class="dropdown-divider">
                    </li> --}}

                    <li>
                        <form method="POST"
                              action="{{ route('logout') }}">
                            @csrf

                            <button type="submit"
                                    class="dropdown-item">
                                Logout
                            </button>
                        </form>
                    </li>

                </ul>

            </li>

        </ul>

    </div>

</div>
</nav>

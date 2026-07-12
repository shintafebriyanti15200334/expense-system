<nav class="navbar navbar-light bg-white shadow-sm px-4">

    <div>
        <h5 class="mb-0">
            Sistem Pengajuan Pengeluaran
        </h5>
    </div>

    <div class="dropdown">

        <button
            class="btn btn-outline-secondary dropdown-toggle"
            data-bs-toggle="dropdown">

            {{ auth()->user()->nama }}
        </button>

        <ul class="dropdown-menu dropdown-menu-end">

            <li>
                <span class="dropdown-item-text">
                    {{ auth()->user()->role->nama_role }}
                </span>
            </li>

            <li><hr class="dropdown-divider"></li>

            <li>

                <form method="POST"
                      action="{{ route('logout') }}">

                    @csrf

                    <button
                        class="dropdown-item">

                        Logout
                    </button>

                </form>

            </li>

        </ul>

    </div>

</nav>


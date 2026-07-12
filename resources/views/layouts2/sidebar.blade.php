<div class="bg-dark text-white p-3"
     style="width:250px;min-height:100vh;">

    <h5 class="mb-4">
        Lavanaya
    </h5>

    <ul class="nav flex-column">

        <li class="nav-item mb-2">

            <a href="{{ route('dashboard') }}"
               class="nav-link text-white">

                <i class="bi bi-speedometer2"></i>
                Dashboard
            </a>

        </li>

        @if(auth()->user()->role->nama_role=='Staff')

            <li>

                <a href="{{ route('pengajuan.index') }}"
                   class="nav-link text-white">

                    <i class="bi bi-file-earmark-text"></i>
                    Pengajuan

                </a>

            </li>

            <li class="nav-item">
    <a href="{{ route('kategori.index') }}"
       class="nav-link">

        <i class="bi bi-tags"></i>
        Kategori Pengeluaran

    </a>
</li>

        @endif


        @if(auth()->user()->role->nama_role=='SPV')

            <li>

                <a href="{{ route('approval.spv') }}"
                   class="nav-link text-white">

                    Approval SPV

                </a>

            </li>

        @endif


        @if(auth()->user()->role->nama_role=='Manager')

            <li>

                <a href="{{ route('approval.manager') }}"
                   class="nav-link text-white">

                    Approval Manager

                </a>

            </li>

        @endif


        @if(auth()->user()->role->nama_role=='Direktur')

            <li>

                <a href="{{ route('approval.direktur') }}"
                   class="nav-link text-white">

                    Approval Direktur

                </a>

            </li>

        @endif


        @if(auth()->user()->role->nama_role=='Finance')

            <li>

                <a href="{{ route('finance.index') }}"
                   class="nav-link text-white">

                    Pembayaran

                </a>

            </li>

        @endif

    </ul>

</div>


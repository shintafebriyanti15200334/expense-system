@extends('layouts.app')

@section('title', 'Tambah Pengajuan')

@section('header')

<div class="d-flex justify-content-between align-items-center">

    <div>
        <h3 class="fw-bold mb-1">
            <i class="bi bi-plus-circle me-2"></i>
            Tambah Pengajuan
        </h3>

        <small class="text-muted">
            Buat data pengajuan pengeluaran baru
        </small>
    </div>

    <a href="{{ route('submissions.index') }}"
       class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>
        Kembali
    </a>

</div>

@endsection

@section('content')

<div class="row justify-content-center">

    <div class="col-lg-10">

        <div class="card border-0 shadow">

            <div class="card-header bg-primary text-white py-3">

                <h5 class="mb-0">
                    <i class="bi bi-file-earmark-plus me-2"></i>
                    Form Tambah Pengajuan
                </h5>

            </div>

            <div class="card-body p-4">

                @if ($errors->any())

                    <div class="alert alert-danger">

                        <div class="fw-semibold mb-2">
                            Terdapat kesalahan:
                        </div>

                        <ul class="mb-0">

                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach

                        </ul>

                    </div>

                @endif

                <form action="{{ route('submissions.store') }}"
                      method="POST"
                      enctype="multipart/form-data"
                      id="submissionForm">

                    @csrf

                    @include('submissions._form')

                </form>

            </div>

        </div>

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const amount = document.getElementById('amount');

    amount.addEventListener('input', function (e) {

        let value = e.target.value
            .replace(/\D/g, '');

        e.target.value =
            new Intl.NumberFormat('id-ID')
            .format(value);
    });

    amount.closest('form')
        .addEventListener('submit', function () {

        amount.value =
            amount.value.replace(/\./g, '');

    });

});
</script>

@endsection
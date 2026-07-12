@extends('layouts.app')

@section('title', 'Data Pengajuan')

@section('header')

    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h3 class="fw-bold mb-1">
                <i class="bi bi-receipt-cutoff me-2"></i>
                Data Pengajuan
            </h3>
            <small class="text-muted">
                Kelola seluruh data pengajuan pengeluaran
            </small>
        </div>
        <a href="{{ route('submissions.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-circle me-1"></i>
            Tambah Pengajuan
        </a>

    </div>
@endsection

@section('content')

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">

        <div class="card-body border-bottom bg-light">

            <form method="GET">

                <div class="row g-3">

                    <div class="col-md-6">

                        <div class="input-group">

                            <span class="input-group-text">
                                <i class="bi bi-search"></i>
                            </span>

                            <input type="text" name="keyword" class="form-control"
                                placeholder="Cari nomor pengajuan atau deskripsi..." value="{{ request('keyword') }}">

                        </div>

                    </div>

                    <div class="col-md-3">

                        <select name="status" class="form-select">

                            <option value="">
                                Semua Status
                            </option>

                            @foreach (\App\Models\Submission::STATUSES as $status)
                                <option value="{{ $status }}" @selected(request('status') == $status)>
                                    {{ $status }}
                                </option>
                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-3 d-flex gap-2">

                        <button class="btn btn-primary flex-fill">
                            <i class="bi bi-funnel me-1"></i>
                            Filter
                        </button>

                        <a href="{{ route('submissions.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-clockwise"></i>
                        </a>

                    </div>

                </div>

            </form>

        </div>


        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-dark">

                    <tr>
                        <th width="60">No</th>
                        <th>Nomor</th>
                        <th>Tanggal</th>
                        <th>Kategori</th>
                        <th>Nominal</th>
                        <th>Status</th>
                        <th width="220">Aksi</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse($submissions as $submission)
                        @php

                            $badge = match ($submission->status) {
                                'Draft' => 'secondary',
                                'Submitted' => 'primary',

                                'Waiting SPV Approval' => 'warning', // Kuning
                                'Waiting Manager Approval' => 'primary', // Biru
                                'Waiting Director Approval' => 'dark', // Hitam
                                'Waiting Finance' => 'info', // Cyan

                                'Paid' => 'success', // Hijau
                                'Rejected' => 'danger', // Merah

                                default => 'secondary',
                            };

                        @endphp
                        <tr>

                            <td>
                                {{ $loop->iteration + ($submissions->firstItem() - 1) }}
                            </td>

                            <td>
                                <div class="fw-semibold">
                                    {{ $submission->submission_number }}
                                </div>
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($submission->submission_date)->format('d M Y') }}
                            </td>

                            <td>
                                <span class="badge bg-light text-dark border">
                                    {{ $submission->category->name }}
                                </span>
                            </td>

                            <td class="fw-bold text-success">
                                Rp {{ number_format($submission->amount, 0, ',', '.') }}
                            </td>

                            <td>

                                <span class="badge bg-{{ $badge }}">
                                    {{ $submission->status }}
                                </span>

                            </td>

                            <td>

                                <div class="d-flex flex-wrap gap-1">

                                    <a href="{{ route('submissions.show', $submission) }}"
                                        class="btn btn-sm btn-info text-white">

                                        <i class="bi bi-eye"></i>

                                    </a>

                                    <a href="{{ route('submissions.edit', $submission) }}" class="btn btn-sm btn-warning">

                                        <i class="bi bi-pencil-square"></i>

                                    </a>

                                    <form action="{{ route('submissions.destroy', $submission) }}" method="POST">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" onclick="return confirm('Hapus data ini?')"
                                            class="btn btn-sm btn-danger">

                                            <i class="bi bi-trash"></i>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7" class="text-center py-5">

                                <i class="bi bi-inbox display-5 text-muted"></i>

                                <p class="text-muted mt-3 mb-0">
                                    Belum ada data pengajuan.
                                </p>

                            </td>

                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>


        @if ($submissions->hasPages())
            <div class="card-footer bg-white">

                {{ $submissions->links() }}

            </div>
        @endif
    </div>

@endsection

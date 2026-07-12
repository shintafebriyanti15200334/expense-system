@extends('layouts.app')

@section('title', 'History Pengajuan')

@section('content')

    <div class="container py-4">

        <div class="card shadow-sm border-0">

            <div class="card-header bg-white">

                <h5 class="mb-0 fw-bold">

                    <i class="bi bi-clock-history me-2"></i>
                    History Pengajuan Saya

                </h5>

            </div>

            <div class="card-body">

                <form method="GET" class="row g-2 mb-3">

                    <div class="col-md-3">

                        <input type="date" name="date" class="form-control" value="{{ request('date') }}">

                    </div>

                    <div class="col-md-3">

                        <select name="status" class="form-select">

                            <option value="">
                                Semua Status
                            </option>

                            @foreach (['Submitted', 'Waiting SPV Approval', 'Waiting Manager Approval', 'Waiting Director Approval', 'Waiting Finance', 'Paid', 'Rejected'] as $status)
                                <option value="{{ $status }}" @selected(request('status') == $status)>

                                    {{ $status }}

                                </option>
                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-4">

                        <input type="text" name="search" class="form-control" placeholder="Cari nomor pengajuan..."
                            value="{{ request('search') }}">

                    </div>

                    <div class="col-md-2">

                        <button class="btn btn-primary w-100">

                            Filter

                        </button>

                    </div>

                </form>

<div class="d-flex gap-2 mb-3">

    <a href="{{ route('submissions.history.excel') }}"
       class="btn btn-success">

        <i class="bi bi-file-earmark-excel"></i>
        Export Excel
    </a>

    <a href="{{ route('submissions.history.pdf') }}"
       class="btn btn-danger">

        <i class="bi bi-file-earmark-pdf"></i>
        Export PDF
    </a>

</div>

                <div class="table-responsive">

                    <table class="table table-hover">

                        <thead class="table-light">

                            <tr>

                                <th>No</th>
                                <th>No Pengajuan</th>
                                <th>Kategori</th>
                                <th>Tanggal</th>
                                <th>Nominal</th>
                                <th>Status</th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($submissions as $submission)
                                <tr>

                                    <td>
                                        {{ $submissions->firstItem() + $loop->index }}
                                    </td>

                                    <td>

                                        <a href="{{ route('submissions.show', $submission) }}">

                                            {{ $submission->submission_number }}

                                        </a>

                                    </td>

                                    <td>
                                        {{ $submission->category->name }}
                                    </td>

                                    <td>
                                        {{ $submission->created_at->format('d-m-Y') }}
                                    </td>

                                    <td>

                                        Rp
                                        {{ number_format($submission->amount, 0, ',', '.') }}

                                    </td>

                                    <td>

                                        @php
                                            $badge = match ($submission->status) {
                                                'Paid' => 'success',
                                                'Rejected' => 'danger',

                                                'Waiting SPV Approval',
                                                'Waiting Manager Approval',
                                                'Waiting Director Approval',
                                                'Waiting Finance'
                                                    => 'warning',

                                                default => 'secondary',
                                            };
                                        @endphp

                                        <span class="badge bg-{{ $badge }}">

                                            {{ $submission->status }}

                                        </span>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="6" class="text-center py-4">

                                        Belum ada history pengajuan.

                                    </td>

                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

                {{ $submissions->links() }}

            </div>

        </div>

    </div>

@endsection

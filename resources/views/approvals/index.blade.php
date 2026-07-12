@extends('layouts.app')

@section('title', 'Approval Pengajuan')

@section('header')

    <div class="d-flex justify-content-between align-items-center">


        <div>
            <h3 class="fw-bold mb-1">
                <i class="bi bi-check2-square me-2"></i>
                Approval Pengajuan
            </h3>

            <small class="text-muted">
                Daftar pengajuan yang menunggu persetujuan
            </small>
        </div>


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


        <div class="card-body p-0">

            <div class="table-responsive">

                <form method="GET" class="mb-3">
                    <div class="row">

                        <div class="col-md-3">
                            <select name="status" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="Pending">Pending</option>
                                <option value="Approved">Approved</option>
                                <option value="Rejected">Rejected</option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <button class="btn btn-primary">
                                Filter
                            </button>
                        </div>

                    </div>
                </form>

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-dark">

                        <tr>
                            <th width="70">No</th>
                            <th>No Pengajuan</th>
                            <th>Tanggal</th>
                            <th>Tgl Approval</th>
                            <th>Pengaju</th>
                            <th>Kategori</th>
                            <th>Nominal</th>
                            <th>Status</th>
                            <th width="130">Aksi</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse($approvals as $approval)
                            @php

                                $status = $approval->status;

                                $badge = match ($status) {
                                    'Pending' => 'warning',
                                    'Approved' => 'success',
                                    'Rejected' => 'danger',
                                    default => 'secondary',
                                };

                            @endphp

                            <tr>

                                <td>
                                    {{ $loop->iteration + ($approvals->firstItem() - 1) }}
                                </td>

                                <td>

                                    <div class="fw-semibold">

                                        {{ $approval->submission->submission_number }}

                                    </div>

                                </td>

                                <td>

                                    {{ $approval->submission->submission_date->format('d M Y') }}

                                </td>

                                <td>
                                    @if ($approval->approved_at)
                                        {{ $approval->approved_at->format('d M Y H:i') }}
                                    @else
                                        -
                                    @endif
                                </td>

                                <td>

                                    <div class="fw-semibold">

                                        {{ $approval->submission->user->name }}

                                    </div>

                                </td>

                                <td>

                                    <span class="badge bg-light text-dark border">

                                        {{ $approval->submission->category->name }}

                                    </span>

                                </td>

                                <td class="fw-bold text-success">

                                    Rp {{ number_format($approval->submission->amount, 0, ',', '.') }}

                                </td>

                                <td>

                                    <span class="badge bg-{{ $badge }}">

                                        {{ $status }}

                                    </span>

                                </td>

                                <td>

                                    <a href="{{ route('approvals.show', $approval) }}" class="btn btn-sm btn-primary">

                                        <i class="bi bi-eye me-1"></i>
                                        Detail

                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="8" class="text-center py-5">

                                    <i class="bi bi-inbox display-5 text-muted"></i>

                                    <p class="text-muted mt-3 mb-0">

                                        Tidak ada approval yang menunggu.

                                    </p>

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

        @if ($approvals->hasPages())
            <div class="card-footer bg-white">

                {{ $approvals->links() }}

            </div>
        @endif


    </div>

@endsection

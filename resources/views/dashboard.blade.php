@extends('layouts.app')

@section('title','Dashboard')

@section('content')

<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="mb-4">
        <h4 class="fw-bold mb-1">
            Dashboard
        </h4>

        <small class="text-muted">
            Ringkasan statistik pengajuan pengeluaran
        </small>
    </div>

    {{-- Statistik --}}
    <div class="row g-3">

        {{-- Total --}}
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <small class="text-muted">
                                Total Pengajuan
                            </small>

                            <h3 class="fw-bold mb-1">
                                {{ $totalSubmission }}
                            </h3>

                        </div>

                        <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-file-earmark-text fs-4 text-primary"></i>
                        </div>

                    </div>

                </div>

            </div>
        </div>

        {{-- Waiting --}}
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <small class="text-muted">
                                Menunggu
                            </small>

                            <h3 class="fw-bold text-warning mb-1">
                                {{ $waiting }}
                            </h3>

                        </div>

                        <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-clock-history fs-4 text-warning"></i>
                        </div>

                    </div>

                </div>

            </div>
        </div>

        {{-- Paid --}}
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <small class="text-muted">
                                Dibayar
                            </small>

                            <h3 class="fw-bold text-success mb-1">
                                {{ $paid }}
                            </h3>

                        </div>

                        <div class="bg-success bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-cash-stack fs-4 text-success"></i>
                        </div>

                    </div>

                </div>

            </div>
        </div>

        {{-- Reject --}}
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <small class="text-muted">
                                Ditolak
                            </small>

                            <h3 class="fw-bold text-danger mb-1">
                                {{ $rejected }}
                            </h3>

                        </div>

                        <div class="bg-danger bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-x-circle fs-4 text-danger"></i>
                        </div>

                    </div>

                </div>

            </div>
        </div>

    </div>


    {{-- Nominal + Chart --}}
    <div class="row g-3 mt-2">

        {{-- Nominal --}}
        <div class="col-lg-8">

            <div class="row g-3">

                <div class="col-md-6">

                    <div class="card border-0 shadow-sm">

                        <div class="card-body">

                            <small class="text-muted">
                                Total Nilai Pengajuan
                            </small>

                            <h4 class="fw-bold text-primary mt-2">
                                Rp {{ number_format($totalNominal,0,',','.') }}
                            </h4>

                        </div>

                    </div>

                </div>

                <div class="col-md-6">

                    <div class="card border-0 shadow-sm">

                        <div class="card-body">

                            <small class="text-muted">
                                Total Pengeluaran Dibayar
                            </small>

                            <h4 class="fw-bold text-success mt-2">
                                Rp {{ number_format($totalDibayar,0,',','.') }}
                            </h4>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Approval Terbaru --}}
            @isset($approvalList)

            <div class="card border-0 shadow-sm mt-3">

                <div class="card-header bg-white">

                    <h6 class="mb-0 fw-bold">
                        <i class="bi bi-list-check me-2"></i>
                        Pengajuan Terbaru
                    </h6>

                </div>

                <div class="table-responsive">

                    <table class="table table-hover mb-0">

                        <thead class="table-light">

                        <tr>
                            <th>No Pengajuan</th>
                            <th>Pengaju</th>
                            <th>Kategori</th>
                            <th>Nominal</th>
                            <th>Status</th>
                        </tr>

                        </thead>

                        <tbody>

                        @forelse($approvalList as $item)

                        <tr>

                            <td>
                                {{ $item->submission_number }}
                            </td>

                            <td>
                                {{ $item->user->name }}
                            </td>

                            <td>
                                {{ $item->category->name }}
                            </td>

                            <td class="fw-semibold">
                                Rp {{ number_format($item->amount,0,',','.') }}
                            </td>

                            <td>

                                @php
                                    $badge = match($item->status){
                                        'Paid' => 'success',
                                        'Rejected' => 'danger',
                                        default => 'warning'
                                    };
                                @endphp

                                <span class="badge bg-{{ $badge }}">
                                    {{ $item->status }}
                                </span>

                            </td>

                        </tr>

                        @empty

                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                Tidak ada data pengajuan.
                            </td>
                        </tr>

                        @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

            @endisset

        </div>


{{-- SIDEBAR KANAN --}}
<div class="col-lg-4">

    {{-- Statistik Status --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-header bg-white">
            <h6 class="fw-bold mb-0">
                <i class="bi bi-pie-chart me-2"></i>
                Statistik Status
            </h6>
        </div>

        <div class="card-body">

            <div style="height:220px">
                <canvas id="statusChart"></canvas>
            </div>

            <hr>

            <div class="row text-center">

                <div class="col-4">
                    <div class="border rounded p-2">
                        <small class="text-muted d-block">
                            Menunggu
                        </small>

                        <h5 class="text-warning fw-bold mb-0">
                            {{ $waiting }}
                        </h5>
                    </div>
                </div>

                <div class="col-4">
                    <div class="border rounded p-2">
                        <small class="text-muted d-block">
                            Dibayar
                        </small>

                        <h5 class="text-success fw-bold mb-0">
                            {{ $paid }}
                        </h5>
                    </div>
                </div>

                <div class="col-4">
                    <div class="border rounded p-2">
                        <small class="text-muted d-block">
                            Ditolak
                        </small>

                        <h5 class="text-danger fw-bold mb-0">
                            {{ $rejected }}
                        </h5>
                    </div>
                </div>

            </div>

        </div>

    </div>



    {{-- Audit Trail --}}
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white">
            <h6 class="fw-bold mb-0">
                <i class="bi bi-clock-history me-2"></i>
                Audit Trail Terbaru
            </h6>
        </div>

        <div class="card-body p-0">

            <div class="list-group list-group-flush">

                @forelse($auditTrails as $log)

                    @php
                        $badge = match($log->action){
                            'Create' => 'success',
                            'Update' => 'warning',
                            'Delete' => 'danger',
                            'Approve' => 'success',
                            'Reject' => 'danger',
                            'Paid' => 'info',
                            default => 'secondary'
                        };
                    @endphp

                    <div class="list-group-item">

                        <div class="d-flex justify-content-between">

                            <div>

                                <span class="badge bg-{{ $badge }}">
                                    {{ $log->action }}
                                </span>

                                <span class="badge bg-primary">
                                    {{ $log->module }}
                                </span>

                            </div>

                            <small class="text-muted">
                                {{ $log->created_at->format('d/m H:i') }}
                            </small>

                        </div>

                        <div class="mt-2">

                            <div class="fw-semibold">
                                {{ $log->user?->name }}
                            </div>

                            <small class="text-muted">
                                {{ $log->description }}
                            </small>

                        </div>

                    </div>

                @empty

                    <div class="text-center p-4 text-muted">
                        <i class="bi bi-clock-history fs-2 d-block mb-2"></i>
                        Belum ada aktivitas.
                    </div>

                @endforelse

            </div>

        </div>

    </div>

</div>
            </div>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

new Chart(
    document.getElementById('statusChart'),
    {
        type: 'doughnut',

        data: {
            labels: [
                'Menunggu',
                'Dibayar',
                'Ditolak'
            ],

            datasets: [{
                data: [
                    {{ $waiting }},
                    {{ $paid }},
                    {{ $rejected }}
                ],
                backgroundColor: [
                    '#ffc107',
                    '#198754',
                    '#dc3545'
                ],
                borderWidth: 0
            }]
        },

        options: {
            maintainAspectRatio: false,
            cutout: '70%',

            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    }
);

</script>

@endsection
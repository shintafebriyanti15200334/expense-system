@extends('layouts.app')

@section('title','Detail Pengajuan')

@section('header')

<div class="d-flex justify-content-between align-items-center">
<div>
    <h3 class="fw-bold mb-1">
        <i class="bi bi-file-earmark-text me-2"></i>
        Detail Pengajuan
    </h3>

    <small class="text-muted">
        Informasi lengkap data pengajuan
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

@php
$badge = match($submission->status){
'Draft' => 'secondary',
'Submitted' => 'primary',
'Waiting SPV Approval' => 'warning',
'Waiting Manager Approval' => 'warning',
'Waiting Director Approval' => 'warning',
'Waiting Finance' => 'info',
'Paid' => 'success',
'Rejected' => 'danger',
default => 'secondary'
};
@endphp

<div class="row g-4">
<!-- Detail Pengajuan -->
<div class="col-lg-8">

    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white">
            <h5 class="mb-0 fw-bold">
                Informasi Pengajuan
            </h5>
        </div>

        <div class="card-body">

            <div class="row mb-4">

                <div class="col-md-6">
                    <small class="text-muted">
                        Nomor Pengajuan
                    </small>

                    <div class="fw-semibold fs-5">
                        {{ $submission->submission_number }}
                    </div>
                </div>

                <div class="col-md-6">
                    <small class="text-muted">
                        Status
                    </small>

                    <div>
                        <span class="badge bg-{{ $badge }} fs-6">
                            {{ $submission->status }}
                        </span>
                    </div>
                </div>

            </div>


            <div class="row g-4">

                <div class="col-md-6">
                    <label class="text-muted">
                        Tanggal Pengajuan
                    </label>

                    <div class="fw-semibold">
                        {{ \Carbon\Carbon::parse($submission->submission_date)->format('d F Y') }}
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="text-muted">
                        Nama Pengaju
                    </label>

                    <div class="fw-semibold">
                        {{ $submission->user->name }}
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="text-muted">
                        Kategori
                    </label>

                    <div>
                        <span class="badge bg-light text-dark border">
                            {{ $submission->category->name }}
                        </span>
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="text-muted">
                        Nominal
                    </label>

                    <div class="fw-bold fs-4 text-success">
                        Rp {{ number_format($submission->amount,0,',','.') }}
                    </div>
                </div>

                <div class="col-12">
                    <label class="text-muted">
                        Deskripsi
                    </label>

                    <div class="border rounded p-3 bg-light mt-2">
                        {!! nl2br(e($submission->description)) !!}
                    </div>
                </div>

 <div class="col-12">

    <label class="text-muted">
        Lampiran
    </label>


    <div class="mt-2">


        @if($submission->attachments && $submission->attachments->count())


            @foreach($submission->attachments as $attachment)


                <div class="mb-2">


                    <a href="{{ asset('storage/'.$attachment->file_path) }}"
                       target="_blank"
                       class="btn btn-outline-primary">


                        <i class="bi bi-paperclip me-1"></i>


                        {{ $attachment->file_name }}


                    </a>


                </div>


            @endforeach



        @else


            <span class="text-muted">

                Tidak ada lampiran

            </span>


        @endif


    </div>


</div>
            </div>

        </div>

    </div>

</div>


<!-- Timeline Approval -->
<div class="col-lg-4">

    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white">
            <h5 class="mb-0 fw-bold">
                Riwayat Approval
            </h5>
        </div>

        <div class="card-body">

            @forelse($submission->approvals as $approval)

            <div class="border-start border-4 ps-3 mb-4">

                <div class="fw-semibold">
                    {{ $approval->approver->name }}
                </div>

                <small class="text-muted">
                    {{ $approval->level }}
                </small>

                <div class="mt-2">

                    @php
                        $statusColor =
                            $approval->status == 'Approved'
                            ? 'success'
                            : ($approval->status == 'Rejected'
                                ? 'danger'
                                : 'warning');
                    @endphp

                    <span class="badge bg-{{ $statusColor }}">
                        {{ $approval->status }}
                    </span>

                </div>

                <small class="d-block text-muted mt-2">
                    {{ $approval->approved_at
                        ? \Carbon\Carbon::parse($approval->approved_at)->format('d M Y H:i')
                        : '-' }}
                </small>

                @if($approval->notes)
                    <div class="mt-2">
                        {{ $approval->notes }}
                    </div>
                @endif

            </div>

            @empty

            <div class="text-center py-4">

                <i class="bi bi-clock-history display-5 text-muted"></i>

                <p class="text-muted mt-3 mb-0">
                    Belum ada proses approval.
                </p>

            </div>

            @endforelse

        </div>

    </div>

</div>
</div>

@if($submission->payment)

<div class="card border-0 shadow-sm mt-4">

```
<div class="card-header bg-white">

    <h5 class="fw-bold mb-0">
        <i class="bi bi-cash-stack me-2"></i>
        Informasi Pembayaran
    </h5>

</div>

<div class="card-body">

    <div class="row">

        <div class="col-md-4">

            <small class="text-muted">
                Tanggal Pembayaran
            </small>

            <div class="fw-semibold">
                {{ \Carbon\Carbon::parse($submission->payment->payment_date)->format('d F Y') }}
            </div>

        </div>

        <div class="col-md-4">

            <small class="text-muted">
                Nominal
            </small>

            <div class="fw-bold text-success fs-5">
                Rp {{ number_format($submission->payment->amount,0,',','.') }}
            </div>

        </div>

        <div class="col-md-4">

            <small class="text-muted">
                Keterangan
            </small>

            <div>
                {{ $submission->payment->notes ?? '-' }}
            </div>

        </div>

    </div>

</div>
</div>

@endif

@endsection

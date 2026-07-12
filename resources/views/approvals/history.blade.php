@extends('layouts.app')

@section('title', 'History Approval')

@section('content')

    <div class="container py-4">


        <div class="card shadow-sm">


            <div class="card-header bg-dark text-white">

                <h4 class="mb-0">
                    History Approval
                </h4>

            </div>



            <div class="card-body">


                <form method="GET" class="row g-2 mb-4">


                    <div class="col-md-3">

                        <input type="date" name="date" class="form-control" value="{{ request('date') }}">

                    </div>



                    <div class="col-md-3">

                        <select name="status" class="form-select">


                            <option value="">
                                Semua Status
                            </option>


                            <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>
                                Pending
                            </option>


                            <option value="Approved" {{ request('status') == 'Approved' ? 'selected' : '' }}>
                                Approved
                            </option>


                            <option value="Rejected" {{ request('status') == 'Rejected' ? 'selected' : '' }}>
                                Rejected
                            </option>


                        </select>

                    </div>



                    <div class="col-md-4">

                        <input type="text" name="search" class="form-control" placeholder="Cari nomor pengajuan"
                            value="{{ request('search') }}">

                    </div>



                    <div class="col-md-2">

                        <button class="btn btn-primary w-100">
                            Filter
                        </button>

                    </div>


                </form>



                <div class="d-flex gap-2 mb-3">

                    <a href="{{ route('approvals.history.excel') }}" class="btn btn-success">

                        <i class="bi bi-file-earmark-excel"></i>
                        Export Excel
                    </a>

                    <a href="{{ route('approvals.history.pdf') }}" class="btn btn-danger">

                        <i class="bi bi-file-earmark-pdf"></i>
                        Export PDF
                    </a>

                </div>

                <div class="table-responsive">


                    <table class="table table-bordered table-hover">


                        <thead class="table-dark">

                            <tr>

                                <th>No</th>
                                <th>No Pengajuan</th>
                                <th>Level</th>
                                <th>Approver</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Tanggal Approval</th>
                                <th>Status</th>
                                <th>Catatan</th>

                            </tr>

                        </thead>



                        <tbody>


                            @forelse($approvals as $approval)
                                <tr>


                                    <td>
                                        {{ $loop->iteration + ($approvals->firstItem() - 1) }}
                                    </td>



                                    <td>
                                        {{ $approval->submission->submission_number }}
                                    </td>



                                    <td>

                                        <span class="badge bg-info">

                                            {{ $approval->level }}

                                        </span>

                                    </td>



                                    <td>

                                        {{ $approval->approver->name }}

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


                                        @php

                                            $badge = match ($approval->status) {
                                                'Approved' => 'success',

                                                'Rejected' => 'danger',

                                                'Pending' => 'warning',

                                                default => 'secondary',
                                            };

                                        @endphp



                                        <span class="badge bg-{{ $badge }}">

                                            {{ $approval->status }}

                                        </span>


                                    </td>



                                    <td>

                                        {{ $approval->notes ?? '-' }}

                                    </td>


                                </tr>



                            @empty


                                <tr>

                                    <td colspan="8" class="text-center">

                                        Belum ada history approval

                                    </td>

                                </tr>
                            @endforelse


                        </tbody>


                    </table>


                </div>



                {{ $approvals->links() }}



            </div>


        </div>


    </div>


@endsection

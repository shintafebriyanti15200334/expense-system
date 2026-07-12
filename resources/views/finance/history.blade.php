@extends('layouts.app')

@section('title', 'History Pembayaran')

@section('content')

<div class="container py-4">

    <div class="card shadow-sm">

        <div class="card-header bg-dark text-white">
            <h4 class="mb-0">
                History Pembayaran
            </h4>
        </div>


        <div class="card-body">


            <form method="GET" class="row g-2 mb-4">


                <div class="col-md-3">

                    <select name="status" class="form-select">

                        <option value="">
                            Semua Status
                        </option>

                        <option value="Paid"
                            {{ request('status') == 'Paid' ? 'selected' : '' }}>
                            Paid
                        </option>

                        <option value="Rejected"
                            {{ request('status') == 'Rejected' ? 'selected' : '' }}>
                            Rejected
                        </option>

                    </select>

                </div>



                <div class="col-md-4">

                    <input type="text"
                           name="search"
                           class="form-control"
                           placeholder="Cari nomor pengajuan"
                           value="{{ request('search') }}">

                </div>



                <div class="col-md-2">

                    <button class="btn btn-primary w-100">
                        Filter
                    </button>

                </div>


            </form>



            <div class="mb-3">

                <a href="{{ route('finance.export.excel') }}"
                   class="btn btn-success">

                    <i class="bi bi-file-earmark-excel"></i>
                    Export Excel

                </a>


                <a href="{{ route('finance.export.pdf') }}"
                   class="btn btn-danger">

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
                            <th>Finance</th>
                            <th>Tanggal Bayar</th>
                            <th>Jumlah</th>
                            <th>Tersedia</th>
                            <th>Tersisa</th>
                            <th>Status</th>
                            <th>Catatan</th>

                        </tr>

                    </thead>



                    <tbody>


                    @forelse($payments as $payment)

                        <tr>


                            <td>
                                {{ $loop->iteration }}
                            </td>


                            <td>
                                {{ $payment->submission->submission_number }}
                            </td>


                            <td>
                                {{ $payment->finance->name }}
                            </td>



                            <td>

                                {{ $payment->created_at->format('d-m-Y H:i:s') }}

                            </td>



                            <td>

                                Rp {{ number_format(
                                    $payment->paid_amount,
                                    0,
                                    ',',
                                    '.'
                                ) }}

                            </td>



                            @php

                                $budget = $payment->submission
                                    ->category
                                    ->budgets
                                    ->where('year', date('Y'))
                                    ->first();

                            @endphp



                            <td>

                                @if($budget)

                                    Rp {{ number_format(
                                        $budget->budget_amount,
                                        0,
                                        ',',
                                        '.'
                                    ) }}

                                @else

                                    -

                                @endif

                            </td>




                            <td>

                                @if($budget)

                                    Rp {{ number_format(
                                        $budget->budget_amount - $budget->used_amount,
                                        0,
                                        ',',
                                        '.'
                                    ) }}

                                @else

                                    -

                                @endif

                            </td>




                            <td>

                                <span class="badge bg-success">

                                    {{ $payment->status }}

                                </span>

                            </td>




                            <td>

                                {{ $payment->notes ?? '-' }}

                            </td>


                        </tr>


                    @empty


                        <tr>

                            <td colspan="9" class="text-center">

                                Belum ada pembayaran

                            </td>

                        </tr>


                    @endforelse


                    </tbody>


                </table>


            </div>



            <div class="mt-3">

                {{ $payments->links() }}

            </div>



        </div>

    </div>

</div>


@endsection
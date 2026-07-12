@extends('layouts.app')

@section('title', 'Finance')

@section('content')

    <div class="container py-4">


        <div class="card shadow-sm">


            <div class="card-header">

                <h4 class="mb-0">
                    Finance - Pembayaran
                </h4>

            </div>



            <div class="card-body">


                @if (session('success'))
                    <div class="alert alert-success">

                        {{ session('success') }}

                    </div>
                @endif



                @if (session('error'))
                    <div class="alert alert-danger">

                        {{ session('error') }}

                    </div>
                @endif




                <div class="table-responsive">


                    <table class="table table-bordered table-hover">


                        <thead class="table-dark">


                            <tr>

                                <th>
                                    No
                                </th>

                                <th>
                                    Nomor Pengajuan
                                </th>

                                <th>
                                    Pengaju
                                </th>

                                <th>
                                    Kategori
                                </th>

                                <th>
                                    Nominal
                                </th>
                                <th>
                                    Tersedia
                                </th>
                                <th>
                                    Tersisa
                                </th>

                                <th>
                                    Status
                                </th>

                                <th width="250">
                                    Action
                                </th>

                            </tr>


                        </thead>



                        <tbody>


                            @forelse($submissions as $submission)
                                <tr>


                                    <td>

                                        {{ $loop->iteration }}

                                    </td>


                                    <td>

                                        {{ $submission->submission_number }}

                                    </td>



                                    <td>

                                        {{ $submission->user->name }}

                                    </td>



                                    <td>

                                        {{ $submission->category->name }}

                                    </td>



                                    <td>

                                        Rp
                                        {{ number_format($submission->amount, 0, ',', '.') }}

                                    </td>

                                    <td>

                                        @php
                                            $budget = $submission->category->budgets->where('year', date('Y'))->first();
                                        @endphp


                                        @if ($budget)
                                            Rp
                                            {{ number_format($budget->budget_amount, 0, ',', '.') }}
                                        @else
                                            -
                                        @endif

                                    </td>



                                    <td>

                                        @if ($budget)
                                            Rp
                                            {{ number_format($budget->budget_amount - $budget->used_amount, 0, ',', '.') }}
                                        @else
                                            -
                                        @endif

                                    </td>



                                    <td>

                                        <span class="badge bg-warning">

                                            {{ $submission->status }}

                                        </span>

                                    </td>



                                    <td>


                                        <form method="POST"
                                            action="{{ route('finance.pay', $submission) }}">


                                            @csrf



                                           <div class="mb-2">

    <input type="time"
           name="payment_time"
           class="form-control"
           value="{{ date('H:i') }}">

</div>



                                            <div class="mb-2">


                                                <textarea name="notes" class="form-control" placeholder="Catatan Finance"></textarea>


                                            </div>



                                            <button type="submit" class="btn btn-success btn-sm w-100">


                                                Proses Pembayaran


                                            </button>



                                        </form>


                                    </td>


                                </tr>


                            @empty


                                <tr>

                                    <td colspan="7" class="text-center">


                                        Tidak ada transaksi.


                                    </td>

                                </tr>
                            @endforelse


                        </tbody>


                    </table>


                </div>


                <div class="mt-3">

                    {{ $submissions->links() }}

                </div>



            </div>


        </div>


    </div>

@endsection

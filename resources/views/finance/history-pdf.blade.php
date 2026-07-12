<h3>
    History Pembayaran Finance
</h3>

<table border="1" width="100%" cellspacing="0" cellpadding="5">

    <tr>
        <th>No</th>
        <th>Nomor</th>
        <th>Pengaju</th>
        <th>Kategori</th>
        <th>Nominal</th>
        <th>Budget Tersedia</th>
        <th>Budget Tersisa</th>
        <th>Tanggal Pembayaran</th>
    </tr>


    @foreach ($payments as $payment)

        @php
            $budget = $payment->submission
                ->category
                ->budgets
                ->where('year', date('Y'))
                ->first();
        @endphp


        <tr>

            <td>
                {{ $loop->iteration }}
            </td>


            <td>
                {{ $payment->submission->submission_number }}
            </td>


            <td>
                {{ $payment->submission->user->name }}
            </td>


            <td>
                {{ $payment->submission->category->name }}
            </td>


            <td>
                Rp {{ number_format(
                    $payment->submission->amount,
                    0,
                    ',',
                    '.'
                ) }}
            </td>


            <td>
                Rp {{ number_format(
                    $budget ? $budget->budget_amount : 0,
                    0,
                    ',',
                    '.'
                ) }}
            </td>


            <td>
                Rp {{ number_format(
                    $budget
                    ? $budget->budget_amount - $budget->used_amount
                    : 0,
                    0,
                    ',',
                    '.'
                ) }}
            </td>


            <td>
                {{ $payment->created_at
                    ? $payment->created_at->format('d-m-Y H:i:s')
                    : '-' }}
            </td>


        </tr>

    @endforeach


</table>
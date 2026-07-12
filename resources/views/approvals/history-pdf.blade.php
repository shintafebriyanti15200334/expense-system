```blade
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>History Approval</title>

    <style>
        body{
            font-family: DejaVu Sans;
            font-size:12px;
        }

        table{
            width:100%;
            border-collapse: collapse;
        }

        th,
        td{
            border:1px solid #000;
            padding:6px;
        }

        th{
            background:#f2f2f2;
        }

        h2{
            text-align:center;
            margin-bottom:20px;
        }
    </style>

</head>
<body>

<h2>Laporan History Approval</h2>

<table>

    <thead>

    <tr>
        <th>No</th>
        <th>No Pengajuan</th>
        <th>Pengaju</th>
        <th>Kategori</th>
        <th>Nominal</th>
        <th>Level</th>
        <th>Status</th>
        <th>Tanggal</th>
    </tr>

    </thead>

    <tbody>

    @forelse($approvals as $item)

        <tr>

            <td>
                {{ $loop->iteration }}
            </td>

            <td>
                {{ $item->submission?->submission_number }}
            </td>

            <td>
                {{ $item->submission?->user?->name }}
            </td>

            <td>
                {{ $item->submission?->category?->name }}
            </td>

            <td>
                Rp {{ number_format($item->submission?->amount,0,',','.') }}
            </td>

            <td>
                {{ $item->level }}
            </td>

            <td>
                {{ $item->status }}
            </td>

            <td>
                {{ optional($item->approved_at)->format('d-m-Y H:i') }}
            </td>

        </tr>

    @empty

        <tr>
            <td colspan="8" align="center">
                Tidak ada data
            </td>
        </tr>

    @endforelse

    </tbody>

</table>

</body>
</html>
```

<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8">
    <title>History Pengajuan</title>

```
<style>
    body{
        font-family: sans-serif;
        font-size:12px;
    }

    table{
        width:100%;
        border-collapse:collapse;
    }

    th,
    td{
        border:1px solid #000;
        padding:6px;
    }

    th{
        background:#f2f2f2;
    }

    h3{
        text-align:center;
        margin-bottom:20px;
    }
</style>
```

</head>
<body>

<h3>History Pengajuan Pengeluaran</h3>

<table>

```
<thead>

<tr>
    <th>No</th>
    <th>No Pengajuan</th>
    <th>Kategori</th>
    <th>Nominal</th>
    <th>Status</th>
    <th>Tanggal</th>
</tr>

</thead>

<tbody>

@foreach($submissions as $item)

<tr>

    <td>{{ $loop->iteration }}</td>

    <td>
        {{ $item->submission_number }}
    </td>

    <td>
        {{ $item->category->name }}
    </td>

    <td>
        Rp {{ number_format($item->amount,0,',','.') }}
    </td>

    <td>
        {{ $item->status }}
    </td>

    <td>
        {{ $item->created_at->format('d-m-Y H:i') }}
    </td>

</tr>

@endforeach

</tbody>
```

</table>

</body>
</html>

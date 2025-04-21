<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Siswa</title>

</head>

<body>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }
    </style>

    <table class="table table-light">
        <thead class="thead-light">
            <tr>
                <th>No</th>
                <th>No Invoice</th>
                <th>Keterangan</th>
                <th>NIS</th>
                <th>Nominal</th>
                <th>Bulan</th>
                <th>Tahun</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tagihans as $index => $tagihan)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $tagihan->no_invoice }}</td>
                    <td>{{ $tagihan->keterangan }}</td>
                    <td>{{ $tagihan->siswa->nis ?? '-' }}</td>
                    <td>{{ 'Rp. ' . number_format($tagihan->biaya->nominal, 0, ',', '.') }}</td>
                    <td>{{ $tagihan->bulan }}</td>
                    <td>{{ $tagihan->tahun }}</td>
                    <td>
                        @if ($tagihan->status == 'Belum Lunas')
                            <span class="badge rounded-pill bg-danger">Belum Lunas</span>
                        @elseif ($tagihan->status == 'Sedang Diverifikasi')
                            <span class="badge rounded-pill bg-warning">Sedang Diverifikasi</span>
                        @elseif ($tagihan->status == 'Lebih')
                            <span class="badge rounded-pill bg-success">Lunas Lebih</span>
                        @elseif ($tagihan->status == 'Kurang')
                            <span class="badge rounded-pill bg-warning">Kurang</span>
                        @else
                            <span class="badge rounded-pill bg-success">Lunas</span>
                        @endif
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>

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

        .header {
            text-align: center;
            margin-bottom: 15px;
            position: relative;
            padding-bottom: 15px;
        }

        .header:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 25%;
            width: 50%;
            height: 3px;
            background: linear-gradient(to right, #4a90e2, #64b5f6, #4a90e2);
        }

        .main-title {
            font-size: 24px;
            color: #2c3e50;
            margin: 0 0 3px 0;
            /* text-transform: uppercase; */
            letter-spacing: 1px;
        }

        .sub-title {
            font-size: 16px;
            color: #666;
            margin: 5px 0;
            text-align: left;
        }
    </style>

    {{-- <div style="text-align: center;"><h3>Laporan Data SPP</h3></div> --}}
    <div class="header">
        <h1 class="main-title">Pemerintah Provinsi Bali</h1>
        <h1 class="main-title">SD Cipta Dharma</h1>
        <h1 class="main-title">Laporan Data SPP</h1>        
        <p class="sub-title">
            @php
                $periode = '';
                if ($filtertahun && $filterbulan) {
                    $periode .= $filterbulan . ' ' . $filtertahun;
                } elseif ($filtertahun) {
                    $periode .= $filtertahun;
                } else {
                    $periode .= '-';
                }   
            @endphp
            Periode: {{ $periode }}
        </p>
    </div>

    <table class="table table-light">
        <thead class="thead-light">
            <tr>
                <th>No</th>
                <th>No Invoice</th>
                <th>NIS</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Bulan</th>
                <th>Tahun</th>
                <th>Total Bayar</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($laporan_spp as $index => $spp)
                <tr>
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $spp->no_invoice ?? '-' }}</td>
                        <td>{{ $spp->siswa->nis  ?? '-'}}</td>
                        <td>{{ $spp->siswa->nama  ?? '-'}}</td>
                        <td>{{ $spp->siswa->kelas  ?? '-'}}</td>
                        <td>{{ $spp->bulan  ?? '-'}}</td>
                        <td>{{ $spp->tahun  ?? '-' }}</td>
                        <td>{{ 'Rp. ' . number_format($spp->biaya->nominal, 0, ',', '.') }}</td>
                    </tr>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>

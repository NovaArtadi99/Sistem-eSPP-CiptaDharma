{{-- <!DOCTYPE html>
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
                <th>Nama Pegawai</th>
                <th>NIP</th>
                <th>Jabatan</th>
                <th>SPP Terbit</th>
                <th>SPP Dilunasi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($laporan_petugas as $index => $petugas)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $petugas->nama }}</td>
                    <td>{{ $petugas->nip ?? '-' }}</td>
                    <td>
                        <ul>
                            @foreach ($petugas->roles as $role)
                                <li>{{ $role->name }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td><b>{{ $petugas->menerbitkan_count }}</b></td>
                    <td><b>{{ $petugas->melunasi_count ?? '-' }}</b></td>
                </tr>
            @endforeach


        </tbody>
    </table>

</body>

</html> --}}

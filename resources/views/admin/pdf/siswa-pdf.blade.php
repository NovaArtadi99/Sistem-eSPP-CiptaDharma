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

    <table class="table table-light" >
        <thead class="thead-light">
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>NIS</th>
                <th>NISN</th>
                <th>Email</th>
                <th>Nama Wali</th>
                <th>Alamat</th>
                <th>No Telfon</th>
                {{-- <th>Angkatan</th>
                <th>Kelas</th>
                <th>Jenis Kelamin</th> --}}
            </tr>
        </thead>
        <tbody>
            @foreach ($siswas as $index => $siswa)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $siswa->nama }}</td>
                    <td>{{ $siswa->nis }}</td>
                    <td>{{ $siswa->nisn }}</td>
                    <td>{{ $siswa->email }}</td>
                    <td>{{ $siswa->nama_wali }}</td>
                    <td>{{ $siswa->alamat }}</td>
                    <td>{{ $siswa->no_telp }}</td>
                    {{-- <td>{{ $siswa->angkatan }}</td>
                    <td>{{ $siswa->kelas }}</td>
                    <td>{{ $siswa->jenis_kelamin }}</td> --}}
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>

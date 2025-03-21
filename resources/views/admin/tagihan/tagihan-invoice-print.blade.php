<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <title>Invoice</title>
</head>

<body>
    <style>
        {!! file_get_contents($bootstrap) !!}


        body {
            background-color: #EAEFF2;
            color: #254B4C;
            font-weight: 700;
        }

        table tr,
        td,
        th {
            color: #205345 !important;

        }

        /* #container-judul {
            padding: 10vh 0;
        } */

        table,
        tbody,
        tr,
        td {
            background-color: #EAEFF2 !important;
        }

        #logo {

            color: white;
            width: 25%;
            min-height: 10vh;
            background: #254B4C;
        }

        #table-content thead,
        th {
            background: #254B4C !important;
            color: white !important;

        }

        .table-identitas td {
            padding: unset !important;
        }
    </style>
    <div class="container-fluid">
        <div class="row mb-5">
            <div class="col-3 d-flex">
                <div id="logo" class="text-center">
                    <div class="mt-5">
                        Logo sekolah
                    </div>
                </div>


            </div>

            <div class="col-6">
                <div class="ms-5 mt-4">
                    <h1>Cipta Dharma</h1>
                    <h2>Alamat Sekolah</h2>
                </div>
            </div>



            <div class="col-3">
                <h1 class="font-weight-bold">KWITANSI</h1>
            </div>
        </div>


        <div class="row mb-5">
            <div class="col-4">
                <table class="table table-borderless table-identitas" style="padding: unset !important">
                    <tbody>
                        <tr>
                            <td>Nama Wali</td>
                            <td>:Nama Wali Murid</td>
                        </tr>
                        <tr>
                            <td>Nama Murid</td>
                            <td>:Nama Murid</td>
                        </tr>
                        <tr>
                            <td>Kelas</td>
                            <td>:Kelas</td>
                        </tr>
                        <tr>
                            <td>Semester</td>
                            <td>:Semester Murid</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="col-4">

            </div>
            <div class="col-4">
                <table class="table table-borderless table-identitas">
                    <tbody>
                        <tr>
                            <td>Nama Wali</td>
                            <td>:Nama Wali Murid</td>
                        </tr>
                        <tr>
                            <td>Nama Murid</td>
                            <td>:Nama Murid</td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>


        <div class="row">
            <div class="col-12 m">
                <table class="table table-bordered border border-2 border-dark text-center" id="table-content">
                    <tbody>
                        <thead class="text-light">
                            <th style="width: 50px;">No</th>
                            <th>Keterangan</th>
                            <th>Jumlah</th>
                        </thead>
                        <tr>
                            <td>1</td>
                            <td>Keterangan</td>
                            <td>150000</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-end">Total</td>
                            <td>150000</td>
                        </tr>
                    </tbody>
                </table>


                <h5 class="mt-5">Terbilang : Seratur lima puluh ribu rupiah </h5>



            </div>
            <div class="col-6 text-center mt-5">
                <h5>Petugas</h5>
                <br>
                <br>
                <br>
                <h5>Nama Petugas</h5>
            </div>
            <div class="col-6 text-center mt-5">
                <h5>Bali, 6 September 2024 <br>
                    Mengetahui</h5>
                <br>
                <br>
                <br>
                <h5>Nama Kepsek <br>
                    NIP.123456</h5>
            </div>
        </div>


    </div>

</body>

</html>

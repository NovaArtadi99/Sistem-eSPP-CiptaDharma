@extends('admin.admin-layout')
@section('content')
    <div class="row">

        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6">
            <div class="card text-white bg-primary mb-3" style="">
                <div class="card-header">Total Siswa</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $total_siswa }}</h5>

                    <a href="{{ route('siswa.index') }}" class="btn btn-sm btn-dark mt-3">Halaman Siswa</a>
                </div>


            </div>

        </div>

        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6">
            <div class="card text-white bg-success mb-3" style="">
                <div class="card-header">Total Petugas</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $total_petugas }}</h5>
                    <a href="{{ route('petugas.index') }}" class="btn btn-sm btn-dark mt-3">Halaman Petugas</a>

                </div>
            </div>
        </div>

        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6">
            <div class="card text-dark bg-light mb-3" style="">
                <div class="card-header">Total Laki-laki</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $total_laki }}</h5>
                    <a href="{{ route('siswa.index') }}" class="btn btn-sm btn-dark mt-3">Halaman Siswa</a>

                </div>
            </div>
        </div>

        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6">
            <div class="card text-white bg-warning mb-3" style="">
                <div class="card-header">Total Perempuan</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $total_perempuan }}</h5>
                    <a href="{{ route('siswa.index') }}" class="btn btn-sm btn-dark mt-3">Halaman Siswa</a>

                </div>
            </div>
        </div>




    </div>


    <div class="row mt-3">
        <div class="col-xl-4">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-area me-1"></i>
                    Statistik Per Jenis Kelamin
                </div>
                <div class="card-body  mb-5">
                    <canvas id="jenisKelaminChart" width="100%" height="100"></canvas>
                </div>
            </div>
        </div>

        <div class="col-xl-8">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <div class="py-2">
                            <i class="fas fa-chart-area me-1"></i>
                            Statistik Per Bulan
                        </div>

                    </div>

                </div>
                <div class="card-body mb-5" style="height: 400">
                    <div class="row mb-3">
                        <div class="col-2">
                            <select name="tahun" id="filter_tahun" class="form-control">
                                <option value="">Pilih Tahun </option>
                                @foreach ($select_tahun as $tahun)
                                    <option value="{{ $tahun }}">{{ $tahun }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-2">
                            <select name="bulan_awal" id="filter_bulan_awal" class="form-control">
                                <option value="">Pilih Bulan </option>
                                @foreach (range(1, 12) as $bulan)
                                    <option value="{{ $bulan }}">
                                        {{ DateTime::createFromFormat('!m', $bulan)->format('F') }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-2">
                            <select name="bulan_akhir" id="filter_bulan_akhir" class="form-control">
                                <option value="">Pilih Bulan </option>
                                @foreach (range(1, 12) as $bulan)
                                    <option value="{{ $bulan }}">
                                        {{ DateTime::createFromFormat('!m', $bulan)->format('F') }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-3">
                            <button class="btn btn-primary" id="btnFilterBulan">Filter</button>
                        </div>
                    </div>

                    <canvas id="dataPerBulan"></canvas>
                </div>
            </div>
        </div>

        <div class="col-xl-12">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <div class="py-2">
                            <i class="fas fa-chart-area me-1"></i>
                            Statistik Per Tahun
                        </div>

                    </div>

                </div>
                <div class="card-body mb-5" style="min-height: 400px">
                    <div class="row mb-3">
                        <div class="col-4">
                            <select name="tahun" id="filter_tahun_awal" class="form-control">
                                <option value="">Pilih Tahun </option>
                                @foreach ($select_tahun as $tahun)
                                    <option value="{{ $tahun }}">{{ $tahun }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-4">
                            <select name="tahun" id="filter_tahun_akhir" class="form-control">
                                <option value="">Pilih Tahun </option>

                                @foreach ($select_tahun as $tahun)
                                    <option value="{{ $tahun }}">{{ $tahun }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-4">
                            <button class="btn btn-primary" id="btnFilterTahun">Filter</button>
                        </div>
                    </div>

                    <canvas id="dataPerTahun"></canvas>
                </div>
            </div>
        </div>

    </div>
    @if (session()->has('loginSuccess'))
    @include('admin.partials.loginberhasil')
@endif

@endsection


@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

    <script>
        const ctxJenisKelamin = document.getElementById('jenisKelaminChart').getContext('2d');
        const jenisKelaminChart = new Chart(ctxJenisKelamin, {
            type: 'pie',
            data: {
                labels: [
                    @foreach ($data_perJenisKelamin as $item)
                        '{{ $item['jenis_kelamin'] }}',
                    @endforeach
                ],
                datasets: [{
                    label: 'Jumlah Siswa ',
                    data: [
                        @foreach ($data_perJenisKelamin as $item)
                            {{ $item['total'] }},
                        @endforeach
                    ],
                    backgroundColor: [
                        @foreach ($data_perJenisKelamin as $item)
                            '{{ $item['jenis_kelamin'] == 'Laki-laki' ? 'rgba(54, 162, 235, 0.2)' : 'rgba(255, 99, 132, 0.2)' }}',
                        @endforeach
                    ],
                    borderColor: [
                        @foreach ($data_perJenisKelamin as $item)
                            '{{ $item['jenis_kelamin'] == 'Laki-laki' ? 'rgba(54, 162, 235, 1)' : 'rgba(255, 99, 132, 1)' }}',
                        @endforeach
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });





        var ctxTahunan = document.getElementById("dataPerTahun");
        var perTahunLineChart = new Chart(ctxTahunan, {
            type: 'line',
            data: {
                labels: [
                    @foreach ($data_pembayaranPerTahun as $index => $item)
                        '{{ $index }}',
                    @endforeach
                ],
                datasets: [{
                    label: "Jumlah",
                    lineTension: 0.3,
                    backgroundColor: "rgba(2,117,216,0.2)",
                    borderColor: "rgba(2,117,216,1)",
                    pointRadius: 5,
                    pointBackgroundColor: "rgba(2,117,216,1)",
                    pointBorderColor: "rgba(255,255,255,0.8)",
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(2,117,216,1)",
                    pointHitRadius: 50,
                    pointBorderWidth: 2,
                    data: [
                        @foreach ($data_pembayaranPerTahun as $item)
                            '{{ $item }}',
                        @endforeach
                    ],
                }],
            },
            options: {
                scales: {
                    xAxes: [{
                        time: {
                            unit: 'date'
                        },
                        gridLines: {
                            display: false
                        },
                        ticks: {
                            maxTicksLimit: 7
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            min: 0,
                            maxTicksLimit: 5
                        },
                        gridLines: {
                            color: "rgba(0, 0, 0, .125)",
                        }
                    }],
                },
                legend: {
                    display: false
                }
            }
        });


        var ctxBulanan = document.getElementById("dataPerBulan");
        var perbulanLineChart = new Chart(ctxBulanan, {
            type: 'line',
            data: {
                labels: [
                    @foreach ($data_pembayaranPerBulan as $index => $item)
                        '{{ $index }}',
                    @endforeach
                ],
                datasets: [{
                    label: "Rp",
                    lineTension: 0.3,
                    backgroundColor: "rgba(255,205,86,0.2)",
                    borderColor: "rgba(255,205,86,1)",
                    pointRadius: 5,
                    pointBackgroundColor: "rgba(255,205,86,1)",
                    pointBorderColor: "rgba(255,255,255,0.8)",
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(255,205,86,1)",
                    pointHitRadius: 50,
                    pointBorderWidth: 2,
                    data: [
                        @foreach ($data_pembayaranPerBulan as $item)
                            '{{ $item }}',
                        @endforeach
                    ],
                }],
            },
            options: {
                scales: {
                    xAxes: [{
                        time: {
                            unit: 'date'
                        },
                        gridLines: {
                            display: false
                        },
                    }],
                    yAxes: [{
                        ticks: {
                            min: 0,
                            maxTicksLimit: 5
                        },
                        gridLines: {
                            color: "rgba(0, 0, 0, .125)",
                        }
                    }],
                },
                legend: {
                    display: false
                }
            }
        });


        $('#btnFilterTahun').click(function(e) {
            e.preventDefault();

            var filter_tahun_akhir = $('#filter_tahun_akhir').val();
            var filter_tahun_awal = $('#filter_tahun_awal').val();
            $.ajax({
                type: "POST",
                url: "filter-dashboard",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "filter_tahun_akhir": filter_tahun_akhir,
                    "filter_tahun_awal": filter_tahun_awal,
                },
                dataType: "json",
                success: function(response) {
                    console.log(response);
                    updateYearlyChart(response);
                }
            });
        });



        $('#btnFilterBulan').click(function(e) {
            e.preventDefault();

            var filter_tahun = $('#filter_tahun').val();
            var filter_bulan_awal = $('#filter_bulan_awal').val();
            var filter_bulan_akhir = $('#filter_bulan_akhir').val();
            $.ajax({
                type: "POST",
                url: "filter-dashboard",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "filter_tahun": filter_tahun,
                    "filter_bulan_awal": filter_bulan_awal,
                    "filter_bulan_akhir": filter_bulan_akhir,
                },
                dataType: "json",
                success: function(response) {
                    console.log(response);
                    updateMonthlyChart(response);
                }
            });
        });



        function updateYearlyChart(data) {
            var labels = Object.keys(data);
            var dataSets = Object.values(data);

            if (window.perTahunLineChart) {
                // Update data jika chart sudah ada
                window.perTahunLineChart.data.labels = labels;
                window.perTahunLineChart.data.datasets[0].data = dataSets;
                window.perTahunLineChart.update();
            } else {
                // Buat chart baru jika belum ada
                var ctxTahunan = document.getElementById("dataPerTahun").getContext('2d');
                window.perTahunLineChart = new Chart(ctxTahunan, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: "Jumlah Pembayaran",
                            lineTension: 0.3,
                            backgroundColor: "rgba(54, 162, 235, 0.2)", // Sesuai dengan bar chart
                            borderColor: "rgba(54, 162, 235, 1)",
                            pointRadius: 5,
                            pointBackgroundColor: "rgba(54, 162, 235, 1)",
                            pointBorderColor: "rgba(255,255,255,0.8)",
                            pointHoverRadius: 7,
                            pointHoverBackgroundColor: "rgba(54, 162, 235, 1)",
                            pointHitRadius: 50,
                            pointBorderWidth: 2,
                            data: dataSets
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'bottom'
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    maxTicksLimit: 7
                                }
                            },
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    maxTicksLimit: 5
                                },
                                grid: {
                                    color: "rgba(0, 0, 0, .125)"
                                }
                            }
                        }
                    }
                });
            }
        }



        function updateMonthlyChart(data) {
            var labels = Object.keys(data);
            var dataSets = Object.values(data);

            if (window.perbulanLineChart) {
                // Update data jika chart sudah ada
                window.perbulanLineChart.data.labels = labels;
                window.perbulanLineChart.data.datasets[0].data = dataSets;
                window.perbulanLineChart.update();
            } else {
                // Buat chart baru jika belum ada
                var ctxBulanan = document.getElementById("dataPerBulan").getContext('2d');
                window.perbulanLineChart = new Chart(ctxBulanan, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: "Jumlah Pembayaran",
                            lineTension: 0.3,
                            backgroundColor: "rgba(54, 162, 235, 0.2)", // Sesuai dengan bar chart
                            borderColor: "rgba(54, 162, 235, 1)",
                            pointRadius: 5,
                            pointBackgroundColor: "rgba(54, 162, 235, 1)",
                            pointBorderColor: "rgba(255,255,255,0.8)",
                            pointHoverRadius: 7,
                            pointHoverBackgroundColor: "rgba(54, 162, 235, 1)",
                            pointHitRadius: 50,
                            pointBorderWidth: 2,
                            data: dataSets
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'bottom'
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    maxTicksLimit: 7
                                }
                            },
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    maxTicksLimit: 5
                                },
                                grid: {
                                    color: "rgba(0, 0, 0, .125)"
                                }
                            }
                        }
                    }
                });
            }
        }

    </script>
@endpush

@extends('index')

@section('title', 'Forecasting - Admin Dashboard')

@section('css')
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        .modal-dialog {
            max-width: 50%;
        }
    </style>
@endsection

@section('content')
    @include('partials.sidebar')
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Forecasting</h3>
                    <br>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Forecasting</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <form action="{{ route('tmforecasting') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="form-group">
                                    <select class="choices form-select" name="chooseItem" id="chooseItem">
                                        <option value="" selected disabled>-- Pilih Peramalan --</option>
                                        <option value="rawat_inap"
                                            {{ (old('chooseItem') ?? ($selectedItem ?? '')) == 'rawat_inap' ? 'selected' : '' }}>
                                            Rawat Inap</option>
                                        <option value="rawat_jalan"
                                            {{ (old('chooseItem') ?? ($selectedItem ?? '')) == 'rawat_jalan' ? 'selected' : '' }}>
                                            Rawat Jalan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="form-group">
                                    <select name="chooseYear" id="chooseYear" class="choices form-select">
                                        <option value="">-- Pilih Tahun --</option>
                                        @foreach ($years as $y)
                                            <option value="{{ $y->tahun }}"
                                                {{ (old('chooseYear') ?? ($selectedYear ?? '')) == $y->tahun ? 'selected' : '' }}>
                                                {{ $y->tahun }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 mt-2">
                                <div class="form-group">
                                    <select class="choices form-select" name="forecast_period" id="forecast_period"
                                        required>
                                        <option value="" disabled
                                            {{ old('forecast_period', $forecastPeriod ?? '') == '' ? 'selected' : '' }}>
                                            -- Pilih Durasi Peramalan --
                                        </option>
                                        <option value="12"
                                            {{ old('forecast_period', $forecastPeriod ?? '') == '12' ? 'selected' : '' }}>
                                            12 Bulan
                                        </option>
                                        <option value="6"
                                            {{ old('forecast_period', $forecastPeriod ?? '') == '6' ? 'selected' : '' }}>
                                            6 Bulan
                                        </option>
                                        <option value="3"
                                            {{ old('forecast_period', $forecastPeriod ?? '') == '3' ? 'selected' : '' }}>
                                            3 Bulan
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mb-2 mt-2" id="btn-forecast">Proses</button>
                        <button type="button" id="lihatGrafikBtn" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#grafikModal">
                            Lihat Grafik
                        </button>
                    </form>
                </div>
                <div class="card-body">
                    <br>
                    <div class="table-responsive" style="margin-top: -40px">
                        <table class="table table-striped table-hover mb-0">
                            <thead>
                                <tr align="center">
                                    <th>Jenis Peramalan</th>
                                    <th>Tanggal</th>
                                    <th>Nilai Aktual Tahun yang Diramal</th>
                                    <th>Nilai Forecasting</th>
                                    {{-- <th>Status Tren<br>
                                        <small
                                            style="font-size: 70%; font-weight: normal; font-style: italic; color: #666;">
                                            *perbandingan dengan tahun sebelumnya
                                        </small>
                                    </th> --}}
                                </tr>
                            </thead>
                            <tbody align="center">
                                @if (isset($newDate) && isset($y))
                                    @foreach ($newDate as $index => $date)
                                        <tr>
                                            <td>{{ $itemName }}</td>
                                            <td>{{ $date }}</td>
                                            @if (isset($actualY[$index]))
                                                <td>{{ $actualY[$index] }}</td>
                                            @else
                                                <td><em>Belum Ada</em></td>
                                            @endif
                                            <td>{{ $roundedY[$index] }}</td>
                                            {{-- <td>{{ $trendStatus[$index] ?? '-' }}</td> --}}
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" class="text-center">Silakan pilih tahun dan jenis rawat untuk
                                            memulai peramalan.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        <div class="mt-5 ms-4">
                            <p style="text-align: center">
                                @if (isset($mape) && $mape !== null)
                                    @if (is_numeric($mape))
                                        Berdasarkan hasil perhitungan metode, diperoleh nilai MAPE
                                        rata-rata sebesar <strong>{{ round($mape, 2) }}%</strong>, Nilai ini menunjukkan
                                        bahwa tingkat akurasi
                                        <strong>
                                            @if ($mape <= 10)
                                                Sangat Akurat
                                            @elseif ($mape <= 20)
                                                Akurat
                                            @elseif ($mape <= 50)
                                                Cukup Akurat
                                            @else
                                                Tidak Akurat
                                            @endif
                                        </strong>
                                    @else
                                        <em>*{{ $mape }}</em>
                                    @endif
                                @else
                                    <em>Data Aktual Belum Tersedia untuk perhitungan MAPE</em>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="modal fade" id="grafikModal" tabindex="-1" aria-labelledby="grafikModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="grafikModalLabel">Grafik Perbandingan Nilai Actual dan Nilai Forecasting
                        {{ $year ?? '—' }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="chart"></div>
                </div>
                <p style="font-size: 90%; color: #555; text-align: center">
                    @if (!empty($isActualAvailable) && $isActualAvailable)
                        @isset($monthMaxIncrease, $maxIncreaseValue, $percentIncrease)
                            <em>*Kenaikan jumlah pasien paling banyak terjadi pada bulan</em>
                            <strong>{{ $monthMaxIncrease }}</strong>
                            <strong>({{ number_format($percentIncrease, 2) }}%)</strong>
                            <br>
                        @endisset
                        @isset($monthMaxDecrease, $maxDecreaseValue, $percentDecrease)
                            <em>*Penurunan jumlah pasien paling banyak terjadi pada bulan</em>
                            <strong>{{ $monthMaxDecrease }}</strong>
                            <strong>({{ number_format($percentDecrease, 2) }}%)</strong>
                        @endisset
                    @else
                        <em>*Data aktual untuk tahun yang diramal belum tersedia</em>
                    @endif
                </p>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.44.0"></script>

        <script>
            // Data dari controller
            var newDate = @json($newDate ?? []);
            var actualY = @json($actualY ?? []);
            var roundedY = @json($roundedY ?? []);
            var prevYearData = @json($prevYearData ?? []);
            var isActualAvailable = @json($isActualAvailable ?? false);

            var seriesData = [];

            if (isActualAvailable) {
                seriesData = [{
                        name: 'Actual',
                        data: actualY
                    },
                    {
                        name: 'Forecasting',
                        data: roundedY
                    }
                ];
            } else {
                seriesData = [{
                    name: 'Forecasting',
                    data: roundedY
                }];
            }

            var options = {
                chart: {
                    height: 350,
                    type: 'bar'
                },
                colors: isActualAvailable ? ['#2C73D2', '#A9AEB1'] : [
                    '#A9AEB1'
                ], // Kalau actual gak ada, pakai warna forecasting saja
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth'
                },
                series: seriesData,
                xaxis: {
                    categories: newDate,
                },
                tooltip: {
                    x: {
                        format: 'dd/MM/yy HH:mm'
                    },
                },
            };

            var chart;

            // Render grafik hanya saat modal ditampilkan
            var modal = document.getElementById('grafikModal');
            modal.addEventListener('shown.bs.modal', function() {
                if (chart) chart.destroy(); // Hancurkan grafik sebelumnya jika ada
                chart = new ApexCharts(document.querySelector("#chart"), options);
                chart.render();
            });
        </script>

        <script>
            document.getElementById('chooseItem').addEventListener('change', function() {
                var item = this.value;
                var yearDropdown = document.getElementById('chooseYear');
                yearDropdown.innerHTML = '<option value="">Pilih Tahun</option>';

                if (item) {
                    fetch(`/get-years/${item}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.years.length > 0) {
                                // Ambil tahun-tahun yang >= 2021
                                const validYears = data.years
                                    .map(year => year.tahun)
                                    .filter(t => t >= 2021);

                                // Tambahkan tahun-tahun tersebut ke dropdown
                                validYears.forEach(year => {
                                    var option = document.createElement('option');
                                    option.value = year;
                                    option.textContent = year;
                                    yearDropdown.appendChild(option);
                                });

                                // Cari tahun maksimum dan tambahkan +1 jika belum ada di daftar
                                const maxYear = Math.max(...validYears);
                                const nextYear = maxYear + 1;

                                // Cek agar tidak duplikat
                                if (!validYears.includes(nextYear)) {
                                    var nextOption = document.createElement('option');
                                    nextOption.value = nextYear;
                                    nextOption.textContent = nextYear;
                                    yearDropdown.appendChild(nextOption);
                                }
                            }
                        });
                }
            });
        </script>
    @endpush

@endsection

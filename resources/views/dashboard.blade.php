@extends('index')

@section('title', 'Admin Dashboard')

@section('css')
    <style>
        .row,
        .card {
            margin: 0;
            padding: 0;
        }
    </style>
@endsection

@section('content')
    <div class="page-heading">
        <h3>Dashboard</h3>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
                <div class="row">
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-1 py-4">
                                <div class="row align-items-center">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-center"
                                        style="padding-right: 0;">
                                        <div class="stats-icon red mb-2">
                                            <i class="iconly-boldShow"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7"
                                        style="padding-left: 5px; padding-bottom: 5px">
                                        <h6 class="text-muted font-semibold mb-0">
                                            Rawat Inap {{ $yearInap }}
                                        </h6>
                                        <h6 class="font-extrabold mb-0">
                                            {{ number_format($totalInap) }}
                                            <span style="color: {{ $growthInap < 0 ? 'red' : 'green' }};">
                                                ({{ number_format($growthInap, 2) }}%)
                                            </span>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-1 py-4">
                                <div class="row align-items-center">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-center"
                                        style="padding-right: 0;">
                                        <div class="stats-icon blue mb-2">
                                            <i class="iconly-boldProfile"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7"
                                        style="padding-left: 2px; padding-bottom: 5px">
                                        <h6 class="text-muted font-semibold mb-0">
                                            Rawat Jalan {{ $yearJalan }}
                                        </h6>
                                        <h6 class="font-extrabold mb-0">
                                            {{ number_format($totalJalan) }}
                                            <span style="color: {{ $growthJalan < 0 ? 'red' : 'green' }};">
                                                ({{ number_format($growthJalan, 2) }}%)
                                            </span>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-1 py-4">
                                <div class="row align-items-center">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-center"
                                        style="padding-right: 0;">
                                        <div class="stats-icon green mb-2">
                                            <i class="iconly-boldHeart"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7"
                                        style="padding-left: 2px; padding-bottom: 5px">
                                        <h6 class="text-muted font-semibold mb-0">
                                            -
                                        </h6>
                                        <h6 class="font-extrabold mb-0">
                                            -
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body px-1 py-4">
                                <div class="row align-items-center">
                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-center"
                                        style="padding-right: 0;">
                                        <div class="stats-icon purple mb-2">
                                            <i class="iconly-boldActivity"></i>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7"
                                        style="padding-left: 2px; padding-bottom: 5px">
                                        <h6 class="text-muted font-semibold mb-0">
                                            -
                                        </h6>
                                        <h6 class="font-extrabold mb-0">
                                            -
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card" style="margin-top: 30px">
                                <div class="card-header">
                                    <h4>Grafik Jumlah Pasien Terbaru</h4>
                                </div>
                                <div class="card-body">
                                    <div id="chart-tahunan" style="overflow: hidden;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
        </section>
    </div>
    </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var options = {
                chart: {
                    type: 'bar',
                    height: 350,
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '80%',
                        borderRadius: 3,
                        borderRadiusApplication: 'end'
                    },
                },
                series: [{
                        name: 'Rawat Inap {{ $yearInap }}',
                        data: @json($dataInap)
                    },
                    {
                        name: 'Rawat Jalan {{ $yearJalan }}',
                        data: @json($dataJalan)
                    }
                ],
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov',
                        'Des'
                    ]
                },
                colors: ['#2C73D2', '#A9AEB1'],
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                fill: {
                    opacity: 1
                },
            };

            var chart = new ApexCharts(document.querySelector("#chart-tahunan"), options);
            chart.render();
        });
    </script>
@endpush

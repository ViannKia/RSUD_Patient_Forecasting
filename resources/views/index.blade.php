<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard')</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="./assets/compiled/svg/favicon.svg" type="image/x-icon">
    <link rel="shortcut icon" href="data:image/png;base64,...(panjang, tidak perlu potong)...=" type="image/png">
    <link rel="stylesheet" crossorigin="" href="./assets/compiled/css/iconly.css">
    <link rel="stylesheet" href="./assets/compiled/css/app.css" media="(prefers-color-scheme: light)">
    <link rel="stylesheet" href="./assets/compiled/css/app-dark.css" media="(prefers-color-scheme: dark)">
    <link href="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" rel="stylesheet" />
    <link rel="stylesheet" crossorigin href="./assets/compiled/css/app.css">

    <style>
        .modal-backdrop {
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(100px);
            background-color: rgba(0, 0, 0, 0.1);
        }

        .modal-dialog {
            max-width: 500px;
            margin: 10% auto;
            bottom: 30px;
        }

        #tabelInap th,
        #tabelInap td {
            text-align: center !important;
            vertical-align: middle !important;
            padding: 12px !important;
        }

        #tabelJalan th,
        #tabelJalan td {
            text-align: center !important;
            vertical-align: middle !important;
            padding: 12px !important;
        }

        #tabelInap {
            width: 100% !important;
            table-layout: fixed;
        }

        #tabelInap th {
            white-space: nowrap;
        }

        .dataTables_paginate .pagination li {
            margin: 0 4px;
        }

        #excelDropzone {
            border: none !important;
            box-shadow: none !important;
            background: #f8f9fa;
            padding: 30px;
            text-align: center;
            border-radius: 10px;
        }
    </style>
    @yield('css')
    @stack('css')
</head>

<body>
    <div id="app">
        @include('partials.sidebar')

        <div id="main">
            @yield('content')
        </div>
    </div>
</body>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
{{-- <script src="{{ asset('assets/extensions/bootstrap/js/bootstrap.bundle.min.js') }}"></script> --}}
<script src="assets/static/js/components/dark.js"></script>
<script src="assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="assets/compiled/js/app.js"></script>
<script src="assets/extensions/apexcharts/apexcharts.min.js"></script>
<script src="assets/static/js/pages/dashboard.js"></script>
<script src="{{ asset('assets/compiled/js/app.js') }}"></script>

<script>
    // Nonaktifkan dark theme
    document.getElementById('dark-theme').disabled = true;
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if ($errors->any() && old('_from') === 'inap')
            var myModalInap = new bootstrap.Modal(document.getElementById('modalinap'));
            myModalInap.show();
        @endif

        @if ($errors->any() && old('_from') === 'jalan')
            var myModalJalan = new bootstrap.Modal(document.getElementById('modaljalan'));
            myModalJalan.show();
        @endif

        @if ($errors->any() && old('_from') === 'updateinap')
            var myModalUpdate = new bootstrap.Modal(document.getElementById('modalinapupdate'));
            myModalUpdate.show();
        @endif

        @if ($errors->any() && old('_from') === 'updatejalan')
            var myModalJalan = new bootstrap.Modal(document.getElementById('modaljalanupdate'));
            myModalJalan.show();
        @endif
    });
</script>

@stack('scripts')

</html>

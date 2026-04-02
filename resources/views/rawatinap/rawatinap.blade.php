@extends('index')

@section('title', 'Rawat Inap - Admin Dashboard')

@section('css')
@endsection

@section('content')
    @include('partials.sidebar')
        {{-- <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header> --}}

        <div class="page-heading">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>Rawat Inap</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Rawat Inap</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <section class="section">
                <div class="card"  style="margin-top: 25px">
                    <div class="card-header">
                        <h4 class="card-title" style="margin-top: 8px;">Data Rawat Inap</h4>
                    </div>
                    <div class="card-body">
                        <div class="button-group">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#modalinap">Tambah Data</button>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#modalimportInap">Import Data</button>
                        </div>
                        <br>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0" id="tabelInap">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tahun</th>
                                        <th>Bulan</th>
                                        <th>Jumlah Pasien</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data_inap as $inap)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $inap->tahun }}</td>
                                            <td>{{ $inap->bulan }}</td>
                                            <td>{{ $inap->jumlah_inap }}</td>
                                            <td>
                                                <a href="#" class="btn icon btn-primary editBtn"
                                                    data-id="{{ $inap->id }}" data-tahun="{{ $inap->tahun }}"
                                                    data-bulan="{{ $inap->bulan }}" data-jumlah="{{ $inap->jumlah_inap }}"
                                                    data-bs-toggle="modal" data-bs-target="#modalinapupdate">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <a href="/rawatinap/hapus/{{ $inap->id }}"
                                                    class="btn icon btn-danger"><i class="bi bi-x"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    @include('modals-inap.tambah-inap')
    @include('modals-inap.update-inap')
    @include('modals-inap.import-inap')

    @push('scripts')
        <script>
            $('#tabelInap').DataTable({
                language: {
                    lengthMenu: "Show _MENU_ entries per page",
                    zeroRecords: "No matching records found",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "Showing 0 to 0 of 0 entries",
                    search: "Search:",
                    paginate: {
                        first: "First",
                        last: "Last",
                        next: ">",
                        previous: "<"
                    }
                }
            });

            $(document).on('click', '.editBtn', function() {
                const id = $(this).data('id');
                const tahun = $(this).data('tahun');
                const bulan = $(this).data('bulan');
                const jumlah = $(this).data('jumlah');

                $('#updateTahun').val(tahun);
                $('#updateBulan').val(bulan);
                $('#updateJumlah').val(jumlah);
                $('#updateForm').attr('action', `/rawatinap/update/${id}`);
            });

            Dropzone.autoDiscover = false;

            const dropzoneInstance = new Dropzone("#excelDropzone", {
                url: "{{ url('/rawatinap/import') }}",
                paramName: "file",
                maxFilesize: 2,
                acceptedFiles: ".xlsx,.xls,.csv",
                addRemoveLinks: true,
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
            });
        </script>
    @endpush
@endsection

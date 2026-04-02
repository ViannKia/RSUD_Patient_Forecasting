@extends('index')

@section('title', 'Pengguna - ' . (Auth::user()->role == 'admin' ? 'Admin Dashboard' : 'User Dashboard'))

@section('css')
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
                    <h3>Pengguna</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Pengguna</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card" style="margin-top: 25px">
                <div class="card-header">
                    <h4 class="card-title" style="margin-top: 8px;">Daftar Pengguna</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0 text-center" id="tabelPengguna">
                            <thead class="text-center">
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Nama Pengguna</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Role</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $index => $user)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $user->nama }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ ucfirst($user->role) }}</td>
                                        <td>
                                            @if (Cache::has('user-is-online-' . $user->id))
                                                <span class="badge bg-success">Online</span>
                                            @else
                                                <span class="badge bg-secondary">Offline</span>
                                            @endif
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

    @push('scripts')
        <script>
            $('#tabelPengguna').DataTable({
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
        </script>
    @endpush
@endsection

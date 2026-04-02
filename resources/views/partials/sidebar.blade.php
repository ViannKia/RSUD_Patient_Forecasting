@push('css')
    <style>
        /* #sidebar .sidebar-wrapper {
                transform: translateX(-100%);
                position: fixed;
                top: 0;
                left: 0;
                height: 100%;
                width: 300px;
                box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
                z-index: 1050;
            } */

        #sidebar.active .sidebar-wrapper {
            transform: translateX(0) !important;
        }

        #sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-color: rgba(0, 0, 0, 0.4);
            z-index: 1040;
            display: none;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        #sidebar-overlay.active {
            display: block;
            opacity: 1;
        }
    </style>
@endpush

@php
    $user = Auth::user();
@endphp

<!-- Tombol hamburger -->
<button id="toggleSidebar" class="btn btn-outline-primary d-xl-none m-2">
    <i class="bi bi-list"></i>
</button>
<div id="sidebar">
    <div id="sidebar-overlay"></div>
    <div class="sidebar-wrapper">
        <div class="sidebar-header position-relative">
            <div class="d-flex justify-content-center align-items-center">
                <div class="page-heading" style="margin-top: 5px">
                    <h3>ForecastMed</h3>
                </div>
                <div class="theme-toggle d-flex gap-2 align-items-center mt-2">
                </div>
                <div class="sidebar-toggler x">
                    <a href="#" class="sidebar-hide d-xl-none d-block">
                        <i class="bi bi-x bi-middle"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu" style="margin-top: -50px">
            <ul class="menu">
                <li class="sidebar-title">Menu</li>

                <li class="sidebar-item {{ request()->is('dashboard') ? 'active' : '' }}">
                    <a href="{{ url('dashboard') }}" class='sidebar-link'>
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="sidebar-item {{ request()->is('rawatinap') ? 'active' : '' }}">
                    <a href="{{ url('rawatinap') }}" class='sidebar-link'>
                        <i class="bi bi-file-earmark-medical-fill"></i>
                        <span>Rawat Inap</span>
                    </a>
                </li>

                <li class="sidebar-item {{ request()->is('rawatjalan') ? 'active' : '' }}">
                    <a href="{{ url('rawatjalan') }}" class='sidebar-link'>
                        <i class="bi bi-heart-pulse"></i>
                        <span>Rawat Jalan</span>
                    </a>
                </li>

                @if ($user && $user->role === 'admin')
                    <li class="sidebar-item {{ request()->is('pengguna') ? 'active' : '' }}">
                        <a href="{{ url('pengguna') }}" class='sidebar-link'>
                            <i class="bi bi-person-lines-fill"></i>
                            <span>Pengguna</span>
                        </a>
                    </li>
                @endif

                <li class="sidebar-item {{ request()->is('forecasting') ? 'active' : '' }}">
                    <a href="{{ url('forecasting') }}" class='sidebar-link'>
                        <i class="bi bi-book-half"></i>
                        <span>Forecasting</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="{{ url('logout') }}" class="sidebar-link" id="btn-logout">
                        <i class="bi bi-door-closed-fill"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const logoutBtn = document.getElementById('btn-logout');
            if (logoutBtn) {
                logoutBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const logoutUrl = this.href;

                    Swal.fire({
                        title: 'Yakin ingin logout?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, Logout!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = logoutUrl;
                        }
                    });
                });
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggleBtn = document.getElementById('toggleSidebar');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay'); // Dapatkan overlay
            const closeBtn = document.querySelector('.sidebar-hide');

            toggleBtn.addEventListener('click', () => {
                sidebar.classList.toggle('active');
                overlay.classList.toggle('active'); // Toggle juga overlay
            });

            if (closeBtn) {
                closeBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    sidebar.classList.remove('active');
                    overlay.classList.remove('active'); // Remove juga overlay
                });
            }

            // Tambahan: ketika klik overlay juga sidebar harus tutup
            if (overlay) {
                overlay.addEventListener('click', () => {
                    sidebar.classList.remove('active');
                    overlay.classList.remove('active');
                });
            }
        });
    </script>
@endpush

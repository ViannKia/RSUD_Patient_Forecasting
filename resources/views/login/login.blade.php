<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>Login Page</title>
    <link rel="shortcut icon" href="{{ asset('assets/compiled/png/letter-s.png') }}" type="image/x-icon">

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.css') }}">

    <!-- Default -->
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/auth.css') }}">

    <style>
        #auth {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .row.h-100 {
            width: 100%;
            margin: 0;
        }

        /* Title utama - ForecastMed (DITAMBAHKAN) */
        .auth-title {
            font-size: 2.5rem !important;
            font-weight: 700 !important;
            margin-bottom: 0.5rem !important;
        }

        .auth-title a {
            text-decoration: none !important;
            color: #435ebe !important;
        }

        .auth-subtitle {
            font-size: 1rem !important;
            color: #6c757d !important;
            margin-bottom: 2rem !important;
        }

        /* Tablet (768px ke bawah) */
        @media screen and (max-width: 768px) {
            #auth {
                padding: 1rem;
            }

            #auth-left {
                padding: 1.5rem;
            }

            .auth-title {
                font-size: 2rem !important;
                /* DIUBAH */
            }

            .auth-subtitle {
                font-size: 0.95rem !important;
                /* DIUBAH */
            }

            .form-control-xl {
                font-size: 0.9rem;
                padding: 0.7rem 1rem;
            }

            .btn-block {
                padding: 0.7rem 1rem;
                font-size: 1rem;
            }
        }

        /* HP (576px ke bawah) - CUKUP INI SAJA */
        @media screen and (max-width: 576px) {
            #auth {
                padding: 1rem;
                padding-top: 4rem;
            }

            .row {
                flex-direction: column !important;
            }

            .col-lg-5,
            .col-lg-7 {
                width: 100% !important;
            }

            .auth-title,
            .auth-title a {
                font-size: 1.8rem !important;
                text-align: center !important;
            }

            .auth-subtitle {
                font-size: 0.9rem !important;
                text-align: center !important;
            }

            .form-control-xl {
                font-size: 0.85rem;
                padding: 0.6rem 1rem;
                padding-left: 2.5rem;
            }

            .btn-block {
                padding: 0.6rem 1rem;
                font-size: 0.9rem;
            }

            .col-lg-7 {
                order: 2;
                margin: 1rem 0;
            }

            .col-lg-7 img {
                width: 50% !important;
                max-width: 200px !important;
            }
        }

        /* Landscape mode HP */
        @media screen and (max-width: 768px) and (orientation: landscape) {
            .row {
                flex-direction: row !important;
            }

            .col-lg-5 {
                width: 50% !important;
            }

            .col-lg-7 {
                width: 50% !important;
            }

            .col-lg-7 img {
                width: 80% !important;
            }

            .auth-title {
                font-size: 1.5rem !important;
                /* DIUBAH */
            }
        }
    </style>
</head>

<body data-error-message="{{ session('error') }}">
    <div id="auth">
        <div class="row h-100">
            <div class="col-lg-5 col-12">
                @csrf
                <div id="auth-left">
                    <div class="logo"></div>
                    <h1 class="auth-title">
                        <a href="">ForecastMed</a>
                    </h1>
                    <p class="auth-subtitle mb-5">Log in with your data that you entered during registration.</p>
                    <form action="/login/login-proses" method="POST" enctype="multipart/form-data"
                        data-parsley-validate>
                        @csrf
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text"
                                class="form-control form-control-xl @error('email') is-invalid @enderror"
                                placeholder="Username" name="email" id="email" data-parsley-required="true"
                                autocomplete="off">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password"
                                class="form-control form-control-xl @error('password') is-invalid @enderror"
                                placeholder="Password" name="password" id="password" data-parsley-required="true">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                        </div>
                        <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5" id="btn-login">Log
                            in</button>
                        <div class="mt-4 text-center">
                            <p class="text-muted">
                                <small>Demo Account:</small><br>
                                <strong>demo@gmail.com</strong> | <strong>akundemo</strong>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-7 my-auto">
                <div class="d-flex justify-content-center">
                    <img class="img-fluid" src="{{ asset('assets/compiled/png/login1.png') }}" alt="login1.png">
                </div>
            </div>
        </div>
    </div>

    <!-- ValidationParsley -->
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/parsleyjs/parsley.min.js') }}"></script>
    <script src="{{ asset('assets/static/js/pages/parsley.js') }}"></script>
</body>

</html>

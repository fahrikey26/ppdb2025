<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PPDB 2025 - Tamsis</title>
    <link rel="icon" type="image/png" href="img/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    </script>
</head>

<body>
    <nav class="navbar navbar-expand-lg p-2 bg-body-tertiary">
        <div class="container-fluid">
            <div class="me-3">
                <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('dashboard') }}">
                    <img src="/img/logo.png" alt="Logo" width="50" height="50" class="img-fluid">
                    <span class="fs-4 fw-bold">SMK Tamansiswa 2 Jakarta</span>
                </a>
            </div>


            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">

                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-5 me-auto mb-4 mb-lg-0 align-items-center gap-3">

                    @if(Auth::user()->role == 'Admin')
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2 {{ request()->is('user/tampil') ? 'active fw-bold text-primary border-bottom border-2 border-primary' : '' }}" href="/user/tampil">
                            <i class="bi bi-person-lines-fill fs-5"></i>
                            <span>User</span>
                        </a>
                    </li>
                    @endif

                    @if(Auth::user()->role == 'Pendaftar' || Auth::user()->role == 'Petugas' || Auth::user()->role == 'Admin')
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2 {{ request()->is('pendaftar/tampil') ? 'active fw-bold text-primary border-bottom border-2 border-primary' : '' }}" href="/pendaftar/tampil">
                            <i class="bi bi-box-seam fs-5"></i>
                            <span>Pendaftar</span>
                        </a>
                    </li>
                    @endif
                    
                    @if(Auth::user()->role == 'Admin' || Auth::user()->role == 'Petugas')
                    {{-- Menu Nominasi (Semua Role) --}}
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2 {{ request()->is('pendaftar/nominasi2') ? 'active fw-bold text-primary border-bottom border-2 border-primary' : '' }}" href="/pendaftar/nominasi2">
                            <i class="bi bi-circle fs-5"></i>
                            <span>Nominasi Murid</span>
                        </a>
                    </li>
                    @endif

                    @if(Auth::user()->role == 'Admin' || Auth::user()->role == 'Petugas')
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2 {{ request()->is('pendaftar/diterima') ? 'active fw-bold text-primary border-bottom border-2 border-primary' : '' }}" href="/pendaftar/diterima">
                            <i class="bi bi-award fs-5"></i>
                            <span>Murid Diterima</span>
                        </a>
                    </li>
                    @endif

                    @if(Auth::user()->role == 'Pendaftar')
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2 {{ request()->is('pendaftar/status') ? 'active fw-bold text-primary border-bottom border-2 border-primary' : '' }}" href="/pendaftar/status">
                            <i class="bi bi-award fs-5"></i>
                            <span>Status Pendaftaran</span>
                        </a>
                    </li>
                    @endif
                </ul>


                {{-- Profil Dropdown --}}
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle fs-5 me-2"></i>
                            <b class="text-dark">{{ Auth::user()->email }}</b>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li class="dropdown-item text-muted">
                                <i class="bi bi-shield-lock-fill me-2"></i> Level: <strong>{{ Auth::user()->role }}</strong>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li class="px-3 pb-2">
                                <a href="{{ route('actionlogout') }}" class="btn btn-outline-danger w-100">
                                    <i class="bi bi-box-arrow-right"></i> Log Out
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>

        </div>
    </nav>
    <p class="p-2">@yield('konten')</p>
</body>
<script
    src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

</html>
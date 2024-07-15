<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gematen | @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>

    {{-- link --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
</head>

<style>
    .rubik-font {
        font-family: 'Rubik', sans-serif;
        font-optical-sizing: auto;
        font-weight: 400; /* Adjust the weight as needed */
        font-style: normal;
    }

    .main {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }

    .content {
        flex: 1;
    }

    .footer {
        flex-shrink: 0;
    }
</style>

<body class="rubik-font">
    <div class="main">
        <nav class="navbar navbar-dark navbar-expand-lg">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ Auth::user()->role_id == 1 || Auth::user()->role_id == 3 ? url('dashboard') : url('home') }}">Gematen</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#hamburger"
                    aria-controls="hamburger" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>
        <div class="body-content h-100 rubik-font">
            <div class="row g-0 h-100">
                <div class="sidebar card shadow col-lg-2 collapse d-lg-block" id="hamburger">
                    @php
                        $roleId = Auth::user()->role_id;
                    @endphp
                
                    @if ($roleId == 1 || $roleId == 3)
                        <a href="{{ url('dashboard') }}" class="{{ request()->route()->uri == 'dashboard' ? 'active' : '' }}">Dashboard</a>
                        <a href="{{ url('rent') }}" class="{{ request()->route()->uri == 'rent' ? 'active' : '' }}">Peminjaman</a>
                        <a href="{{ url('users') }}" class="{{ request()->route()->uri == 'users' || request()->route()->uri == 'registered-user' ? 'active' : '' }}">Pengguna</a>
                        <a href="{{ route('room') }}" class="{{ request()->route()->uri == 'room' || request()->route()->uri == 'room-add' || request()->route()->uri == 'room/edit/' || request()->route()->uri == 'room-delete' ? 'active' : '' }}">Ruang</a>
                        <a href="{{ route('item') }}" class="{{ request()->route()->uri == 'item' || request()->route()->uri == 'item-add' || request()->route()->uri == 'item-edit' || request()->route()->uri == 'item-delete' ? 'active' : '' }}">Barang</a>
                        <a href="{{ url('profile') }}" class="{{ request()->route()->uri == 'profile' ? 'active' : '' }}">Profile</a>
                        <a href="{{ url('logout') }}" class="{{ request()->route()->uri == 'logout' ? 'active' : '' }}">Keluar</a>
                    @else
                        <a href="{{ url('home') }}" class="{{ request()->route()->uri == 'home' ? 'active' : '' }}">Home</a>
                        <a href="{{ url('pinjam-ruang') }}" class="{{ request()->route()->uri == 'pinjam-ruang' ? 'active' : '' }}">Pinjam Ruang</a>
                        <a href="{{ url('keranjang') }}" class="{{ request()->route()->uri == 'keranjang' ? 'active' : '' }}">Keranjang</a>
                        <a href="{{ url('profile') }}" class="{{ request()->route()->uri == 'profile' ? 'active' : '' }}">Profile</a>
                        <a href="{{ url('logout') }}" class="{{ request()->route()->uri == 'logout' ? 'active' : '' }}">Keluar</a>
                    @endif
                </div>
                
                <div class="content p-5 col-lg-10">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    {{-- <footer class="footer bg-light py-3">
        <div class="container text-center">
            <p>&copy; 2024 Gematen. All rights reserved.</p>
        </div>
    </footer> --}}

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
        
    </script>
</body>

</html>

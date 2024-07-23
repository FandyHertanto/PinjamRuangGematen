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

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    
</head>

<script>

body {
    font-family: 'Rubik';
    background-color: #121212;
    color: #e0e0e0;
}

/* Content styling */
.content {
    flex: 1;
    padding: 20px;
    background: #1e1e1e;
    border-radius: 8px;
}

/* Responsive design adjustments */
@media only screen and (max-width: 992px) {
    .sidebar {
        width: 250px;
    }
    
    .sidebar a {
        font-size: 16px;
        padding: 15px 25px;
    }
}

@media only screen and (max-width: 768px) {
    .sidebar {
        width: 100%;
        height: auto;
        position: absolute;
        top: 56px; /* Adjust according to the height of the navbar */
        left: 0;
        z-index: 1000;
        display: none;
    }
    
    .sidebar.collapse.show {
        display: block;
    }
    
}

</script>

<body class="rubik-font">
    <div class="main">
        <nav class="navbar navbar-dark navbar-expand-lg">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ Auth::user()->role_id == 1 || Auth::user()->role_id == 3 ? url('dashboard') : url('home') }}">RUANG GEMATEN</a>
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
                        <a href="{{ url('dashboard') }}" class="{{ request()->route()->uri == 'dashboard' ? 'active' : '' }}"><i class="bi bi-house-door"></i> Dashboard</a>
                        <a href="{{ url('rent') }}" class="{{ request()->route()->uri == 'rent' ? 'active' : '' }}"><i class="bi bi-calendar"></i> Peminjaman</a>
                        <a href="{{ url('users') }}" class="{{ request()->route()->uri == 'users' || request()->route()->uri == 'registered-user' || Str::startsWith(request()->route()->uri, 'user-detail/') ? 'active' : '' }}"><i class="bi bi-people"></i> Pengguna</a>
                        <a href="{{ route('room') }}" class="{{ request()->route()->uri == 'room' || request()->route()->uri == 'room-add' || Str::startsWith(request()->route()->uri, 'room/edit/') || request()->route()->uri == 'room-delete' ? 'active' : '' }}"><i class="bi bi-door-open"></i> Ruang</a>
                        <a href="{{ route('item') }}" class="{{ request()->route()->uri == 'item' || request()->route()->uri == 'item-add' || request()->route()->uri == 'item-edit' || request()->route()->uri == 'item-delete' || Str::startsWith(request()->route()->uri, 'fasilitas-add') ? 'active' : '' }}"><i class="bi bi-box"></i> Barang</a>
                        <a href="{{ url('profile') }}" class="{{ request()->route()->uri == 'profile' || request()->route()->uri == 'profile-edit' ? 'active' : '' }}"><i class="bi bi-person"></i> Profile</a>
                        <a href="{{ url('logout') }}" class="{{ request()->route()->uri == 'logout' ? 'active' : '' }}"><i class="bi bi-box-arrow-right"></i> Keluar</a>
                    @else
                    <div class="sidebar-footer">
                        <img src="{{ asset('images/GMA-white.png') }}" alt="Logo Gematen" class="logo" width="150" height="150">
                    </div>
                        <a href="{{ url('home') }}" class="{{ request()->route()->uri == 'home' ? 'active' : (Str::startsWith(request()->route()->uri, 'detail-ruang/') ? 'active' : '') }}"><i class="bi bi-house-door"></i> Home</a>
                        <a href="{{ url('pinjam-ruang') }}" class="{{ request()->route()->uri == 'pinjam-ruang' ? 'active' : (request()->route()->uri == 'pinjam-add' ? 'active' : '') }}"><i class="bi bi-calendar"></i> Pinjam Ruang</a>
                        <a href="{{ url('keranjang') }}" class="{{ request()->route()->uri == 'keranjang' ? 'active' : '' }}"><i class="bi bi-cart"></i> Keranjang</a>
                        <a href="{{ url('profile') }}" class="{{ request()->route()->uri == 'profile' || Str::startsWith(request()->route()->uri, 'profile-edit') ? 'active' : '' }}"><i class="bi bi-person"></i> Profile</a>
                        <a href="{{ url('logout') }}" class="{{ request()->route()->uri == 'logout' ? 'active' : '' }}"><i class="bi bi-box-arrow-right"></i> Keluar</a> 
                        
                    @endif
                </div>
                
                <div class="content p-5 col-lg-10">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
</body>

</html>
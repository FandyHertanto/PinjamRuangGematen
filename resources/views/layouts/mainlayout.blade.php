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

<style>
    .rubik-font {
        font-family: 'Rubik', sans-serif;
        font-optical-sizing: auto;
        font-weight: 400;
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

    /* Default styling for all screen sizes */


/* Small devices (portrait tablets and large phones, 600px and up) */
@media only screen and (min-width: 600px) {
  .col-s-1 {width: 8.33%;}
  .col-s-2 {width: 16.66%;}
  .col-s-3 {width: 25%;}
  .col-s-4 {width: 33.33%;}
  .col-s-5 {width: 41.66%;}
  .col-s-6 {width: 50%;}
  .col-s-7 {width: 58.33%;}
  .col-s-8 {width: 66.66%;}
  .col-s-9 {width: 75%;}
  .col-s-10 {width: 83.33%;}
  .col-s-11 {width: 91.66%;}
  .col-s-12 {width: 100%;}
}

/* Medium devices (landscape tablets, 768px and up) */
@media only screen and (min-width: 768px) {
  .col-1 {width: 8.33%;}
  .col-2 {width: 16.66%;}
  .col-3 {width: 25%;}
  .col-4 {width: 33.33%;}
  .col-5 {width: 41.66%;}
  .col-6 {width: 50%;}
  .col-7 {width: 58.33%;}
  .col-8 {width: 66.66%;}
  .col-9 {width: 75%;}
  .col-10 {width: 83.33%;}
  .col-11 {width: 91.66%;}
  .col-12 {width: 100%;}
}

/* Large devices (laptops/desktops, 992px and up) */
@media only screen and (min-width: 992px) {
  .col-l-1 {width: 8.33%;}
  .col-l-2 {width: 16.66%;}
  .col-l-3 {width: 25%;}
  .col-l-4 {width: 33.33%;}
  .col-l-5 {width: 41.66%;}
  .col-l-6 {width: 50%;}
  .col-l-7 {width: 58.33%;}
  .col-l-8 {width: 66.66%;}
  .col-l-9 {width: 75%;}
  .col-l-10 {width: 83.33%;}
  .col-l-11 {width: 91.66%;}
  .col-l-12 {width: 100%;}
}


</style>

<body class="rubik-font">
    <div class="main">
        <nav class="navbar navbar-dark navbar-expand-lg">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ Auth::user()->role_id == 1 || Auth::user()->role_id == 3 ? url('dashboard') : url('home') }}">GEMATEN</a>
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
                        <a href="{{ url('users') }}" class="{{ request()->route()->uri == 'users' || request()->route()->uri == 'registered-user' || Str::startsWith(request()->route()->uri, 'user-detail/') ? 'active' : '' }}">Pengguna</a>
                        <a href="{{ route('room') }}" class="{{ request()->route()->uri == 'room' || request()->route()->uri == 'room-add' || Str::startsWith(request()->route()->uri, 'room/edit/') || request()->route()->uri == 'room-delete' ? 'active' : '' }}">Ruang</a>
                        <a href="{{ route('item') }}" class="{{ request()->route()->uri == 'item' || request()->route()->uri == 'item-add' || request()->route()->uri == 'item-edit' || request()->route()->uri == 'item-delete' || Str::startsWith(request()->route()->uri, 'fasilitas-add') ? 'active' : '' }}">Barang</a>
                        <a href="{{ url('profile') }}" class="request()->route()->uri == 'profile-edit'|| {{ request()->route()->uri == 'profile' ? 'active' : '' }}">Profile</a>
                        <a href="{{ url('logout') }}" class="{{ request()->route()->uri == 'logout' ? 'active' : '' }}">Keluar</a>
                    @else
                        <a href="{{ url('home') }}" class="{{ request()->route()->uri == 'home' ? 'active' : (Str::startsWith(request()->route()->uri, 'detail-ruang/') ? 'active' : '') }}">Home</a>
                        <a href="{{ url('pinjam-ruang') }}" class="{{ request()->route()->uri == 'pinjam-ruang' ? 'active' : (request()->route()->uri == 'pinjam-add' ? 'active' : '') }}">Pinjam Ruang</a>
                        <a href="{{ url('keranjang') }}" class="{{ request()->route()->uri == 'keranjang' ? 'active' : '' }}">Keranjang</a>
                        <a href="{{ url('profile') }}" class="{{ request()->route()->uri == 'profile' || Str::startsWith(request()->route()->uri, 'profile-edit') ? 'active' : '' }}">Profile</a>
                        <a href="{{ url('logout') }}" class="{{ request()->route()->uri == 'logout' ? 'active' : '' }}">Keluar</a>
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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gematen | @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel='stylesheet' href="{{ asset('css/style.css') }}">

</head>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type='text/javascript'>
    $function() {
        $(document).on('click', '#delete', function(e) {
            e.preventDefault();
            var link = $(this).attr('href');

            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Deleted!",
                        text: "Your file has been deleted.",
                        icon: "success"
                    });
                }
            });
        });
    }
</script>

<body>
    <div class="main">
        <nav class="navbar navbar-dark navbar-expand-lg bg-primary">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Gematen</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#hamburger"
                    aria-controls="hamburger" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>
        <div class="body-content h-100">
            <div class="row g-0 h-100">
                <div class="sidebar col-lg-2 collapse d-lg-block" id="hamburger">
                    @if (Auth::user()->role_id == 1)
                        <a href="dashboard" @if (request()->route()->uri == 'dashboard'
                            ) class='active' @endif>Dashboard</a>
                        <a href="users" @if (request()->route()->uri == 'users') class='active' @endif>Pengguna</a>
                        <a href="{{ route('room') }}" @if (request()->route()->uri == 'room' ||
                            request()->route()->uri == 'room-add' ||
                            request()->route()->uri == 'room-edit' ||
                            request()->route()->uri == 'room-delete')
                            class='active' @endif> Ruang</a>

                        <a href="{{ route('item') }}" @if (request()->route()->uri == 'item' ||
                                request()->route()->uri == 'item-add' ||
                                request()->route()->uri == 'item-edit' ||
                                request()->route()->uri == 'item-delete') class='active' @endif>Barang</a>

                        <a href="logout" @if (request()->route()->uri == 'logout') class='active' @endif>Keluar</a>
                    @else

                        <a href="home" @if (request()->route()->uri == 'home') class='active' @endif>Home</a>
                        <a href="profile" @if (request()->route()->uri == 'profile') class='active' @endif>Profile</a>
                        <a href="logout" @if (request()->route()->uri == 'logout') class='active' @endif>Keluar</a>
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

@extends('layouts.mainlayout')

@section('title', 'Home')

@section('content')
    <style>
        .card-title {
            color: #000000; /* Warna teks untuk judul kartu */
        }

        .card-body {
            color: #000000; /* Warna teks untuk isi kartu */
        }
    </style>

    <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css' rel='stylesheet'>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.13/index.global.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.13/locales-all.global.min.js'></script>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet'>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/bootstrap5@6.1.13/index.global.min.js'></script>
    
    <div class="container my-5 mt-4">
        <div class="card shadow">
            <div class="card-body">
                <h3 class="card-title text-center mt-3 mb-5">Data Ruang</h3>

                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                @endif

                <div class='my-3'>
                    <div class="row">
                        @php
                            $reversedRooms = $rooms->reverse();
                        @endphp
                        @foreach ($reversedRooms as $room)
                            <div class="col-md-4 mb-4">
                                <a href="{{ route('detail-ruang', ['id' => $room->id]) }}" class="text-decoration-none">
                                    <div class="card h-100">
                                        <img src="{{ asset('Gambar/' . $room->Gambar) }}" class="card-img-top" alt="{{ $room->NamaRuang }}">
                                        <div class="card-body">
                                            <h5 class="card-title text-center">{{ $room->NamaRuang }}</h5>    
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

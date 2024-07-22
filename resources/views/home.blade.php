@extends('layouts.mainlayout')

@section('title', 'Home')

@section('content')
    <style>
        .card-title {
            color: #000000; /* Color of the card title text */
        }

        .card-body {
            color: #000000; /* Color of the card body text */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .card-img-top {
            object-fit: cover; /* Ensure the image covers the frame without distortion */
            height: 200px; /* Fixed height for consistency */
            width: 100%; /* Full width of the card */
        }

        .card {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%; /* Ensure the card takes full height of the column */
        }

        .card-body {
            flex: 1; /* Allow the card body to grow and fill available space */
        }

        .text-center {
            text-align: center; /* Center the text */
        }

        .row {
            margin-left: 0;
            margin-right: 0;
        }

        .col {
            display: flex;
            justify-content: center;
            margin-bottom: 1rem; /* Adjust margin as needed */
        }

        .row-cols-md-3 > .col {
            flex: 1 1 33.333%; /* Flex basis for 3 columns */
        }

        .row-cols-md-2 > .col {
            flex: 1 1 50%; /* Flex basis for 2 columns */
        }

        .row-cols-md-1 > .col {
            flex: 1 1 100%; /* Flex basis for 1 column */
        }

        /* Center the row when there are fewer than 3 items */
        .justify-content-center {
            justify-content: center;
        }
    </style>

    <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css' rel='stylesheet'>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet'>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.13/index.global.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.13/locales-all.global.min.js'></script>
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
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4 justify-content-center">
                        @php
                            $reversedRooms = $rooms->reverse();
                        @endphp
                        @foreach ($reversedRooms as $room)
                            <div class="col d-flex justify-content-center mb-4">
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

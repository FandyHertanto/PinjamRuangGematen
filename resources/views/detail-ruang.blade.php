@extends('layouts.mainlayout')

@section('title', 'Detail Ruang')

@section('content')
    <div class="container my-5">
        <div class="card shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-5">
                    <a href="{{ route('home') }}" class="btn btn-danger">Kembali</a>
                    <h3 class="card-title text-center flex-grow-1 mb-0">{{ $room->NamaRuang }}</h3>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <img src="{{ asset('Gambar/' . $room->Gambar) }}" class="img-fluid" alt="{{ $room->NamaRuang }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Kapasitas:</strong> {{ $room->Kapasitas }}</p>
                        <p class="mb-0"><strong>Fasilitas:</strong></p>
                        <ul class="list-unstyled mb-0">
                            @foreach ($room->fasilitas as $fasil)
                                @if($fasil->item)
                                    <li>
                                        {{ $fasil->item->Deskripsi }} {{ $fasil->JumlahBarang }}
                                    </li>
                                @else
                                    <li>Item not found</li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

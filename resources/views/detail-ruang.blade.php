@extends('layouts.mainlayout')

@section('title', 'Detail Ruang')

@section('content')
    <div class="container my-5">
        <div class="card shadow">
            <div class="card-body">
                <h3 class="card-title text-center mb-5 mt-3">{{ $room->NamaRuang }}</h3>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <img src="{{ asset('Gambar/' . $room->Gambar) }}" class="img-fluid" alt="{{ $room->NamaRuang }}">
                        </div>
                        <div>
                            <a href="{{ route('home') }}" class="btn btn-danger mt-3">Kembali</a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <p>Kapasitas: {{ $room->Kapasitas }}</p>
                        <td>Fasilitas:</td>
                        <br>
                        @foreach ($room->fasilitas as $fasil)
                            @if($fasil->item)
                                
                                <td>{{ $fasil->item->Deskripsi }}</td>
                                <td>{{ $fasil->JumlahBarang }}</td>
                                <br>
                            @else
                                <p>Item not found</p>
                                <br>
                            @endif
                        @endforeach
                    
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection





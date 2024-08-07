@extends('layouts.mainlayout')

@section('title', 'Fasilitas')

@section('content')

    <h3>Data Fasilitas</h3>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="my-5 d-flex justify-content-end" style="font-family: 'Rubik';">
        <a href="{{ route('create-fasilitas') }}" class="btn btn-primary">+ Data Fasilitas</a>
    </div>
    <div class='my-5'>
        <table class='table'>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Ruang</th>
                    <th>Barang</th>
                    <th>Jumlah Barang</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($fasilitas as $index => $fasilita)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $fasilita->room->NamaRuang }}</td>
                        <td>{{ $fasilita->item->NamaBarang }}</td>
                        <td>{{ $fasilita->JumlahBarang }}</td>
                        <td>
                            <form action="{{ route('fasilitas-destroy', $fasilita->id) }}" method="POST">
                                <a href="{{ route('fasilitas-edit', $fasilita->id) }}" class="btn btn-secondary">Edit</a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection

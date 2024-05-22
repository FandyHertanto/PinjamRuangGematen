@extends('layouts.mainlayout')

@section('title', 'Data Ruang')

@section('content')

    <h3>Data Ruang</h3>

    <div class="my-5 d-flex justify-content-end">
        <a href="{{ route('create') }}" class="btn btn-primary">+ Data Ruang</a>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <div class='my-5'>
        <table class='table '>
            <thead>
                <tr>
                    <th>Nama Ruang</th>
                    <th>Kapasitas</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rooms as $room)
                    <tr>
                        <td>{{ $room->NamaRuang }}</td>
                        <td>{{ $room->Kapasitas }}</td>
                        <td><img src="{{ asset('Gambar/' . $room->Gambar) }}" width="100px"></td>
                        <td>
                            <form action="{{ route('room-destroy', $room->id) }}" method="POST">
                                <a href="{{ route('room-edit', $room->id) }}" class="btn btn-warning">Edit</a>
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

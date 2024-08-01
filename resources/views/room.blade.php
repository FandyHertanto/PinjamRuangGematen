@extends('layouts.mainlayout')

@section('title', 'Data Ruang')

@section('content')

<div class="card shadow-lg border-0 rounded-3">
    <div class="card-header text-center" style="background-color: rgb(105, 0, 0); color: white;">
        <h3>Data Ruang</h3>
    </div>
    <div class="card-body">

        
        <div class="my-3">
            <a href="{{ route('create') }}" class="btn btn-primary me-3" style="background-color: rgb(163, 1, 1); border-color: rgb(163, 1, 1);">+ Data Ruang</a>
        </div>

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

        <div class='my-3'>
            <div class="table-responsive">
                <table class='table text-center'>
                    <thead>
                        <tr>
                            <th>Nama Ruang</th>
                            <th>Kapasitas</th>
                            <th>Gambar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $reversedRooms = $rooms->reverse();
                        @endphp
                        @foreach ($reversedRooms as $room)
                        <tr>
                            <td>{{ $room->NamaRuang }}</td>
                            <td>{{ $room->Kapasitas }}</td>
                            <td><img src="{{ asset('Gambar/' . $room->Gambar) }}" width="100px"></td>
                            <td>
                                <form action="{{ route('room-destroy', $room->id) }}" method="POST">
                                    <a href="{{ route('room-edit', $room->id) }}" class="btn btn-warning"><i
                                            class="bi bi-pencil-square"></i></a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"><i
                                            class="bi bi-trash3-fill"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

@endsection

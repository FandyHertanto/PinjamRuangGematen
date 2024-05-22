@extends('layouts.mainlayout')

@section('title', 'Barang')

@section('content')

    <h3>Data Barang</h3>

    <div class="mt-5 d-flex justify-content-end">
        <a href="{{ route('item-add') }}" class='btn btn-primary'>+ Tambah Barang</a>
    </div>

    <div>
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
    </div>

    <div class='my-5'>
        <table class='table'>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->NamaBarang }}</td>
                        <td>{{ $item->Deskripsi }}</td>
                        <td>
                            <form action="{{ route('item-destroy', $item->id) }}" method="POST">
                                <a href="{{ route('item-edit', $item->id) }}" class="btn btn-secondary">Edit</a>
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

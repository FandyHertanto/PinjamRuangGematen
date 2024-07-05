@extends('layouts.mainlayout')

@section('title', 'Barang')

@section('content')

<div class="card shadow">
    <div class="card-body">

        <h3 class="card-title text-center">Data Barang</h3>

        <div class="my-3">
            <a href="{{ route('item-add') }}" class="btn btn-primary">+ Data Barang</a>
        </div>

        <div class="my-3">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
        </div>

        <div class="my-3">
            <table class="table text-center">
                <thead>
                    <tr>
                        
                        <th>Nama</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $reversedItems = $items->reverse();
                    @endphp
                    @foreach ($reversedItems as $item)
                        <tr>
                            
                            <td>{{ $item->NamaBarang }}</td>
                            <td>{{ $item->Deskripsi }}</td>
                            <td>
                                <form action="{{ route('item-destroy', $item->id) }}" method="POST">
                                    <a href="{{ route('item-edit', $item->id) }}" class="btn btn-warning"><i class="bi bi-pencil-square"></i></a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"><i class="bi bi-trash3-fill"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>

@endsection

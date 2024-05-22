@extends('layouts.mainlayout')

@section('title', 'Tambah Ruang')

@section('content')

<h3>Tambah Ruang</h3>

<div class="mt-5 w-50">
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('room-store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="NamaRuang" class='form-label'>Nama Ruang</label>
            <input type="text" name="NamaRuang" id="NamaRuang" class="form-control" placeholder="co: Yohanes">
        </div>
        <div class="mb-3">
            <label for="Kapasitas" class='form-label'>Kapasitas</label>
            <input type="number" name="Kapasitas" id="Kapasitas" class="form-control"
                placeholder="Kapasitas ruang">
        </div>

        <div class="mb-3">
            <label for="Gambar" class='form-label'>Gambar</label>
            <input type="file" name="Gambar" id='Gambar' class="form-control">
        </div>
        <div class="mt-3">
            <button class="btn btn-success" type="submit">Simpan</button>
        </div>
    </form>
</div>

@endsection

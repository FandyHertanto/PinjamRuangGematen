@extends('layouts.mainlayout')

@section('title', 'Tambah Barang')

@section('content')

    <h3>Tambah Barang</h3>

    <div class="mt-5 w-50">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="item-add" method="post">
            @csrf
            <div>
                <label for="NamaBarang" clas='form-label'>Nama Barang</label>
                <input type="text" name="NamaBarang" id="NamaBarang" class="form-control" placeholder="contoh: meja">
            </div>
            <div>
                <label for="Deskripsi" clas='form-label'>Deskripsi</label>
                <input type="text" name="Deskripsi" id="Deskripsi" class="form-control" placeholder="contoh: meja kayu">
            </div>
            <div class="mt-3">
                <button class="btn btn-success" type="submit">Simpan</button>
            </div>
        </form>
    </div>

@endsection

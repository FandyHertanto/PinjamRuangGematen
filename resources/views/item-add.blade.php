@extends('layouts.mainlayout')

@section('title', 'Tambah Barang')

@section('content')

    <div class="container-fluid">



        <div class="card shadow">
            <div class="card-body">
                <div class="mb-3">
                    <h3 class="mb-3">Tambah barang</h3>
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

                <form action="item-add" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="NamaBarang" class="form-label">Nama Barang</label>
                        <input type="text" name="NamaBarang" id="NamaBarang" class="form-control"
                            placeholder="contoh: meja">
                    </div>
                    <div class="mb-3">
                        <label for="Deskripsi" class="form-label">Deskripsi</label>
                        <input type="text" name="Deskripsi" id="Deskripsi" class="form-control"
                            placeholder="contoh: meja kayu">
                    </div>
                    <div class="mt-3">
                        <button class="btn btn-success" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

@endsection

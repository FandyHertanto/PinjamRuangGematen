@extends('layouts.mainlayout')

@section('title', 'Tambah Barang')

@section('content')

    <div class="container-fluid">



        <div class="card shadow-lg border-0 rounded-3">
            <div class="card-header text-center" style="background-color: rgb(105, 0, 0); color: white;">
                <h3>Tambah Barang</h3>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    
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
                            placeholder="contoh: meja" required>
                    </div>
                    <div class="mb-3">
                        <label for="Deskripsi" class="form-label">Deskripsi</label>
                        <input type="text" name="Deskripsi" id="Deskripsi" class="form-control"
                            placeholder="contoh: meja kayu" >
                    </div>
                    <div class="mt-3 text-center">
                        <button class="btn btn-success" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

@endsection

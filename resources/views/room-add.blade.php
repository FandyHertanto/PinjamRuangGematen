@extends('layouts.mainlayout')

@section('title', 'Tambah Ruang')

@section('content')

    <div class="container-fluid">


        <div class="row mt-5">
            <div class="col-lg-12">
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

                <div class="card shadow">

                    <div class="card-body">
                        <div class="mb-3">
                            <h3 class="mb-3">Tambah ruang</h3>
                        </div>
                        <form action="{{ route('room-store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="NamaRuang" class="form-label">Nama Ruang</label>
                                <input type="text" name="NamaRuang" id="NamaRuang" class="form-control"
                                    placeholder="co: Yohanes" required>
                            </div>
                            <div class="mb-3">
                                <label for="Kapasitas" class="form-label">Kapasitas</label>
                                <input type="text" name="Kapasitas" id="Kapasitas" class="form-control"
                                    placeholder="Kapasitas ruang" required>
                            </div>

                            <div class="mb-3">
                                <label for="Gambar" class="form-label">Gambar</label>
                                <input type="file" name="Gambar" id="Gambar" class="form-control" required>
                            </div>
                            <div class="mt-3">
                                <button class="btn btn-success" type="submit">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection